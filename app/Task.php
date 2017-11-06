<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Validator;

class Task extends Eloquent
{
    protected $table     = 'tasks';


    public function notes()

    {

        return $this->hasMany(TaskNote::class);

    }

    public function category(){

        return $this->hasOne(TaskCategory::class, 'id','task_category_id');

    }

    public  function files(){

        return $this->hasMany(TaskFile::class);
    }

    public  function priority(){

        return $this->hasone(TaskPriority::class,'id','priority_id');
    }

    public  function status(){

        return $this->hasone(TaskStatus::class,'id','status_id');

    }

    public  function user(){

        return $this->belongsTo(User::class,'created_by');

    }

    public  function subtasks(){

        return $this->hasMany(SubTask::class);
    }

    public function owners(){

        return $this->hasMany(TaskOwner::class);

    }

    public function taskActivity()

    {

        return $this->hasMany(TaskActivity::class);

    }

    public function taskReminder()

    {

        return $this->hasOne(TaskReminder::class);

    }
}
