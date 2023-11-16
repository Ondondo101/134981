<?php
include 'connection.php'; // Include the database connection file
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
}

// Initialize variables for form fields
$customerName = $phoneNumber = $sendingFrom= $sendingTo = $extraInfo= "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form
    $customerName = $_POST["customerName"];
    $phoneNumber = $_POST["phoneNumber"];
    $sendingFrom = $_POST["agentStore"];
    $sendingTo = $_POST["sendingTo"];
    $extraInfo = $_POST["extraInfo"];

    // Check if all fields are filled
    if (!empty($customerName) && !empty($phoneNumber)&& !empty($sendingFrom) && !empty($sendingTo) && !empty($extraInfo) ) {
        // Retrieve the username from the session
        $username = $_SESSION['name'];

        // Calculate the total fee
        $totalFee = ($_POST['delivery_option'] == 'vendor_pays') ? 300 : 0;

        // Insert the data into the database, including the username
        $sql = "INSERT INTO doorsteppackages (customerName, phoneNumber, sendingFrom, sendingTo, extraInfo, status, username) VALUES (?, ?, ?, ?, ?, 'Pending Approval', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $customerName, $phoneNumber, $sendingFrom, $sendingTo, $extraInfo, $username);


        if ($stmt->execute()) {
            // Display the total fee
            echo "Package submitted successfully";
        } else {
            // If the insertion fails, display an error message
            echo "Error: package not submitted " . $stmt->error;
        }

        // Close the statement
        $stmt->close();

}}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="agent.css">
    <title>Doorstep Service</title>
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

        <h2>Doorstep Services</h2>
        <form id="DoorstepForm" method="post">
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
                        <option value="Umoja">Umoja</option>
                        <option value="Gikomba">Gikomba</option>
                        <option value="Utawala">Utawala</option>
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
                                'Umoja': ['Store A', 'Store B', 'Store C'],
                                'Gikomba': ['Shop 1', 'Shop 2'],
                                'Utawala': ['Utawala Store 1', 'Utawala Store 2'],
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
            <h2>Where are you sending to?</h2>
            <div class="form-group">
                <label for="sendingTo"> Select location</label>
                <select id="sendingTo" name="sendingTo" required >
                    <option value="Location 1">Selects customer's pick up location</option>
                    <option value="CBD">CBD</option>
                    <option value="Umoja">Umoja</option>
                    <option value="Gikomba">Gikomba</option>
                    <option value="Utawala">Utawala</option>
                    <!-- Add more locations here -->
                </select>
            </div>
            <div class="form-group">
                <label for="extraInfo">Other details</label>
                <input type="text" id="extraInfo" name="extraInfo" required placeholder="Other location details: e.g. House, floor, room no.">
            </div>

            <h2>Product Payment</h2>
            <p>select payment option</p>
            <div class="notification">
                    <h2>Note!</h2>
                    <ul>
                        <li>Customers should pay via M-PESA only.</li>
                        <li>Our riders will NOT collect hard cash.</li>
                        <li>If you have questions call 0752052001</li>
                        
                    </ul>
        </div>

                <div class="delivery-options">
            <label class="option-container">
                <input type="radio" name="delivery_option" value="customer_pays" id="customerPays">
                <span class="checkmark"></span>
                <span class="option-label">
                    <strong>Customer pays for delivery</strong>
                    <br>
                    <span class="small-text">Delivery fee is provided by the customer</span>
                </span>
            </label>

            <label class="option-container">
                <input type="radio" name="delivery_option" value="vendor_pays" id="vendorPays">
                <span class="checkmark"></span>
                <span class="option-label">
                    <strong>Vendor pays for delivery</strong>
                    <br>
                    <span class="small-text">You will pay for the package delivery fee</span>
                </span>
            </label>
        </div>

        <div class="total-fee">
            Total Fee: Ksh <span id="deliveryFee">0</span>
        </div>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const customerPaysRadio = document.getElementById("customerPays");
                const vendorPaysRadio = document.getElementById("vendorPays");
                const deliveryFeeContainer = document.getElementById("deliveryFee");

                function updateDeliveryFee() {
                    if (customerPaysRadio.checked) {
                        // Customer pays option selected
                        deliveryFeeContainer.textContent = "0";
                    } else if (vendorPaysRadio.checked) {
                        // Vendor pays option selected
                        deliveryFeeContainer.textContent = "300";
                    }
                }

                // Add event listeners to radio buttons
                customerPaysRadio.addEventListener("change", updateDeliveryFee);
                vendorPaysRadio.addEventListener("change", updateDeliveryFee);

                // Initial update based on the default option
                updateDeliveryFee();
            });
        </script>
        <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const form = document.getElementById("DoorstepForm");
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



            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
