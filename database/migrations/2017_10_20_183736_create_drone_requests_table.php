<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDroneRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drone_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by')->unsigned();
            $table->integer('drone_type_id')->unsigned();
            $table->integer('sub_drone_type_id')->unsigned();
            $table->integer('drone_case_status')->unsigned();
            $table->text('comments');
            $table->integer('department')->unsigned();
            $table->integer('reject_reason')->unsigned();
            $table->string('reject_other_reason');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('drone_type_id')->references('id')->on('drone_types');
            $table->foreign('sub_drone_type_id')->references('id')->on('drone_sub_types');
            $table->foreign('drone_case_status')->references('id')->on('drone_approval_statuses');
            $table->foreign('department')->references('id')->on('departments');
            $table->foreign('reject_reason')->references('id')->on('drone_reject_reasons');
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
        Schema::drop('drone_requests');
    }
}
