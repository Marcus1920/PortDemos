<?php

namespace App\services;
use App\Task;
use App\TaskOwner;
use App\User;
use App\TaskDateChange;
use App\TaskCategoryType;

use Auth;


class TaskService
{

    protected $task_owners;

    public function __construct(TaskOwnerService $task_owner_service)
    {

        $this->task_owners = $task_owner_service;

    }

    public function getTasksPerUser($userId,$type)
    {

        $tasks  = TaskOwner::with('user','task','task.status')
                                ->where('user_id',$userId)
                                ->where('task_owner_type_id',$type);
        return $tasks;
    }

        public function getTasks()
        {

            $tasks  = TaskOwner::with('user','task')->with('task.status');
            return $tasks;

        }
        public function getSubTasks()
        {
            return Task::all();
        }
        public function getDateChangeRequest($id)
        {
            $dateChangeRequest=TaskDateChange::where('task_id',$id)->orderBy('id','DESC')->first();
            return $dateChangeRequest;
        }

        public function getTask($id){

            $task = Task::with('status')->with('category')->with('priority')->where('id',$id)->first();
            return $task;
        }


        public function getAssignedByMeTasksPerUser($userId)
        {

            $myCreatedTasks  =  TaskOwner::where('task_owner_type_id',1)->where('user_id',$userId)->lists('task_id')->toArray();
            $myAssignedTasks =  TaskOwner::with('user','task','task.status')
                                            ->whereIn('task_id',$myCreatedTasks)
                                            ->where('task_owner_type_id',2);
            return $myAssignedTasks;

        }

        public function getCaseTasks($id)
        {
            $caseTasks=TaskCategoryType::with('tasks')->where('type_id',$id)->get();
            return $caseTasks;
        }

    public function getCaseProfile($id)
    {
        $caseProfile=TaskCategoryType::with('tasks')->where('task_id',$id)->first();

        return $caseProfile;
    }


        public function storeTask($request)
        {
            $task= new Task();
            $task->status_id                = 1;
            $task->priority_id              = $request['priority_id'];
            $task->task_category_id         = $request['task_category_id'];
            $task->title                    = $request['title'];
            $task->complete                 = 0;
            $task->due_date                 = $request['due_date'];
            $task->date_received            = $request['date_received'];
            $task->date_booked_out          = $request['date_booked_out'];
            $task->commencement_date        = $request['commencement_date'];
            $task->last_activity_date_time  = $request['last_activity_date_time'];
            $task->description              = $request['description'];
            $task->parent_id                = $request['parent_id'];
            $task->created_by               = Auth::user()->id;
            $task->save();

            return $task;
        }

        public function storeDateChangeRequest($request)
        {
            $taskDateChange                    = new TaskDateChange();
            $taskDateChange->task_id           = $request['task_id'];
            $taskDateChange->note              = $request['note'];
            $taskDateChange->commencement_date = $request['commencement_date'];
            $taskDateChange->due_date          = $request['due_date'];
            $taskDateChange->created_by        = Auth::user()->id;
            $taskDateChange->save();

            return $taskDateChange;
        }

    public function updateTask($form)
    {

            $task                       = Task::find($form['task_id']);
            $task->status_id            = $form['status_id'];
            $task->priority_id          = $form['priority_id'];
            $task->description          = $form['description'];
            $task->title                = $form['title'];
            $task->complete             = $form['complete'];
            $task->commencement_date    = $form['commencement_date'];
            $task->due_date             = $form['due_date'];
            $task->save();

            $this->assignTask($form);
            return $task;

    }

    public function updateTaskDates($request)
    {

        $task                       = Task::find($request['task_id']);
        $task->commencement_date    = $request['commencement_date'];
        $task->due_date             = $request['due_date'];
        $task->save();

        return $task;

    }

    public function addTaskParent($child_task_id,$parent_task_id){

        $task            = Task::find($child_task_id);
        $task->parent_id = $parent_task_id;
        $task->save();
    }

    public function assignTask($form){


        $task_owners = $this->task_owners->getOwners($form['task_id']);

        foreach ($task_owners as $task_owner){

            if($task_owner->ownerType->name == 'assignee'){

                if($task_owner->user_id <> $form['task_assignee_id']){

                    $this->task_owners->deleteTaskOwner($task_owner);
                    $this->task_owners->addTaskOwner($form);
                    $this->sendCommToTaskAssignee($form['task_id'],$form['task_assignee_id']);

                    //TODO : ADD TASK ACTIVITY WHEN REASSIGNING TASK

                }
            }

        }

    }


    public function sendTaskCreationCommToTaskOwner($task_id,$task_owner_id){

        $task      = Task::find($task_id);
        $taskOwner = User::find($task_owner_id);

        $data = array(
            'name'             => $taskOwner->name,
            'task_id'          => $task->id,
            'task_description' => $task->description
        );

        \Mail::send('emails.tasks.create',$data, function($message) use ($taskOwner)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($taskOwner->email)->subject("Siyaleader Notification - New Task: ");

        });
    }

    public function sendTaskAcceptanceCommToTaskOwner($task_id,$task_originator_id,$task_assignee_id){


        $task           = Task::find($task_id);
        $taskOriginator = User::find($task_originator_id);
        $taskAssignee   = User::find($task_assignee_id);

        $data = array(
            'name'             => $taskOriginator->name,
            'task_id'          => $task->id,
            'acceptedBy'       => $taskAssignee->name .' '.$taskAssignee->surname
        );

        \Mail::send('emails.tasks.accept',$data, function($message) use ($taskOriginator)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($taskOriginator->email)->subject("Siyaleader Notification - New Task: ");

        });
    }



    public function sendTaskRejectionCommToTaskOwner($task_id,$task_originator_id,$task_assignee_id){

        $task           = Task::find($task_id);
        $taskOriginator = User::find($task_originator_id);
        $taskAssignee   = User::find($task_assignee_id);

        $data = array(
            'name'             => $taskOriginator->name,
            'task_id'          => $task->id,
            'rejectedBy'       => $taskAssignee->name .' '.$taskAssignee->surname
        );

        \Mail::send('emails.tasks.reject',$data, function($message) use ($taskOriginator)
        {
            $message->from('info@siyaleader.net', 'Siyaleader');
            $message->to($taskOriginator->email)->subject("Siyaleader Notification - New Task: ");
        });
    }


    public function editTask($id)
    {

        $Taskobj= Task::find($id);
        $Taskobj->status_id = 2;
        $Taskobj->save();
        return $Taskobj;


    }

    public function rejectTask($id)
    {

        $Taskobj = Task::find($id);
        $Taskobj->status_id = 3;
        $Taskobj->save();
        return $Taskobj;

    }




}