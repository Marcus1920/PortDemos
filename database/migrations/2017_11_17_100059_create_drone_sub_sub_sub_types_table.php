<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDroneSubSubSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drone_sub_sub_sub_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('drone_sub_sub_type_id')->unsigned();
            $table->foreign('drone_sub_sub_type_id')->references('id')->on('drone_sub_sub_types');
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
        Schema::drop('drone_sub_sub_sub_types');
    }
}
