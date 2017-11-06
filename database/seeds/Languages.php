<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Language;


class Languages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->truncate();
        Language::create(['id' => '1','slug' => 'EN','name' => 'English']);
        Language::create(['id' => '2','slug' => 'Zulu','name' => 'IsiZulu']);
        Language::create(['id' => '3','slug' => 'Xhosa','name' => 'IsiXhosa']);
        Language::create(['id' => '4','slug' => 'Afrikaans','name' => 'Afrikaans']);
        Language::create(['id' => '5','slug' => 'Portuguese','name' => 'Portuguese']);
        Language::create(['id' => '6','slug' => 'Swahili','name' => 'Swahili']);
        Language::create(['id' => '7','slug' => 'Shangaan','name' => 'Shangaan']);
        Language::create(['id' => '8','slug' => 'Other','name' => 'Other']);



    }
}
