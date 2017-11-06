<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TaskFileRequest;
use App\Http\Controllers\Controller;
use App\Services\TaskFileService;
use App\Services\TaskActivityService;
use App\TaskFile;
use Redirect;
use Session;

class TaskFileController extends Controller
{

    protected $TaskFiles;
    protected $taskActivity;

    public function __construct(TaskFileService $service,TaskActivityService $taskActivityService)
    {
        $this->TaskFiles=$service;
        $this->taskActivity=$taskActivityService;
    }

    public function index()
    {

        $data=$this->TaskFiles->getFiles();
        return response()->json($data);

    }


    public function create($id)
    {

        $task_id=$id;
        return view('taskfile.add',compact('task_id'));

    }


    public function store(TaskFileRequest $request)
    {

//        $this->validate($request,[
//            'file_note' => 'required',
//            'file' => 'required',
//
//        ]);

        //TODO : BRIAN CLICKING ON ATTACH FILE BREAK IF THERE IS NO ATTACHEMENT
        $file = $this->TaskFiles->createTaskFile($request);
        $taskActivity=$this->taskActivity->createTaskActivity($request);
        \Session::flash('success', 'well done! Task file for Task '.$file['task_id'].' has been successfully added!');
        return Redirect::to('tasks/'.$file['task_id']);
    }




}
