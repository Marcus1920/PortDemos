@extends('master')

@section('content')
    @include('cases.profile')
    @include('cases.closeRequest')
    @include('addressbook.list')
<div class="row">
<div class="container" id="cornford">

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

      {!! Form::open(['url' => 'createCaseAgent', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"CreateCaseAgentForm" ,'files' => 'true']) !!}
      {!! Form::hidden('hseHolderId',NULL,['id' => 'hseHolderId']) !!}
      {{--{!! Form::hidden('lat',NULL,['id' => 'lat','class' => 'latitude']) !!}--}}
      {{--{!! Form::hidden('lng',NULL,['id' => 'lng','class' => 'longitude']) !!}--}}
        <div class="col-md-4">
            <h4 class="page-title"><center>Incident Location</center> </h4>
            &nbsp;

            <div class="form-group">
                {!! Form::label('GPS Latitude', 'GPS Latitude', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('gpsAddressLat',NULL,['class' => 'form-control input-sm','id' => 'lat']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('GPS Longitude', 'GPS Longitude', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('gpsAddressLong',NULL,['class' => 'form-control input-sm','id' => 'lng']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Address', 'Address', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                    <textarea rows="2" id="address" name="address" class="form-control"></textarea>
                    <div id = "hse_error_description"></div>
                </div>

            </div>

          <h4 class="page-title"><center>Reporter</center></h4>
          &nbsp;

          <div class="form-group">
            {!! Form::label('Reporter', 'Reporter', array('class' => 'col-md-4 control-label')) !!}
            <div class="col-md-6">
              <div class="input-group">
                {!! Form::select('reporter',$optsReporters,0,['class' => 'form-control input-sm','id' => 'reporters']) !!}
                <div class="input-group-addon" id="add_reporter" title="Add New" style="cursor:pointer;">
                  <span class="glyphicon glyphicon-plus"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group" id="wReporterName">
            {!! Form::label('Investigation Officer', 'Name', array('class' => 'col-md-4 control-label')) !!}
            <div class="col-md-6">
              {!! Form::text('reporter_name',NULL,['class' => 'form-control input-sm','id' => 'reporter_name']) !!}
              <div id = "hse_error_reporter_name"></div>
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('Investigation Cellphone', 'Cellphone', array('class' => 'col-md-4 control-label')) !!}
            <div class="col-md-6">
              {!! Form::text('reporter_cell',NULL,['class' => 'form-control input-sm','id' => 'reporter_cell']) !!}
              <div id = "hse_reporter_cellphone"></div>
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('Investigation Email', 'Email', array('class' => 'col-md-4 control-label')) !!}
            <div class="col-md-6">
              {!! Form::text('reporter_email',NULL,['class' => 'form-control input-sm','id' => 'reporter_email']) !!}
              <div id = "hse_error_reporter_email"></div>
            </div>
          </div>

                <h4 class="page-title"><center>Capturer</center> </h4>
                &nbsp;
            {{--<div class="form-group">
                    {!! Form::label('Search Client', 'Search Client', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('hsecellphone',NULL,['class' => 'form-control input-sm','id' => 'hsecellphone']) !!}
                        <div id = "hse_error_search"></div>
                    </div>
            </div>--}}


                <div class="form-group">
                    {!! Form::label('Cell Number', 'Cell Number', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                    {!! Form::text('cellphone',"{$user['cellphone']}",['class' => 'form-control input-sm','id' => 'cellphone','disabled']) !!}
                        <div id = "hse_error_cellphone"></div>

                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('Client Name', 'Name', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                    {!! Form::text('name',"{$user['name']}",['class' => 'form-control input-sm','id' => 'name','disabled']) !!}
                        <div id = "hse_error_name"></div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Client Surname', 'Surname', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                    {!! Form::text('surname',"{$user['surname']}",['class' => 'form-control input-sm','id' => 'surname','disabled']) !!}
                        <div id = "hse_error_surname"></div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('Company', 'Company', array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                    {!! Form::text('company',"{$user['companyname']}",['class' => 'form-control input-sm','id' => 'company','disabled']) !!}
                        <div id = "hse_error_company"></div>
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


            <div class="col-md-4 form-horizontal">


                <h4 class="page-title hidden"><center>Description</center></h4>
                &nbsp;&nbsp;
              <div class="form-group">
                {!! Form::label('Company', 'Company', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select("company", $optsCompanies, null, array('class'=>"form-control input-sm selCompany", 'id'=>"selCompany", 'style'=>"width: initial; display: inline-block")) !!}

                </div>
              </div>


              <div class="form-group">
                {!! Form::label('Department', 'Department', array('class' => 'col-md-4 control-label')) !!}
                <div class="col-md-6">
                  {!! Form::select('department',$selectDepartments,0,['class' => 'form-control input-sm selDepartment' ,'id' => 'selDepartment']) !!}
                </div>
              </div>
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
            {!! Form::label('Date', 'Date', array('class' => 'col-md-4 control-label')) !!}

            <div class="col-md-6 datetime-pick date-only">
              <div class="input-icon datetime-pick date-only">
                <input data-format="yyyy-MM-dd" id="occured_at_date" name="occured_at_date" class="form-control input-sm" type="text">
                <span class="add-on">
                          <i class="sa-plus icon-calendar"></i>
                      </span>
              </div>
              <div id = "hse_error_description"></div>
            </div>

          </div>
					<div class="form-group">
            {!! Form::label('Time', 'Time', array('class' => 'col-md-4 control-label')) !!}
            <div class="col-md-6 datetime-pick time-only">
              <div class="input-icon datetime-pick time-only">
                <input data-format="hh:mm:ss" id="occured_at_time" name="occured_at_time" class="form-control input-sm" type="text">
                <span class="add-on">
                          <i class="sa-plus icon-calendar"></i>
                      </span>
              </div>
              <div id = "hse_error_description"></div>
            </div>

          </div>


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
      {!! Form::close() !!}
        </div>
    </div>
</div>

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
								geocoder = new google.maps.Geocoder();
								geocoder.geocode( { 'location': {'lat': lat, 'lng': lng} }, function(results, status) {
						      if (status == 'OK') {
										console.log('geocoded! results - ',results);
						        
										var sAddress = "";
										sAddress = results[0].formatted_address;
										$("#address").val(sAddress);
						      } else {
						        console.log('Geocode was not successful for the following reason: ' + status);
						      }
						    });
								
								
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
										infoWindow.setContent("<div id='infor' style='color: initial'>"+results[0].formatted_address+"</div>")
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
@endsection

@section('footer')

@endsection
