<!DOCTYPE html>
<html>
<head>
    <title>Drawing tools</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
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
</head>
<body>


<div id="map">


</div>
<script>
    // This example requires the Drawing library. Include the libraries=drawing
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing">

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -30.559482, lng: 22.937505999999985},
            zoom: 5
        });






        //function for current location
        function geolocation()
        {

//            if(marker2.visible==true)
//            {
//                marker2.setVisible(false);
//            }
            //find the current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,

                    };

                    //clear default marker
//                    marker.setVisible(false);
//
//                    marker2=new google.maps.Marker({
//                        position: {
//                            lat: -30.559482,
//                            lng: 22.937505999999985,
//
//                        }, map: map,
//                        draggable: true,
//                        zoom:10
//                        //            icon:'https://d30y9cdsu7xlg0.cloudfront.net/png/2955-200.png'
//                    });
//
//                    $('#lat').val(pos['lat']);
//                    $('#lng').val(pos['lng']);

//                    google.maps.event.addListener(marker2,'position_changed',function(){
//                        var lat=marker2.getPosition().lat();
//                        var lng=marker2.getPosition().lng();
//
//                        $('#lat').val(lat);
//                        $('#lng').val(lng);
                    })

                    //to get the address of the current location
//                    var geocoder = new google.maps.Geocoder;
//
//                    var input = pos['lat']+','+pos['lng'];
//                    var latlngStr = input.split(',', 2);
//                    var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
//                    geocoder.geocode({'location': latlng}, function(results, status) {
//                        if (status === 'OK') {
//                            if (results[0]) {
//                                $('#address').val(results[0].formatted_address);
//                                infoWindow.setContent(results[0].formatted_address)
//                            } else {
//                                window.alert('No results found');
//                            }
//                        } else {
//                            window.alert('Geocoder failed due to: ' + status);
//                        }
//                    });

//                    infoWindow.setPosition(pos);
//
//
//                    map.setCenter(pos);
//                    map.setZoom(19);
//                    marker2.setPosition(pos);
//
//
//
//                    infoWindow.open(map,marker2);
//                }, function() {
//
//                    handleLocationError(true, infoWindow, map.getCenter());
//
//                });
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






















        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.MARKER,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
            },
            markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
            circleOptions: {
                fillColor: '#ffff00',
                fillOpacity: 1,
                strokeWeight: 5,
                clickable: false,
                editable: true,
                zIndex: 1
            }
        });
        drawingManager.setMap(map);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwXS96_uM6y-6ZJZhSJGE87pO-qxpDp-Q&libraries=drawing&callback=initMap"
        async defer></script>
</body>
</html>