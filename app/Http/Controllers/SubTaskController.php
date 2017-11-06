<?php

namespace App\Http\Controllers;

use App\services\SubTaskService;
use App\services\TaskService;
use Illuminate\Http\Request;
use session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubTaskController extends Controller
{
    protected $subtasks;
    protected $tasks;


    public function __construct(SubTaskService $service,TaskService $taskService)
    {
        $this->subtasks=$service;
        $this->tasks=$taskService;

    }

    public function index()
    {

    }

    public function create($id)
    {
        $task_id=$id;
        return view('subTasks.create',compact('task_id'));
    }

    public function store(Request $request)
    {
        $task=$this->tasks->storeTask($request);
        $subTaskId=$task->id;
        $data=$this->subtasks->createSubTask($request,$subTaskId);

        return response()->json($data);

//        \Session::flash('success', 'well done! Sub Task for Task '.$data['task_id'].' has been successfully added!');
//        return Redirect::to('tasks/'.$data['task_id']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
