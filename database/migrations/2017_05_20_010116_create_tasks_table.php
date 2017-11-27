<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned();
            $table->integer('priority_id')->unsigned();
            $table->integer('task_category_id')->unsigned();
            $table->string('title')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('complete')->nullable();
            $table->dateTime('date_received')->nullable();
            $table->dateTime('date_booked_out')->nullable();
            $table->date('commencement_date')->nullable();
            $table->dateTime('last_activity_date_time')->nullable();
            $table->string('description')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->unsigned();
            $table->foreign('status_id')->references('id')->on('task_statuses');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('priority_id')->references('id')->on('task_priorities');
            $table->foreign('task_category_id')->references('id')->on('task_categories');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::drop('tasks');
    }
}
