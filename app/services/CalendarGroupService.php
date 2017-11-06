<?php

namespace App\services;
use App\CalendarGroup;
use App\Calendar;
use App\CalendarGroupUser;
use Auth;



class CalendarGroupService
{
    public function getCalendarGroups()
    {
        return CalendarGroup::all();
    }

    public function getCalendarGroupPerUser()
    {
        return CalendarGroupUser::with('CalendarGroup')
                                ->where('user_group_id',Auth::user()->role)
                                ->get();
    }
    public function getCalendarGroup($id){

        $calendarGroup = CalendarGroup::where('id',$id)->first();
        return $calendarGroup;
    }
    public function createCalendarGroup($name,$description)
    {
        $calendarGroup              = new CalendarGroup();
        $calendarGroup->name        = $name;
        $calendarGroup->description = $description;
        $calendarGroup->save();
        return $calendarGroup;
    }
    public function updateCalendarGroup($request)
    {
        $calendarGroup              = CalendarGroup::find($request['calendar_group_id']);
        $calendarGroup->name        = $request['name'];
        $calendarGroup->description = $request['description'];
        $calendarGroup->save();
        return $calendarGroup;
    }
    public function deleteCalendarGroup($id)
    {
        $calendaGroup=CalendarGroup::find($id);
        $calendaGroup->delete();
    }
}