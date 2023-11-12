<?php
session_start(); // Start the session if not already started

// Include your database connection file or define the database connection here
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect or handle unauthorized access
    // For example, you can redirect to a login page
    header('Location: login.php');
    exit();
}

// Assuming you have a database connection, you can proceed to fetch the new package data
// For demonstration purposes, let's assume you have an "AgentPackages" table

$userId = $_SESSION['userId']; // Get the user ID of the logged-in user

// Query to retrieve new packages for the logged-in user with "Pending Approval" status
$sql = "SELECT customerName, phoneNumber, sendingFrom, packageColor, sendingTo, status FROM agentPackages WHERE user_id = ? AND status = 'Delivered'";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    // Initialize an array to store the results
    $packages = array();

    // Fetch the data as an associative array
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }

    // Close the database connection
    $stmt->close();

    // Return the new package data as JSON
    header('Content-Type: application/json');
    echo json_encode($packages);
} else {
    // Handle any errors
    echo "Error: " . $conn->error;
}
?>
