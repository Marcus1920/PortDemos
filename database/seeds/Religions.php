<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Religion;


class Religions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('religions')->truncate();
        Religion::create(['id' => '1','slug' => 'Islamic','name' => 'Islamic']);
        Religion::create(['id' => '2','slug' => 'Christian','name' => 'Christian']);
        Religion::create(['id' => '3','slug' => 'Hindu','name' => 'Hindu']);
        Religion::create(['id' => '4','slug' => 'Traditional','name' => 'Traditional']);
        Religion::create(['id' => '5','slug' => 'Portuguese','name' => 'Portuguese']);
       

    }
}
