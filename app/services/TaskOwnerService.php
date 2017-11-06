<?php

namespace App\Services;
use App\Http\Requests;
use App\TaskOwner;
use Auth;

class TaskOwnerService
{


    public function getOwners($task_id){

    $owners = TaskOwner::where('task_id',$task_id)->with('user','ownerType')->get();
    return $owners;

  }

  public function getTaskAssigneeOwner($task_id){

      $assignee = $this->getOwners($task_id)->where('task_owner_type_id',2);
      return $assignee->first();

  }

    public function getTaskCreatorOwner($task_id){

        $creator = $this->getOwners($task_id)->where('task_owner_type_id',1);
        return $creator->first();

    }

  public function addTaskOwner($form){

      $taskOwner                        = new TaskOwner;
      $taskOwner->task_owner_type_id    = 2;
      $taskOwner->user_id               = $form['task_assignee_id'];
      $taskOwner->task_id               = $form['task_id'];
      $taskOwner->save();
  }

  public function deleteTaskOwner($taskOwner){

      $taskOwner->delete();

  }

  public function acceptTask($id){

    $taskOwner         = TaskOwner::where('task_id',$id)->where('task_owner_type_id',2)->first();
    $taskOwner->accept = 1;
    $taskOwner->save();

  }

    public function rejectTask($id){

        $taskOwner          = TaskOwner::where('task_id',$id)->where('task_owner_type_id',2)->first();
        $taskOwner->delete();

    }


}