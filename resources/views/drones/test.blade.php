@extends('master')
@section('content')
    <div class="block-area container" id="droneApproval">
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('tasks') }}">TASK LIST</a></li>
            <li class="active"></li>
        </ol>
        <h4 class="page-title">Second Approval</h4>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">

            {!! Form::open(['url' => '', 'method' => '', 'class' => 'form-horizontal']) !!}
                {!! Form::hidden('id',Auth::user()->id) !!}

            <div class="form-group">
                <label for="inputTitle" class="col-md-2 control-label"></label>
                <div class="col-md-8">
                    <h3 class="block-title">CASE DETAILS</h3>
                    <h5 class="h3"><small style="color: white;" >Case  Number</small>   : {{$droneRequest->id}}</h5>
                    <h5 class="h3"><small style="color: white;">Case Status </small>     : {{$droneRequest->DroneCaseStatus->name}} </h5>
                    <h5 class="h3"><small style="color: white;">Case logged Date</small> : {{$droneRequest->created_at}} </h5>
                    <h5 class="h3"><small style="color: white;">Case Duration </small>   : {{$droneRequest->created_at->diffForHumans()}}</h5>
                    <h3 class="block-title">DRONES DETAILS</h3>
                    <h5 class="h3"><small style="color: white;">Drone Type</small>   : {{$droneRequest->DroneType->name}} </h5>
                    <h5 class="h3"><small style="color: white;">Drone Service Request</small>  :  {{$droneRequest->DroneSubType->name}} </h5>
                    <h5 class="h3"><small style="color: white;">Requested by</small> : {{$droneRequest->User->name}} {{$droneRequest->User->surname}}</h5>
                    <h5 class="h3"><small style="color: white;">Department Requested Service</small> :  {{$droneRequest->Department->name}}</h5>
                </div>
                </div>

                <div class="form-group">
                    <label for="inputCategory" class="col-md-2 control-label"></label>
                    <div class="col-md-8">
                        <h3 class="block-title">COMMENTS</h3>
                        {!! Form::textarea('comment',null,['class' => 'form-control input-sm','id' => 'comment','disabled']) !!}
                    </div>
                    <br/>
                </div>


                <div class="form-group">
                    <label for="inputCategory" class="col-md-2 control-label"></label>
                    <div class="col-md-8">
                        <h3 class="block-title">ACTION</h3>

                        <div class="col">
                        {!! Form::open(['url' => 'api/v1/finalDroneApproval/', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"secondApprovalForm" ]) !!}
                        {!! Form::hidden('user',Auth::user()->id)!!}
                        <div class="form-group">
                            <div class="col-md-6" style="margin-top:20px;">
                                <button type="submit" class="btn btn-primary" id="approveId">Approve</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        </div>
                        <div class="col">
                            {!! Form::open(['url' => 'api/v1/rejectDroneRequest/', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"RejectForm" ]) !!}
                            {!! Form::hidden('user',Auth::user()->id)!!}


                            <div class="form-group">
                                <div class="col-md-6" style="margin-top:20px;">
                                    <button type="button" class="btn  btn-danger" id="rejectId">Reject</button>

                                </div>
                            </div>

                            <div class="form-group reason hidden ">
                                <div class="col-md-6">
                                    <div class="col-md-6 " style="margin-top:10px;">
                                        <select name="rejectReason" id="rejectReason" class="form-control input-sm">
                                            <option value="0"  selected disabled>-select reason-</option>
                                            @foreach($droneRejectReasons as $reason)
                                                <option value="{{$reason->id}}"  class="rejectReasonOption">{{$reason->reason}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="form-group  noneReason hidden">
                                <div class="col">
                                    {!! Form::textarea('noneReason',null,['class' => 'form-control input-sm','id' => 'noneReason','placeholder'=>'write the other reason here.']) !!}
                                </div>
                            </div>

                            <div class="form-group submit hidden">
                                <div class="col-md-10">
                                    <button type="submit" type="button" class="btn btn-sm" id="submitId" disabled>Submit</button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>

                    </div>
                    <br/>
                </div>




            {!! Form::close() !!}
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
                                    <a class="t-overflow" href="">{{$item->User->name}} {{$item->User->surname}}</a><br/>
                                    <small class="text-muted">{{$item->activity}}</small>
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
@endsection
@section('footer')
    <script>
        $('#rejectId').on('click',function(){
            //alert('okay');
            $('.reason').removeClass('hidden');
            $('.submit').removeClass('hidden');
            $("#submitId").removeAttr('disabled');
            $("#approveId").attr('disabled','disabled');
        })
        $('#rejectReason').on('change',function(){
            var selectedval  = $(this).find("option:selected").val();
            //alert(selectedval);
            if(selectedval == 3 ){
                $('.noneReason').removeClass('hidden');
            } else {
                $('.noneReason').addClass('hidden');
            }
        })
    </script>
@endsection