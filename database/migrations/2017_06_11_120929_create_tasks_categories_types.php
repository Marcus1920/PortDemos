<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksCategoriesTypes extends Migration
{

    public function up()
    {
        Schema::create('tasks_categories_types',function(Blueprint $table){

            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->integer('task_category_id')->unsigned();
            $table->integer('type_id');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('task_category_id')->references('id')->on('task_categories');
            $table->timestamps();

        });
    }





    public function down()
    {
        Schema::drop('tasks_categories_types');
    }
}
