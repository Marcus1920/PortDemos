<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksOwnersTypes extends Migration
{

    public function up()
    {
        Schema::create('task_owner_types',function(Blueprint $table){

            $table->increments('id');
            $table->string('name');
            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::drop('task_owner_types');
    }
}
