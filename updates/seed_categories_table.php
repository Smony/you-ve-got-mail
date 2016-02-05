<?php namespace Lovata\Subscriptions\Updates;

use Lovata\Subscriptions\Models\Category;
use October\Rain\Database\Updates\Seeder;

class SeedCategoryTable extends Seeder {

    public function run() {

        Category::create([
            'title' => trans('lovata.subscriptions::lang.category.default'),
            'slug' => 'default',
        ]);
    }
}
