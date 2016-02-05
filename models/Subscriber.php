<?php namespace Lovata\Subscriptions\Models;

use Model;

/**
 * Subscriber Model
 */
class Subscriber extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'lovata_subscriptions_subscribers';

    /**
     * @var array Rules fields
     */
    public $rules = [
        'email' => 'required|unique:lovata_subscriptions_subscribers'
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['email'];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'categories' => ['Lovata\Subscriptions\Models\Category', 'table' => 'lovata_subscriptions_category_subscriber']
    ];

}