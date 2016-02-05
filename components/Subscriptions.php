<?php namespace Lovata\Subscriptions\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Input;
use Lovata\Subscriptions\Models\Category;
use Lovata\Subscriptions\Models\Subscriber;
use Validator;

class Subscriptions extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'lovata.subscriptions::lang.component.name',
            'description' => 'lovata.subscriptions::lang.component.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'category' => [
                'title'       => 'Categories',
                'type'        => 'dropdown',
                'default'     => 'handprint',
                'placeholder' => 'Select category'
            ]
        ];
    }

    /**
     * Формируем список категорий пользователей для параметра компонента
     * @return array|void
     */
    public function getCategoryOptions()
    {
        $arOptions = [];
        $obCategories = Category::all();
        if(empty($obCategories)){
            return;
        }
        foreach ($obCategories as $obCategory) {
            $arOptions[$obCategory->id] = $obCategory->title;
        }
        return $arOptions;
    }

    /**
     * Сохранение нового подпичика
     * @return array|void
     */
    public function onSubscribe(){
        $sEmail = Input::get('email');
        if(empty($sEmail)){
            return;
        }
        //получаем выбранную в компоненте группу подписки
        $iCategoryId =  $this->property('category');
        //валидация уникального почтового адреса подписчика
        $rules = [
            'email' => 'unique:lovata_subscriptions_subscribers'
        ];
        $validator = Validator::make(['email' => $sEmail], $rules);
        if ($validator->fails()) {
            return ['status' => 'not_unique_email'];
        }

        $obSubscriber = Subscriber::create([
            'email' => $sEmail
        ]);
        //привязка подпичика к определенной группе
        $obSubscriber->categories()->attach($iCategoryId);

        return ['status' => 'success'];
    }
}