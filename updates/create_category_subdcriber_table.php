<?php namespace Lovata\Webridge\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCategorySubscriberTable extends Migration
{

    public function up()
    {
        Schema::create('lovata_subscriptions_category_subscriber', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('lovata_subscriptions_categories')->onDelete('cascade');
            $table->integer('subscriber_id')->unsigned()->index();
            $table->foreign('subscriber_id')->references('id')->on('lovata_subscriptions_subscribers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lovata_subscriptions_category_subscriber');
    }

}
