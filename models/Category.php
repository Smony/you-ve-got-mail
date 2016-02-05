<?php namespace Lovata\Subscriptions\Models;

use Backend;
use Flash;
use Lang;
use Model;

/**
 * Category Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'lovata_subscriptions_categories';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Rules fields
     */
    public $rules = [
        'title' => 'required',
        'slug' => 'required',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['title', 'slug'];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'subscribers' => ['Lovata\Subscriptions\Models\Subscriber', 'table' => 'lovata_subscriptions_category_subscriber']
    ];

    public $hasMany = [
        'mailings' => 'Lovata\Subscriptions\Models\Mailing'
    ];

    public function beforeDelete()
    {
        //категорию default удалить нельзя
        if($this->slug == 'default'){
            return false;
        }
    }

    public function beforeUpdate()
    {
        //категорию default изменить нельзя
        if($this->slug == 'default'){
            return false;
        }
    }
}