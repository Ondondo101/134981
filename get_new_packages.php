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

$userId = $_SESSION['userId']; // Get the user ID of the logged-in user

// Assuming you have a database connection, you can proceed to fetch the new package data
// For demonstration purposes, let's assume you have an "AgentPackages" table

// Query to retrieve new packages for the logged-in user with "Pending Approval" status
$sql = "SELECT ap.customerName, ap.phoneNumber, ap.sendingFrom, ap.packageColor, ap.sendingTo, ap.status
        FROM agentpackages AS ap
        JOIN users AS u ON ap.userId = u.userId
        WHERE ap.userId = ? AND ap.status = 'Pending Approval'";
        

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();
// Execute the query
$result = $conn->query($sql);

if (!$result) {
    // Handle errors
    echo "Error: " . $conn->error;
} else {
    // Initialize an array to store the results
    $packages = array();

    // Fetch the data as an associative array
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }

    // Close the database connection
    $conn->close();

    // Return the new package data as JSON
    header('Content-Type: application/json');
    echo json_encode($packages);
}

?>