<!-- Modal Default -->
@extends('master')

@section('content')
    <div class="block-area" id="basic">
        <!-- Breadcrumb -->
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('calendar/events') }}">Calendar Events</a></li>
            <li><a href="{{ url('calendar-group') }}">Calendar Group List</a></li>
            <li class="active">Edit Calendar Group</li>
        </ol>

        <h4 class="page-title">EDIT A CALENDAR GROUP</h4>

        <br>
        <div class="tile p-15">
            {!! Form::open(['url' => 'calendar-group/updateCalendarGroup', 'method' => 'post', 'class' => 'form-horizontal' ]) !!}

            {!! Form::hidden('calendar_group_id',$calendarGroup->id) !!}
            <div class="form-group">
                {!! Form::label('Calendar Group Name ', 'Calendar Group Name', array('class' => 'col-md-3 control-label validate[required]')) !!}
                <div class="col-md-6">
                    {!! Form::text('name',$calendarGroup->name,['class' => 'form-control input-sm','id' => 'name']) !!}

                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Description', 'Description', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::textarea('description',  $calendarGroup->description , ['class' => 'form-control input-sm','id' => 'description','size' => '30x5']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-3 col-md-10">
                    <button type="submit" type="button" class="btn btn-sm">SAVE CHANGES</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection