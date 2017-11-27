<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases',function($table){
            $table->increments('id');
            $table->string('description')->nullable();
            $table->integer('user')->nullable();
            $table->integer('department')->nullable();
            $table->integer('province')->nullable();
            $table->integer('district')->nullable();
            $table->integer('municipality')->nullable();
            $table->integer('ward')->nullable();
            $table->string('area')->nullable();
            $table->integer('category')->nullable();
            $table->integer('sub_category')->nullable();
            $table->integer('sub_sub_category')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('status')->nullable();
            $table->string('gps_lat')->nullable();
            $table->string('gps_lng')->nullable();
            $table->string('img_url')->nullable();
            $table->integer('addressbook')->nullable();
            $table->integer('reporter')->nullable();
            $table->integer('severity')->nullable();
            $table->integer('source')->nullable();
            $table->integer('busy')->nullable();
            $table->dateTime('accepted_at')->nullable();
            $table->dateTime('referred_at')->nullable();
            $table->dateTime('escalated_at')->nullable();
            $table->dateTime('resolved_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->boolean('active')->default(1);
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
         Schema::drop('cases');
    }
}
