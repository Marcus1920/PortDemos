@extends('master')

@section('content')

<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="{{ url('calendar/events') }}">Calendar</a></li>
    <li class="active"><a href="create">Create Event</a></li>
    <li class="active"><a href="#" class="active">Create Event Type</a></li>
</ol>
<h4 class="page-title">CREATE EVENT TYPE</h4>

<!-- Basic with panel-->
<div class="block-area" id="basic">
    
    <div class="tile p-15">
        {!! Form::open(['url' => 'calendar/event-types/create', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"registrationForm" ]) !!}

          

            <div class="form-group">
                {!! Form::label('Name', 'Name', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'title']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Color', 'Color', array('class' => 'col-md-3 control-label')) !!}
                 <div class="col-md-6">
                  <input type="color" name="color" class="form-control">
                </div>
                
            </div>

             <hr class="whiter m-t-20">
             <hr class="whiter m-b-20">

            
            <div class="form-group">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" id='submitMemberForm' class="btn btn-info btn-sm m-t-10">Add Event Type</button>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('footer')
<script>
   $(document).ready(function() {

  })

</script>
@endsection
