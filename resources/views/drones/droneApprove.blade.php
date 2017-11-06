@extends('master')
@section('content')
    <div class="block-area container" id="droneApproval">
        <ol class="breadcrumb hidden-xs">
            <li><a href="{{ url('drones') }}">Drone LIST</a></li>
            <li class="active"></li>
        </ol>
        <h4 class="page-title">First Approval</h4>
        <br>
        <div class="row justify-content-center">
            <div  class="col-md-4 ">
                <h3 class="block-title">CASE DETAILS</h3>
                <h5 class="h3"><small style="color: white;" >Case  Number</small>   : {{$droneRequest->id}}</h5>
                <h5 class="h3"><small style="color: white;">Case Status </small>     : {{$droneRequest->DroneCaseStatus->name}} </h5>
                <h5 class="h3"><small style="color: white;">Case logged Date</small> : {{$droneRequest->created_at}} </h5>
                <h5 class="h3"><small style="color: white;">Case Duration </small>   : {{$droneRequest->created_at->diffForHumans()}}</h5>
            </div>
            <div  class="col-md-4">
                <h3 class="block-title">DRONES DETAILS</h3>
                <h5 class="h3"><small style="color: white;">Drone Type</small>   : {{$droneRequest->DroneType->name}} </h5>
                <h5 class="h3"><small style="color: white;">Drone Service Request</small>  :  {{$droneRequest->DroneSubType->name}} </h5>
                <h5 class="h3"><small style="color: white;">Requested by</small> : {{$droneRequest->User->name}} {{$droneRequest->User->surname}}</h5>
                <h5 class="h3"><small style="color: white;">Department Requested Service</small> :  {{$droneRequest->Department->name}}</h5>
            </div>

        </div>
        <h3 class="block-title">COMMENTS</h3>
        <div class="row">
            {!! Form::open(['url' => 'tasks', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addTaskCaptureForm" ]) !!}
            {!! Form::hidden('user',Auth::user()->id)!!}
            <div class="form-group">
                {!! Form::label('', '', array('class' => 'col-md-1 control-label')) !!}
                <div class="col-md-6">
                    {{--{!! Form::textarea('comment',$droneRequest->comments,['class' => 'form-control input-sm','id' => 'comment']) !!}--}}
                    <textarea id="comment" rows="5" class="form-control" name="comment" ></textarea>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <br/>

        <h3 class="block-title">ACTION</h3>

        <div class="row" style="margin-left: 100px;">

            <div class="col">
                {!! Form::open(['url' => 'http://localhost:8000/api/v1/firstDroneApproval/1', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"drone_request_id" ]) !!}
                {!! Form::hidden('user',Auth::user()->id)!!}
                <div class="form-group">
                    <div class="col-md-6" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary" id="approveId">Approve</button>

                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col">
                {!! Form::open(['url' => 'http://localhost:8000/api/v1/rejectDroneRequest/1', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"drone_request_id" ]) !!}
                {!! Form::hidden('user',Auth::user()->id)!!}

                <div class="form-group">
                    <div class="col-md-6" style="margin-top:20px;">
                        <button type="button" class="btn  btn-danger" id="rejectId">Reject</button>

                    </div>
                </div>

                <div class="form-group reason hidden ">
                    <div class="col-md-6" >
                        <div class="col-md-3 " style="margin-top:10px;">
                            <select name="reject_reason" id="reject_reason" class="form-control input-sm">
                                <option value="0"  selected disabled>-select reason-</option>

                                @foreach($droneRejectReasons as $droneRejectReason)
                                    {
                                    <option value="{{$droneRejectReason->id}}">{{$droneRejectReason->reason}}</option>
                                    }
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form-group otherReason hidden" >
                    {!! Form::label('', '') !!}
                    <div class="col-md-6">
                        {!! Form::textarea('reject_other_reason',null,['class' => 'form-control input-sm','id' => 'reject_other_reason','placeholder'=>'other reason.']) !!}
                        @if ($errors->has('reject_other_reason')) <p class="help-block red">*{{ $errors->first('reject_other_reason') }}</p> @endif
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
    </div>
@endsection
@section('footer')
    <script>
        $('#rejectId').on('click',function()
        {
            alert('are you sure you want to reject? if yes press ok');
            $('.reason').removeClass('hidden');
            $('.submit').removeClass('hidden');
            $("#submitId").removeAttr('disabled');
            $("#approveId").attr('disabled','disabled');
        })
        $('#reject_reason').on('change',function(){
            var val  = $(this).find("option:selected").val();
            if(val == 3 ){

                $('.otherReason').removeClass('hidden');
            } else {

                $('.otherReason').addClass('hidden');
                //('otherReason').hide();
            }

        })
    </script>
@endsection

