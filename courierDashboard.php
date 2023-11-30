<?php
include 'connection.php';

use Twilio\Rest\Client;

session_start();


if (!isset($_SESSION['name'])) {
    header("Location: login.php");
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle location update request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $courier_id = $data['courier_id'];
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];

    // Get the username from the session
    $username = $_SESSION['name'];

    // Prepare an SQL INSERT statement
    $sql = "INSERT INTO courier_locations (courier_id, username, latitude, longitude) VALUES (?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("isdd", $courier_id, $username, $latitude, $longitude);

    // Execute the statement
    if ($stmt->execute()) {
        // The location update was successful
        echo json_encode(['message' => 'Location updated successfully']);
    } else {
        // Error occurred during the location update
        echo json_encode(['error' => 'Error updating location']);
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Dashboard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="ccourier.css">
    

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe-TvHoVyVkUq-qq0TKHee1FWIbeyJEyA&callback=initMap" async defer></script>

    <style>
        #map-container {
            width: 1300px; /* Set the width of the container */
            height: 300px; /* Set the height of the container */
            margin: 20px; /* Add some margin for spacing */
            border: 1px solid #ccc; /* Add a border for a neat appearance */
            border-radius: 8px; /* Optional: Add border-radius for rounded corners */
            overflow: hidden; /* Hide any overflow for a clean look */
            
        }

        #map {
            width: 100%;
            height: 100%;
        }
    </style>
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
<div id = "map-container">   
    <div id="map" ></div>

</div>
       
<button onclick="manualUpdateLocation()">Manual Location Update </button>

<script>
    if ('geolocation' in navigator) {
    navigator.geolocation.getCurrentPosition(
        function (position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Use latitude and longitude to track packages or perform other actions
            console.log('Latitude:', latitude, 'Longitude:', longitude);
        },
        function (error) {
            console.error('Error getting location:', error.message);
        }
    );
} else {
    console.log('Geolocation is not supported');
}
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            const { latitude, longitude } = position.coords;
            const courier_id = '?';  // Replace with the actual user ID

            // Send the location data to your server
            updateLocationOnServer(courier_id, latitude, longitude);
        },
        (error) => {
            console.error(error.message);
        }
    );
} else {
    console.error('Geolocation is not supported by this browser.');
}
</script>
<script>
        let map;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -1.3101642546239305, lng: 36.81312994191326 }, // Default location
                zoom: 8
            });
            addMarker({ lat: -1.2864739087143127, lng: 36.89444691202632 }, 'Umoja (store A');
            addMarker({ lat: -1.3101642546239305, lng: 36.81312994191326 }, 'Strathmore(STC store 2');
            addMarker({ lat: -1.2820535808107185, lng: 36.82407512217219 }, 'CBD(platinum plaza shop b2');

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Add marker to the map
                    const userLocation = { lat: latitude, lng: longitude };
                    new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: 'User Location'
                    });

                    // Center the map on the user's location
                    map.setCenter(userLocation);
                },
                function (error) {
                    console.error('Error getting location:', error.message);
                }
            );
            function addMarker(location, title) {
            new google.maps.Marker({
            position: location,
            map: map,
            title: title
        });
    }
}

        
    </script>
    <script>
            // Get user's location
        navigator.geolocation.watchPosition(updateLocation, errorGettingLocation, { enableHighAccuracy: true, maximumAge: 0 });

        // Function to update location on the server
        function updateLocation(position) {
            const courier_id = getCourierId(); // Implement a function to get the user ID
            const { latitude, longitude } = position.coords;

            // Send location data to the server
            fetch('http://your-api-server.com/updateLocation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ courier_id, latitude, longitude }),
            })
            .then(response => response.json())
            .then(data => console.log('Location update successful:', data))
            .catch(error => console.error('Error updating location:', error));
        }

    </script>


<script>
    

    function updateLocationOnServer(courier_id, latitude, longitude) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'courierDashboard.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Location update successful:', xhr.responseText);
            } else {
                console.error('Error updating location:', xhr.responseText);
            }
        };
        xhr.send(JSON.stringify({ courier_id, latitude, longitude, username: '<?php echo $_SESSION['name']; ?>' }));
    }

</script>
<script>
    function manualUpdateLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    const courier_id = '?';  // Replace with the actual user ID

                    // Send the location data to your server
                    updateLocationOnServer(courier_id, latitude, longitude, '<?php echo $_SESSION['name']; ?>');

                    // Reload the page after the location update
                    location.reload();
                },
                (error) => {
                    console.error(error.message);
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }
</script>




</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>