<!-- Modal Default -->
<div class="modal fade modalEditEvent" id="modalEditEvent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id='depTitle'>EDIT EVENT</h4>
            </div>
            <div class="modal-body">
            
 
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
                    <button type="button" id='editEventForm' class="btn btn-info btn-sm m-t-10">Edit Event</button>
                </div>
            </div>

        {!! Form::close() !!}
    
            
        </div>
    </div>
</div>
