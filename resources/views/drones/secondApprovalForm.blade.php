@extends('master')
@section('content')
    <div class="block-area container" id="droneApproval">
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('DroneList') }}">Drone Requests List</a></li>
            <li class="active">Approval Form</li>
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

                <table class="table">
                    <tbody>
                    <tr>
                        <td>Case Number</td>
                        <td></td>
                        <td>: {{$droneRequest->id}}</td>
                    </tr>
                    <tr>
                        <td>Case Status </td>
                        <td></td>
                        <td>: {{$droneRequest->DroneCaseStatus->name}}</td>
                    </tr>
                    <tr>
                        <td>Case logged Date</td>
                        <td></td>
                        <td>: {{$droneRequest->created_at}}</td>
                    </tr>
                    <tr>
                        <td>Case Duration</td>
                        <td></td>
                        <td>: {{$droneRequest->created_at->diffForHumans()}}</td>

                    </tr>
                    </tbody>
                </table>

                {{--<h5 class="h3"><small style="color: white;"></small>   : {{$droneRequest->id}}</h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Case Status </small>     : {{$droneRequest->DroneCaseStatus->name}} </h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Case logged Date</small> : {{$droneRequest->created_at}} </h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Case Duration </small>   : {{$droneRequest->created_at->diffForHumans()}}</h5>--}}


                <table class="table">
                    <tbody>
                    <tr>
                        <td>Case  Number</td>
                        <td> {{$droneRequest->id}}</td>
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

                    </tbody>
                </table>

            </div>
            <div  class="col-md-4">

                <h3 class="block-title">DRONES DETAILS</h3>


                <table class="table" style="border: none;">
                    <tbody>
                    <tr>
                        <td>Drone Type</td>
                        <td></td>
                        <td> : {{$droneRequest->DroneType->name}}</td>
                    </tr>
                    <tr>
                        <td>Drone Service Request</td>
                        <td></td>
                        <td> : {{$droneRequest->DroneSubType->name}}</td>
                    </tr>
                    <tr>
                        <td>Requested by</td>
                        <td></td>
                        <td>: {{$droneRequest->User->name}} {{$droneRequest->User->surname}}</td>
                    </tr>
                    <tr>
                        <td>Department Requested Service</td>
                        <td></td>
                        <td>: {{$droneRequest->Department->name}}</td>

                    </tr>
                    </tbody>
                </table>
                {{--<h5 class="h3"><small style="color: white;">Drone Type</small>   : {{$droneRequest->DroneType->name}} </h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Drone Service Request</small>  :  {{$droneRequest->DroneSubType->name}} </h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Requested by</small> : {{$droneRequest->User->name}} {{$droneRequest->User->surname}}</h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Department Requested Service</small> :  {{$droneRequest->Department->name}}</h5>--}}

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
                    </tbody>
                </table>

            </div>


            <div  class="col-md-4">
                <h3 class="block-title">DRONES REQUEST ACTIVITIES</h3>
                <div class="tile">
                    <h2 class="tile-title">
                        <div class="pull-right">
                        </div>
                    </h2>
                    <div class="listview narrow">
                        @foreach($droneRequestActivity as $item)
                            <div class="media p-l-5">
                                <div class="media-body">

                                    <a class="t-overflow" href="">{{$item->User->name}} {{$item->User->surname}} {{$item->activity}}</a><br/>

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
        <h3 class="block-title">COMMENTS</h3>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                {!! Form::open(['url' => '', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addTaskCaptureForm" ]) !!}
                <div class="form-group">
                    {!! Form::label('', '', array('class' => 'col-md-1 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::textarea('comment',$droneRequest->comments,['class' => 'form-control input-sm','id' => 'comment','disabled']) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
        <br/>

        <h3 class="block-title">ACTION</h3>

        <div class="row" style="margin-left: 100px; position:center;">

            <div class="col">
                {!! Form::open(['url' => 'api/v1/finalDroneApproval/'.$droneRequest->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"secondApprovalForm" ]) !!}
                {!! Form::hidden('user',Auth::user()->id)!!}
                <div class="form-group">

                    <div class="col-md-6 col-md-offset-4" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary btn-lg"  onclick="getApproveToaster()" id="approveId" >Approve</button>
                        <button type="button" class="btn  btn-danger btn-lg"   form="secondRejectForm" id="rejectId" >Reject</button>
                    </div>

                </div>

                {!! Form::close() !!}
            </div>
            <div class="col"></div>
            <div class="col">
                {!! Form::open(['url' => 'api/v1/rejectDroneRequest/'.$droneRequest->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"secondRejectForm" ]) !!}
                {!! Form::hidden('user',Auth::user()->id)!!}

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">


                        <div class="form-group reason hidden ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-6 " style="margin-top:15px;">
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
                        </div>

                        <br/>

                        <div class="form-group noneReason hidden" >
                            {!! Form::label('', '') !!}
                            <div class="col-md-6">
                                {!! Form::textarea('reject_other_reason',null,['class' => 'form-control ','id' => 'reject_other_reason','placeholder'=>'Type the other reason here.','required']) !!}
                                @if ($errors->has('reject_other_reason')) <p class="help-block red">*{{ $errors->first('reject_other_reason') }}</p> @endif
                            </div>
                        </div>

                        <div class="form-group submit hidden">
                            <div class="col-md-10"  style="margin-top:15px;">
                                <button type="submit"  class="btn btn-lg" id="submitId" onclick="getRejectToaster()" disabled>Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
                {!! Form::close() !!}
                <div id="snackbar">The Request was already approved</div>
                <div id="rejectSnackbar">The Request was already rejected</div>

            </div>
        </div>
        <h3 class="block-title" style="margin-left: 15px">COMMENTS</h3>
        <div class="row " >
            <div class="col-md-12 col-lg-12" style="padding-left: 15px">

                <p style="text-align: justify;font-size: 150%; padding: 30px;">
                    {{$droneRequest->comments}}
                </p>


            </div>
        </div>
        <br/>
    </div>
@endsection
@section('footer')

    <script>
        function getApproveToaster() {
            if (typeof(Storage) !== "undefined") {
                if (localStorage.clickcount) {
                    localStorage.clickcount = Number(localStorage.clickcount) + 1;

                    var x = document.getElementById("snackbar");
                    x.className = "show";
                    setTimeout(function () {
                        x.className = x.className.replace("show", "");
                    }, 3000);

                    event.preventDefault();

                } else {
                    localStorage.clickcount = 1;
                }
            }
        }

        function getRejectToaster() {

            if (typeof(Storage) !== "undefined") {
                if (localStorage.rejectClickCount) {
                    localStorage.rejectClickCount = Number(localStorage.rejectClickCount) + 1;

                    var x = document.getElementById("rejectSnackbar");
                    x.className = "show";
                    setTimeout(function () {
                        x.className = x.className.replace("show", "");
                    }, 3000);

                    event.preventDefault();

                } else {
                    localStorage.rejectClickCount = 1;
                }
            }
        }

//        function getApproveToaster() {
//            if (typeof(Storage) !== "undefined") {
//                if (localStorage.clickcount) {
//                    localStorage.clickcount = Number(localStorage.clickcount) + 1;
//
//                    var x = document.getElementById("snackbar");
//                    x.className = "show";
//                    setTimeout(function () {
//                        x.className = x.className.replace("show", "");
//                    }, 3000);
//
//                    event.preventDefault();
//
//                } else {
//                    localStorage.clickcount = 1;
//                }
//            }
//        }
//
//        function getRejectToaster() {
//
//            if (typeof(Storage) !== "undefined") {
//                if (localStorage.rejectClickCount) {
//                    localStorage.rejectClickCount = Number(localStorage.rejectClickCount) + 1;
//
//                    var x = document.getElementById("rejectSnackbar");
//                    x.className = "show";
//                    setTimeout(function () {
//                        x.className = x.className.replace("show", "");
//                    }, 3000);
//
//                    event.preventDefault();
//
//                } else {
//                    localStorage.rejectClickCount = 1;
//                }
//            }
//        }


        $('#rejectId').on('click',function(){
            $('.reason').removeClass('hidden');
            $('.submit').removeClass('hidden');
            $("#submitId").removeAttr('disabled');
            $("#approveId").attr('disabled','disabled');
        });

        $('#reject_reason').on('change',function()
        {
            window.localStorage.removeItem("rejectClickCount");
            var selectedval  = $(this).find("option:selected").val();

            if(selectedval == 3)
            {
                $('.noneReason').removeClass('hidden');
            } else {

                $('.noneReason').addClass('hidden');


            }

        });

        $("#reject_other_reason").mouseleave(function(){
            window.localStorage.removeItem("rejectClickCount");
        });

        $("#secondRejectForm").validate();
    </script>
@endsection

