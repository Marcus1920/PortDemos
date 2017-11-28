@extends('master')
@section('content')



    <div class="block-area container" id="droneApproval">
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('DroneList') }}">Drone List</a></li>
            <li class="active">First Approval</li>
        </ol>
        @if(Auth::user()->id == $droneRequest->created_by)
        <a aria-hidden="true">
        <h4 class="page-title">Drone Request Profile</h4>
        </a>
            @else
            <a aria-hidden="true">
                <h4 class="page-title">First Approval</h4>
            </a>
        @endif
        <br>
        <center>
        @if(Auth::user()->id != $droneRequest->created_by)
                @if($droneRequest->drone_case_status==1)
            <a aria-hidden="true">
                {{--<h3 class="block-title">ACTION</h3>--}}

                <div class="row" style="margin-left: 330px;">

                    <div class="col">
                        {!! Form::open(['url' => 'api/v1/firstDroneApproval/'.$droneRequest->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"firstApprovalForm" ]) !!}
                        {!! Form::hidden('user',Auth::user()->id)!!}
                        <div class="form-group" >
                            <div class="col-md-6" style="margin-top:20px;">
                                <button type="submit" class="btn btn-primary"  onclick="getApproveToaster()" id="approveId"><i  id="acceptTaskBtn"  class="fa fa-check fa-4x" aria-hidden="true"></i>Approve</button>

                                <button type="button" class="btn  btn-danger" id="rejectId"><i  id="declineTaskBtn" class="fa fa-times fa-4x" aria-hidden="true"></i>Reject</button>


                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col">
                        {!! Form::open(['url' => 'api/v1/rejectDroneRequest/'.$droneRequest->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"firstRejectionForm" ]) !!}
                        {{--{!! Form::hidden('user',Auth::user()->id)!!}--}}
                        <div class="form-group reason hidden ">
                            <div class="col-md-6 col-md-offset-3" >
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
        @endif
        </center>
        <div class="row justify-content-center">

            <div  class="col-md-4">

                <h3 class="block-title">CASE DETAILS</h3>

                <table class="table">
                    <tbody>
                    <tr>
                        <td>Drone Request Number</td>
                        <td> {{$droneRequest->id}}</td>
                    </tr>
                    <tr>
                        <td>Case  Number</td>
                        <td> {{$droneRequest->caseNumber}}</td>
                    </tr>
                    <tr>
                        <td>Case Status</td>
                        <td>{{$droneRequest->DroneCaseStatus->name}}</td>
                    </tr>
                    <tr>
                        <td>Case logged Date</td>
                        <td>{{$droneRequest->created_at}}</td>
                    </tr>
                    <tr>
                        <td>Case Duration</td>
                        <td>{{$droneRequest->created_at->diffForHumans()}}</td>
                    </tr>
                    <tr>
                        <td>dronesub</td>
                        <td>drone type</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div  class="col-md-4">
                <h3 class="block-title">DRONES DETAILS</h3>
                <table class="table">
                <tbody>
                <tr>
                    <td>Requested by</td>
                    <td>{{$droneRequest->User->name}} {{$droneRequest->User->surname}} </td>
                </tr>
                <tr>
                    <td> Drone Type</td>
                    <td>{{$droneRequest->DroneType->name}}</td>
                </tr>
                <tr>
                    <td>Drone Service Request</td>
                    <td>{{$droneRequest->DroneSubType->name}}</td>
                </tr>
                <tr>
                    <td>Department Requested Service</td>
                    <td>{{$droneRequest->Department->name}}</td>
                </tr>
                <tr>
                    <td>Purpose Of Survey</td>
                    <td>{{$droneRequest->purposeOfSurvey}}</td>
                </tr>
                <tr>
                    <td>Service Required</td>
                    <td>{{$droneRequest->serviceRequired}}</td>
                </tr>

                <tr>
                    <td>Scope of Work</td>
                    <td>{{$droneRequest->scope_of_work}}</td>
                </tr>

                <tr>
                    <td>Object of Interest</td>
                    <td>{{$droneRequest->interest}}</td>
                </tr>
                <tr>
                    <td>Drone Sub Service</td>
                    <td>{{$droneRequest->drone_sub_service_type_id}}</td>
                </tr>
                <tr>
                    <td>Number Of Stockpiles</td>
                    <td>{{$droneRequest->numberOfStockpiles}}</td>
                </tr>
                <tr>
                    <td>Vertical Accuracy</td>
                    <td>{{$droneRequest->vertical_accuracy}}</td>
                </tr>
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

            <div class="col-md-6 col-lg-4" style="padding-left: 15px">
                <h3 class="block-title" style="margin-left: 15px">NOTES</h3>
                <p style="text-align: justify;font-size: 150%; padding: 30px;">
                    {{$droneRequest->notes}}
                </p>

            </div>
            <div class="col-md-6 col-lg-8 ">
                <h3 class="block-title" style="margin-left: 15px">Map</h3>

                <p  style="text-align: justify;font-size: 150%; padding: 20px;">Map</p>


                <div id="map" style="width: 100%; height: 500px">
                {{--//    {!! Mapper::Render() !!}--}}
                </div>


                <input type="text" name="" id="cod" value="{{$staff}}" class="form-control">

                <div id="show"></div>

                {{--@foreach($staff as $cod)--}}

                    {{--{{$cod}}--}}

                {{--@endforeach--}}


            </div>

        </div>
        <br/>
    </div>
    @endsection
@section('footer')
    <script>

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: {lat: -30.886, lng: 29.268},
                mapTypeId: 'terrain'
            });

//        var triangleCoords=document.getElementById("")
            {{--var  triangleCoords= Json.parse({{json_encode($remove)}});--}}
//            var triangleCoords = [
//                {lat: -30.774, lng: 29.190},
//                {lat: -30.466, lng: 29.118},
//                {lat: -30.321, lng: 29.757},
//                {lat: -30.774, lng: 29.190}
//            ];

            var codes=document.getElementById("cod").value.split(',');



            var last ={lat: -30.774, lng: 29.190};
            var long={lat: -30.774, lng: 29.190};

            for(var i=0; i < codes.length  ; i++){

                last = {lat: parseInt(codes[i]), lng: parseInt(codes[i+1])}
            }


            var triangleCoords =[

                {lat: -30.774, lng: 29.190},
                {lat: -30.466, lng: 29.118},
                {lat: -30.321, lng: 29.757},
                {lat: -30.774, lng: 29.190}

]
        ;
            // Construct the polygon.
           {{--// var coordinates   = JSON.parse("{!!json_encode($remove)!!}");--}}
            var bermudaTriangle = new google.maps.Polygon({
                paths: triangleCoords,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });
            bermudaTriangle.setMap(map);
        }

    </script>
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

                $('.otherReason').removeClass('hidden');
            } else {

                $('.otherReason').addClass('hidden');
            }

        });
        $("#firstRejectionForm").validate();
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=drawing&callback=initMap"></script>

@endsection

