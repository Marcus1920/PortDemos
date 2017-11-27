<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_group_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('calendar_group_id')->unsigned();
            $table->integer('user_group_id')->unsigned();
            $table->foreign('calendar_group_id')->references('id')->on('calendar_groups');
            $table->foreign('user_group_id')->references('id')->on('users_roles');
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
        Schema::drop('calendar_group_users');
    }
}
