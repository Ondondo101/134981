<?php
include 'connection.php';

// Fetch courier users from the database
$sqlCouriers = "SELECT name FROM users WHERE role = 'courier'";
$resultCouriers = $conn->query($sqlCouriers);

if (!$resultCouriers) {
    die("Error: " . $conn->error);
}

// Create an array to store the courier usernames
$couriers = array();

// Fetch usernames and add them to the array
while ($row = $resultCouriers->fetch_assoc()) {
    $couriers[] = $row['name'];
}

// Output the array as JSON
echo json_encode($couriers);

// Close the database connection
$conn->close();
?>
