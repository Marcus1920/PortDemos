<div class="tab-pane" id="global">

    <div class="" style="align-content: center">
        <table border=0>
            <tr>
                <td><button id="emailsFromGlobal" class="btn btn-default">
                       Email
                    </button></td>
                <td>&nbsp</td><td>&nbsp</td>
                <td><button id="add_button" class="btn btn-default">
                        Favourite
                    </button></td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                </td><td>&nbsp</td><td>&nbsp</td>
                {{--<td><input type="text" style="background-color: transparent ; border-color: transparent; width: auto"></td>--}}
                <td><input type="text" class="form-control counter pull pull-right col-sm-10 "></td>
            </tr>

        </table>
        <br/>
    </div>
    <div class="row">

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <table border=0 class="table" style="margin-bottom: 0">
                            <thead>
                            <tr>
                                <th width="6%">Select</th>
                                <th class="col-md- col-xs-5" width="100%">Full Name </th>
                            </tr>
                            </thead>
                        </table>
                    </h3>
                </div>
                <div class="panel-body" style="max-height:30em;overflow:auto;">

                    <table class="table table-hover table-bordered results" id="myGlobalTable" >
                        <tbody>
                        @foreach($users as $user)
                            <tr class="clickable-row">
                                <td>
                                    <input type="checkbox" name="row" value="{{$user->id}}"  class="names" id="id"></td>
                                <td><a class="t-overflow" onclick="profileGlobal({{$user->id}});">{{$user->name . " " . $user->surname}}</a><br/>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    {{count($users)}}     Users
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="block-area" id="basic" style="background-color: rgba(0, 0, 0, 0.35);">
                {{--<form class="form-horizontal"  method="post" action="addContact">--}}
                    {!! Form::open(['url' => 'addContact', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"profileForm" ,'files' => 'true']) !!}

                    <div class="col-md-4" style="">

                        <img alt="Bootstrap Image Preview" src="{{asset('/img/siyaleader_light_bg.png')}}" class="img-thumbnail" style="align-content: center">

                        <div class="col-md-1">
                            <label for="inputEmail3" class="col-sm-2 control-label" style="align-content: center">
                                global
                            </label>
                        </div>
                    </div>
                    {{--<div class="col-md-2">--}}
                    {{--</div>--}}
                    <div class="col-md-8">
                        {{--<h3 class="block-title">PERSONAL DETAILS</h3>--}}
                        <div class="form-group col-md-18">

                            <label for="inputEmail3" class="col-sm-3 control-label">
                                NAME
                            </label>
                            <div class="col-sm-9">
                                <input name="first_name" value="{{isset($userOrder) ? $userOrder->name : ''}}" class="form-control" id="first_name" readonly>
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="inputEmail3" class="col-sm-3 control-label">
                                SURNAME
                            </label>
                            <div class="col-sm-9" >
                                <input name="Surname" class="form-control" value="{{isset($userOrder) ? $userOrder->surname : ''}}" id="Surname" readonly>
                            </div>
                        </div>
                        {{--<div class="form-group">

                            <label for="inputEmail3" class="col-sm-3 control-label">
                                BIRTHDAY
                            </label>
                            <div class="col-sm-9">
                                <input name="dob" class="form-control"  value="{{Null}}" id="dob_global" readonly>
                            </div>
                        </div>--}}
                        <hr class="whiter m-t-20">
                        {{--<h3 class="block-title">CONTACT DETAILS</h3>--}}
                        <div class="form-group">


                            <label for="inputPassword3" class="col-sm-3 control-label">
                                EMAIL
                            </label>
                            <div class="col-sm-9">
                                <input name="email" class="form-control" value="{{isset($userOrder) ? $userOrder->email : ''}}" id="email" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">
                                MOBILE
                            </label>
                            <div class="col-sm-9">
                                <input name="cellphone" class="form-control" value="{{isset($userOrder) ? $userOrder->cellphone : ''}}"id="cellphone" readonly>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-sm-10">
                                {!! Form::text('user',(isset($userOrder) ? $userOrder->id : -1),['class' => 'form-control input-sm','id' => 'user','readonly']) !!}

                            </div>
                        </div>

                        <hr class="whiter m-t-20">

                        {{--<h3 class="block-title">ACTIONS</h3>--}}
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">

                                <button onclick="sendGlobalEmail();" class="btn btn-default" >
                                    Email
                                </button>

                                <button type="submit" class="btn btn-default">
                                    Favourite
                                </button>
                            </div>
                        </div>
                    </div>
                {!! Form::close()!!}
                {{--</form>--}}
            </div>
        </div>

    </div>

</div>