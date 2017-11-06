<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TaskCategoryType extends Eloquent
{

    protected $table    = 'tasks_categories_types';
    protected $fillable = ['task_id','task_category_id','task_category_id','type_id'];


    public function task(){

        return $this->belongsTo(Task::class);
    }


    public function category(){

        return $this->belongsTo(TaskCategory::class);
    }

    public  function tasks(){

        return $this->belongsTo(Task::class,'task_id','id');
    }

    public function store($task,$type_id){

        TaskCategoryType::create(
                                    [
                                        'task_id'          => $task->id,
                                        'task_category_id' => $task->task_category_id,
                                        'type_id'          => $type_id
                                    ]
                                );

    }



}
