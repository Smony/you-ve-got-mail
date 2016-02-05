<?php namespace Lovata\Subscriptions\Models;

use Lovata\Articles\Models\Article;
use Model;
use System\Classes\PluginManager;
use System\Models\MailTemplate;

/**
 * Mailing Model
 */
class Mailing extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'lovata_subscriptions_mailings';


    /**
     * @var array Rules fields
     */
    public $rules = [
        'mailsend_title' => 'required'
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['title', 'preview', 'link', 'mailsend_title', 'category_id'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'category' => 'Lovata\Subscriptions\Models\Category',
    ];

    /**
     * Если установлен плагин Lovata.Articles получаем из него список новостей
     * @param null $keyValue
     * @param null $fieldName
     * @return array
     */
    public function articlesListStatuses($keyValue = null, $fieldName = null)
    {
        if(PluginManager::instance()->hasPlugin('Lovata.Articles')) {
            $arList = [];
            $obArticles = Article::orderBy('published_start')->get();
            if(empty($obArticles)){
                return [];
            }
            foreach ($obArticles as $obArticle) {
                $arList[$obArticle->id] = $obArticle->title;
            }
            return $arList;
        }
        return [];
    }

    /**
     * В зависимости от выбранного типа источника данных при создании рассылки скрываем ненужные поля
     * @param $fields
     * @param null $context
     */
    public function filterFields($fields, $context = null)
    {
        $sDataSourceType = $fields->data_source->value;

        switch ($sDataSourceType) {
            case 'handprint':
                $fields->article_id->hidden = true;
                break;
            case 'article':
                $fields->title->hidden = true;
                $fields->preview->hidden = true;
                $fields->link->hidden = true;
                break;
        }
    }

    /**
     * ПОлучаем список шаблонов для рассылки
     * @return array
     */
    public function getSubscriptionTemplates(){
        $obMailTemplates = MailTemplate::where('code', 'LIKE', 'lovata.subscriptions%')->get();
        if(empty($obMailTemplates)){
            return [];
        }
        $arList = [];
        foreach ($obMailTemplates as $obMailTemplate) {
            $arList[$obMailTemplate->code] = $obMailTemplate->subject;
        }
        return $arList;
    }
}