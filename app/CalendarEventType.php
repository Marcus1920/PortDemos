<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEventType extends Model
{
    protected $fillable = ['name', 'slug'];

    public function calenderEvent()
    {
        return $this->belongsToMany(CalendarEvent::class);
    }

    public function calender()
    {
        return $this->belongsTo(Calendar::class);
    }
}
