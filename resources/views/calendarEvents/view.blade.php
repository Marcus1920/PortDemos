

@extends('master')

@section('content')

    <!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="{{ url('/home') }}">Home</a></li>
    <li class="active">Calendar</li>
</ol>
<h4 class="page-title">CALENDAR EVENTS</h4>



    <br>

    <div class="block-area container">
        <div class="row">
            <div class="col-md-3">

                <div class="form-group">
                    <div class="pull-left">
                        <button type="button" onclick="location.href='events/create'" class="btn btn-sm"><i class="glyphicon glyphicon-calendar" style="margin-right: 10px;"></i>Add Personal Event</button>


                    </div>
                </div>

            <br>
            <br>

                <div class="tile">
                    <h2 class="tile-title">Categories</h2>

                    <div class="listview icon-list" style="padding: 10px;">
                        {!! Form::select('eventType',$selectCalendarEventType,0,['class' => 'form-control input-sm' ,'id' => 'eventType']) !!}
                    </div>
                </div>


				{{--<a href="{{ url('calendar-group/create') }}" class="btn btn-sm" style="margin-bottom: 10px">
					<i class="fa fa-plus" aria-hidden="true"  data-toggle="tooltip">Add Calendar Group</i>
				</a>--}}

                <div class="tile">

					<h2 class="tile-title"><b>Calendar Groups</b></h2>
					<div class="listview narrow">
						<div class="panel-group">
							@foreach($calendarGroups as $calendarGroup)
							<div class="panel panel-default">
								<div class="panel-heading">
                                    {{--<a href="{{ url('calendar/create',$calendarGroup->id) }}" class="pull-right text-right">--}}
                                        {{--<i class="fa fa-plus" aria-hidden="true"></i>--}}
                                    {{--</a>--}}
									<h4 class="panel-title">

                                        <a data-toggle="collapse" href="#{{$calendarGroup->id}}">{{$calendarGroup->name}}</a>
                                    </h4>
								</div>
								<div id="{{$calendarGroup->id}}" class="panel-collapse collapse in">
									<ul class="list-group">
										@if($calendarGroup->calendar->count())
											@foreach($calendarGroup->calendar as $calendar)
												@foreach($calendar->calendarEventType as $cal)
												<li class="list-group-item" 
														style="background-color: 
														{{ $cal->color }}" href="#">

														{{ $cal->name }}
														<div class="toggle toggle-light"  onclick="getEventsPerCalendar({{ $calendar->id }})" ></div>

												</li>
												
												@endforeach
											@endforeach
										@endif
									</ul>

								</div>
							</div>
								@endforeach
						</div>
					</div>
                </div>

            </div>

            <div class="col-md-9">
                <div id="calendar" class="p-relative p-10 m-b-20">
                <!-- Calendar Views -->
        <ul class="calendar-actions list-inline clearfix">
            <li class="p-r-0">
                <a data-view="month" href="#" class="tooltips" title="Month">
                    <i class="sa-list-month"></i>
                </a>
            </li>
            <li class="p-r-0">
                <a data-view="agendaWeek" href="#" class="tooltips" title="Week">
                    <i class="sa-list-week"></i>
                </a>
            </li>
            <li class="p-r-0">
                <a data-view="agendaDay" href="#" class="tooltips" title="Day">
                    <i class="sa-list-day"></i>
                </a>
            </li>
        </ul>
    </div>
            </div>

        </div>

    </div>

@include('cases.profile')
@include('functions.caseModal')
@include('calendarEvents.addEvent')
@endsection
@section('footer')
<script type="text/javascript">

$('.toggle').toggles({
  drag: true, // allow dragging the toggle between positions
  click: true, // allow clicking on the toggle
  text: {
    on: 'ON', // text for the ON position
    off: 'OFF' // and off
  },
  on: false, // is the toggle ON on init
  animate: 250, // animation time (ms)
  easing: 'swing', // animation transition easing function
  checkbox: null, // the checkbox to toggle (for use in forms)
  clicker: null, // element that can be clicked on to toggle. removes binding from the toggle itself (use nesting)
  width: 50, // width used if not set in css
  height: 20, // height if not set in css
  type: 'compact' // if this is set to 'select' then the select style toggle will be used
});

  var calendar_id=0;	
  function getEventsPerCalendar(id){
	calendar_id=id;
  }
  

