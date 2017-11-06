@extends('master')

@section('content')
    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="{{ url('calendar/events') }}">Calendar Events</a></li>
        <li><a href="{{ url('calendar-group') }}">Calendar Group List</a></li>
        <li><a href="{{ url('calendar-group-user',$calendar_group_id) }}">Calendar Group Users List</a></li>
        <li class="active">Calendar User Groups</li>
    </ol>

    <h4 class="page-title">Add Calendar User Groups</h4>
    <!-- Responsive Table -->
    <div class="tile p-15">
        {!! Form::open(['url' => 'calendar-group-users', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addCalendarGroupUsers" ]) !!}
        {!! Form::hidden('calendar_group_id',$calendar_group_id) !!}

        <div class="form-group">
            {!! Form::label('Calendar User Groups', 'Calendar User Groups', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-6">
                {!! Form::text('calendar_group_user_id',NULL,['class' => 'form-control input-sm','id' => 'calendar_group_user_id']) !!}
                @if ($errors->has('calendar_group_user_id')) <p class="help-block red">*{{ $errors->first('calendar_group_user_id') }}</p> @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3 col-md-10">
                <button type="submit" type="button" class="btn btn-sm">Add Calendar User Groups</button>
            </div>
        </div>
    </div>

@endsection
@section('footer')
    <script>

        $("#calendar_group_user_id").tokenInput("{!! url('/getUserRoles')!!}",{tokenLimit:100});

    </script>

@endsection
