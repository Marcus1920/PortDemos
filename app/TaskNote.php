<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaskNote extends Eloquent
{

    protected $table    = 'tasks_notes';

    public  function task(){

        return $this->belongsTo(Task::class);
    }

    public  function user(){

        return $this->belongsTo(User::class,'created_by','id');
    }


}
