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
            Key in the errand details and call to check courier availability
        
        </div>
        <h2>Errand Service</h2>
        <form action="process_errand.php" method="post">
            
           <div class="form-group">
                <label for="extra-info">Errand details</label>
                <input type="text" id="extra-info" name="extra-info" required>
            </div>

            <button onclick="makeCall()">Call Deli</button>
    
        <script>
            function makeCall() {
                // Replace '1234567890' with the phone number you want to call
                window.location.href = 'tel:+254790342747';
            }
        </script>
        </form>
    </div>
</body>
</html>
