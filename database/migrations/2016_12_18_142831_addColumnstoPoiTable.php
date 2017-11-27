<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnstoPoiTable extends Migration
{
   public function up()
    {
        Schema::table('poi', function($table)
        {

            $table->string('work_permit');
            $table->string('yellow_fever');
            $table->date('work_permit_expiry_date');
            $table->date('doc_expiry_date');
            $table->date('yellow_fever_expiry_date');

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
            $table->dropColumn('work_permit');
            $table->dropColumn('yellow_fever');
            $table->dropColumn('work_permit_expiry_date');
            $table->dropColumn('doc_expiry_date');
            $table->dropColumn('yellow_fever_expiry_date');

        });
    }
}
