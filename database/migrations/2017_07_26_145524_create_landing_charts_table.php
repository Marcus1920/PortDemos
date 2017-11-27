<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landingpagecharts', function (Blueprint $table) {

            $table->increments('id');
            $table->string('fillColor');
            $table->string('strokeColor');
            $table->string('pointColor');
            $table->string('pointStrokeColor');
            $table->string('pointHighlightFill');
            $table->string('pointHighlightStroke');
            $table->integer('department_id');
            $table->foreign('id')->references('id')->on('departments');

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
        Schema::drop('landingpagecharts');
    }
}
