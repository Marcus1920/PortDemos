<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQualificationToPoi extends Migration
{
     public function up()
    {
        Schema::table('poi', function($table)
        {

            $table->integer('qualification_type');
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
            $table->dropColumn('qualification_type');
        });
    }
}
