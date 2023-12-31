<?php
include 'connection.php'; // Include your database connection file

if (isset($_GET['tracking-id'])) {
    $AtrackingId = $_GET['tracking-id'];
    
    // Query the database to retrieve the latest information based on the tracking ID
    $sql = "SELECT username, latitude, longitude, timestamp FROM courier_locations WHERE Atracking_id = ? ORDER BY timestamp DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $AtrackingId);
    $stmt->execute();
    $stmt->bind_result($username, $latitude, $longitude, $timestamp);

    // Fetch the result
    if ($stmt->fetch()) {
        $Astatus = "Package found";
    } else {
        $Astatus = "Package not found";
        // You can customize this message or handle it differently based on your requirements
    }

    $stmt->close();
}
?>

<?php
include 'connection.php'; // Include your database connection file

if (isset($_GET['tracking-id'])) {
    $CtrackingId = $_GET['tracking-id'];
    
    // Query the database to retrieve the latest information based on the tracking ID
    $sql = "SELECT username, latitude, longitude, timestamp FROM courier_locations WHERE Ctracking_id = ? ORDER BY timestamp DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $CtrackingId);
    $stmt->execute();
    $stmt->bind_result($username, $latitude, $longitude, $timestamp);

    // Fetch the result
    if ($stmt->fetch()) {
        $Cstatus = "Package found";
    } else {
        $Cstatus = "Package not found";
        // You can customize this message or handle it differently based on your requirements
    }

    $stmt->close();
}
?>

<?php
include 'connection.php'; // Include your database connection file

if (isset($_GET['tracking-id'])) {
    $DtrackingId = $_GET['tracking-id'];
    
    // Query the database to retrieve the latest information based on the tracking ID
    $sql = "SELECT username, latitude, longitude, timestamp FROM courier_locations WHERE Dtracking_id = ? ORDER BY timestamp DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $DtrackingId);
    $stmt->execute();
    $stmt->bind_result($username, $latitude, $longitude, $timestamp);

    // Fetch the result
    if ($stmt->fetch()) {
        $Dstatus = "Package found";
    } else {
        $Dstatus = "Package not found";
        // You can customize this message or handle it differently based on your requirements
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Tracking</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="nstyle.css">

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

<!-- Add this PHP section before the JavaScript section -->
<?php if (isset($Astatus) && $Astatus === 'Package found') : ?>
    <script>
        var latitude = <?php echo $latitude; ?>;
        var longitude = <?php echo $longitude; ?>;
        var trackingId = <?php echo $AtrackingId; ?>;
    </script>
<?php endif; ?>

<?php if (isset($Cstatus) && $Cstatus === 'Package found') : ?>
    <script>
        var latitude = <?php echo $latitude; ?>;
        var longitude = <?php echo $longitude; ?>;
        var trackingId = <?php echo $CtrackingId; ?>;
    </script>
<?php endif; ?>

<?php if (isset($Dstatus) && $Dstatus === 'Package found') : ?>
    <script>
        var latitude = <?php echo $latitude; ?>;
        var longitude = <?php echo $longitude; ?>;
        var trackingId = <?php echo $DtrackingId; ?>;
    </script>
<?php endif; ?>

<script>
    // Initialize the map with the provided latitude and longitude
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 15
        });

        // Add a marker for the package location
        var marker = new google.maps.Marker({
            position: {lat: latitude, lng: longitude},
            map: map,
            title: 'Package Location'
        });
    }
</script>

</head>

<body>
    <header>
    <button id="backButton" class="btn btn-default">

        <i class="fas fa-arrow-left"></i> Back
    </button>

    <script>
        document.getElementById('backButton').addEventListener('click', function () {
            window.history.back();
        });
    </script>
    </header>
    
    <section class="package-tracking">
        <h2>Package Tracking</h2>
        
        <!-- Display the tracking result here -->
        
            <div class="tracking-result">
                    <p>Courier: <?php echo $username; ?></p>
                    <p>Latitude: <?php echo $latitude; ?></p>
                    <p>Longitude: <?php echo $longitude; ?></p>
                    <p>Timestamp: <?php echo $timestamp; ?></p>
               
            </div>
       

    <div id="map-container">
        <div id="map"></div>
    </div>

    <footer>
        <!-- Add your footer content here if needed -->
    </footer>
</body>


</html>
