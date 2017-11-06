<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarGroupUser extends Model
{
    protected $table    = 'calendar_group_users';
    protected $fillable = ['calendar_group_id','user_group_id'];

    public function UserCalendarGroup()
    {
        return $this->hasMany('App\UserNew','id','user_id');
    }

    public function CalendarGroupUser()
    {
        return $this->hasMany('App\CalendarGroup','id','calendar_group_id');
    }
    public  function user(){

        return $this->belongsTo(UserRole::class,'user_group_id','id');
    }
    public  function CalendarGroup(){

        return $this->belongsTo(CalendarGroup::class,'calendar_group_id','id');
    }

}
