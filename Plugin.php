<?php namespace Lovata\Subscriptions;

use Backend\Facades\Backend;
use System\Classes\PluginBase;

/**
 * subscriptions Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'lovata.subscriptions::lang.plugin.name',
            'description' => 'lovata.subscriptions::lang.plugin.description',
            'author'      => 'lovata.subscriptions::lang.plugin.author',
            'icon'        => 'icon-leaf'
        ];
    }

//    public function registerNavigation() {
//        return [
//            'subscriptions' => [
//                'order'       => 700,
//                'icon'        => 'icon-envelope-o',
//                'permissions' => ['lovata.subscriptions.*'],
//                'label'       => 'lovata.subscriptions::lang.menu.name',
//                'url'         => Backend::url('lovata/subscriptions/mailings'),
//
//                'sideMenu' => [
//                    'subscribers' => [
//                        'icon'        => 'icon-graduation-cap',
//                        'permissions' => ['lovata.subscriptions.manage_subscribers'],
//                        'label'       => 'lovata.subscriptions::lang.sub_menu.subscribers',
//                        'url'         => Backend::url('lovata/subscriptions/subscribers'),
//                        'order'       => 200
//                    ],
//                    'categories' => [
//                        'icon'        => 'icon-graduation-cap',
//                        'permissions' => ['lovata.subscriptions.manage_categories'],
//                        'label'       => 'lovata.subscriptions::lang.sub_menu.categories',
//                        'url'         => Backend::url('lovata/subscriptions/categories'),
//                        'order'       => 300
//                    ],
//                    'mailings' => [
//                        'icon'        => 'icon-envelope',
//                        'permissions' => ['lovata.subscriptions.manage_mailings'],
//                        'label'       => 'lovata.subscriptions::lang.sub_menu.mailings',
//                        'url'         => Backend::url('lovata/subscriptions/mailings'),
//                        'order'       => 100
//                    ],
//                ]
//            ]
//        ];
//    }

    public function registerComponents() {
        return [
            '\Lovata\Subscriptions\Components\Subscriptions' => 'LVSubscriptions',
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'lovata.subscriptions::subscribe_form' => 'Subscription mail template',
        ];
    }

    public function registerPermissions() {
        return [
            'lovata.subscriptions.manage_mailings'    => [
                'tab' => 'lovata.subscriptions::lang.permission.tab',
                'label' => 'lovata.subscriptions::lang.permission.manage_mailings'],
            'lovata.subscriptions.manage_categories'    => [
                'tab' => 'lovata.subscriptions::lang.permission.tab',
                'label' => 'lovata.subscriptions::lang.permission.manage_categories'],
            'lovata.subscriptions.manage_subscribers'    => [
                'tab' => 'lovata.subscriptions::lang.permission.tab',
                'label' => 'lovata.subscriptions::lang.permission.manage_subscribers'],
        ];
    }
}
