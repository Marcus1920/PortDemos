<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaskOwner extends Eloquent
{

    protected $table    = 'task_owners';
    protected $fillable = ['task_owner_type_id','user_id','task_id'];


    public  function user(){

        return $this->hasone(User::class,'id','user_id');

    }

    public  function task(){

        return $this->hasone(Task::class,'id','task_id');

    }

    public  function ownerType(){

        return $this->hasone(TaskOwnerType::class,'id','task_owner_type_id');

    }

    public function store($task,$user){

        TaskOwner::create(
            [
                'task_owner_type_id'            => 1,
                'user_id'                       => $task->created_by,
                'task_id'                       => $task->id,
            ]
        );

        TaskOwner::create(
            [
                'task_owner_type_id'            => 2,
                'user_id'                       => $user,
                'task_id'                       => $task->id,
            ]
        );

    }



}