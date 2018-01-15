@extends('master')
@section('content')
    <div class="block-area container" id="droneApproval">
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('DroneList') }}">Drone Requests List</a></li>
            <li class="active">Second Approval</li>
        </ol>
        <h4 class="page-title">Second Approval</h4>
        <br>

        <center>
                @if($droneRequest->drone_case_status==2)
                    <a aria-hidden="true">
                        {{--<h3 class="block-title">ACTION</h3>--}}

                        <div class="row" style="margin-left: 330px;">

                            <div class="col">
                                {!! Form::open(['url' => 'api/v1/finalDroneApproval/'.$droneRequest->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"secondApprovalForm" ]) !!}
                                {!! Form::hidden('user',Auth::user()->id)!!}
                                <div class="form-group" >
                                    <div class="col-md-6" style="margin-top:20px;">
                                        <button type="submit" class="btn btn-primary" id="approveId"><i  id="acceptTaskBtn"  class="fa fa-check fa-4x" aria-hidden="true"></i>Approve</button>

                                        <button type="button" class="btn  btn-danger" id="rejectId"><i  id="declineTaskBtn" class="fa fa-times fa-4x" aria-hidden="true"></i>Reject</button>


                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col">
                                {!! Form::open(['url' => 'api/v1/rejectDroneRequest/'.$droneRequest->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"secondRejectForm" ]) !!}
                                {!! Form::hidden('user',Auth::user()->id)!!}
                                <div class="form-group reason hidden ">
                                    <div class="col-md-6 col-md-offset-2" >
                                        <div class="col-md-5 " style="margin-top:10px;">
                                            <select name="reject_reason" id="reject_reason" class="form-control " required>
                                                <option value="0"  selected disabled>-select reason-</option>
                                                @foreach($droneRejectReasons as $reason)
                                                    <option value="{{$reason->id}}" name="reject_reason" id="{{$reason->id}}" required>{{$reason->reason}}</option>
                                                    @if ($errors->has('reject_reason')) <p class="help-block red">*{{ $errors->first('reject_reason') }}</p> @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="form-group otherReason hidden" >
                                    {!! Form::label('', '') !!}
                                    <div class="col-md-6">
                                        {!! Form::textarea('reject_other_reason',null,['class' => 'form-control input-sm','id' => 'reject_other_reason','placeholder'=>'other reason.','required']) !!}
                                        @if ($errors->has('reject_other_reason')) <p class="help-block red">*{{ $errors->first('reject_other_reason') }}</p> @endif
                                    </div>
                                </div>

                                <div class="form-group submit hidden" style="margin-bottom: 35px">
                                    <div class=" col-md-6">
                                        <button type="submit" class="btn btn-lg" id="submitId" onclick="getRejectToaster()" disabled>Submit</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                                <div id="snackbar">The Request was already approved</div>
                                <div id="rejectSnackbar">The Request was already rejected</div>

                            </div>
                        </div>
                    </a>
                @endif
        </center>

        @if(Session::has('success'))
            <div class="alert alert-success alert-icon">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('success') }}
                <i class="icon">&#61845;</i>
            </div>
        @endif
        <div class="row justify-content-center">

            <div  class="col-md-4">

                <h3 class="block-title">CASE DETAILS</h3>

                <table class="table" id="myTable">
                    <tbody>
                    @if($droneRequest->id=="")
                        <tr class="hidden">
                            <td>Drone Request Number</td>
                            <td> {{$droneRequest->id}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Drone Request Number</td>
                            <td> {{$droneRequest->id}}</td>
                        </tr>
                    @endif
                    @if($droneRequest->caseNumber =="")
                        <tr class="hidden">
                            <td>Case  Number</td>
                            <td> {{$droneRequest->caseNumber}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Case  Number</td>
                            <td> {{$droneRequest->caseNumber}}</td>
                        </tr>
                    @endif
                    @if($droneRequest->DroneCaseStatus->name ==" ")
                        <tr class="hidden">
                            <td>Case Status</td>
                            <td>{{$droneRequest->DroneCaseStatus->name}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Case Status</td>
                            <td>{{$droneRequest->DroneCaseStatus->name}}</td>
                        </tr>
                    @endif
                    @if($droneRequest->created_at ==" ")
                        <tr class="hidden">
                            <td>Case logged Date</td>
                            <td>{{$droneRequest->created_at}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Case logged Date</td>
                            <td>{{$droneRequest->created_at}}</td>
                        </tr>
                    @endif

                    @if($droneRequest->created_at->diffForHumans()==" ")
                        <tr class="hidden">
                            <td>Case Duration</td>
                            <td>{{$droneRequest->created_at->diffForHumans()}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Case Duration</td>
                            <td>{{$droneRequest->created_at->diffForHumans()}}</td>
                        </tr>
                    @endif


                    </tbody>
                </table>
            </div>
            <div  class="col-md-4">

                <h3 class="block-title">DRONES DETAILS</h3>

                <table class="table">
                    <tbody>
                    @if($droneRequest->User->name=="" && $droneRequest->User->surname=="" )
                        <tr class="hidden">
                            <td>Requested by</td>
                            <td>{{$droneRequest->User->name}} {{$droneRequest->User->surname}} </td>
                        </tr>
                    @else
                        <tr>
                            <td>Requested by</td>
                            <td>{{$droneRequest->User->name}} {{$droneRequest->User->surname}} </td>
                        </tr>
                    @endif
                    @if($droneRequest->DroneType->name =="")
                        <tr class="hidden">
                            <td> Drone Type</td>
                            <td>{{$droneRequest->DroneType->name}}</td>
                        </tr>
                    @else
                        <tr>
                            <td> Drone Type</td>
                            <td>{{$droneRequest->DroneType->name}}</td>
                        </tr>
                    @endif
                    @if($droneRequest->DroneSubType->name=="")
                        <tr class="hidden">
                            <td>Drone Service Request</td>
                            <td>{{$droneRequest->DroneSubType->name}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Drone Service Request</td>
                            <td>{{$droneRequest->DroneSubType->name}}</td>
                        </tr>
                    @endif
                    @if($droneRequest->Department->name=="")
                        <tr class="hidden">
                            <td>Department Requested Service</td>
                            <td>{{$droneRequest->Department->name}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Department Requested Service</td>
                            <td>{{$droneRequest->Department->name}}</td>
                        </tr>
                    @endif
                    @if($droneRequest->purposeOfSurvey=="")
                        <tr class="hidden">
                            <td>Purpose Of Survey</td>
                            <td>{{$droneRequest->purposeOfSurvey}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Purpose Of Survey</td>
                            <td>{{$droneRequest->purposeOfSurvey}}</td>
                        </tr>
                    @endif

                    @if($droneRequest->serviceRequired=="")
                        <tr class="hidden">
                            <td>Service Required</td>
                            <td>{{$droneRequest->serviceRequired}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Service Required</td>
                            <td>{{$droneRequest->serviceRequired}}</td>
                        </tr>
                    @endif

                    @if($droneRequest->scope_of_work=="")
                        <tr class="hidden">
                            <td>Scope of Work</td>
                            <td>{{$droneRequest->scope_of_work}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Scope of Work</td>
                            <td>{{$droneRequest->scope_of_work}}</td>
                        </tr>
                    @endif

                    @if($droneRequest->interest=="")
                        <tr class="hidden">
                            <td>Object of Interest</td>
                            <td>{{$droneRequest->interest}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Object of Interest</td>
                            <td>{{$droneRequest->interest}}</td>
                        </tr>
                    @endif

                    @if($droneRequest->drone_sub_service_type_id=="")
                        <tr class="hidden">
                            <td>Drone Sub Service</td>
                            <td>{{$droneRequest->drone_sub_service_type_id}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Drone Sub Service</td>
                            <td>{{$droneRequest->drone_sub_service_type_id}}</td>
                        </tr>
                    @endif

                    @if($droneRequest->numberOfStockpiles=="")
                        <tr class="hidden">
                            <td>Number Of Stockpiles</td>
                            <td>{{$droneRequest->numberOfStockpiles}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Number Of Stockpiles</td>
                            <td>{{$droneRequest->numberOfStockpiles}}</td>
                        </tr>
                    @endif
                    @if($droneRequest->vertical_accuracy=="")
                        <tr class="hidden">
                            <td>Vertical Accuracy</td>
                            <td>{{$droneRequest->vertical_accuracy}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Vertical Accuracy</td>
                            <td>{{$droneRequest->vertical_accuracy}}</td>
                        </tr>@endif
                    </tbody>
                </table>
            </div>


            <div  class="col-md-4">
                <h3 class="block-title">DRONES REQUEST ACTIVITIES</h3>
                <div class="tile">
                    <h2 class="tile-title"></h2>
                    <div class="listview narrow">
                        @foreach($droneRequestActivity as $item)
                            <div class="media p-l-5">
                                <div class="media-body">
                                    <a class="t-overflow" href="">{{$item->User->name}} {{$item->User->surname}} {{$item->activity}}  </a><br/>
                                    <small class="text-muted">{{$item->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="media text-center whiter l-100">
                    </div>
                </div>

            </div>
        </div>

        <div class="row " >

            <div class="col-md-6 col-lg-4">
                <h3 class="block-title" >NOTES</h3>
                <p style="text-align: justify;font-size: 150%;">
                    {{$droneRequest->notes}}
                </p>

            </div>
            <div class="col-md-6 col-lg-8 ">
                <h3 class="block-title">Map</h3>
                <div id="map" style="width: 100%; height: 500px">
                </div>
                <input type="hidden" name="" id="cod" value="{{$coordinates}}" class="form-control" disabled>

                <div id="show"></div>
            </div>

        </div>
        <br/>
    </div>
@endsection
@section('footer')
    <script>
        $('#rejectId').on('click',function(){
            $('.reason').removeClass('hidden');
            $('.submit').removeClass('hidden');
            $("#submitId").removeAttr('disabled');
            $("#approveId").attr('disabled','disabled');
        });

        $('#reject_reason').on('change',function(){
            var selectedval  = $(this).find("option:selected").val();
            if(selectedval == 3 ){

                $('.noneReason').removeClass('hidden');
            } else {

                $('.noneReason').addClass('hidden');
            }

        });
        $("#secondRejectForm").validate();
    </script>
    <script>
function initMap()
{

        var map = new google.maps.Map(document.getElementById('map'), 
        {
                zoom: 12,
                center: {lat:-29.8579, lng: 31.0292},
                mapTypeId: google.maps.MapTypeId.RoadMap
        });

        var codes=  document.getElementById("cod").value.split(',');
        var last = [];

        if(codes.length >2)
        {
          
            for(var i=0; i < codes.length  ; i+=2)
                {
                last.push({lat: parseFloat(codes[i]), lng: parseFloat(codes[i+1])});
                }
            var bermudaTriangle = new google.maps.Polygon({
                paths: last,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
                   });

            bermudaTriangle.setMap(map);

        }
        else
        {
           
        for(var i=0; i < codes.length ; i+=2)
            {
                
                last.push({lat: parseFloat(codes[i]), lng: parseFloat(codes[i+1])});
            }

            geocodePlaceName(map);
        }

    function geocodePlaceName(map)
    {
        var geocoder = new google.maps.Geocoder;
        geocoder.geocode({'location': last[0]}, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var bermudaTriangle = new google.maps.Marker({
                        position: last[0],
                        map: map
                    });

                    var infowindow = new google.maps.InfoWindow({
                        content: '<span style="color:black;">' + results[0].formatted_address + '</span>'
                    });

                    infowindow.open(map, bermudaTriangle);

                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    }

}
        
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=drawing&callback=initMap"></script>
@endsection

