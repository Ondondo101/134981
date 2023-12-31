<?php
session_start();
include 'connection.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="ADashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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

    <h1>Agent Packages</h1>

    <!-- Table to display Agent Packages -->
    <table id="agentPackageTable">
        <tr>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Sending From</th>
            <th>FromAgent</th>
            <th>Package Color</th>
            <th>Sending To</th>
            <th>ToAgent</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
    include 'connection.php';
    
    $mysqli = new mysqli($server, $user, $pass, $database);
    if ($mysqli->connect_error) {
        exit('Could not connect');
    }

    // Query for Agent Packages
    $sqlAgent = "SELECT ApID, customerName, phoneNumber, sendingFrom, FromAgent, packageColor, sendingTo, ToAgent, status FROM agentpackages";
    $resultAgent = $mysqli->query($sqlAgent);

    if (!$resultAgent) {
        echo "Error: " . $mysqli->error;
    } else {
        // Display Agent Packages
        if ($resultAgent->num_rows > 0) {
            while ($row = $resultAgent->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['customerName'] . "</td>";
                echo "<td>" . $row['phoneNumber'] . "</td>";
                echo "<td>" . $row['sendingFrom'] . "</td>";
                echo "<td>" . $row['FromAgent'] . "</td>";
                echo "<td>" . $row['packageColor'] . "</td>";
                echo "<td>" . $row['sendingTo'] . "</td>";
                echo "<td>" . $row['ToAgent'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo '<td><button class="agentapprove-btn" data-Ap-id="' . $row['ApID'] . '">Approve</button></td>';
                
                echo '<td><button class="agentassign-btn" data-Ap-id="' . $row['ApID'] . '">Assign Courier</button></td>';

                echo '<td><button class="agentdispatch-btn" data-Ap-id="' . $row['ApID'] .'">Dispatch</button></td>';
                echo '<td><button class="agentdelivered-btn" data-Ap-id="' . $row['ApID'] . '">Delivered</button></td>';
                echo '<td><button class="agentundelivered-btn" data-Ap-id="' . $row['ApID'] . '">Undelivered</button></td>';
                echo "</tr>";
            }
        }
    }

    $mysqli->close();
    ?>
    </table>
    
<script>
    // Add this JavaScript code to your existing script
const assignCourierButtons = document.querySelectorAll(".agentassign-btn");

assignCourierButtons.forEach(button => {
    button.addEventListener('click', function() {
        const ApID = this.getAttribute('data-Ap-id');
        assignCourierToPackage(ApID);
    });
});

function assignCourierToPackage(ApID) {
    // Send an AJAX request to fetch the list of available couriers
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_couriers.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const couriers = JSON.parse(xhr.responseText);

            // Display a prompt to the user to select a courier
            const selectedCourier = prompt('Select a courier:\n' + couriers.join('\n'));

            if (selectedCourier !== null) {
                // Update the courier column in the agentpackages table
                updateCourierInPackage(ApID, selectedCourier);
            }
        }
    };
    xhr.send();
}

function updateCourierInPackage(ApID, courierName) {
    // Send an AJAX request to update the courier column in the agentpackages table
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'assign_courier.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Refresh the table after assigning the courier
            refreshPackageTable();
        }
    };
    xhr.send(`ApID=${ApID}&courierName=${courierName}`);
}

    </script>
<script>
    // AJAX to handle package dispatch, approval, delivered, and undelivered
    const agentButtons = document.querySelectorAll(".agentapprove-btn, .agentdispatch-btn, .agentdelivered-btn, .agentundelivered-btn");
    
    agentButtons.forEach(button => {
        button.addEventListener('click', function() {
            const ApID = this.getAttribute('data-Ap-id');
            const action = this.className.replace("agent", "").replace("-btn", ""); // Extract action from button class
            agentActionPackage(ApID, action);
        });
    });

    function agentActionPackage(ApID, action) {
        // Send an AJAX request to your server to update the status
        const xhr = new XMLHttpRequest();
        xhr.open('POST', `A${action}_package.php`, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Refresh the table after the action
                refreshPackageTable();
            }
        };
        xhr.send(`ApID=${ApID}`);
    }

    // Function to refresh the package table
    function refreshPackageTable() {
        // You can implement the code to fetch and display the updated package data here.
    }
</script>
</body>
</html>
