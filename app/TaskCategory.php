<?php

namespace App;

use App\Http\Requests\TaskCategoryRequest;
use Illuminate\Database\Eloquent\Model as Eloquent;

class TaskCategory extends Eloquent
{
    protected $table    = 'task_categories';
    protected $fillable = ['name','color','slug'];


    public function task(){

        return $this->belongsTo(Task::class);
    }


    public function addTaskCategory($data){

        TaskCategory::create([ 'name' => $data['name'],'slug' => $data['name'],'color' => $data['color']]);
    }

    public function editTaskCategory($data){

        $taskCategory             = TaskCategory::find($data['task_category_id']);
        $taskCategory->name       = $data['color_name'];
        $taskCategory->color      = $data['color_code'];
        $taskCategory->save();
    }

    public function getTaskCategories(){

        return TaskCategory::all();

    }



}
