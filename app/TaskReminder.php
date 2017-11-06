<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaskReminder extends Eloquent
{
    protected $table     = 'task_reminders';

    
    public  function task(){

        return $this->belongsTo(Task::class);
    }

}
