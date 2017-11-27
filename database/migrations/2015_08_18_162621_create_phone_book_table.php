<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addressbook',function($table){
            $table->increments('id');
            $table->string('first_name');
            $table->string('surname');
            $table->string('cellphone');
            $table->string('email');
            $table->string('relationship')->nullable();
            $table->integer('user');
            $table->boolean('active')->default(1);
            $table->integer('created_by');
            $table->foreign('user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('addressbook');
    }
}
