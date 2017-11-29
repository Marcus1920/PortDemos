@extends('master')
@section('content')

   <style>
    /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
    #map {
    height: 100%;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    }
    </style>

    <div class="block-area" id="basic">
        <ol class="breadcrumb hidden-xs">
            <li class="active">Drone Request Form</li>
        </ol>
        <h4 class="page-title">REQUEST FORM</h4>
        <br>

        @if(Session::has('success'))
            <div class="alert alert-success alert-icon">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ Session::get('success') }}
                <i class="icon">&#61845;</i>
            </div>
        @endif
        <div class="tile p-15" style="margin:0 auto;" >
            {!! Form::open(['url' => '/api/v1/drone', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"requestDroneForm" ]) !!}
            {!! Form::hidden('created_by',Auth::user()->id)!!}
            <div class="form-group">
                {!! Form::label('Search Department', 'Search Department', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('dronesDepartment',null,['class' => 'form-control validate[required]' ,'id' => 'dronesDepartment', old('department')]) !!}
                    @if ($errors->has('dronesDepartment')) <p class="help-block red">*{{ $errors->first('dronesDepartment') }}</p> @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Select Drone', 'Select Drone', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::select('drone_type_id',$selectDroneTypes,"",['class' => 'form-control validate[required]','id' => 'drone_type_id', old('drone_type_id')]) !!}
                    @if ($errors->has('drone_type_id')) <p class="help-block red">*{{ $errors->first('drone_type_id') }}</p> @endif
                </div>

            </div>

            <div class="form-group">
                {!! Form::label('Select Drone Types ', 'Select Drone Types', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {{--{!! Form::select('sub_drone_type_id',Null,['class' => 'form-control validate[required]' ,'id' => 'sub_drone_type_id']) !!}--}}
                    {{--@if ($errors->has('sub_drone_type_id')) <p class="help-block red">*{{ $errors->first('sub_drone_type_id') }}</p> @endif--}}

                    <select class="form-control" id="sub_drone_type_id" name="sub_drone_type_id"  value ="old('sub_drone_type_id')">
                        <option selected disabled>Nothing selected</option>
                    </select>
                    @if ($errors->has('sub_drone_type_id')) <p class="help-block red">*{{ $errors->first('sub_drone_type_id') }}</p> @endif
                </div>
            </div>
            <div class="form-group realTime hidden">
                    {!! Form::label('Service Required ', 'Service Required ', array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('service',NULL,['class' => 'form-control input-sm','id' => 'service']) !!}
                    </div>
                </div>

            <div class="form-group droneService hidden">
                {!! Form::label('Select Drone Services', 'Select Drone Services', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <select class="form-control" id="drone_service_type_id" name="drone_service_type_id"  value ="old('sub_drone_type_id')">
                        <option selected disabled>Nothing selected</option>
                    </select>
                    @if ($errors->has('drone_service_type_id')) <p class="help-block red">*{{ $errors->first('drone_service_type_id') }}</p> @endif
                </div>
            </div>
            <div class="form-group droneSubService hidden">
                {!! Form::label('Select Drone Sub Services', 'Select Drone Sub Services', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    <select class="form-control" id="drone_sub_service_type_id" name="drone_sub_service_type_id"  value ="old('sub_drone_type_id')">
                        <option selected disabled>Nothing selected</option>
                    </select>
                    @if ($errors->has('drone_sub_service_type_id')) <p class="help-block red">*{{ $errors->first('drone_sub_service_type_id') }}</p> @endif
                </div>
            </div>
            <div class="form-group surveys hidden">
                {!! Form::label('Area of Interest', 'Area of Interest', array('class' => 'col-md-3 control-label  ')) !!}
                <div class="col-md-6 col-offfset-3">
                    <div style="width: 100% ; min-height: 500px"; id="map">
                    </div>
                    @if ($errors->has('area_of_interest')) <p class="help-block red">*{{ $errors->first('area_of_interest') }}</p> @endif
                </div>
            </div>
            <div class="form-group purposeOfSurvey hidden">
                {!! Form::label('Purpose Of Survey ', 'Purpose Of Survey', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('purpose_of_survey',NULL,['class' => 'form-control input-sm','id' => 'purpose_of_survey','disabled']) !!}
                </div>
            </div>
            <div class="form-group numberOfStockPile hidden">
                {!! Form::label('Number of Stockpiles', 'Number of Stockpiles', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('number_of_stockpiles',NULL,['class' => 'form-control input-sm','id' => 'number_of_stockpiles','disabled','rows'=>'7']) !!}
                </div>
            </div>
            <div class="form-group verticalAccuracy hidden">
                {!! Form::label('Vertical Accuracy', 'Vertical Accuracy', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('vertical_accuracy',NULL,['class' => 'form-control input-sm','id' => 'vertical_accuracy','disabled','rows'=>'7']) !!}
                </div>
            </div>
            <div class="form-group auxiliaryServices hidden">
                {!! Form::label('Object of Interest ', 'Object of Interest ', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('interest',NULL,['class' => 'form-control input-sm','id' => 'interest','disabled','rows'=>'7']) !!}
                </div>
            </div>
            <div class="form-group scopeOfWOrk hidden">
                {!! Form::label('Scope of Work ', 'Scope of Work  ', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('scope_of_work',NULL,['class' => 'form-control input-sm','id' => 'scope_of_work']) !!}
                </div>
            </div>
            <div class="form-group Notes hidden">
                {!! Form::label('Notes', 'Notes ', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::textarea('notes',NULL,['class' => 'form-control input-sm','id' => 'notes']) !!}
                </div>
            </div>
            <div class="form-group surveys hidden">
                {!! Form::label('Geo Fence Clipboard', 'clip Board', array('class' => 'col-md-3 control-label  ')) !!}
                <div class="col-md-6">
                    <div>
                        {!! Form::text('geoFenceCoords',NULL,['class' => 'form-control input-sm','id' => 'geoFenceCoords','rows'=>5]) !!}
                    </div>
                    @if ($errors->has('geoFenceCoords')) <p class="help-block red">*{{ $errors->first('geoFenceCoords') }}</p> @endif
                </div>
            </div>
            <div class="form-group " style="margin-top: 10px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="col-sm-6 col-sm-offset-5">
                        <button type="submit" class="btn btn-lg">Request</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@stop
@section('footer')
    <script>

            $('#drone_type_id').on('change', function () {
                var id = this.value;
                $('#sub_drone_type_id').empty();
                $.get('api/v1/droneSubType/' + id, function (response) {
                    $('#sub_drone_type_id').append("<option  selected disabled>Select Drone Type</option>");
                    $.each(response, function (key, value) {
                        $('#sub_drone_type_id').append("<option  value=" + value.id + ">" + value.name + "</option>");
                    });
                });
            });
            $('#sub_drone_type_id').on('change', function () {
                var id = this.value;
                $('#drone_service_type_id').empty();
                $.get('api/v1/droneServiceType/' + id, function (response) {
                    $('#drone_service_type_id').append("<option  selected disabled>Select Drone service</option>");
                    $.each(response, function (key, value) {
                        $('#drone_service_type_id').append("<option  value=" + value.id + ">" + value.name + "</option>");
                    });

                });
                var selectText = $(this).find("option:selected").text();
                if (selectText == 'Real Time') {

                    $('.realTime').removeClass('hidden');
                    $('.scopeOfWOrk').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $("#service").removeAttr('disabled');
                    $("#scope_of_work").removeAttr('disabled');
                    $("#notes").removeAttr('disabled');

                    $('.droneService').addClass('hidden');
                    $("#drone_service_type_id").attr('disabled', 'disabled');

                } else {

                    $('.realTime').addClass('hidden');
                    $('.scopeOfWOrk').addClass('hidden');
                    $('.Notes').addClass('hidden');
                    $("#service").attr('disabled', 'disabled');
                    $("#scope_of_work").attr('disabled', 'disabled');
                    $("#notes").attr('disabled', 'disabled');

                    $('.droneService').removeClass('hidden');
                    $("#drone_service_type_id").removeAttr('disabled');

                }
            });
            $('#drone_service_type_id').on('change', function () {
                var id = this.value;
                $('#drone_sub_service_type_id').empty();
                $.get('api/v1/droneSubServiceType/' + id, function (response) {
                    $('#drone_sub_service_type_id').append("<option  selected disabled>Select Drone Sub Service</option>");
                    $.each(response, function (key, value) {
                        $('#drone_sub_service_type_id').append("<option  value=" + value.id + ">" + value.name + "</option>");
                    });
                });

                var selectId   =$(this).find("option:selected").val();
                var selectText = $(this).find("option:selected").text();
              //Aquatic -> ad Hoc
                if (selectText == 'Auxiliary Services') {
                    $('.droneSubService').removeClass('hidden');
                    $('.auxiliaryServices').removeClass('hidden');
                    $('.scopeOfWOrk').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $("#drone_sub_service_type_id").removeAttr('disabled');
                    $("#interest").removeAttr('disabled');
                    $("#scope_of_work").removeAttr('disabled');
                    $("#notes").removeAttr('disabled');
                }
                // Aerial ->ad Hoc
                else if(selectId == 6 && selectText == 'Inspection'){
                    $('.droneSubService').removeClass('hidden');
                    $('.auxiliaryServices').removeClass('hidden');
                    $('.scopeOfWOrk').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $("#drone_service_type_id").removeAttr('disabled', 'disabled');
                    $("#interest").removeAttr('disabled', 'disabled');
                    $("#scope_of_work").removeAttr('disabled', 'disabled');
                    $("#notes").removeAttr('disabled', 'disabled');
                    $('.purposeOfSurvey').addClass('hidden');
                    $('.verticalAccuracy').addClass('hidden');
                    $('.numberOfStockPile').addClass('hidden');
                    $('.surveys').addClass('hidden');
                }
                else if(selectText =='Surveys'){
                    $('.droneSubService').removeClass('hidden');
                    $('.scopeOfWOrk').addClass('hidden');
                    $('.Notes').addClass('hidden');
                    $('.auxiliaryServices').addClass('hidden');

                }
                //Aquatic -> ad Hoc
                else if(selectText =='Hydrographic Survey' && selectText=='Hydrographic Solar Scanning'){
                    $('.scopeOfWOrk').removeClass('hidden');
                    $('.surveys').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $('.purposeOfSurvey').addClass('hidden');
                }
                else if(selectId == 4 && selectText=='Inspection'){
                    $('.auxiliaryServices').removeClass('hidden');
                    $('.scopeOfWOrk').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $('.purposeOfSurvey').addClass('hidden');
                    $('.surveys').addClass('hidden');
                    $("#interest").removeAttr('disabled', 'disabled');
                    $("#scope_of_work").removeAttr('disabled');
                    $("#notes").removeAttr('disabled');
                }
                else if(selectText == 'Film and Photography' || selectText == 'Infrastructure Assessment')
                {
                    $('.auxiliaryServices').removeClass('hidden');
                    $('.scopeOfWOrk').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $("#interest").removeAttr('disabled', 'disabled');
                    $("#scope_of_work").removeAttr('disabled', 'disabled');
                    $("#notes").removeAttr('disabled', 'disabled');
                    $('.purposeOfSurvey').addClass('hidden');
                    $('.surveys').addClass('hidden');
                    $('.verticalAccuracy').addClass('hidden');
                    $('.droneSubService').addClass('hidden');
                }
                else{
                    $('.surveys').removeClass('hidden');
                    $('.purposeOfSurvey').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $("#notes").removeAttr('disabled', 'disabled');
                    $("#purpose_of_survey").removeAttr('disabled', 'disabled');
                    $('.auxiliaryServices').addClass('hidden');
                    $('.scopeOfWOrk').addClass('hidden');
                    $('.droneSubService').addClass('hidden');
                }
            });
            $('#drone_sub_service_type_id').on('change', function () {

                var selectText = $(this).find("option:selected").text();
                //Aerial ->ad Hoc ->Surveys
                if(selectText == 'Stockpile Surveys'){
                    $('.surveys').removeClass('hidden');
                    $('.purposeOfSurvey').removeClass('hidden');
                    $('.verticalAccuracy').addClass('hidden');
                    $('.scopeOfWOrk').addClass('hidden');
                    $('.auxiliaryServices').addClass('hidden');
                    $('.numberOfStockPile').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $("#purpose_of_survey").removeAttr('disabled', 'disabled');
                    $("#number_of_stockpiles").removeAttr('disabled', 'disabled');
                    $("#notes").removeAttr('disabled', 'disabled');

                }else if(selectText =='Water Sampler' ||selectText =='Sediment Sampler' ||selectText =='Net Repairer' ||selectText =='Cut Attachment'||selectText =='Thermal Inspection'||selectText =='Industrial Inspection')
                {
                    $('.verticalAccuracy').addClass('hidden');
                }
                else{

                    $('.surveys').removeClass('hidden');
                    $('.purposeOfSurvey').removeClass('hidden');
                    $('.Notes').removeClass('hidden');
                    $('.numberOfStockPile').addClass('hidden');
                    $('.verticalAccuracy').removeClass('hidden');
                    $("#vertical_accuracy").removeAttr('disabled', 'disabled');
                    $("#purpose_of_survey").removeAttr('disabled', 'disabled');
                    $("#number_of_stockpiles").removeAttr('disabled', 'disabled');
                    $("#notes").removeAttr('disabled', 'disabled');
                }

            });
            $("#dronesDepartment").tokenInput("{!! url('/api/v1/userDepartment')!!}", {tokenLimit: 1});

            var map, infoWindow ,drawingManager,poly1;

            function initMap() {
                map = new google.maps.Map(document.getElementById('map'),
                    {
                        center: {lat: -30.559482, lng: 22.937505999999985},
                        zoom: 5,
                        mapTypeId: google.maps.MapTypeId.RoadMap
                    });
                //doAllPolygons();

                infoWindow = new google.maps.InfoWindow;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        infoWindow.setPosition(pos);
                        infoWindow.setContent('Location found.');
                        infoWindow.open(map);
                        map.setCenter(pos);

                    }, function () {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                    handleLocationError(false, infoWindow, map.getCenter());
                }

                var p = document.getElementById('geoFenceCoords').value.replace(/%20/g, ',');
                var point = p.substr(10, p.length - 1);
                var gFance = point.substr(0, point.indexOf('),'));
                var points = gFance.split(", ");
                var CoordsPath = points.map(function (points) {
                    var latlon = points.split(' ');
                    //alert(latlon[0] + " " + latlon[1]);
                    return new google.maps.LatLng(latlon[0], latlon[1]);
                });

                if (CoordsPath != "(0, NaN)") {
                    drawingManager = new google.maps.drawing.DrawingManager({
                        drawingMode: google.maps.drawing.OverlayType.POLYGON,
                        drawingControl: true,
                        drawingControlOptions: {
                            position: google.maps.ControlPosition.TOP_CENTER,
                            drawingModes: [
                                //'marker', 'polygon'
                                google.maps.drawing.OverlayType.POLYGON
                            ]
                        },
                        polygonOptions: doPolygon(map)
//                        {
//                                geodesic: true,
//                                strokeColor: '#FF0000',
//                                strokeOpacity: 1.0,
//                                strokeWeight: 2,
//                                clickable: true,
//                                editable: true,
//                                zIndex: 1
//                            }

                    });
                } else {
                    drawingManager = new google.maps.drawing.DrawingManager({
                        drawingMode: google.maps.drawing.OverlayType.POLYGON,
                        drawingControl: true,
                        drawingControlOptions: {
                            position: google.maps.ControlPosition.TOP_CENTER,
                            drawingModes: [
                                //'marker', 'polygon'
                                google.maps.drawing.OverlayType.POLYGON
                            ]
                        },
                        polygonOptions: {
                            geodesic: true,
                            strokeColor: '#FF0000',
                            strokeOpacity: 1.0,
                            strokeWeight: 2,
                            clickable: true,
                            editable: true,
                            zIndex: 1

                        }
                    });

                    drawingManager.setMap(map);

                    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {

                        openInfoWindowPolygon(polygon);

                    });
                }
            }

//                var triangleCoords = [
//                    new google.maps.LatLng(33.5362475, -111.9267386),
//                    new google.maps.LatLng(33.5104882, -111.9627875),
//                    new google.maps.LatLng(33.5004686, -111.9027061)
//                ];
//
//
////                var paht=arraySet(pos);
////  alert(paht);
//                myPolygon = new google.maps.Polygon({
//                    paths: triangleCoords,
//                    draggable: true, // turn off if it gets annoying
//                    editable: true,
//                    strokeColor: '#FF0000',
//                    strokeOpacity: 0.8,
//                    strokeWeight: 2,
//                    fillColor: '#FF0000',
//                    fillOpacity: 0.35
//                });
//
//                myPolygon.setMap(map);
//
//                var drawingManager = new google.maps.drawing.DrawingManager({
//                    drawingMode: google.maps.drawing.OverlayType.POLYGON,
//                    drawingControl: true,
//                    drawingControlOptions: {
//                        position: google.maps.ControlPosition.TOP_CENTER,
//                        drawingModes: ['marker', 'polygon']
//                    },
//                    markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
//                    circleOptions: {
//                        fillColor: '#ffff00',
//                        fillOpacity: 1,
//                        strokeWeight: 5,
//                        clickable: false,
//                        editable: true,
//                        zIndex: 1
//                    }
//
//                });

//                function getPolygonCoords() {
//                    var len = flightPath.getPath().getLength();
//                    var htmlStr = "";
//                    var firstPos = "";
//                    var result = "";
//                    for (var i = 0; i < len; i++) {
//                        htmlStr += flightPath.getPath().getAt(i).toUrlValue(5) + " ";
//                        var arr = flightPath.getPath().getAt(i).toUrlValue(5).split(',');
//
//                        if (i == 0) {
//
//                            result += arr[0] + " " + arr[1];
//                            //firstPos = ","+arr[0] + " " + arr[1];
//                        }
//                        else {
//                            result += "," + arr[0] + ", " + arr[1];
//                        }
//                    }
//                    result += "))";
//                    document.getElementById('geoFenceCoords').value = result;
//                }

                function openInfoWindowPolygon(polygon) {

                    poly1 = polygon;
                    //alert(poly1);
                    var vertices = polygon.getPath();
                    //foreach(xy in vertices)
                    //{
                    document.getElementById('geoFenceCoords').value = polygon.getPath();
                    //}
                    var contents = 'Location name';
                    var bounds = new google.maps.LatLngBounds();
                    vertices.forEach(function (xy, i) {
                        bounds.extend(xy);
                        document.getElementById('geoFenceCoords').value += xy+"_";
                    });
                    vertices.forEach(function (xy, i)
                    {
                        bounds.extend(xy);
                    });
                    //infoWindow.setContent(contents);
                    //infoWindow.setPosition(bounds.getCenter());
                    drawingManager.setDrawingMode(null);
                    infoWindow.open(map);
                }

                function doPolygon(map) {

                    //document.getElementById('txtCoordinates').value = getParameterByName('GeoFence');
                    var p = document.getElementById('geoFenceCoords').value.replace(/%20/g, ',');
                    var point = p.substr(10, p.length - 2);
                    var gFance = point.substr(0, point.indexOf(',),'));
                    var points = gFance.split(" ");
                    var CoordsPath = points.map(function (points) {
                        var latlon = points.split(' ');
                        alert(latlon[0] + " " + latlon[1]);
                        return new google.maps.LatLng(latlon[0], latlon[1]);
                    });

                    flightPath = new google.maps.Polygon({
                        path: CoordsPath,
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2,
                        editable: true

                    });

                    flightPath.setMap(map);
                    google.maps.event.addListener(flightPath, "dragend", getPolygonCoords);
                    google.maps.event.addListener(flightPath.getPath(), "insert_at", getPolygonCoords);
                    google.maps.event.addListener(flightPath.getPath(), "remove_at", getPolygonCoords);
                    google.maps.event.addListener(flightPath.getPath(), "set_at", getPolygonCoords);

                    var latlngbounds = new google.maps.LatLngBounds();
                    for (var i = 0; i < CoordsPath.length; i++) {
                        latlngbounds.extend(CoordsPath[i]);
                    }
                    map.fitBounds(latlngbounds);

                }
                function clearMap() {
                    drawingManager.setDrawingMode(null);
                    flightPath.setMap(null);
                    document.getElementById('geoFenceCoords,').value = null;
                }

                google.maps.event.addDomListener(window, 'load', initMap);

                //myPolygon.setMap(map);
//                google.maps.event.addListener(myPolygon, "dragend", getPolygonCoords);
//                google.maps.event.addListener(drawingManager.ge, "insert_at", getCoords);
//                google.maps.event.addListener(myPolygon.getPath(), "remove_at", getPolygonCoords);
//                 google.maps.event.addListener(drawingManager.getPath(), "set_at", getCoords);
//                google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon)
//                {
//                    var coordinates =(polygon.getPath().getArray());
//                   console.log(coordinates);
//
//                   // var len = (polygon.getPath().getLength());
//                   // var htmlStr = "";
//                   // console.log(len);
////                    for (var i = 0; i < len; i++) {
////                        htmlStr += "new google.maps.LatLng(" + polygon.getPath().getArray(i).toUrlValue(5) + "), ";
////                        //Use this one instead if you want to get rid of the wrap > new google.maps.LatLng(),
////                        //htmlStr += "" + myPolygon.getPath().getAt(i).toUrlValue(5);
////                    }
////                    document.getElementById('geoFenceCoords').innerHTML = htmlStr;
//
////                    if (event.type == 'polygon') {
////                        var len = drawingManager.getPath().getLength();
////                        var htmlStr = "";
////                        for (var i = 0; i < len; i++) {
////                            htmlStr += "new google.maps.LatLng(" + drawingManager.getPath().getAt(i).toUrlValue(5) + "), ";
////                            //Use this one instead if you want to get rid of the wrap > new google.maps.LatLng(),
////                            //htmlStr += "" + myPolygon.getPath().getAt(i).toUrlValue(5);
////                        }
////                        document.getElementById('geoFenceCoords').innerHTML = htmlStr;
//////                        //var radius = event.overlay.getCoords();
//                 //   }
//                });
            //}
//            function getCoords() {
//                var len = drawingManager.getPath().getLength();
//                var htmlStr = "";
//                for (var i = 0; i < len; i++) {
//                    htmlStr += "new google.maps.LatLng(" + drawingManager.getPath().getAt(i).toUrlValue(5) + "), ";
//                    //Use this one instead if you want to get rid of the wrap > new google.maps.LatLng(),
//                    //htmlStr += "" + myPolygon.getPath().getAt(i).toUrlValue(5);
//                }
//                document.getElementById('geoFenceCoords').innerHTML = htmlStr;
//            }

//            function  geolocation() {
//                infoWindow = new google.maps.InfoWindow;
//                // Try HTML5 geolocation.
//                if (navigator.geolocation) {
//                    navigator.geolocation.getCurrentPosition(function(position) {
//                        var pos = {
//                            lat: position.coords.latitude,
//                            lng: position.coords.longitude
//                        };
//
//                        infoWindow.setPosition(pos);
//                        infoWindow.setContent('Location found.');
//                        infoWindow.open(map);
//                        map.setCenter(pos);
//                    }, function() {
//                        handleLocationError(true, infoWindow, map.getCenter());
//                    });
//                } else {
//                    // Browser doesn't support Geolocation
//                    handleLocationError(false, infoWindow, map.getCenter());
//                }
//            }
//            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
//                infoWindow.setPosition(pos);
//                infoWindow.setContent(browserHasGeolocation ?
//                    'Error: The Geolocation service failed.' :
//                    'Error: Your browser doesn\'t support geolocation.');
//                infoWindow.open(map);
//            }
//
            function copyToClipboard(text) {
                window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
            }



                //function for current location

//                function geolocation()
//                {
//
////            if(marker2.visible==true)
////            {
////                marker2.setVisible(false);
////            }
//                    //find the current location
////                    if (navigator.geolocation) {
////                        navigator.geolocation.getCurrentPosition(function (position) {
////                            var pos = {
////                                lat: position.coords.latitude,
////                                lng: position.coords.longitude,
////
////                            };
////
////                            //clear default marker
//////                    marker.setVisible(false);
//////
//////                    marker2=new google.maps.Marker({
//////                        position: {
//////                            lat: -30.559482,
//////                            lng: 22.937505999999985,
//////
//////                        }, map: map,
//////                        draggable: true,
//////                        zoom:10
//////                        //            icon:'https://d30y9cdsu7xlg0.cloudfront.net/png/2955-200.png'
//////                    });
//////
//////                    $('#lat').val(pos['lat']);
//////                    $('#lng').val(pos['lng']);
////
//////                    google.maps.event.addListener(marker2,'position_changed',function(){
//////                        var lat=marker2.getPosition().lat();
//////                        var lng=marker2.getPosition().lng();
//////
//////                        $('#lat').val(lat);
//////                        $('#lng').val(lng);
////                            });
////
////                        //to get the address of the current location
//////                    var geocoder = new google.maps.Geocoder;
//////
//////                    var input = pos['lat']+','+pos['lng'];
//////                    var latlngStr = input.split(',', 2);
//////                    var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
//////                    geocoder.geocode({'location': latlng}, function(results, status) {
//////                        if (status === 'OK') {
//////                            if (results[0]) {
//////                                $('#address').val(results[0].formatted_address);
//////                                infoWindow.setContent(results[0].formatted_address)
//////                            } else {
//////                                window.alert('No results found');
//////                            }
//////                        } else {
//////                            window.alert('Geocoder failed due to: ' + status);
//////                        }
//////                                 });
////
////                        infoWindow.setPosition(pos);
////                        map.setCenter(pos);
////                        map.setZoom(19);
//////                        marker2.setPosition(pos);
////                        infoWindow.open(map);
////
//////                },function() {
////////
//////                    handleLocationError(true, infoWindow, map.getCenter());
////////
//////                });
////                    } else {
//                        // Browser doesn't support Geolocation
//                        handleLocationError(false, infoWindow, map.getCenter());
//                    }


                    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                        infoWindow.setPosition(pos);
                        infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
                        infoWindow.open(map,marker2);
                    }




//                var drawingManager = new google.maps.drawing.DrawingManager({
//                    drawingMode: google.maps.drawing.OverlayType.MARKER,
//                    drawingControl: true,
//                    drawingControlOptions: {
//                        position: google.maps.ControlPosition.TOP_CENTER,
//                        drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
//                    },
//                    markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
//                    circleOptions: {
//                        fillColor: '#ffff00',
//                        fillOpacity: 1,
//                        strokeWeight: 5,
//                        clickable: false,
//                        editable: true,
//                        zIndex: 1
//                    }
//                });
//                drawingManager.setMap(map);
//


    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=drawing&callback=initMap"
            async defer></script>

@endsection