{!! Form::open(['url' => 'tasks/updateTask', 'method' => 'post', 'class' => 'form-horizontal' ]) !!}

{!! Form::hidden('task_id',$task->id) !!}
{!! Form::hidden('id',Auth::user()->id) !!}
{!! Form::hidden('task_assignee_id','',['id' => 'task_assignee_id']) !!}
<div class="form-group">
    <label for="inputTitle" class="col-md-2 control-label">Title</label>
    <div class="col-md-10">

        <input class="form-control input-sm" type="text" id="title"  name="title" value="{{$task->title}}">

    </div>
</div>
<hr class="whiter m-t-10" /><br>
<div class="form-group">
    <label for="inputCategory" class="col-md-2 control-label">Category</label>
    <div class="col-md-10">

        {!! Form::select('task_category_id',$selectTaskCategories,$task->category->id,['class' => 'form-control input-sm' ,'id' => 'task_category_id']) !!}

    </div>
</div>
<hr class="whiter m-t-10" /><br>

<div class="form-group">
    <label for="assigned" class="col-md-2 control-label">Task Delegation</label>
    <div class="col-md-10">

        {!! Form::text('task_assignee',null ,['class' => 'form-control input-sm','id' => 'task_assignee']) !!}

    </div>
</div>

<hr class="whiter m-t-10" /><br>

<div class="form-group">
    {!! Form::label('Description', 'Description', array('class' => 'col-md-2 control-label')) !!}
    <div class="col-md-10">

        {!! Form::textarea('description',  $task->description , ['class' => 'form-control input-sm','id' => 'description','size' => '30x5']) !!}
    </div>
</div>

<hr class="whiter m-t-10" /><br>
<h3 class="block-title">TASK SETTINGS</h3>

<div class="form-group">
    <label for="inputPriority" class="col-md-2 control-label">Priority</label>
    <div class="col-md-10">

        {!! Form::select('priority_id',$selectTaskPriorities,$task->priority->id,['class' => 'form-control input-sm' ,'id' => 'task_category_id']) !!}

    </div>
</div>

<hr class="whiter m-t-10" /><br>

<div class="form-group">
    <label for="inputStatus" class="col-md-2 control-label">Status</label>
    <div class="col-md-10">

        {!! Form::select('status_id',$selectTaskStatuses,$task->status->id,['class' => 'form-control input-sm' ,'id' => 'task_category_id']) !!}

    </div>
</div>

<hr class="whiter m-t-10" /><br>

<div class="form-group">
    <label for="inputPercentageComplete" class="col-md-2 control-label"> % Complete</label>
    <div class="col-md-10">


        {!! Form::text('complete',$task->complete,['class' => 'form-control input-sm spinner-2 spinedit','id' => 'complete']) !!}
        @if ($errors->has('complete')) <p class="help-block red">*{{ $errors->first('complete') }}</p> @endif


    </div>

</div>

<hr class="whiter m-t-10" /><br>
<h3 class="block-title">TASK DATES</h3>

<div class="form-group">
    <label for="inputStartDate" class="col-md-2 control-label">Start Date</label>
    <div class="col-md-10">

        <div class="input-icon datetime-pick date-only">
            <input data-format="yyyy-MM-dd" type="text" id='commencement_date' name ='commencement_date'  value="{{$task->commencement_date }}" class="form-control input-sm"  style="color:#FFFFFF"/>
            <span class="add-on">
                  <i class="sa-plus"></i>
            </span>
        </div>
        <div id = "hse_error_due_date"></div>

    </div>
</div>

<hr class="whiter m-t-10" /><br>

<div class="form-group">
    <label for="inputDueDate" class="col-md-2 control-label">Due Date</label>
    <div class="col-md-10">

        <div class="input-icon datetime-pick date-only">
            <input data-format="yyyy-MM-dd" type="text" id='due_date' name ='due_date'  value="{{ $task->due_date }}" class="form-control input-sm"  style="color:#FFFFFF"/>
            <span class="add-on">
                  <i class="sa-plus"></i>
            </span>
        </div>
        <div id = "hse_error_due_date"></div>

    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
        <button type="submit" class="btn btn-info btn-sm m-t-10">SAVE CHANGES</button>
    </div>
</div>
{!! Form::close() !!}