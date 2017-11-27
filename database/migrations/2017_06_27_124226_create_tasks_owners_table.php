<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksOwnersTable extends Migration
{

    public function up()
    {
        Schema::create('task_owners',function(Blueprint $table){

            $table->increments('id');
            $table->integer('task_owner_type_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('task_id')->unsigned();
            $table->integer('accept') ->default('0');
            $table->foreign('task_owner_type_id')->references('id')->on('task_owner_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::drop('task_owners');
    }
}
