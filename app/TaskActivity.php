<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskActivity extends Model
{
    protected $table = "tasks_activities";

    public  function task(){

        return $this->belongsTo(Task::class);
    }

    public  function user(){

        return $this->belongsTo(User::class,'created_by','id');
    }
}
