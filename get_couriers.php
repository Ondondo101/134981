<?php
// get_couriers.php
include 'connection.php';

$sql = "SELECT name FROM users WHERE role = 'courier'";
$result = $conn->query($sql);

$couriers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $couriers[] = $row['name'];
    }
}

echo json_encode($couriers);

$conn->close();
?>
