@extends('master')

@section('content')

    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="{{ url('calendar/events') }}">Calendar</a></li>
        <li class="active">Create Event</li>
    </ol>
    <h4 class="page-title">CREATE CALENDAR</h4>

    <!-- Basic with panel-->


    @if(Session::has('success'))
        <div class="alert alert-success alert-icon">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('success') }}
            <i class="icon">&#61845;</i>
        </div>
    @endif

    <div class="block-area" id="basic">
        <div class="tile p-15">
            {!! Form::open(['url' => 'calendars/create', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"newCalendarForm" ]) !!}
            {!! Form::hidden('calendar_group_id',$calendarGroup->id) !!}

            <div class="form-group">
                {!! Form::label('Name', 'Name', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::select('event_type_id',$selectCalendarEventType,"",['class' => 'form-control validate[required]' ,'id' => 'event_type_id']) !!}
                </div>
            </div>

            <hr class="whiter m-t-20">
            <hr class="whiter m-b-20">

            <div class="form-group">
                {!! Form::label('Description', 'Description', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <textarea rows="6" id="description" name="description" class="form-control" maxlength="500"></textarea>
                </div>
            </div>




            <div class="form-group">
                {!! Form::label('Color', 'Color', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <input type="color" name="color">
                </div>
        </div>



            <hr class="whiter m-t-20">
            <hr class="whiter m-b-20">

            <div class="form-group">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" id='submitMemberForm' class="btn btn-info btn-sm m-t-10">Add Calendar</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function()
        {
        })
    </script>
@endsection