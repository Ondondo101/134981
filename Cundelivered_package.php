<?php
include 'connection.php';
// Check if the CpID is set and not empty
if (isset($_POST['CpID']) && !empty($_POST['CpID'])) {
    // Get the CpID from the POST data
    $CpID = $_POST['CpID'];

    // Create a new MySQLi connection
    $conn = new mysqli($server, $user, $pass, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define the new status
    $newStatus = "Undelivered";

    // Prepare an SQL UPDATE statement
    $sql = "UPDATE countypackages SET status = ? WHERE CpID = ?";
   

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("ss", $newStatus, $CpID);

    // Execute the statement
    if ($stmt->execute()) {
        // The update was successful
        echo "Success: Package status updated to 'Undelivered'.";
    } else {
        // Error occurred during the update
        echo "Error: Package status not updated . " . $stmt->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // CpID was not provided in the POST data
    echo "Error: Invalid data provided.";
}
?>
