<?php namespace Lovata\Subscriptions\Controllers;

use Backend;
use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Illuminate\Http\Request;
use Lang;
use Lovata\Subscriptions\Models\Category;

/**
 * Categories Back-end Controller
 */
class Categories extends Controller
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

        BackendMenu::setContext('Lovata.Subscriptions', 'subscriptions', 'categories');

        $this->obRequest = $obRequest;
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
            if(!$obElement = Category::find($iElementID))
                continue;

            //смотрим, есть ли привязки категории к рассылкам
            $obMailings = $obElement->mailings;

            if(!($obMailings->isEmpty())){
                Flash::warning(Lang::get('lovata.subscriptions::lang.message.category_warning'));
                return redirect()->back();
            }

            $obElement->delete();
        }

        Flash::success(Lang::get('lovata.subscriptions::lang.message.delete_success'));
        return $this->listRefresh();
    }

    /**
     * Переопределяем метод удаления категории из формы update с проверками на наличие связи категории с рассылками. Если категория привязана к рассылкам,
     * то не удаляем ее пока, пока рассылки не будут удалены или переназначены на другие категории. Также делаем невозможным удалить категорию default
     *
     * @param null $iId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function update_onDelete($iId = null){
        $obCategory = Category::find($iId);
        if(empty($obCategory)){
            return;
        }

        //смотрим, есть ли привязки категории к рассылкам
        $obMailings = $obCategory->mailings;

        if(!($obMailings->isEmpty())){
            Flash::warning(Lang::get('lovata.subscriptions::lang.message.category_warning'));
            return redirect()->back();
        }

        //если условия выполнены, удаляем категорию и редиректимся к списку категорий
        $obCategory->delete();

        Flash::success(Lang::get('lovata.subscriptions::lang.message.delete_success'));
        return redirect(Backend::url('lovata/subscriptions/categories'));
    }

}