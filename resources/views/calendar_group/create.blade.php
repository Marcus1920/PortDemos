<!-- Modal Default -->
@extends('master')

@section('content')
    <div class="block-area" id="basic">
        <!-- Breadcrumb -->
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('calendar/events') }}">CALENDAR EVENTS</a></li>
            <li class="active">ADD CALENDAR GROUP</li>
        </ol>

        <h4 class="page-title">ADD A CALENDAR GROUP</h4>

        <br>
        <div class="tile p-15">
            {!! Form::open(['url' => 'calendar-group', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addTaskCaptureForm" ]) !!}
            {!! Form::hidden('id',Auth::user()->id) !!}

            <div class="form-group">
                {!! Form::label('Calendar Group Name ', 'Calendar Group Name', array('class' => 'col-md-3 control-label validate[required]')) !!}
                <div class="col-md-6">
                    {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'name']) !!}

                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Description', 'Description', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <textarea rows="5" id="description" name="description" class="form-control" maxlength="500" title="short"></textarea>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Calendar User Groups', 'Calendar User Groups', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('calendar_group_user_id',NULL,['class' => 'form-control input-sm','id' => 'calendar_group_user_id']) !!}
                    @if ($errors->has('calendar_group_user_id')) <p class="help-block red">*{{ $errors->first('calendar_group_user_id') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-3 col-md-10">
                    <button type="submit" type="button" class="btn btn-sm">Add Calendar Group</button>
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

        $("#calendar_group_user_id").tokenInput("{!! url('/getUserRoles')!!}",{tokenLimit:100});
        
    </script>

@endsection