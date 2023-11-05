<?php 

session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="nstyle.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <title>Welcome</title>
</head>
<body>
<header>
	<nav>
        <a href="landing.html">
        <div class="logo">
            <img src="deli.png" alt="Company Logo">
        </div>
    </a>

        

            <form method="get" action="track.php" class="package-tracking-form">
            <label for="tracking-id"></label>
            <input type="text" name="tracking-id" id="tracking-id" placeholder="Enter your tracking ID" required>
            <button type="submit">Track</button>
            </form>

            <ul class="nav-links">
                <li><a href="profile.php"> Account</a></li>
                <li><a href="logout.php">Logout</a></li>
                
                
            </ul>
           
        </nav>
    </header>
    <?php echo "<h1>Welcome " . $_SESSION['name'] . "</h1>"; ?>
        <div id="map"></div>
    <script>
    function initMap() {
        // Initialize the map
        var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 8
        });
    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

    <body> 
         
            <div class="delivery-services-container">
                <a href="Doorstep.php" class="service">
                    <div class="service-icon">
                        <img src="doorstep-icon.png" alt="Doorstep">
                    </div>
                    <div class="service-name">Doorstep</div>
                </a>
                <a href="agent.php" class="service">
                    <div class="service-icon">
                        <img src="agent-icon.png" alt="Agent ">
                    </div>
                    <div class="service-name">Agent</div>
                </a>
                <a href="countylink.php" class="service">
                    <div class="service-icon">
                        <img src="location-icon.png" alt="Agent ">
                    </div>
                    <div class="service-name">County Link</div>
                </a>

                <a href="errand.php" class="service">
                    <div class="service-icon">
                        <img src="errand-icon.png" alt="Errand ">
                    </div>
                    <div class="service-name">Errand</div>
                </a>
            </div>
<br></br>

        <div class="vendor-container">
            <div class="New-container">
                <div class="vendor-info">
                    <div class="vendor-icon">
                        <img src="new packages.png">
                    </div>
                    <div class="vendor-label">
                        New Packages
                    </div>
                    <div class="vendor-number">
                        0
                    </div>
                </div>
                </div>
        

            <div class="approval-container">
                <div class="vendor-info">
                <div class="vendor-icon">
                        <img src="approval.png">
                    </div>
                    <div class="vendor-label">
                        Waiting approval
                    </div>
                    <div class="vendor-number">
                        0
                    </div>
                </div>
            </div>

                <div class="Dropped-container">
                    <div class="vendor-info">
                    <div class="vendor-icon">
                        <img src="dropped.png">
                    </div>
                        <div class="vendor-label">
                            Dropped Packages
                        </div>
                        <div class="vendor-number">
                            0
                        </div>
                    </div>
                </div>
                <div class="Transit-container">
                    <div class="vendor-info">
                    <div class="vendor-icon">
                        <img src="Intransit.png">
                    </div>
                        <div class="vendor-label">
                         Packages In Transit 
                        </div>
                        <div class="vendor-number">
                            0
                        </div>
                    </div>
                </div>
                    <div class="Delivered-container">
                        <div class="vendor-info">
                        <div class="vendor-icon">
                        <img src="delivered.png">
                    </div>
                            <div class="vendor-label">
                                Delivered Packages
                            </div>
                            <div class="vendor-number">
                                0
                            </div>
                        </div>
                    </div>
                        <div class="Undelivered-container">
                            <div class="vendor-info">
                            <div class="vendor-icon">
                                <img src="not-delivered.png">
                            </div>
                                <div class="vendor-label">
                                    Undelivered Packages
                                </div>
                                <div class="vendor-number">
                                    0
                                </div>
                            </div>
                        </div>

        </div>


    
</body>
 
