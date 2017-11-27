<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_type_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->integer('calendar_group_id')->unsigned();
            $table->foreign('calendar_group_id')->references('id')->on('calendar_groups');
            $table->foreign('event_type_id')->references('id')->on('calendar_event_types');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('calendars');
    }
}
