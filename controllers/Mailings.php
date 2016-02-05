<?php namespace Lovata\Subscriptions\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Lovata\Articles\Models\Article;
use Lovata\Subscriptions\Models\Category;
use Lovata\Subscriptions\Models\Mailing;
use October\Rain\Support\Facades\Flash;
use System\Classes\PluginManager;
use URL;

/**
 * Mailings Back-end Controller
 */
class Mailings extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    protected $obRequest;

    public function __construct(Request $obRequest)
    {
        parent::__construct();
        BackendMenu::setContext('Lovata.Subscriptions', 'subscriptions', 'mailings');
        $this->obRequest = $obRequest;
    }


    public function onFormMailSend() {

        $arElementsID = $this->obRequest->input('checked');

        if(empty($arElementsID) || !is_array($arElementsID)) {
            return $this->listRefresh();
        }

        foreach($arElementsID as $iElementID) {
            if(!$obElement = Mailing::find($iElementID))
                continue;

            //получаем список адресов из категории подписчиков, назначенной рассылке
            $obCategory = Category::find($obElement->category_id);
            if(empty($obCategory)){
                return;
            }
            $arSendTo = [];
            foreach ($obCategory->subscribers as $obSubscriber) {
                $arSendTo[] = $obSubscriber->email;
                if(empty($obElement->template_code)){
                    Flash::warning(Lang::get('lovata.subscriptions::lang.message.no_template'));
                    return;
                }
                $sTemplate = $obElement->template_code;
            }

            //если нет подпичиков, то нет смысла рассылки
//            if(empty($arSendTo)){
//                return;
//            }

            //смотрим на источник данных из рассылки и формируем данные
            switch ($obElement->data_source) {
                case 'handprint':
                    $arData = [
                        'title' => $obElement->title,
                        'preview' => $obElement->preview,
                        'link' => $obElement->link,
                    ];
                    break;
                case 'article':
                    if(empty($obElement->article_id) || !(PluginManager::instance()->hasPlugin('Lovata.Articles'))){
                        return;
                    }
                    $arData = $this->getArticle($obElement->article_id);
                    break;
                default:
                    return;
            }

            //формируем очередь рассылки данных подписчикам
            foreach ($arSendTo as $sEmail) {
                $this->mailSend($sEmail, $sTemplate, $arData);
            }
        }

        Flash::success(Lang::get('lovata.subscriptions::lang.message.mailsend_success'));
        return $this->listRefresh();
    }

    /**
     * Ставим отправку почты в очередь 'subscribe'
     * @param $sSendTo
     * @param null $sTitle
     * @param null $sPreview
     * @param null $sLink
     */
    public function mailSend($sSendTo, $sTemplate, $arData){
        Mail::queueOn('subscribe', $sTemplate, $arData, function($message) use ($sSendTo) {
            $message->to($sSendTo);
        });
    }

    /**
     * Формируем данные для рассылки из новости
     * @param $iId
     * @return array|void
     */
    public function getArticle($iId){
        if(PluginManager::instance()->hasPlugin('Lovata.Articles')) {
            $obArticle = Article::find($iId);
            if (empty($obArticle)) {
                return;
            }
            $arData = [
                'title' => $obArticle->title,
                'preview' => $obArticle->preview,
                'link' => url('/news/' . $obArticle->slug),
            ];
            return $arData;
        }
        return [];
    }

    /**
     * Ajax удаление элементов
     * @return mixed
     */
    public function index_onDelete() {

        $arElementsID = $this->obRequest->input('checked');

        if(empty($arElementsID) || !is_array($arElementsID)) {
            return $this->listRefresh();
        }

        foreach($arElementsID as $iElementID) {
            if(!$obElement = Mailing::find($iElementID))
                continue;

            $obElement->delete();
        }

        Flash::success(Lang::get('lovata.subscriptions::lang.message.delete_success'));
        return $this->listRefresh();
    }
}