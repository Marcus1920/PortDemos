<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->string('alt_email')->nullable();
            $table->string('cellphone')->unique();
            $table->string('alt_cellphone')->nullable();
            $table->string('title')->nullable();
            $table->integer('position')->nullable();
            $table->integer('role')->nullable();
            $table->integer('language')->nullable();
            $table->integer('id_number')->nullable();
            $table->string('company')->nullable();
            $table->integer('department')->nullable();
            $table->string('username')->nullable();
            $table->integer('province')->nullable();
            $table->integer('district')->nullable();
            $table->integer('ward')->nullable();
            $table->string('area')->nullable();
            $table->integer('phone_brand')->nullable();
            $table->integer('phone_type')->nullable();
            $table->integer('phone_network')->nullable();
            $table->integer('municipality')->nullable();
            $table->string('img_url')->nullable();
            $table->string('api_key')->nullable();
            $table->string('password');
            $table->integer('availability')->nullable();
            $table->datetime('last_login')->nullable();
            $table->datetime('last_logout')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('mandate')->nullable();
            $table->string('client_reference_number')->nullable();
            $table->string('saps_case_number')->nullable();
            $table->string('street_number')->nullable();
            $table->string('route')->nullable();
            $table->string('locality')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->integer('affiliation')->nullable();
            $table->string('administrative_area_level_1')->nullable();
            $table->boolean('active')->default(1);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
