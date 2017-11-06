@extends('master')

@section('content')


<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{url('maps')}}">All Cases</a></li>
                    <li><a href="{{url('creatCase')}}">Create Case</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <form  method="post" action="search"  class="navbar-form navbar-left">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="input-group">

                        <input type="text" class="form-control" name="search" id="pick" placeholder="Search address">

                        <div class="input-group-btn">

                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>

                    </div>

                </form>
            </div>
            <div class="col-md-4">
                <form   method="post" action="searchCase"  class="navbar-form navbar-left">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="input-group">

                        <input type="text" class="form-control" placeholder="Search Case Number" name="caseID">
                        <div class="input-group-btn">

                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-10">
                    <div style="width: 100% ; height:600px ;">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-icon">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('success') }}
                                <i class="icon">&#61845;</i>
                            </div>
                        @endif


                        <div id="maps2">
                            {!! Mapper::render(0) !!}
                        </div>

                    </div>
                </div>
                <div class="col-md-2">
									<div class="row form-group">
										{!! Form::label("Company") !!}
										{!! Form::select("company",$optsCompanies, null, array('class'=>"form-control selCompany", 'id'=>"selCompany")) !!}
									</div>
									<div class="row form-group">
										{!! Form::label("Department") !!}
										{!! Form::select("department",array("Select company"), null, array('class'=>"form-control selDepartment", 'id'=>"selDepartment")) !!}
									</div>
									  <div class="row">
                        <b>Marker Labels:</b>
                    </div>
                    &nbsp;
										<div id="wMarkers">
                    <div class="row">
                        <a href="maps">
                        <img src="markers_2/marker_1.png" alt="">&nbsp;&nbsp;&nbsp;
                        {{--<i class="n-count animated" id='countPrivateMessages'>{{ 5 }}</i>&nbsp;&nbsp;--}}
                            Housekeeping
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                        <img src="markers_2/marker_2.png" alt="">&nbsp;&nbsp;&nbsp;
                        {{--<i class="n-count animated" id='countPrivateMessages'>{{ count(0) }}</i>&nbsp;&nbsp;--}}
                            Maintenance (Civil)
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                        <img src="markers_2/marker_3.png" alt="">&nbsp;&nbsp;&nbsp;
                        {{--<i class="n-count animated" id='countPrivateMessages'>{{ 12 }}</i>&nbsp;&nbsp;--}}
                            Maintenance (Electrical)
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                        <img src="markers_2/marker_4.png" alt="">&nbsp;&nbsp;&nbsp;
                        {{--<i class="n-count animated" id='countPrivateMessages'>{{ 23 }}</i>&nbsp;&nbsp;--}}
                            Maintenance (Marine)
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                        <img src="markers_2/marker_5.png" alt="">&nbsp;&nbsp;&nbsp;
                        {{--<i class="n-count animated" id='countPrivateMessages'>{{ 16 }}</i>&nbsp;&nbsp;--}}
                            Maintenance (Mechanical)
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                        <img src="markers_2/marker_6.png" alt="">&nbsp;&nbsp;&nbsp;
                        {{--<i class="n-count animated" id='countPrivateMessages'>{{ 8 }}</i>&nbsp;&nbsp;--}}
                            Property
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                            <img src="markers_2/marker_7.png" alt="">&nbsp;&nbsp;&nbsp;
                            {{--<i class="n-count animated" id='countPrivateMessages'>{{ 8 }}</i>&nbsp;&nbsp;--}}
                            Security
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                            <img src="markers_2/marker_8.png" alt="">&nbsp;&nbsp;&nbsp;
                            {{--<i class="n-count animated" id='countPrivateMessages'>{{ 8 }}</i>&nbsp;&nbsp;--}}
                            SHERQF
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                            <img src="markers_2/marker_9.png" alt="">&nbsp;&nbsp;&nbsp;
                            {{--<i class="n-count animated" id='countPrivateMessages'>{{ 8 }}</i>&nbsp;&nbsp;--}}
                            Traffic Management
                        </a>
                    </div>
                    &nbsp;
			<!--
                    <div class="row">
                        <a href="maps">
                            <img src="markers_2/marker_10.png" alt="">&nbsp;&nbsp;&nbsp;
                            {{--<i class="n-count animated" id='countPrivateMessages'>{{ 8 }}</i>&nbsp;&nbsp;--}}
                            Chemicaly
                        </a>
                    </div>
                    &nbsp;
                    <div class="row">
                        <a href="maps">
                            <img src="markers_2/marker_11.png" alt="">&nbsp;&nbsp;&nbsp;
                            {{--<i class="n-count animated" id='countPrivateMessages'>{{ 8 }}</i>&nbsp;&nbsp;--}}
                            test
                        </a>
                    </div>  -->
										</div>
                </div>
            </div>

        </div>
    </div>
</nav>


@endsection

<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js')}}" type="text/javascript" ></script>

<script src="bower_components/jquery/dist/js/jquery.min.js"></script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=places"></script>





<script  language="javascript">

google.maps.event.addDomListener(window,'load',function()
{

var search=new google.maps.places.Autocomplete(document.getElementById('pick'));
google.maps.event.addListener(search,'place_changed',function(){

 var place=search.getPlace();
 var address= place.formatted_address;

 {{--alert(address);--}}

    {{--$.ajax({--}}
        {{--url     :"{!! url('/search')!!}",--}}
        {{--type    :"POST",--}}
        {{----}}
        {{--dataType : "text",--}}
        {{--contentType: "application/json",--}}
        {{--data : dataAttribute--}}
    {{--});--}}

});

});

    //default map destination
    var eightMileOverlayBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(-30.008609, 30.931000),
        new google.maps.LatLng(-29.759365, 31.234000));

    var input     = document.getElementById('pick');
    var searchBox = new google.maps.places.SearchBox(input);

    $('#search').val(searchBox);

    /*map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });*/

</script>
