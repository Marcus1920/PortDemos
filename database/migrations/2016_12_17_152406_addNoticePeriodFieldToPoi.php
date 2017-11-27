<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoticePeriodFieldToPoi extends Migration
{
    public function up()
    {
        Schema::table('poi', function($table)
        {

            $table->string('notice_period');
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
            $table->dropColumn('notice_period');
        });
    }
}
