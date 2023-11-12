<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$userName = $_SESSION['name'];

$sql = "SELECT customerName, phoneNumber, sendingFrom, packageColor, sendingTo, status
        FROM agentPackages
        WHERE customerName = ? AND status = 'Pending Approval'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Error: " . $conn->error;
} else {
    $packages = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($packages);
}
?>
