<hr class="whiter m-t-20">
<hr class="whiter m-b-20">
                {!! Form::open(['url' => 'escalateCase', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"escalateCaseForm" ]) !!}
                <input type="hidden" name="caseID" value="{{ $case->id }}">
                {!! Form::hidden('modalType',NULL,['id' => 'modalType']) !!}

		<div class="form-group">
                    {!! Form::label('Search Box', 'Search Box', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                    {!! Form::text('addresses',NULL,['class' => 'form-control input-sm','id' => 'addresses']) !!}
                </div>
                </div>
		
	      <div class="form-group">
              {!! Form::label('Due Date', 'Due Date', array('class' => 'col-md-2 control-label')) !!}
              <div class="col-md-8">     
                <div class="input-icon datetime-pick date-only">
                  <input data-format="yyyy-MM-dd" type="text" id='due_date' name ='due_date' class="form-control input-sm"/>
                  <span class="add-on">
                      <i class="sa-plus"></i>
                  </span>
              </div>
                  <div id = "hse_error_due_date"></div>

              </div>

            </div>
	    
	    <div class="form-group">
                {!! Form::label('Start Time', 'Due Time', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-8">
                    <div class="input-icon datetime-pick time-only">
                        <input data-format="hh:mm:ss" type="text" id='start_time' name='due_time' class="form-control input-sm" />
                        <span class="add-on">
                            <i class="sa-plus"></i>
                        </span>
                    </div>
                    <div id='error_meeting_start_time'></div>
                </div>
            </div>


		<hr class="whiter m-t-20">
		<hr class="whiter m-b-20">
                <div class="form-group">
                    {!! Form::label('Message', 'Message', array('class' => 'col-md-2 control-label')) !!}
                    <div class="col-md-8">
                        <textarea rows="5" id="message" name="message" class="form-control" maxlength="500"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                       <button  type="submit" class="btn btn-sm">Refer Case</button>
                    </div>
                </div>

               <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">

                    </div>
                </div>
                {!! Form::close() !!}



