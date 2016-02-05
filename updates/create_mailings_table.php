<?php namespace Lovata\Subscriptions\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMailingsTable extends Migration
{

    public function up()
    {
        Schema::create('lovata_subscriptions_mailings', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('lovata_subscriptions_categories')->onDelete('cascade');
            $table->string('template_code');
            $table->string('mailsend_title');
            $table->string('data_source')->default('handprint');
            $table->string('title')->nullable();
            $table->string('preview')->nullable();
            $table->string('link')->nullable();
            $table->integer('article_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lovata_subscriptions_mailings');
    }

}
