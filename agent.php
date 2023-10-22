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
        <div class="notification">
            Send from Agent to Agent at Ksh 250
        </div>
        <h2>Agent Service</h2>
        <form action="process_agent.php" method="post">
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
                    <option value="Location 1"></option>
                    <option value="Location 2">CBD</option>
                    <option value="Location 3">Umoja</option>
                    <option value="Location 4">Gikomba</option>
                    <option value="Location 5">kisumu</option>
                    <!-- Add more locations here -->
                </select>
            </div>
            <h2>Package</h2>
            <div class="form-group">
                <label for="packageColor">Package Color</label>
               
                <select id="packageColor" name="packageColor">
                    <option value="Location 1"></option>

                    <option value="Location 2">Red</option>
                    <option value="Location 3">Blue</option>
                    <option value="Location 4">orange</option>
                    <option value="Location 5">green</option>
                    <option value="Location 6">Yellow</option>
                    <option value="Location 7">Black</option>
                    <option value="Location 8">Pink</option>
                    <!-- Add more locations here -->
                </select>
            </div>
            <div class="form-group">
                <h2>Where are you sending to?</h2>
                <label for="sendingTo">To location</label>
                <select id="sendingTo" name="sendingTo">
                <option value="Location 1"></option>

                <option value="Location 2">CBD</option>
                    <option value="Location 3">Umoja</option>
                    <option value="Location 4">Gikomba</option>
                    <option value="Location 5">kisumu</option>
                    <!-- Add more locations here -->
                </select>
            </div>
            <h2>Delivery Fee</h2>
            <div class="total-fee">
                Total Fee: Ksh 300
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
