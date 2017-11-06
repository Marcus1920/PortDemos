<!-- Modal Default -->
@extends('master')

@section('content')
    <div class="block-area" id="basic">
        <!-- Breadcrumb -->
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('tasks') }}">TASK LIST</a></li>
            <li class="active">ADD A NEW TASK</li>
        </ol>

        <h4 class="page-title">ADD A NEW TASK </h4>

        <br>
        <div class="tile p-15">
            {!! Form::open(['url' => 'tasks', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addTaskCaptureForm" ]) !!}
            {!! Form::hidden('id',Auth::user()->id) !!}
            {!! Form::hidden('parent_id',$parent_id ) !!}

            <div class="form-group">
                {!! Form::label('Task Category', 'Task Category', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::select('task_category_id',$selectTaskCategories,"",['class' => 'form-control validate[required]' ,'id' => 'task_category_id']) !!}
                    @if ($errors->has('task_category_id')) <p class="help-block red">*{{ $errors->first('task_category_id') }}</p> @endif
                </div>
            </div>

            <div class="form-group searchCase hidden">
                {!! Form::label('Search Case', 'Search Case', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('case_id',NULL,['class' => 'form-control input-sm','id' => 'case_id','disabled']) !!}
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
                {!! Form::label('Task Delegation', 'Task Delegation', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('task_user_id',NULL,['class' => 'form-control input-sm','id' => 'task_user_id']) !!}
                    @if ($errors->has('task_user_id')) <p class="help-block red">*{{ $errors->first('task_user_id') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('From', 'From', array('class' => 'col-md-3 control-label')) !!}
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
                {!! Form::label('To', 'To', array('class' => 'col-md-3 control-label')) !!}
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
        <div class="modal-footer">

        </div>

        {!! Form::close() !!}
    </div>
    </div>
@endsection

@section('footer')
    <script>

        $('#task_category_id').on('change',function(){

            var selectText  = $(this).find("option:selected").text();

            if(selectText == 'Case' ){

                $('.searchCase').removeClass('hidden');
                $("#case_id").removeAttr('disabled');

            } else {

                $('.searchCase').addClass('hidden');
                $("#case_id").attr('disabled','disabled');
            }

        })


        $("#task_user_id").tokenInput("{!! url('/getUsers')!!}",{tokenLimit:1});
        $("#case_id").tokenInput("{!! url('/getCases')!!}",{tokenLimit:1});


    </script>

@endsection