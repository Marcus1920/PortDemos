<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaskStatus extends Eloquent
{
    protected $table = 'task_statuses';
    protected $fillable = ['id','name','slug'];

    public function task(){

        return $this->belongsTo(Task::class,'status_id','id');

    }

}


