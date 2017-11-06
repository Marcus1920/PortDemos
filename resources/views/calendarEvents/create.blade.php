@extends('master')

@section('content')

<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="{{ url('calendar/events') }}">Calendar</a></li>
    <li class="active"><a href="#" class="active">Create Event</a></li>
</ol>
<h4 class="page-title">CREATE EVENT</h4>

<!-- Basic with panel-->
<div class="block-area" id="basic">
    
    <div class="tile p-15">
        {!! Form::open(['url' => '#', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"registrationForm" ]) !!}

          

            <div class="form-group">
                {!! Form::label('Title', 'Title', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('title',NULL,['class' => 'form-control input-sm','id' => 'title']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('CalendarType', 'Calendar Type', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">

                <div class="input-group">
                  {!! Form::select('eventType',$selectCalendarEventTypes,0,['class' => 'form-control input-sm' ,'id' => 'eventType']) !!}
                  <div class="input-group-addon" onclick="location.href='event-types'" title="Add New" style="cursor:pointer;">
                    <span class="glyphicon glyphicon-plus"></span>
                  </div>
                </div>
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
                {!! Form::label('Start Date', 'Start Date', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <div class="input-icon datetime-pick date-only">
                      <input data-format="yyyy-MM-dd" type="text" id='start_date' name ='start_date' class="form-control input-sm" />
                      <span class="add-on">
                          <i class="sa-plus"></i>
                      </span>
                    </div>
                    <div id='error_meeting_date'></div>
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('End Date', 'End Date', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <div class="input-icon datetime-pick date-only">
                      <input data-format="yyyy-MM-dd" type="text" id='end_date' name ='end_date' class="form-control input-sm" />
                      <span class="add-on">
                          <i class="sa-plus"></i>
                      </span>
                    </div>
                    <div id='error_meeting_date'></div>
              </div>
            </div>

            <hr class="whiter m-t-20">
            <hr class="whiter m-b-20">

            <div class="form-group">
                    {!! Form::label('Note', 'Note', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-6">
                        <textarea rows="6" id="note" name="note" class="form-control" maxlength="500"></textarea>
                    </div>
            </div>

             <div class="form-group">
                {!! Form::label('Venue', 'Venue', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::text('venue',NULL,['class' => 'form-control input-sm','id' => 'venue']) !!}
                </div>
            </div>

            <hr class="whiter m-t-20">
            <hr class="whiter m-b-20">


            
            <div class="form-group">
                <div class="col-md-offset-3 col-md-6">
                    <button type="button" id='submitEventForm' class="btn btn-info btn-sm m-t-10">Add Event</button>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('footer')
<script>
   $(document).ready(function() {
      $('#submitEventForm').click(function(){

        var title             = $("#title").val();
        var eventType         = $("#eventType").val();
        var description       = $("#description").val();
        var start_date        = $("#start_date").val();
        var end_date          = $("#end_date").val();
        var note              = $("#note").val();
        var venue             = $("#venue").val();
        var token             = $('input[name="_token"]').val();

        var formData         = {
                              title:title,
                              eventType:eventType,
                              description:description,
                              start_date:start_date,
                              end_date:end_date,
                              note:note,
                              venue:venue
      };

      $.ajax({
          type    :"POST",
          data    : formData,
          headers : { 'X-CSRF-Token': token },
          url     :"{!! url('/calendar/events/createEvent')!!}",
          success : function(response){
             window.location = '{{url('calendar/events')}}';
          },
      })

      })
  })

</script>
@endsection
