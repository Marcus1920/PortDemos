<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDroneSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drone_sub_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drone_type_id')->unsigned();
            $table->string('name');
            $table->foreign('drone_type_id')->references('id')->on('drone_types');
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
        Schema::drop('drone_sub_types');
    }
}
