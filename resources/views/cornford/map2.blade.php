
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtqWsq5Ai3GYv6dSa6311tZiYKlbYT4mw&libraries=geometry,places"></script>
    <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    {{--<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css">--}}
    <title> Ubulwembu </title>


    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/form.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/generics.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/token-input.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/lightbox.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('/css/media-player.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('/css/file-manager.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/HoldOn.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-switch.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/incl/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/Treant.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/collapsable.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('/css/perfect-scrollbar.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('/css/form-builder.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/toggles.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/toggle-themes/toggles-all.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
{{--<link href="{{ asset('/bower_components/datatables-responsive/css/responsive.dataTables.scss') }}" rel="stylesheet">--}}
<!-- jQuery Library -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

<style>
    body{
        background-color: #0d6aad;
    }
    
    #infor{

        /*background: linear-gradient(to bottom,rgba(255,255,255,0)0%,rgba(255,255,255,1)100%);*/
       color: black;


    }
    
    </style>

</head>
<body>
<div class="row">
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li><a class="sa-side-homepage" href="{{ url('home') }}"></a></li>
            <li><a href="{{url('maps')}}">All Cases</a></li>
            <li class="active"><a href="{{url('map2')}}">Create Case</a></li>
        </ul>
    </div>
</nav>
</div>
<div class="row">
<div class="container">

    <div class="row">
        <div class="col-md-4">

            <h4 class="page-title"><center>Search Location</center> </h4>
            &nbsp;
            <div class="col-md-12">
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="search" id="seachmap" name="seachmap" class="form-control" placeholder="search address">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group-btn">

                        <button class="btn btn-default" onclick="geolocation()">
                            <i class="glyphicon glyphicon-map-marker" title="Use my current location"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">

                    <div id="map" style="height: 450px; margin: 8px; border-radius: 10px" class="push-right"></div>

            </div>



        </div>

        <div class="col-md-4">
            {!! Form::open(['url' => 'createMapCase', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"CreateCaseAgentForm" ,'files' => 'true']) !!}
            {!! Form::hidden('hseHolderId',NULL,['id' => 'hseHolderId']) !!}
            {{--{!! Form::hidden('lat',NULL,['id' => 'lat','class' => 'latitude']) !!}--}}
            {{--{!! Form::hidden('lng',NULL,['id' => 'lng','class' => 'longitude']) !!}--}}

            <h4 class="page-title"><center>Location  Details & Client Details</center> </h4>
            &nbsp;

            <div class="form-group">
                {!! Form::label('GPS Latitude', 'GPS Latitude', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('lat',NULL,['class' => 'form-control input-sm','id' => 'lat']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('GPS Longitude', 'GPS Longitude', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('lng',NULL,['class' => 'form-control input-sm','id' => 'lng']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Address', 'Address', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    <textarea rows="2" id="address" name="address" class="form-control"></textarea>
                    <div id = "hse_error_description"></div>
                </div>

            </div>

                <h4 class="page-title hidden"><center>Client  Details</center> </h4>
                &nbsp;
                <div class="form-group">
                    {!! Form::label('Search Client', 'Search Client', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('hsecellphone',NULL,['class' => 'form-control input-sm','id' => 'hsecellphone']) !!}
                        <div id = "hse_error_search"></div>
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('Cell Number', 'Cell Number', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('cellphone',NULL,['class' => 'form-control input-sm','id' => 'cellphone','disabled']) !!}
                        <div id = "hse_error_cellphone"></div>

                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('Client Name', 'Client Name', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'name','disabled']) !!}
                        <div id = "hse_error_name"></div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Client Surname', 'Client Surname', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('surname',NULL,['class' => 'form-control input-sm','id' => 'surname','disabled']) !!}
                        <div id = "hse_error_surname"></div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Company', 'Company', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('company',NULL,['class' => 'form-control input-sm','id' => 'company','disabled']) !!}
                        <div id = "hse_error_company"></div>
                    </div>
                </div>


            <h4 class="page-title hidden"><center>Client  References</center></h4>
            &nbsp;

            <div class="form-group">
                {!! Form::label('Client Reference Number', 'Client Reference Number', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('client_reference_number',NULL,['class' => 'form-control input-sm','id' => 'client_reference_number']) !!}
                    <div id = "hse_error_client_reference_number"></div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('SAPS Station', 'SAPS Station', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('saps_station',NULL,['class' => 'form-control input-sm','id' => 'saps_station']) !!}
                    <div id = "hse_error_saps_station"></div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('SAPS CAS Ref No', 'SAPS CAS Ref No', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('saps_case_number',NULL,['class' => 'form-control input-sm','id' => 'saps_case_number']) !!}
                    <div id = "hse_error_saps_case_number"></div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Rate Value', 'Rate Value', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('rate_value',NULL,['class' => 'form-control input-sm','id' => 'rate_value']) !!}
                    <div id = "hse_error_client_reference_number"></div>
                </div>
            </div>





                {{--<div class="form-group">--}}
                    {{--{!! Form::label('Enter Address', 'Enter Address', array('class' => 'col-md-3 control-label')) !!}--}}
                    {{--<div class="col-md-8">--}}
                        {{--{!! Form::text('autocomplete',NULL,['class' => 'form-control input-sm','id' => 'autocomplete', "onfocus"=>"geolocate()"]) !!}--}}
                        {{--<div id="hse_error_email"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}


                {{--<div class="form-group">--}}
                    {{--{!! Form::label('Street Number', 'Street Number', array('class' => 'col-md-3 control-label')) !!}--}}
                    {{--<div class="col-md-8">--}}
                        {{--{!! Form::text('street_number',NULL,['class' => 'street_number form-control input-sm','id' => 'street_number']) !!}--}}

                    {{--</div>--}}
                {{--</div>--}}


                {{--<div class="form-group">--}}
                    {{--{!! Form::label('Route', 'Route', array('class' => 'col-md-3 control-label')) !!}--}}
                    {{--<div class="col-md-8">--}}
                        {{--{!! Form::text('route',NULL,['class' => 'route form-control input-sm','id' => 'route']) !!}--}}

                    {{--</div>--}}
                {{--</div>--}}


                {{--<div class="form-group">--}}
                    {{--{!! Form::label('Locality', 'Locality', array('class' => 'col-md-3 control-label')) !!}--}}
                    {{--<div class="col-md-8">--}}
                        {{--{!! Form::text('locality',NULL,['class' => 'locality form-control input-sm','id' => 'locality']) !!}--}}

                    {{--</div>--}}
                {{--</div>--}}


                {{--<div class="form-group">--}}
                    {{--{!! Form::label('Area', 'Area', array('class' => 'col-md-3 control-label')) !!}--}}
                    {{--<div class="col-md-8">--}}
                        {{--{!! Form::text('administrative_area_level_1',NULL,['class' => 'administrative_area_level_1 form-control input-sm','id' => 'administrative_area_level_1']) !!}--}}

                    {{--</div>--}}
                {{--</div>--}}



                {{--<div class="form-group">--}}
                    {{--{!! Form::label('Postal Code', 'Postal Code', array('class' => 'col-md-3 control-label')) !!}--}}
                    {{--<div class="col-md-8">--}}
                        {{--{!! Form::text('postal_code',NULL,['class' => 'postal_code form-control input-sm','id' => 'postal_code']) !!}--}}

                    {{--</div>--}}
                {{--</div>--}}


                {{--<div class="form-group">--}}
                    {{--{!! Form::label('Country', 'Country', array('class' => 'col-md-3 control-label')) !!}--}}
                    {{--<div class="col-md-8">--}}
                        {{--{!! Form::text('country',NULL,['class' => 'country form-control input-sm','id' => 'country']) !!}--}}

                    {{--</div>--}}
                {{--</div>--}}



        </div>


            <div class="col-md-4">

                <h4 class="page-title"><center>Investigator & Description</center></h4>
                &nbsp;

                <div class="form-group">
                    {!! Form::label('Investigation Officer', 'Investigation Officer', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        <div class="input-group">
                            {!! Form::select('officers',$selectOfficers,0,['class' => 'form-control input-sm' ,'name' => 'officers','id' => 'officers']) !!}
                            <div class="input-group-addon" id="add_officer" title="Add New" style="cursor:pointer;">
                                <span class="glyphicon glyphicon-plus"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group hidden" id="txtOfficer">
                    {!! Form::label('Investigation Officer', 'Investigation Officer', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('investigation_officer',NULL,['class' => 'form-control input-sm','id' => 'investigation_officer']) !!}
                        <div id = "hse_error_saps_investigation_officer"></div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Investigation Cellphone', 'Investigation Cellphone', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('investigation_cell',NULL,['class' => 'form-control input-sm','id' => 'investigation_cell','disabled']) !!}
                        <div id = "hse_error_saps_investigation_cellphone"></div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Investigation Email', 'Investigation Email', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('investigation_email',NULL,['class' => 'form-control input-sm','id' => 'investigation_email','disabled']) !!}
                        <div id = "hse_error_saps_investigation_email"></div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Investigation Note', 'Investigation Note', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::textarea('investigation_note',NULL,['class' => 'form-control input-sm','id' => 'investigation_note' , 'rows'=> '5']) !!}
                        <div id = "hse_error_saps_investigation_note"></div>
                    </div>
                </div>

                <h4 class="page-title hidden"><center>Description</center></h4>
                &nbsp;&nbsp;
                <div class="form-group">
                    {!! Form::label('Case Type', 'Case Type', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('case_type',$selectCasesTypes,0,['class' => 'form-control input-sm' ,'name' => 'case_type[]','id' => 'case_type']) !!}
                        <div id = "hse_error_type"></div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Case Sub Type', 'Case Sub Type', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::select('case_sub_type',[],0,['class' => 'form-control input-sm' ,'name' => 'case_sub_type[]','id' => 'case_sub_type']) !!}
                        <div id = "hse_error_sub_type"></div>
                    </div>
                </div>

                {{--<div class="form-group" id="case_sub_type_addition">--}}
                {{--<div class="col-md-3"></div>--}}
                {{--<div class="col-md-6"><a id="add_case_type" class="btn btn-sm">Add Case Type</a></div>--}}
                {{--</div>--}}

                <div id="case_types_div"></div>




                <div class="form-group">
                    {!! Form::label('Problem Description', 'Problem Description', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        <textarea rows="5" id="description" name="description" class="form-control" maxlength="500"></textarea>
                        <div id = "hse_error_description"></div>
                    </div>

                </div>
                <br>
                <div class="form-group">
                    {!! Form::label('Attach File', 'Attach File', array('class' => 'col-md-4 control-label')) !!}
                    <div class="fileupload fileupload-new row" data-provides="fileupload">
                        <div class="input-group col-md-6">
                            <div class="uneditable-input form-control">
                                <i class="fa fa-file m-r-5 fileupload-exists"></i>
                                <span class="fileupload-preview"></span>
                            </div>
                            <br>
                            <div class="input-group-btn">
                    <span class="btn btn-file btn-alt btn-sm">
                    <span class="fileupload-new">Select file</span>
                    <span class="fileupload-exists">Change</span>
                        {!!  Form::file('caseFile' , null , ['id' => 'caseFile','class' => 'form-control']) !!}
                </span>
                            </div>

                            <a href="#" class="btn btn-sm btn-gr-gray fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                    </div>
                </div>

                <br>
                <div class="form-group">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <button type="submit" id='submitCreateCaseAgentForm' class="btn btn-sm">Create Case</button>

                    </div>
                </div>

            </div>

            <hr class="whiter m-t-20" />
        </div>
    </div>
</div>
{{--@endsection--}}

<script src="bower_components/jquery/dist/js/jquery.min.js"></script>

<!--Toggles-->
<script src="{{ asset('/js/toggles.js') }}"></script>

<script src="{{ asset('/js/jquery-ui.min.js') }}"></script> <!-- jQuery UI -->
<script src="{{ asset('/js/jquery.easing.1.3.js') }}"></script> <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->

<!-- Bootstrap -->
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>




<!--  Form Related -->
<script src="{{ asset('/js/icheck.js') }}"></script> <!-- Custom Checkbox + Radio -->

<!-- UX -->
<script src="{{ asset('/js/scroll.min.js') }}"></script> <!-- Custom Scrollbar -->

<!-- Other -->
<script src="{{ asset('/js/calendar.min.js') }}"></script> <!-- Calendar -->
<script src="{{ asset('/js/feeds.min.js') }}"></script> <!-- News Feeds -->


<!--  Form Related -->
<script src="{{ asset('/js/validation/validate.min.js') }}"></script> <!-- jQuery Form Validation Library -->
<script src="{{ asset('/js/validation/validationEngine.min.js') }}"></script> <!-- jQuery Form Validation Library - requirred with above js -->


<!-- All JS functions -->
<script src="{{ asset('/js/functions.js') }}"></script>


<!-- Token Input -->
<script src="{{ asset('/js/jquery.tokeninput.js') }}"></script> <!-- Token Input -->


<!-- Noty JavaScript -->
<script src="{{ asset('/bower_components/noty/js/noty/packaged/jquery.noty.packaged.js') }}"></script>

<!-- DataTables JavaScript -->


<script src="{{ asset('/bower_components/datatables/media/js/datatables-plugins/pagination/scrolling.js') }}"></script>
<script src="{{ asset('/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>



<!-- Jquery Bootstrap Maxlength -->
<script src="{{ asset('/bower_components/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>


<!-- Media -->
<script src="{{ asset('/js/media-player.min.js') }}"></script> <!-- Video Player -->
<script src="{{ asset('/js/pirobox.min.js') }}"></script> <!-- Lightbox -->
<script src="{{ asset('js/file-manager/elfinder.js') }}"></script> <!-- File Manager -->


<script type="text/javascript" src="{{ asset('/incl/oms.min.js') }}"></script>



<!-- File Upload -->
<script src="{{ asset('/js/fileupload.min.js') }}"></script> <!-- File Upload -->

<!-- Spinner -->
<script src="{{ asset('/js/HoldOn.min.js') }}"></script> <!-- Spinner -->

<!-- bootstrap-switch. -->
<script src="{{ asset('/js/bootstrap-switch.js') }}"></script> <!-- bootstrap-switch. -->

<!-- Date & Time Picker -->
<script src="{{ asset('/js/datetimepicker.min.js') }}"></script> <!-- Date & Time Picker -->

<!-- Buttons HTML5 -->
<script src="{{ asset('/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/js/jszip.min.js') }}"></script>
<script src="{{ asset('/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('/js/vfs_fonts.js') }}"></script>
<!--  Buttons HTML5 -->

<script src="{{ asset('js/socket.io.js') }}"></script>

<script src="{{ asset('js/calendar.min.js') }}"></script> <!-- Calendar -->

<script src="{{ asset('js/raphael.js') }}"> </script>





<!-- D3.js
        <script src="{{ asset('js/d3/plugins.js') }}"></script>
        <script src="{{ asset('js/d3/script.js') }}"></script>
        <script src="{{ asset('js/d3/libs/coffee-script.js') }}"></script>
        <script src="{{ asset('js/d3/libs/d3.v2.js') }}"></script>
        <script src="{{ asset('js/d3/Tooltip.js') }}"></script>
        <script src="{{ asset('js/d3/Tooltip.js') }}"></script>
    -->


{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=places"></script>--}}

<script type="text/javascript">
    var ZoomChartsLicense = "ZCS-bc96u7g34: ZoomCharts 30 day free trial development licence eli..@..l.com (valid for evaluation only); upgrades until: 2016-11-18";
    var ZoomChartsLicenseKey = "bb73530f3272579c914f3828e818a7956bc9a2361fe31fd609"+
        "bda486c2f2b069e414aef7f6bf51355f82b43ace777b9621e7858acaebc7f3c6fb70c5722ed38"+
        "82153935b365406d020ba9a80e45cff204ca43ce64f67c983827de0a7f0752a40401ad318c1bf"+
        "354009e851044a21bc2b73503448e9648ae4aeac2ad277d9f0972c6f2063b49fc7a19c7e4fcd3"+
        "8edb07040e7c65a0df13554a276cd9c576f3f515b252185483e79efff5ed71201d6cbef58a127"+
        "4ddb695c8c89887c9a9322ac8514fe87ccc88da0ed42aabb64b569389ad79f7eeb0f0be40d780"+
        "b487a324116c7da20f45f1e2f90ee01b277a2c56b52e04b13e6e567ae4c5c42cffb71a0ec7b58";
</script>

@include('functions.caseModal')

<script async defer language="javascript">
    if(navigator.onLine)
    {

        //initialize map
        var map=new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: -30.559482,
                lng: 22.937505999999985
            }, zoom: 2,

        });


        //get a marker
        var marker=new google.maps.Marker({
            position: {
                lat: -30.559482,
                lng: 22.937505999999985,

            }, map: map,
            draggable: true,
            visible:false,
            icon:"markers/newCaseMarker.png"

//            icon:'https://d30y9cdsu7xlg0.cloudfront.net/png/2955-200.png'
            //http://www.iconsdb.com/icons/preview/soylent-red/map-marker-2-xl.png
        });

        var marker2=[];


        infoWindow = new google.maps.InfoWindow;

        //function for current location
        function geolocation()
        {

            if(marker2.visible==true)
            {
                marker2.setVisible(false);
            }
            //find the current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,

                    };

                    //clear default marker
                    marker.setVisible(false);

                    marker2=new google.maps.Marker({
                        position: {
                            lat: -30.559482,
                            lng: 22.937505999999985,

                        }, map: map,
                        draggable: true,
                        zoom:10.,
                        icon:"markers/newCaseMarker.png"
                        //            icon:'https://d30y9cdsu7xlg0.cloudfront.net/png/2955-200.png'
                    });

                    $('#lat').val(pos['lat']);
                    $('#lng').val(pos['lng']);

                    google.maps.event.addListener(marker2,'position_changed',function(){
                        var lat=marker2.getPosition().lat();
                        var lng=marker2.getPosition().lng();

                        $('#lat').val(lat);
                        $('#lng').val(lng);
                    })

                    //to get the address of the current location
                    var geocoder = new google.maps.Geocoder;

                    var input = pos['lat']+','+pos['lng'];
                    var latlngStr = input.split(',', 2);
                    var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
                    geocoder.geocode({'location': latlng}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                $('#address').val(results[0].formatted_address);
                                infoWindow.setContent("<div id='infor'>"+results[0].formatted_address+"</div>")

                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });

                    infoWindow.setPosition(pos);


                    map.setCenter(pos);
                    map.setZoom(19);
                    marker2.setPosition(pos);



                    infoWindow.open(map,marker2);
                }, function() {

                    handleLocationError(true, infoWindow, map.getCenter());

                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }


            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
                infoWindow.open(map,marker2);
            }





        }


        //Search for location
        var searchBox = new google.maps.places.SearchBox(document.getElementById("seachmap"));


        //when the maker is dragged arround then change both cordinates
        google.maps.event.addListener(searchBox,'places_changed',function(){

            //clear a marker for current location
            //marker2.setVisible(false);
            if(marker2.visible==true)
            {
                marker2.setVisible(false);
            }


            var places=searchBox.getPlaces();
            var bounds=new google.maps.LatLngBounds();
            var i,place;
            for (i=0;place=places[i];i++)
            {
                bounds.extend(place.geometry.location);
                marker.setPosition(place.geometry.location);

                var lat=marker.getPosition().lat();
                var lng=marker.getPosition().lng();

                $('#lat').val(lat).disabled=true;
                $('#lng').val(lng);

                //to get the address of the place searched
                var geocoder = new google.maps.Geocoder;

                var input = lat+','+lng;
                var latlngStr = input.split(',', 2);
                var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
                geocoder.geocode({'location': latlng}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            infoWindow.setContent("<div id='infor'>"+results[0].formatted_address+"</div>")

                        } else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder failed due to bugs: ' + status);
                    }
                });

                marker.setVisible(true);
                infoWindow.open(map,marker);
            }
            map.fitBounds(bounds);
            map.setZoom(19);

            google.maps.event.addListener(marker,'position_changed',function(){
                var lat=marker.getPosition().lat();
                var lng=marker.getPosition().lng();

                $('#lat').val(lat);
                $('#lng').val(lng);




            })




            //reset search box
            $('#seachmap').val(null);

        });

    }
    else
    {
//        alert("you are offline");

        (document.getElementById("map")).innerHTML="<a href='{{url('map2')}}'> <img src='img/NoNetwork.png' alt='Network connection failed,Please refresh'></a>";
    }

</script>

</body>
</html>