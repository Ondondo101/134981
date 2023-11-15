<?php

include 'connection.php';

use Twilio\Rest\Client;

session_start();

error_reporting(0);




?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="nstyle.css">
    

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe-TvHoVyVkUq-qq0TKHee1FWIbeyJEyA&callback=initMap" async defer></script>


	<title>Login</title>
</head>

<header>
	<nav>
		<a href="landing.html">
		<div class="logo">
			<img src="deli.png" alt="Company Logo">
		</div>
		</a>


		<ul class="nav-links">
                <li><a href="profile.php"> Account</a></li>
                <li><a href="logout.php">Logout</a></li>
                
                
            </ul>
           
        </nav>
    </header>
<body>
<div id="map" style="height: 400px;"></div>

<script>
	function initMap() {
    // Initialize map
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -1.3101437870286636, lng: 36.81313858865606},
        zoom: 8
    });
	addShipmentsToMap(map);

    // Add markers or polylines for shipments
    // Customize as needed based on your application
}
function addShipmentsToMap(map) {
      // Your logic to fetch shipment data and add markers or polylines
      // Example:
      var shipment1 = { lat:-1.3092611007449082, lng: 36.81162469984158, description: 'Shipment 1' };
      var shipment2 = { lat: -1.3094106779478283, lng: 36.81476246569504, description: 'Shipment 2' };

      // Add markers
      addMarker(map, shipment1);
      addMarker(map, shipment2);

      // Alternatively, add polylines
      addPolyline(map, [shipment1, shipment2]);
   }
   // Function to add a polyline
   function addPolyline(map, path) {
      var polyline = new google.maps.Polyline({
         path: path.map(point => ({ lat: point.lat, lng: point.lng })),
         geodesic: true,
         strokeColor: '#FF0000',
         strokeOpacity: 1.0,
         strokeWeight: 2
      });

      polyline.setMap(map);
   }
function updateMap(shipments) {
    // Clear existing markers or polylines
    // Add new markers or polylines for each shipment
}
function fetchData() {
    // Use AJAX or WebSocket to fetch real-time shipment data
}
setInterval(function() {
    fetchData();
}, 30000); // Update every 30 seconds (adjust as needed)

</script>
</body>
 
<footer>
        <p>&copy; 2023 Logistics & Courier</p>
    </footer>
</html>
