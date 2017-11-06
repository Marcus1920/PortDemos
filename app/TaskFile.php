<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaskFile extends Eloquent
{
    protected $table    = 'tasks_files';


    public function task(){

        return $this->belongsTo(Task::class);
    }

}
