<?php namespace Lovata\Subscriptions\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSubscribersTable extends Migration
{

    public function up()
    {
        Schema::create('lovata_subscriptions_subscribers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lovata_subscriptions_subscribers');
    }

}
