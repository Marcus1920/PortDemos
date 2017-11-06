<?php
/**
 * Created by PhpStorm.
 * User: TTN
 * Date: 2017/07/06
 * Time: 3:43 PM
 */

namespace App\services;


use App\Calendar;
use App\CalendarEventType;

class CalendarService
{
    public function getCalendars()
    {

        return Calendar::with('calendarEventType')->get();
    }

    public function getCalendar($id)
    {
        return Calendar::find($id);
    }

    public function getCalendarPerGroup($event_type_id,$calendar_group_id){
        return Calendar::where('event_type_id',$event_type_id)
                        ->where('calendar_group_id',$calendar_group_id)
                        ->first();
    }

    public function storeCalendar($request)
    {
        
		$calendar                            = new Calendar();
        // $calendar->name                   = $calendarEventTypeObj->name;
        $calendar->event_type_id             = $request['event_type_id'];
        $calendar->description               = $request['description'];
        $calendar->color                     = $request['color'];
        $calendar->calendar_group_id         = $request['calendar_group_id'];
        $calendar->save();

        return $calendar;
    }

    public function updateCalendar($form)
    {
        $calendar                         = Calendar::find($form['calendar_id']);
        $calendar->name                   = $form['name'];
        $calendar->description            = $form['description'];
        $calendar->calendar_event_type_id          = $form['event_type_id'];
        $calendar->color                  = $form['color'];
        $calendar->calendar_group_id      = $form['calendar_group_id'];
        $calendar->save();
        return $calendar;
    }



    public function deleteCalendar($id)
    {
        $calendar = User::find($id);
        $calendar->delete();
    }


}