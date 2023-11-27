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
        $sqlAgent = "SELECT ApID, customerName, phoneNumber, sendingFrom,FromAgent, packageColor, sendingTo, ToAgent, status FROM agentpackages";
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
                    echo '<td><button class="agentdispatch-btn" data-Ap-id="' . $row['ApID'] . '">Dispatch</button></td>';
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
                // AJAX to handle package approval
                const agentapproveButtons = document.querySelectorAll(".agentapprove-btn");
        agentapproveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const ApID = this.getAttribute('data-Ap-id');
                agentapprovePackage(ApID);
            });
        });

        function agentapprovePackage(ApID) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'Aapprove_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after approval
                    refreshPackageTable();
                }
            };
            xhr.send(`ApID=${ApID}`);
        }

        // AJAX to handle package dispatch
        const agentdispatchButtons = document.querySelectorAll(".agentdispatch-btn");
        agentdispatchButtons.forEach(button => {
            button.addEventListener('click', function() {
                const ApID = this.getAttribute('data-Ap-id');
                agentdispatchPackage(ApID);
            });
        });

        function agentdispatchPackage(ApID) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'Adispatch_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after dispatch
                    refreshPackageTable();
                }
            };
            xhr.send(`ApID=${ApID}`);
        }

        // AJAX to handle delivered packages
        const agentdeliveredButtons = document.querySelectorAll(".agentdelivered-btn");
        agentdeliveredButtons.forEach(button => {
            button.addEventListener('click', function() {
                const ApID = this.getAttribute('data-Ap-id');
                agentdeliveredPackage(ApID);
            });
        });

        function agentdeliveredPackage(ApID) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'Adelivered_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after delivered
                    refreshPackageTable();
                }
            };
            xhr.send(`ApID=${ApID}`);
        }

        // AJAX to handle undelivered packages 
        const agentundeliveredButtons = document.querySelectorAll(".agentundelivered-btn");
        agentundeliveredButtons.forEach(button => {
            button.addEventListener('click', function() {
                const ApID = this.getAttribute('data-Ap-id');
                agentundeliveredPackage(ApID);
            });
        });

        function agentundeliveredPackage(ApID) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'Aundelivered_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after undelivered
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

    <h1>County Packages</h1>

    <!-- Table to display County Packages -->
    <table id="countyPackageTable">
        <tr>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Sending From</th>
            <th>Package Color</th>
            <th>Sending To</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        include 'connection.php';
        $mysqli = new mysqli($server, $user, $pass, $database);
        if ($mysqli->connect_error) {
            exit('Could not connect');
        }

        // Query for County Packages
        $sqlCounty = "SELECT CpID, customerName, phoneNumber, sendingFrom, packageColor, sendingTo, status FROM countypackages";
        $resultCounty = $mysqli->query($sqlCounty);

        if (!$resultCounty) {
            echo "Error: " . $mysqli->error;
        } else {
            // Display County Packages
            if ($resultCounty->num_rows > 0) {
                while ($row = $resultCounty->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['customerName'] . "</td>";
                    echo "<td>" . $row['phoneNumber'] . "</td>";
                    echo "<td>" . $row['sendingFrom'] . "</td>";
                    echo "<td>" . $row['packageColor'] . "</td>";
                    echo "<td>" . $row['sendingTo'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo '<td><button class="countyapprove-btn" data-Cp-id="' . $row['CpID'] . '">Approve</button></td>';
                    echo '<td><button class="countydispatch-btn" data-Cp-id="' . $row['CpID'] . '">Dispatch</button></td>';
                    echo '<td><button class="countydelivered-btn" data-Cp-id="' . $row['CpID'] . '">Delivered</button></td>';
                    echo '<td><button class="countyundelivered-btn" data-Cp-id="' . $row['CpID'] . '">Undelivered</button></td>';
                    echo "</tr>";
                }
            }
        }

        $mysqli->close();
        ?>
    </table>
    <script>
       
       const countyapproveButtons = document.querySelectorAll(".countyapprove-btn");
       countyapproveButtons.forEach(button => {
           button.addEventListener('click', function() {
               const CpID = this.getAttribute('data-Cp-id');
               countyapprovePackage(CpID);
           });
       });

       function countyapprovePackage(CpID) {
           // Send an AJAX request to your server to update the status
           const xhr = new XMLHttpRequest();
           xhr.open('POST', 'Capprove_package.php', true);
           xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
           xhr.onload = function () {
               if (xhr.status === 200) {
                   // Refresh the table after approval
                   refreshPackageTable();
               }
           };
           xhr.send(`CpID=${CpID}`);
       }


       // AJAX to handle package dispatch
       const countydispatchButtons = document.querySelectorAll(".countydispatch-btn");
       countydispatchButtons.forEach(button => {
           button.addEventListener('click', function() {
               const CpID = this.getAttribute('data-Cp-id');
               countydispatchPackage(CpID);
           });
       });

       function countydispatchPackage(CpID) {
           // Send an AJAX request to your server to update the status
           const xhr = new XMLHttpRequest();
           xhr.open('POST', 'Cdispatch_package.php', true);
           xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
           xhr.onload = function () {
               if (xhr.status === 200) {
                   // Refresh the table after dispatch
                   refreshPackageTable();
               }
           };
           xhr.send(`CpID=${CpID}`);
       }

       // AJAX to handle delivered packages
       const countydeliveredButtons = document.querySelectorAll(".countydelivered-btn");
       countydeliveredButtons.forEach(button => {
           button.addEventListener('click', function() {
               const CpID = this.getAttribute('data-Cp-id');
               countydeliveredPackage(CpID);
           });
       });

       function countydeliveredPackage(CpID) {
           // Send an AJAX request to your server to update the status
           const xhr = new XMLHttpRequest();
           xhr.open('POST', 'Cdelivered_package.php', true);
           xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
           xhr.onload = function () {
               if (xhr.status === 200) {
                   // Refresh the table after delivered
                   refreshPackageTable();
               }
           };
           xhr.send(`CpID=${CpID}`);
       }

       // AJAX to handle undelivered packages 
       const countyundeliveredButtons = document.querySelectorAll(".countyundelivered-btn");
       countyundeliveredButtons.forEach(button => {
           button.addEventListener('click', function() {
               const CpID = this.getAttribute('data-Cp-id');
               countyundeliveredPackage(CpID);
           });
       });

       function countyundeliveredPackage(CpID) {
           // Send an AJAX request to your server to update the status
           const xhr = new XMLHttpRequest();
           xhr.open('POST', 'Cundelivered_package.php', true);
           xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
           xhr.onload = function () {
               if (xhr.status === 200) {
                   // Refresh the table after undelivered
                   refreshPackageTable();
               }
           };
           xhr.send(`CpID=${CpID}`);
       }

       // Function to refresh the package table
       function refreshPackageTable() {
           // You can implement the code to fetch and display the updated package data here.
       }
   </script>
    <table>

        <h1>Doorstep Packages</h1>

        <!-- Table to display County Packages -->
        <table id="DoorstepPackageTable">
            <tr>
                <th>Customer Name</th>
                <th>Phone Number</th>
                <th>Sending From</th>
                <th>Sending To</th>
                <th>Extra Info</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            include 'connection.php';
            $mysqli = new mysqli($server, $user, $pass, $database);
            if ($mysqli->connect_error) {
                exit('Could not connect');
            }

            // Query for County Packages
            $sqlDoorstep = "SELECT DpId, customerName, phoneNumber, sendingFrom, sendingTo, extraInfo, status FROM doorsteppackages";
            $resultDoorstep = $mysqli->query($sqlDoorstep);

            if (!$resultDoorstep) {
                echo "Error: " . $mysqli->error;
            } else {
                // Display County Packages
                if ($resultDoorstep->num_rows > 0) {
                    while ($row = $resultDoorstep->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['customerName'] . "</td>";
                        echo "<td>" . $row['phoneNumber'] . "</td>";
                        echo "<td>" . $row['sendingFrom'] . "</td>";
                        echo "<td>" . $row['sendingTo'] . "</td>";
                        echo "<td>" . $row['extraInfo'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo '<td><button class="doorstepapprove-btn" data-Dp-Id="' . $row['DpId'] . '">Approve</button></td>';
                        echo '<td><button class="doorstepdispatch-btn" data-Dp-Id="' . $row['DpId'] . '">Dispatch</button></td>';
                        echo '<td><button class="doorstepdelivered-btn" data-Dp-Id="' . $row['DpId'] . '">Delivered</button></td>';
                        echo '<td><button class="doorstepundelivered-btn" data-Dp-Id="' . $row['DpId'] . '">Undelivered</button></td>';
                        echo "</tr>";
                    }
                }
            }

            $mysqli->close();
            ?>
    </table>

   <script>
       
        const doorstepapproveButtons = document.querySelectorAll(".doorstepapprove-btn");
        doorstepapproveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const DpId = this.getAttribute('data-Dp-Id');
                doorstepapprovePackage(DpId);
            });
        });

        function doorstepapprovePackage(DpId) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'Dapprove_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after approval
                    refreshPackageTable();
                }
            };
            xhr.send(`DpId=${DpId}`);
        }


        // AJAX to handle package dispatch
        const doorstepdispatchButtons = document.querySelectorAll(".doorstepdispatch-btn");
        doorstepdispatchButtons.forEach(button => {
            button.addEventListener('click', function() {
                const DpId = this.getAttribute('data-Dp-Id');
                doorstepdispatchPackage(DpId);
            });
        });

        function doorstepdispatchPackage(DpId) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'Ddispatch_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after dispatch
                    refreshPackageTable();
                }
            };
            xhr.send(`DpId=${DpId}`);
        }

        // AJAX to handle delivered packages
        const doorstepdeliveredButtons = document.querySelectorAll(".doorstepdelivered-btn");
        doorstepdeliveredButtons.forEach(button => {
            button.addEventListener('click', function() {
                const DpId = this.getAttribute('data-Dp-Id');
                doorstepdeliveredPackage(DpId);
            });
        });

        function doorstepdeliveredPackage(DpId) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'Ddelivered_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after delivered
                    refreshPackageTable();
                }
            };
            xhr.send(`DpId=${DpId}`);
        }

        // AJAX to handle undelivered packages 
        const doorstepundeliveredButtons = document.querySelectorAll(".doorstepundelivered-btn");
        doorstepundeliveredButtons.forEach(button => {
            button.addEventListener('click', function() {
                const DpId = this.getAttribute('data-Dp-Id');
                doorstepundeliveredPackage(DpId);
            });
        });

        function doorstepundeliveredPackage(DpId) {
            // Send an AJAX request to your server to update the status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'Dundelivered_package.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Refresh the table after undelivered
                    refreshPackageTable();
                }
            };
            xhr.send(`DpId=${DpId}`);
        }

        // Function to refresh the package table
        function refreshPackageTable() {
            // You can implement the code to fetch and display the updated package data here.
        }
    </script>
</body>
</html>
