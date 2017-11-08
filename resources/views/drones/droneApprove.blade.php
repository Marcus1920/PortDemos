@extends('master')
@section('content')



    <div class="block-area container" id="droneApproval">
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('DroneList') }}">Drone LIST</a></li>
            <li class="active"></li>
        </ol>
        <h4 class="page-title">First Approval</h4>
        <br>
        <div class="row justify-content-center">
            {{--<div  class="col-md-4 ">--}}
                {{--<h3 class="block-title">CASE DETAILS</h3>--}}


            <div  class="col-md-4">
                <h3 class="block-title">CASE DETAILS</h3>

                <table class="table">
                    <tbody>
                    <tr>
                        {{--<td><h5 class="h3"><small style="color: white;" >Case  Number</small>   : {{$droneRequest->id}}</h5></td>--}}
                        {{--<td> <h5 class="h3"><small style="color: white;">Case Status </small>     : {{$droneRequest->DroneCaseStatus->name}} </h5></td>--}}
                        {{--<td> <h5 class="h3"><small style="color: white;">Case logged Date</small> : {{$droneRequest->created_at}} </h5></td>--}}
                        {{--<td> <h5 class="h3"><small style="color: white;">Case Duration </small>   : {{$droneRequest->created_at->diffForHumans()}}</h5></td>--}}


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
                {{--<h5 class="h3"><small style="color: white;">Requested by</small> : {{$droneRequest->User->name}} {{$droneRequest->User->surname}}</h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Drone Type</small>   : {{$droneRequest->DroneType->name}} </h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Drone Service Request</small>  :     {{$droneRequest->DroneSubType->name}} </h5>--}}
                {{--<h5 class="h3"><small style="color: white;">Department Requested Service</small> :  {{$droneRequest->Department->name}}</h5>--}}
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
        </div>
        <h3 class="block-title">COMMENTS</h3>
        <div class="row " style="margin-left:200px">
            {!! Form::open(['url' => '', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"commentId" ]) !!}
            <div class="form-group">
                {!! Form::label('', '', array('class' => 'col-md-1 control-label')) !!}
                <div class="col-sm-4">
                    {!! Form::textarea('comment',$droneRequest->comments,['class' => 'form-control input-sm','id' => 'comment','disabled']) !!}

                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <br/>
    @if(Auth::user()->id != $droneRequest->created_by)
        <a aria-hidden="true">
        <h3 class="block-title">ACTION</h3>

        <div class="row" style="margin-left: 330px;">

            <div class="col">
                {!! Form::open(['url' => 'api/v1/firstDroneApproval/'.$droneRequest->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"firstApprovalForm" ]) !!}
                {!! Form::hidden('user',Auth::user()->id)!!}
                <div class="form-group" >
                    <div class="col-md-6" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary"  onclick="getApproveToaster()" id="approveId">Approve</button>

                        <button type="button" class="btn  btn-danger" id="rejectId">Reject</button>


                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col">
                {!! Form::open(['url' => 'api/v1/rejectDroneRequest/'.$droneRequest->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"firstRejectionForm" ]) !!}
                {!! Form::hidden('user',Auth::user()->id)!!}

                {{--<div class="form-group">--}}
                {{--<div class="col-md-6">--}}
                {{--<button type="button" class="btn  btn-danger" id="rejectId">Reject</button>--}}

                {{--</div>--}}
                {{--</div>--}}

                <div class="form-group reason hidden ">
                    <div class="col-md-6" >
                        <div class="col-md-3 " style="margin-top:10px;">
                            <select name="reject_reason" id="reject_reason" class="form-control input-sm" required>
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
                    <div class="col-sm-4">
                        {!! Form::textarea('reject_other_reason',null,['class' => 'form-control input-sm','id' => 'reject_other_reason','placeholder'=>'other reason.','required']) !!}
                        @if ($errors->has('reject_other_reason')) <p class="help-block red">*{{ $errors->first('reject_other_reason') }}</p> @endif
                    </div>
                </div>

                <div class="form-group submit hidden">
                    <div class="col-md-10">
                        <button type="submit" type="button" class="btn btn-sm" id="submitId" onclick="getRejectToaster()" disabled>Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}

                <div id="snackbar">The Request was already approved</div>
                <div id="rejectSnackbar">The Request was already rejected</div>

            </div>
        </div>
        </a>
    @endif


@endsection
@section('footer')

    <script>

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

        $('#rejectId').on('click',function(){

            $('.reason').removeClass('hidden');
            $('.submit').removeClass('hidden');
            $("#submitId").removeAttr('disabled');
            $("#approveId").attr('disabled','disabled');
        })

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
@endsection

