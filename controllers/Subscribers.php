<?php namespace Lovata\Subscriptions\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Illuminate\Http\Request;
use Lovata\Subscriptions\Models\Subscriber;

/**
 * Subscribers Back-end Controller
 */
class Subscribers extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    /** @var Request */
    protected $obRequest;

    public function __construct(Request $obRequest)
    {
        parent::__construct();

        BackendMenu::setContext('Lovata.Subscriptions', 'subscriptions', 'subscribers');

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
            if(!$obElement = Subscriber::find($iElementID))
                continue;

            $obElement->delete();
        }

        Flash::success('lovata.subscriptions::lang.message.delete_success');
        return $this->listRefresh();
    }
}