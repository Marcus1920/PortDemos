{!! Form::open(['url' => 'caseTasks', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addTaskCaptureForm" ]) !!}
{!! Form::hidden('task_category_id',1) !!}
<input type="hidden" name="case_id" value="{{ $case->id }}">

<div class="form-group">
    {!! Form::label('Task Delegation', 'Task Delegation', array('class' => 'col-md-3 control-label')) !!}
    <div class="col-md-6">
        {!! Form::text('task_user_id',NULL,['class' => 'form-control input-sm','id' => 'task_user_id']) !!}
        @if ($errors->has('task_user_id')) <p class="help-block red">*{{ $errors->first('task_user_id') }}</p> @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('Task Title', 'Task Title', array('class' => 'col-md-3 control-label validate[required]')) !!}
    <div class="col-md-6">
        {!! Form::text('title',NULL,['class' => 'form-control input-sm','id' => 'title']) !!}
        @if ($errors->has('title')) <p class="help-block red">*{{ $errors->first('title') }}</p> @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('Start', 'Start', array('class' => 'col-md-3 control-label')) !!}
    <div class="col-md-6">
        <div class="input-icon datetime-pick date-only">
            <input data-format="yyyy-MM-dd" type="text" id='commencement_date' name ='commencement_date' class="form-control input-sm"  style="color:#FFFFFF"/>
            <span class="add-on">
                      <i class="sa-plus"></i>
                            </span>
        </div>
        <div id = "hse_error_due_date"></div>

    </div>
</div>

<div class="form-group">
    {!! Form::label('Finish', 'Finish', array('class' => 'col-md-3 control-label')) !!}
    <div class="col-md-6">
        <div class="input-icon datetime-pick date-only">
            <input data-format="yyyy-MM-dd" type="text" id='due_date' name ='due_date' class="form-control input-sm"  style="color:#FFFFFF"/>
            <span class="add-on">
                      <i class="sa-plus"></i>
                            </span>
        </div>
        <div id = "hse_error_due_date"></div>

    </div>
</div>

<div class="form-group">
    {!! Form::label('Priority', 'Priority', array('class' => 'col-md-3 control-label')) !!}
    <div class="col-md-6">
        {!! Form::select('priority_id',$selectTaskPriorities,"",['class' => 'form-control validate[required]' ,'id' => 'priority_id']) !!}
        @if ($errors->has('priority_id')) <p class="help-block red">*{{ $errors->first('priority_id') }}</p> @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('Description', 'Description', array('class' => 'col-md-3 control-label')) !!}
    <div class="col-md-6">
        <textarea rows="5" id="description" name="description" class="form-control" maxlength="500" title="short"></textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-3 col-md-10">
        <button type="submit" type="button" class="btn btn-sm">Add Task</button>
    </div>
</div>
</div>

{!! Form::close() !!}