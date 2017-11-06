@extends('master')

@section('content')
    <div class="block-area" id="basic">
        <!-- Breadcrumb -->
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('tasks') }}">TASK LIST</a></li>
            <li><a href="{{ url('tasks',$task_id) }}">TASK PROFILE</a></li>
            <li class="active">ADD TASK RELATIONSHIP</li>
        </ol>

        <h4 class="page-title">ADD TASK RELATIONSHIP </h4>

        <br>
        <div class="tile p-15">
            {!! Form::open(['url' => 'tasks/addTaskRelationship', 'method' => 'post', 'class' => 'form-horizontal' ]) !!}
            {!! Form::hidden('id',Auth::user()->id) !!}
            {!! Form::hidden('task_id',$task_id) !!}

            <div class="col-md-4">

                {!! Form::label('Relationship', 'Relationship', array('class' => '')) !!}
                {!! Form::select('relationship',['child' => 'Child','parent' => 'Parent' ],1,['class' => 'form-control input-sm' ,'id' => 'role']) !!}

            </div>

            <div class="form-group">
                {!! Form::label('Search Task', 'Search Task', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('search_task',NULL,['class' => 'form-control input-sm','id' => 'search_task']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-3 col-md-10">
                    <button type="submit" type="button" class="btn btn-sm">Add Relationship</button>
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

        $("#search_task").tokenInput("{!! url('/getSearchTasks')!!}",{tokenLimit:1});

    </script>



@endsection

