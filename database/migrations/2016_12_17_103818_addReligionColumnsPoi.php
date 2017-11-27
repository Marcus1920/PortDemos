<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReligionColumnsPoi extends Migration
{
   
    public function up()
    {
        Schema::table('poi', function($table)
        {

            $table->integer('religion');
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
            $table->dropColumn('religion');
        });
    }
   
}
