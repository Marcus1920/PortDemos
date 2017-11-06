<!-- Modal Default -->
@extends('master')

@section('content')
    <div class="block-area" id="basic">
        <!-- Breadcrumb -->
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('tasks') }}">TASK LIST</a></li>
            <li><a href="{{ url('tasks/'.$task->id) }}">TASK PROFILE</a></li>
            <li class="active">CHANGE DATES REQUEST</li>
        </ol>

        <h4 class="page-title">CHANGE DATES REQUEST </h4>

        <br>
        <div class="tile p-15">
        {!! Form::open(['url' => 'dateChangeRequest', 'method' => 'post', 'class' => 'form' ]) !!}
        {!! Form::hidden('id',Auth::user()->id) !!}
        {!! Form::hidden('activity_note','requested date change') !!}
        <input type="hidden" name="task_id" value="{{ $task->id }}">

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

        &nbsp;

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

        &nbsp;

        <div class="form-group">
            <label for="inputMessage" class="col-md-2 control-label">Note</label>
            <div class="col-md-10">
            <textarea class="form-control  input-sm"  rows="5"  id="note" rows="3" name="note">
            </textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-info btn-sm m-t-10">REQUEST DATE CHANGE</button>
            </div>
        </div>
        {!! Form::close() !!}
        </div>
    </div>
@endsection




