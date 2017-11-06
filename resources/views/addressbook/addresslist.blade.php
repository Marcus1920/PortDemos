@extends('master')

@section('content')
    <!--Nav Tabs-->
    <div id="tabs">
        <ul class="nav nav-pills navbar-right" role="tablist">
            <li class="active"><a href="#global"  data-toggle="tab">Global Address Book</a></li>
            <li><a href="#private"  data-toggle="tab">Private Address Book</a></li>

        </ul>
        <h4 class="page-title">ADDRESS BOOK</h4>

        <div class="block-area" id="alternative-buttons">
            <h3 class="block-title">Look for People to Add to Your Private Address Book</h3>
        </div>

        <div class="tab-content">
            <div class="tab-pane" id="global">
                <!-- Responsive Table -->
                <div class="block-area" id="responsiveTable">
                    <div id="MeetingNotification"></div>
                    <div class="table-responsive overflow">

                        <div class="container">
                            <div class="row">
                                <div class ="col-md-8">
                                    <div class="scrollabe">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--GLOBAL TAB CONTENT-->
        <div class="tab-content">
            <div class="tab-pane" id="global">
                <!-- Responsive Table -->
                <div class="block-area" id="responsiveTable">
                    <div id="MeetingNotification"></div>
                    <div class="table-responsive overflow">

                        <div class="row">
                            <div style="width:100%;">
                                <!--LEFT SIDE DIV-->
                                <div class="col-sm-3 col-md-6 col-lg-4" div style="float:left; display:inline-block;">
                                    <div class="listview narrow">
                                        <div class="form-group pull-right">

                                            <input type="text" id="myGlobalInput" class="search form-control" onkeyup="globalFunction()" placeholder="Search for names..">
                                        </div>
                                        <span class="counter pull-right"></span>
                                        <INPUT type="button" value="Add to Private" id="add_button"/>
                                        <INPUT type="button" value="Send Emails" onclick="deleteRow('dataTable')" />

                                        <table class="table table-hover table-bordered results" id="myGlobalTable">
                                            <thead>
                                            <tr>
                                                <th width="10%">Select</th>
                                                <th class="col-md-5 col-xs-5">User Full Name</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr class="clickable-row">
                                                    <td>
                                                        <input type="checkbox" name="row" value="{{$user->id}}" id="chck" class="get_value" ></td>
                                                    <td><a class="t-overflow" href="{{url('getContactProfile/'.$user->id)}}">{{$user->name . " " . $user->surname}}</a><br/>
                                                        <small class="text-muted">{{$user->email}}</small></td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--RIGHT SIDE DIV-->
                                <div class="col-sm-9 col-md-6 col-lg-8" style="float:right; display:inline-block;">
                                    <div class="block-area" id="basic">
                                        <div class="tile p-15">

                                            <div class="row">
                                                @if(Session::has('success'))
                                                    <div class="alert alert-success alert-icon">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                        {{ Session::get('success') }}
                                                        <i class="icon">&#61845;</i>
                                                    </div>
                                                @endif

                                                <div class="col-md-6">

                                                    <h3 class="block-title">CONTACT PICTURE!</h3>

                                                    <span class="counter pull-right"></span>

                                                    <div class="card" style="width: 30rem;">
                                                        <img class="img-circle"  src="{{asset('images/trolltunga.jpg')}}"  width="300" height="200"  alt="Card image cap">
                                                        <div class="card-block">
                                                            <hr class="whiter m-t-20">
                                                            <h1 class="card-title">Card title</h1>
                                                            <p class="card-text"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">

                                                    {!! Form::open(['url' => 'addContact', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"profileForm" ,'files' => 'true']) !!}
                                                    {!! Form::hidden('created_by',Auth::user()->id) !!}
                                                    {!! Form::hidden('user',$contacts->id)!!}
                                                    {!! Form::hidden('email',$contacts->email)!!}


                                                    <h3 class="block-title">PERSONAL DETAILS!</h3>

                                                    <span class="counter pull-right"></span>

                                                    <div class="form-group">
                                                        {!! Form::label('NAME', 'NAME', array('class' => 'col-md-3 control-label')) !!}
                                                        <div class="col-md-8">
                                                            {!! Form::text('first_name',$contacts->name,['class' => 'form-control input-sm','id' => 'first_name']) !!}
                                                            <div id = "hse_error_cellphone"></div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('SURNAME', 'SURNAME', array('class' => 'col-md-3 control-label')) !!}
                                                        <div class="col-md-8">
                                                            {!! Form::text('Surname',$contacts->surname,['class' => 'form-control input-sm','id' => 'Surname']) !!}
                                                            <div id = "hse_error_cellphone"></div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('CELLPHONE ', 'CELLPHONE', array('class' => 'col-md-3 control-label')) !!}
                                                        <div class="col-md-8">
                                                            {!! Form::text('cellphone',$contacts->cellphone,['class' => 'form-control input-sm','id' => 'cellphone']) !!}
                                                            <div id = "hse_error_cellphone"></div>

                                                        </div>
                                                    </div>
                                                    <hr class="whiter m-t-20">


                                                    <h3 class="block-title">ADD TO PRIVATE ADDRESS BOOK</h3>
                                                    <span class="counter pull-right"></span>
                                                    <span class="counter pull-right"></span>
                                                    <br/>


                                                    <div class="form-group">

                                                    </div>


                                                    <hr class="whiter m-t-20">


                                                    <h3 class="block-title">COMMUNICATION</h3>
                                                    <span class="counter pull-right"></span>
                                                    <span class="counter pull-right"></span>
                                                    <br/>


                                                    <lu>
                                                        <a href="{{ url('') }}" ><i class="fa fa-envelope-o fa-2x" aria-hidden="true" title="EMAIL"></i>
                                                        </a>
                                                        <a href="#" >
                                                            <i class="fa fa-star fa-2x" aria-hidden="true" title="EMAIL" data-toggle="tooltip"></i>
                                                        </a>
                                                        <a href="{{ url('') }}">
                                                            <i class="fa fa-message" aria-hidden="true" title="Add Your New Task Here" data-toggle="tooltip"></i>
                                                        </a>
                                                    </lu>

                                                    {!! Form::close()!!}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> ​
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--PRIVATE TAB CONTENT-->
        <div class="tab-content">
            <div class="tab-pane" id="private">
                <!-- Responsive Table -->
                <div class="block-area" id="responsiveTable">
                    <div id="MeetingNotification"></div>
                    <div class="table-responsive overflow">

                        <div class="row">
                            <div style="width:100%;">
                                <!--LEFT SIDE DIV-->
                                <div class="col-sm-3 col-md-6 col-lg-4" div style="float:left; display:inline-block;">
                                    <div class="listview narrow">
                                        <div class="form-group pull-right">
                                            <input type="text" id="myPrivateInput" class="search form-control" onkeyup="myFunction()" placeholder="Search for names..">
                                        </div>
                                        <span class="counter pull-right"></span>
                                        <table class="table table-hover table-bordered results" id="myPrivateTable">
                                            <thead>
                                            <tr>
                                                <th class="col-md-5 col-xs-5">User Full Name</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><a class="t-overflow" href="{{url('getContactProfile/'.$user->id)}}"></a><br/>
                                                    <small class="text-muted"></small></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!--RIGHT SIDE DIV-->

                                <div class="col-sm-9 col-md-6 col-lg-8" style="float:right; display:inline-block;">
                                    <div class="block-area" id="basic">
                                        <div class="tile p-15">

                                            <div class="row">
                                                <div class="col-md-6">

                                                    <h3 class="block-title">CONTACT PICTURE!</h3>

                                                    <span class="counter pull-right"></span>

                                                    <div class="card" style="width: 60rem;">
                                                        <img class="img-circle"  src="{{asset('images/trolltunga.jpg')}}"  width="300" height="200"  alt="Card image cap">
                                                        <div class="card-block">
                                                            <h4 class="card-title">Card title</h4>
                                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">

                                                    {!! Form::open(['url' => 'createCaseAgent', 'method' => 'get', 'class' => 'form-horizontal', 'id'=>"profileForm" ,'files' => 'true']) !!}
                                                    {!! Form::hidden('hseHolderId',NULL,['id' => 'hseHolderId']) !!}

                                                    <h3 class="block-title">PERSONAL DETAILS!</h3>

                                                    <span class="counter pull-right"></span>

                                                    <div class="form-group">
                                                        {!! Form::label('NAME', 'NAME', array('class' => 'col-md-3 control-label')) !!}
                                                        <div class="col-md-8">
                                                            {!! Form::text('name',null,['class' => 'form-control input-sm','id' => 'name','disabled']) !!}
                                                            <div id = "hse_error_cellphone"></div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('SURNAME', 'SURNAME', array('class' => 'col-md-3 control-label')) !!}
                                                        <div class="col-md-8">
                                                            {!! Form::text('surname',null,['class' => 'form-control input-sm','id' => 'cellphone','disabled']) !!}
                                                            <div id = "hse_error_cellphone"></div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        {!! Form::label('EMAIL', 'EMAIL', array('class' => 'col-md-3 control-label')) !!}
                                                        <div class="col-md-8">
                                                            {!! Form::text('email',null,['class' => 'form-control input-sm','id' => 'email','disabled']) !!}
                                                            <div id = "hse_error_cellphone"></div>
                                                        </div>
                                                    </div>

                                                    <hr class="whiter m-t-20">


                                                    <h3 class="block-title">COMMUNICATION</h3>
                                                    <span class="counter pull-right"></span>
                                                    <span class="counter pull-right"></span>
                                                    <br/>


                                                    <lu>
                                                        <a href="{{ url('') }}" >
                                                            <i class="fa fa-envelope" aria-hidden="true" title="EMAIL" data-toggle="tooltip"></i>
                                                        </a>

                                                        <a href="{{ url('') }}" >
                                                            <i class="fa fa-star" aria-hidden="true" title="FAVOURATE" data-toggle="tooltip"></i>
                                                        </a>

                                                        <a href="{{ url('') }}">
                                                            <i class="fa fa-message" aria-hidden="true" title="Add Your New Task Here" data-toggle="tooltip"></i>
                                                        </a>

                                                        <a href="{{ url('') }}">
                                                            <i class="fa fa-phone" aria-hidden="true" title="CALL" data-toggle="tooltip"></i>
                                                        </a>
                                                    </lu>
                                                    {!! Form::close()!!}

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> ​
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('footer')
    <script>
        $("").click(function(event){
            event.preventDefault();
            var searchIDs = $("#myGlobalTable input:checkbox:checked").map(function() {
                return $(this).val();
            }).get();
            console.log(searchIDs);
        });

    </script>
    <script>
        $(document).ready(function () {
            $("#add_button").click(function() {
                getValuetoAdd();
            });

            $("#buttonParent").click(function() {
                getValueforEmails();
            });
        });
        function getValuetoAdd() {
            var chkArray = [];
            $(".get_value:checked").each(function () {
                chkArray.map(function()
                    { return $(this).val()}
                );
            });

            var selected;
            selected = chkArray.join(',') + ",";
            if (selected.length > 1) {
                console.log(selected);
            } else {
                alert("Please at least one of the checkbox");
            }
        }

    </script>
    <!--Star js-->
    <script>
        $('.star').click(function(){
            $(this).toggleClass('clicked');
        });
    </script>

    <!--Show active tr-->
    <script>
        $(document).ready( function(){
            $("#myGlobalTable").on('click','.clickable-row',function(event){
                if($(this).hasClass('active'))
                {
                    $(this).removeClass('active');

                } else{
                    $(this).addClass('active').siblings().removeClass('active');
                }
            });
        });

    </script>

    <!-- TABS SCRIPT-->
    <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
    </script>

    <!--GLOBAL SEARCH  JS-->
    <script>
        function globalFunction() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("myGlobalInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myGlobalTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <!--PRIVATE SEARCH JS-->
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("myPrivateInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myPrivateTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

@endsection


