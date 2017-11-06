<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Calendar extends Eloquent
{
    protected $table    = 'calendars';
    protected $fillable = ['name','description','calendar_group_id','colour'];

    public function calendarGroup()
    {

        return $this->hasOne(CalendarGroup::class,'id','calendar_group_id');

    }

    public function calendarEventType()
    {

        return $this->hasMany(CalendarEventType::class,'id','event_type_id');

    }
    
}
