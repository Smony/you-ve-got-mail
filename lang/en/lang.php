<?php
return [
    'plugin' => [
        'name' => 'LOVATA: Subscriptions',
        'description' => 'Manage subscriptions',
        'author' => 'LOVATA',
    ],
    'menu' => [
        'name' => 'Subscriptions',
    ],
    'sub_menu' => [
        'mailings' => 'Mailings',
        'subscribers' => 'Subscribers',
        'categories' => 'Categories',
    ],
    'field' => [
        'title' => 'Title',
        'title_placeholder' => 'Element title',
        'email' => 'Email',
        'categories' => 'Subscription category',
        'category' => 'Category',
        'data_source' => 'Data source',
        'mailsend_title' => 'Mailsend title',
        'preview' => 'Preview',
        'link' => 'link',
        'article' => 'Article',
        'subscribers' => 'Subscribers',
        'slug' => 'Slug',
        'template' => 'Template',
    ],
    'category' => [
        'default' => 'Default',
    ],
    'message' => [
        'delete_confirm' => 'Do you really want to delete this element?',
        'delete_success' => 'Successfully deleted those elements.',
        'mailsend_success' => 'Mail send is complete',
        'category_warning' => 'Therea\'re any mailings related to the category. Please, change mailing categories and then try to delete this category.',
        'close_confirm' => 'The element is not saved.',
        'return_to_categories' => 'Return to the category list',
        'return_to_mailings' => 'Return to the mailing list',
        'return_to_subscribers' => 'Return to the subscribers list',
        'no_template' => 'No template chosen for subscriptions mail send'
    ],
    'component' => [
        'name' => 'Subscribers',
        'description' => 'Adds new subscriber to mailing category list',
    ],
    'permission' => [
        'tab' => 'LOVATA: Subscriptions',
        'manage_categories' => 'Manage categories',
        'manage_subscribers' => 'Manage subscribers',
        'manage_mailings' => 'Manage mailings',
    ],
    'tab' => [
      'edit' => 'Edit',
      'categories' => 'Categories',
      'subscribers' => 'Subscribers',
    ],
    'buttons' => [
        'mailsend_start' => 'Start mail send'
    ]
];