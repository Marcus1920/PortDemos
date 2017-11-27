<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToPoi extends Migration
{
    public function up()
    {
        Schema::table('poi', function($table)
        {

            $table->integer('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poi', function($table)
        {
            $table->dropColumn('position');
        });
    }
}
