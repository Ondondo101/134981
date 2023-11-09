<?php
include 'connection.php';
// Check if the packageId is set and not empty
if (isset($_POST['packageId']) && !empty($_POST['packageId'])) {
    // Get the packageId from the POST data
    $packageId = $_POST['packageId'];

    // Create a new MySQLi connection
    $conn = new mysqli($server, $user, $pass, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define the new status
    $newStatus = "Dropped";

    // Prepare an SQL UPDATE statement
    $sql = "UPDATE agentpackages SET status = ? WHERE packageId = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("ss", $newStatus, $packageId);

    // Execute the statement
    if ($stmt->execute()) {
        // The update was successful
        echo "Success: Package has been approved and status updated to 'Dropped'.";
    } else {
        // Error occurred during the update
        echo "Error: Package approval failed. " . $stmt->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // PackageId was not provided in the POST data
    echo "Error: Invalid data provided.";
}
?>
