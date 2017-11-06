<?php

namespace App\Http\Controllers;

use App\Services\TaskNoteService;
use App\Services\TaskOwnerService;
use App\Services\TaskActivityService;
use App\TaskNote;
use App\TaskActivity;
use Illuminate\Http\Request;
use illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests;
use App\Http\Requests\TaskNoteRequest;
use App\Http\Controllers\Controller;
use App\Task;
use Session;
use Redirect;

class TaskNoteController extends Controller
{

    protected $notes;
    protected $taskOwners;
    protected $taskActivity;

    public function __construct(TaskNoteService $noteService,TaskOwnerService $taskOwnerService,TaskActivityService $taskActivityService )
    {
        $this->notes       = $noteService;
        $this->taskOwners  = $taskOwnerService;
        $this->taskActivity= $taskActivityService;
    }

    public function index()
    {

          $data=$this->notes->getnotes();
          return response()->json($data);
    }

    public function show($task_id){

        return view('tasknotes.add',compact('task_id'));

    }

    public function store(TaskNoteRequest $request)
    {
        $taskNote     = $this->notes->createNotes($request);
        $taskOwners   = $this->taskOwners->getOwners($taskNote->task_id);
        $taskActivity = $this->taskActivity->createTaskActivity($request);
        $this->sendNotes($taskOwners,$taskNote);
        \Session::flash('success', 'well done! Task note for Task '.$taskActivity['task_id'].' has been successfully added!');
        return Redirect::to('tasks/'.$taskActivity['task_id']);

    }

    public function sendNotes($taskOwners,$taskNote){

        foreach ($taskOwners as $taskOwner){

            $data = array(
                'name'             => $taskNote->user->name,
                'task_id'          => $taskNote->task_id,
                'task_description' => $taskNote->note,
                'author'           => $taskNote->user->name ." ".$taskNote->user->surname
            );

            \Mail::send('emails.tasks.note',$data, function($message) use ($taskOwner)
            {
                $message->from('info@siyaleader.net', 'Siyaleader');
                $message->to($taskOwner->user->email)->subject("Siyaleader Notification - New Task Note: ");

            });

        }


    }


}
