<?php
include 'connection.php';
// Check if the ApID is set and not empty
if (isset($_POST['ApID']) && !empty($_POST['ApID'])) {
    // Get the ApID from the POST data
    $ApID = $_POST['ApID'];

    // Create a new MySQLi connection
    $conn = new mysqli($server, $user, $pass, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define the new status
    $newStatus = "In Transit";

    // Prepare an SQL UPDATE statement
    $sql = "UPDATE agentpackages SET status = ? WHERE ApID = ?";
   

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("ss", $newStatus, $ApID);

    // Execute the statement
    if ($stmt->execute()) {
        // The update was successful
        echo "Success: Package has been dispatched and status updated to 'In  Transit'.";
    } else {
        // Error occurred during the update
        echo "Error: Package dispatch not updated . " . $stmt->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // ApID was not provided in the POST data
    echo "Error: Invalid data provided.";
}
?>
