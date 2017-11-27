<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReligionColumnToUsers extends Migration
{
   
    public function up()
    {
        Schema::table('users', function($table)
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
        Schema::table('users', function($table)
        {
            $table->dropColumn('religion');
        });
    }
}
