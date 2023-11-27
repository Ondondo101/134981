<?php
include 'connection.php'; // Include the database connection file
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
}

// Function to generate a unique tracking ID
function generateTrackingID($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $trackingID = '';
    for ($i = 0; $i < $length; $i++) {
        $trackingID .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $trackingID;
}

// Initialize variables for form fields
$customerName = $phoneNumber = $sendingFrom = $agentStore = $packageColor = $sendingTo = $AgentStore = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form
    $customerName = $_POST["customerName"];
    $phoneNumber = $_POST["phoneNumber"];
    $sendingFrom = $_POST["sendingFrom"];
    $agentStore = $_POST["agentStore"];
    $packageColor = $_POST["packageColor"];
    $sendingTo = $_POST["sendingTo"];
    $AgentStore = $_POST["AgentStore"];

    // Retrieve the username from the session
    $username = $_SESSION['name'];

    // Generate a unique tracking ID
    $trackingID = generateTrackingID();

    // Database connection
    $conn = mysqli_connect($server, $user, $pass, $database);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the package data into the database with a "Pending Approval" status
    $sql = "INSERT INTO countypackages (customerName, phoneNumber, sendingFrom, FromAgent, packageColor, sendingTo, ToAgent, status, username, tracking_id) VALUES ('$customerName', '$phoneNumber', '$sendingFrom', '$agentStore', '$packageColor', '$sendingTo', ' $AgentStore', 'Pending Approval', '$username', '$trackingID')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        echo "Package submitted successfully. Tracking ID: $trackingID";
    } else {
        // Error handling
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="agent.css">
    <title>Agent Service</title>
</head>
<body>
<button id="backButton" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Back
                </button>

                <script>
                document.getElementById('backButton').addEventListener('click', function() {
                    window.history.back();
                });
                </script>   
    <div class="container">
        <div class="notification">
            Inter County delivery costs Ksh 300
        </div>
        <h2>Inter County Service</h2>
        <form id= 'agentForm' method="post">
            <div class="form-group">
                <label for="customerName">Customer Name</label>
                <input type="text" id="customerName" name="customerName" required>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="text" id="phoneNumber" name="phoneNumber" required>
            </div>
            
            <h2>Where are you sending from?</h2>
            <div class="form-group">
                <label for="sendingFrom"> From location</label>
                <select id="sendingFrom" name="sendingFrom">
                        <option value=""></option>
                        <option value="CBD">CBD</option>
                        <option value="NAKURU">NAKURU</option>
                        <option value="NAIVASHA">NAIVASHA</option>
                        <option value="KISUMU">KISUMU</option>
                        <option value="MOMBASA">MOMBASA</option>
                        <!-- Add more locations here -->
                    </select>

            <h2>Choose an Agent Store</h2>
                    <div class="form-group">
                        <label for="agentStore">Agent Store</label>
                        <select id="agentStore" name="agentStore">
                            <!-- Options will be added dynamically based on the selection -->
                        </select>
                    </div>

                        <script>
                            // Get references to the dropdowns
                            const sendingFromDropdown = document.getElementById('sendingFrom');
                            const agentStoreDropdown = document.getElementById('agentStore');

                            // Define the agent stores for each location
                            const agentStores = {
                                'CBD': ['Platinum plaza', 'Soko House Room 101'],
                                'NAKURU': ['Store A', 'Store B', 'Store C'],
                                'NAIVASHA': ['Shop 1', 'Shop 2'],
                                'KISUMU': [' Store 1', 'Store 2'],
                                'NAIROBI': ['Store 1', 'Store 2'],
                                // Add more locations and stores here
                            };

                            // Function to update agent store options based on location selection
                            function updateAgentStores() {
                                const selectedLocation = sendingFromDropdown.value;
                                const stores = agentStores[selectedLocation] || [];

                                // Clear existing options
                                agentStoreDropdown.innerHTML = '';

                                // Add new options
                                for (const store of stores) {
                                    const option = document.createElement('option');
                                    option.value = store;
                                    option.textContent = store;
                                    agentStoreDropdown.appendChild(option);
                                }
                            }

                            // Add an event listener to update the agent stores when the location changes
                            sendingFromDropdown.addEventListener('change', updateAgentStores);

                            // Initial call to populate agent stores based on the default location
                            updateAgentStores();
                        </script>
            <h2>Package</h2>
            <div class="form-group">
                <label for="packageColor">Package Color</label>
               
                <select id="packageColor" name="packageColor">
                    <option value=""></option>

                    <option value="Red">Red</option>
                    <option value="Blue">Blue</option>
                    <option value="Orange">Orange</option>
                    <option value="Green">Green</option>
                    <option value="Yellow">Yellow</option>
                    <option value="Black">Black</option>
                    <option value="Pink">Pink</option>
                    <!-- Add more locations here -->
                </select>
            </div>
            <div class="form-group">
                <h2>Where are you sending to?</h2>
                <label for="sendingTo">To location</label>
                <select id="sendingTo" name="sendingTo">
                        <option value=""></option>
                        <option value="NAIROBI">NAIROBI</option>
                        <option value="NAKURU">NAKURU</option>
                        <option value="NAIVASHA">NAIVASHA</option>
                        <option value="KISUMU">KISUMU</option>
                        <option value="MOMBASA">MOMBASA</option>
                        <!-- Add more locations here -->
                    
                </select>

                    <h2>Choose an Agent Store</h2>
                    <div class="form-group">
                        <label for="AgentStore">Agent Store</label>
                        <select id="AgentStore" name="AgentStore">
                            <!-- Options will be added dynamically based on the selection -->
                        </select>
                    </div>

                        <script>
                            // Get references to the dropdowns
                            const sendingToDropdown = document.getElementById('sendingTo');
                            const AgentStoreDropdown = document.getElementById('AgentStore');

                            // Define the agent stores for each location
                            const AgentStores = {
                                'NAIROBI': ['Platinum plaza', 'Soko House Room 101'],
                                'NAKURU': ['Store A', 'Store B', 'Store C'],
                                'NAIVASHA': ['Shop 1', 'Shop 2'],
                                'KISUMU': [' Store 1', 'Store 2'],
                                'NAIROBI': ['Store 1', 'Store 2'],
                                // Add more locations and stores here
                            };

                            // Function to update agent store options based on location selection
                            function updateAgentStores() {
                                const selectedLocation = sendingToDropdown.value;
                                const stores = agentStores[selectedLocation] || [];

                                // Clear existing options
                                AgentStoreDropdown.innerHTML = '';

                                // Add new options
                                for (const store of stores) {
                                    const option = document.createElement('option');
                                    option.value = store;
                                    option.textContent = store;
                                    AgentStoreDropdown.appendChild(option);
                                }
                            }

                            // Add an event listener to update the agent stores when the location changes
                            sendingToDropdown.addEventListener('change', updateAgentStores);

                            // Initial call to populate agent stores based on the default location
                            updateAgentStores();
                        </script>


            </div>
            <h2>Delivery Fee</h2>
            <div class="total-fee">
                Total Fee: Ksh 0
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
        <script>
                            // Get references to the dropdowns
                            const sendingToDropdown = document.getElementById('sendingTo');
                            const AgentStoreDropdown = document.getElementById('AgentStore');

                            // Define the agent stores for each location
                            const AgentStores = {
                                'CBD': ['Platinum plaza', 'Soko House Room 101'],
                                'Umoja': ['Store A', 'Store B', 'Store C'],
                                'Gikomba': ['Shop 1', 'Shop 2'],
                                'Kisumu': ['Kisumu Store 1', 'Kisumu Store 2'],
                                // Add more locations and stores here
                            };

                            // Function to update agent store options based on location selection
                            function updateAgentStores() {
                                const selectedLocation = sendingToDropdown.value;
                                const stores = agentStores[selectedLocation] || [];

                                // Clear existing options
                                AgentStoreDropdown.innerHTML = '';

                                // Add new options
                                for (const store of stores) {
                                    const option = document.createElement('option');
                                    option.value = store;
                                    option.textContent = store;
                                    AgentStoreDropdown.appendChild(option);
                                }
                            }

                            // Add an event listener to update the agent stores when the location changes
                            sendingToDropdown.addEventListener('change', updateAgentStores);

                            // Initial call to populate agent stores based on the default location
                            updateAgentStores();
                        </script>


            </div>


        <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const form = document.getElementById("agentForm");
                    let firstClick = true;

                    form.addEventListener("submit", function(event) {
                        event.preventDefault(); // Prevent the form from submitting

                        if (firstClick) {
                            // Calculate the delivery fee and display it
                            const deliveryFee = 250;
                            const feeContainer = document.querySelector(".total-fee");
                            feeContainer.textContent = `Total Fee: Ksh ${deliveryFee}`;

                            // Change the button text to "Confirm Submit"
                            const submitButton = form.querySelector("button[type='submit']");
                            submitButton.textContent = "Confirm Submit";
                            
                            firstClick = false;
                        } else {
                            // If it's the second click, submit the form
                            form.submit();
                        }
                    });
                });

            </script>

    </div>
</body>
</html>