$('.toggle').on('toggle', function(e, active) {
  if (active) {

  	 //$('#calendar').fullCalendar('destroy');	
		 $.ajax({
			type    :"GET",
			dataType:"json",
			url: "{!! url('getCalendarsPerGroup/" + calendar_id + "')!!}",
			success :function(data) {

				$('#calendar').fullCalendar('addEventSource',"{!! url('getCalendarsPerGroup/" + calendar_id + "')!!}");
				
			}
					
			});
			
	
  } else {
    $('#calendar').fullCalendar('removeEventSource',"{!! url('getCalendarsPerGroup/" + calendar_id + "')!!}");
  }
});


    $('#landings_calenda').fullCalendar({
        header: {
            center: 'title',
            left: 'prev, next',
            right: ''
        },
        eventClick: function(calEvent, jsEvent, view) {

            var id = calEvent.title;
            //var due_date = calEvent.due_date;
            var caseid = id.substring(9,id.length);
            /*var moment = $('#calendar').fullCalendar('getDate');
            var iMoment = new Date(moment);
            var iDue_date = new Date(due_date.substring(0,4),due_date.substring(5,7),due_date.substring(8,10));
            if(iMoment > iDue_date){
                alert("greater");
            }else{
                alert("lesser" + moment.getDate());
            }*/

            launchCaseModal(caseid);
            $('#modalCase').modal('show');
            $(this).css('border-color', 'red');

        },

        selectable: true,
        selectHelper: true,
        editable: false,

        /*events: {
            url: "{!! url('/" + url+ "/')!!}",
                        error: function() {
                            $('#script-warning').show();
                        }
                    },*/

        eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
            $('#editEvent').modal('show');

            var info =
                "The end date of " + event.title + "has been moved " +
                dayDelta + " days and " +
                minuteDelta + " minutes."
            ;

            $('#eventInfo').html(info);


            $('#editEvent #editCancel').click(function(){
                revertFunc();
            })
        }
    });








    $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
		var url =  'calendar/events/getEvents';
		
		$('#refresh').click(function() {
			var moment = $('#calendar').fullCalendar('getDate');
			//var tomorrow = new Date.today().addDays(1).toString("dd-mm-yyyy");
			var tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000)
			
			if(moment > tomorrow){
				alert("greater");
			}{
				alert("lesser");
			}
			//alert('hey');
		});

        $('#calendar').fullCalendar({
            header: {
                 center: 'title',
                 left: 'prev, next',
                 right: ''
            },
        	eventClick: function(calEvent, jsEvent, view) {
			
        		alert(calEvent.id);
          	},

          	dayClick: function(date, jsEvent, view) {
          		$('#modalAddEvent').modal('toggle');
   			},

            selectable: true,
            selectHelper: true,
            editable: false,

			events: {
			//	url: "{!! url('/" + url+ "/')!!}",
				error: function() {
					$('#script-warning').show();
				}
			},

            eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
                $('#editEvent').modal('show');

                var info =
                    "The end date of " + event.title + "has been moved " +
                    dayDelta + " days and " +
                    minuteDelta + " minutes."
                ;

                $('#eventInfo').html(info);


                $('#editEvent #editCancel').click(function(){
                     revertFunc();
                })
            }
        });

        $('body').on('click', '#addEvent', function(){
             var eventForm =  $(this).closest('.modal').find('.form-validation');
             eventForm.validationEngine('validate');

             if (!(eventForm).find('.formErrorContent')[0]) {

                  //Event Name
                  var eventName = $('#eventName').val();

                  //Render Event
                  $('#calendar').fullCalendar('renderEvent',{
                       title: eventName,
                       start: $('#getStart').val(),
                       end:  $('#getEnd').val(),
                       allDay: true,
                  },true ); //Stick the event

                  $('#addNew-event form')[0].reset()
                  $('#addNew-event').modal('hide');
             }
        });
    });
	
	$("#eventType").change(function(){
		$('#calendar').fullCalendar('destroy');

		var id 		= $("#eventType").val();
		var token   = $('input[name="_token"]').val();

		var formData         = {                      
									id: id
       						   };
		
		var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
		var url = "";
		
		if(id == "-- Select  All --"){
			url = "cases-calendar-list";
		}else{
			url = "calendar/events/getEventPerType/" + id;
		}
		
		
		 $.ajax({
			type    :"GET",
			dataType:"json",
			data    : formData,
          	headers : { 'X-CSRF-Token': token },
			url     : "{!! url('/" + url+ "')!!}",
			success :function(data) {

				$('#calendar').fullCalendar({
					header: {
					 center: 'title',
					 left: 'prev, next',
					 right: ''
				},
				eventClick: function(calEvent, jsEvent, view) {
				
					var id = calEvent.title;
					var caseid = id.substring(9,id.length);
					launchCaseModal(caseid,1);
					$('#modalCase').modal('show');
					 
				
					 // alert('Event: ' + calEvent.title);
					  //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
					  //alert('View: ' + view.name);
					  // change the border color just for fun
					  $(this).css('border-color', 'red');

				},

				selectable: true,
				selectHelper: true,
				editable: false,
			
				events: {
					url: "{!! url('/" + url+ "')!!}",
					error: function() {
						$('#script-warning').show();
					}
				},
			

				eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
					$('#editEvent').modal('show');

					var info =
						"The end date of " + event.title + "has been moved " +
						dayDelta + " days and " +
						minuteDelta + " minutes."
					;

					$('#eventInfo').html(info);


					$('#editEvent #editCancel').click(function(){
						 revertFunc();
					})
				}
			});

			$('body').on('click', '#addEvent', function(){
				 var eventForm =  $(this).closest('.modal').find('.form-validation');
				 eventForm.validationEngine('validate');

				 if (!(eventForm).find('.formErrorContent')[0]) {

					  //Event Name
					  var eventName = $('#eventName').val();

					  //Render Event
					  $('#calendar').fullCalendar('renderEvent',{
						   title: eventName,
						   start: $('#getStart').val(),
						   end:  $('#getEnd').val(),
						   allDay: true,
					  },true ); //Stick the event

					  $('#addNew-event form')[0].reset()
					  $('#addNew-event').modal('hide');
				 }
			});
			}
		});
		
		
		
        
	});

    //Calendar views
    $('body').on('click', '.calendar-actions > li > a', function(e){
        e.preventDefault();
        var dataView = $(this).attr('data-view');
        $('#calendar').fullCalendar('changeView', dataView);

        //Custom scrollbar
        var overflowRegular, overflowInvisible = false;
        overflowRegular = $('.overflow').niceScroll();
    });

</script>

@endsection

