<?php
// Initialize variables for form fields
$customerName = $phoneNumber = $sendingFrom = $packageColor = $sendingTo = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form
    $customerName = $_POST["customerName"];
    $phoneNumber = $_POST["phoneNumber"];
    $sendingFrom = $_POST["sendingFrom"];
    $packageColor = $_POST["packageColor"];
    $sendingTo = $_POST["sendingTo"];

    // Check if all fields are filled
    if (!empty($customerName) && !empty($phoneNumber) && !empty($sendingFrom) && !empty($packageColor) && !empty($sendingTo)) {
        // Calculate the total fee
        $totalFee = 300;

        // Display the total fee
        echo "Total Fee: Ksh $totalFee";
    } else {
        // If any field is empty, display a message
        echo "Please fill in all the information to calculate the total fee.";
    }
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

        <h2>Doorstep Services</h2>
        <form action="process_doorstep.php" method="post">

            <h2>Where are you sending to?</h2>
            <div class="form-group">
                <label for="sendingTo"> Select location</label>
                <select id="sendingTo" name="sendingTo" required>
                    <option value="Location 1"></option>
                    <option value="Location 2">CBD</option>
                    <option value="Location 3">Umoja</option>
                    <option value="Location 4">Gikomba</option>
                    <option value="Location 5">kisumu</option>
                    <!-- Add more locations here -->
                </select>
            </div>
            <div class="form-group">
                <label for="extra-info">Other details</label>
                <input type="text" id="extra-info" name="extra-info" required>
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



            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
