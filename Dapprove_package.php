<?php
include 'connection.php';
// Check if the DpId is set and not empty
if (isset($_POST['DpId']) && !empty($_POST['DpId'])) {
    // Get the DpId from the POST data
    $DpId = $_POST['DpId'];

    // Create a new MySQLi connection
    $conn = new mysqli($server, $user, $pass, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define the new status
    $newStatus = "Dropped";

    // Prepare an SQL UPDATE statement
    $sql = "UPDATE doorsteppackages SET status = ? WHERE DpId = ?";
   

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("ss", $newStatus, $DpId);

    // Execute the statement
    if ($stmt->execute()) {
        // The update was successful
        echo "Success: Package has been dropped and status updated to 'dropped'.";
    } else {
        // Error occurred during the update
        echo "Error: Package drop not updated . " . $stmt->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // DpId was not provided in the POST data
    echo "Error: Invalid data provided.";
}
?>
