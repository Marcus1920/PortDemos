<?php

use Illuminate\Database\Seeder;
use App\CalendarGroup;

class CalendarGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $calendargroups = [

            [
                'id'=>'',
                'name'=>'',
                'description'=>'description',
            ]

        ];

        foreach ($calendargroups as $calendargroup){

            CalendarGroup::create($calendargroup);
        }
    }
}
