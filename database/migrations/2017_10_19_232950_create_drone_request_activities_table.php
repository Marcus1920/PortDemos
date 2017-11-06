<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDroneRequestActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drone_request_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drone_request_id')->unsigned();
            $table->integer('user')->unsigned();
            $table->string('activity');
            $table->foreign('drone_request_id')->references('id')->on('drone_requests');
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
        Schema::drop('drone_request_activities');
    }
}
