<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\TaskCategoryRequest;
use App\Http\Controllers\Controller;
use App\TaskCategory;

class TaskCategoriesController extends Controller
{

    protected $taskCategories;

    public function __construct(TaskCategory $taskCategory)
    {
        $this->taskCategories = $taskCategory->getTaskCategories();

    }


    public function index()
    {

        return view('tasks.categories')->with('taskCategories',$this->taskCategories);
    }


    public function store(TaskCategoryRequest $request,TaskCategory $taskCategory)
    {

        $taskCategory->addTaskCategory($request);
        return redirect()->back();

    }

    public function destroy($id,TaskCategory $taskCategory){

        $taskCategory->destroy($id);
        return back();

    }


    public function edit(Request $request,TaskCategory $taskCategory){

        $taskCategory->editTaskCategory($request);
        \Session::flash('message', 'Task category '.$request['color_name'].' has been successfully edited!');
        return redirect()->back();


    }

}
