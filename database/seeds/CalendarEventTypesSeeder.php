<?php

use Illuminate\Database\Seeder;
use App\CalendarEventType;

class CalendarEventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$calendarEventTypes = [
            [ 'name' => 'Case', 'slug' => 'Case' ,'color' =>''],
            [ 'name' => 'Task', 'slug' => 'Task' ,'color' =>'' ],
            [ 'name' => 'Reminder','slug' => 'Reminder','color'=>''],
            [ 'name' => 'Meeting', 'slug' => 'Meeting','color'=>'']
        ];

        foreach ($calendarEventTypes as $calendarEventType) {

            CalendarEventType::create($calendarEventType);
        }   
    }
}
