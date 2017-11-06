<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaskPriority extends Eloquent
{
    protected $table    = 'task_priorities';

    public function task(){

        return $this->belongsTo(Task::class);
    }

}
