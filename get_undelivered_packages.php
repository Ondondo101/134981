<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['name'];

// Fetch data from agentPackages table
$sqlAgent = "SELECT customerName, phoneNumber, sendingFrom, packageColor, sendingTo, status
            FROM agentPackages
            WHERE username = ? AND status = 'Undelivered'";

$stmtAgent = $conn->prepare($sqlAgent);
$stmtAgent->bind_param("s", $username);
$stmtAgent->execute();
$resultAgent = $stmtAgent->get_result();

if (!$resultAgent) {
    echo "Error: " . $stmtAgent->error;
} else {
    $packagesAgent = $resultAgent->fetch_all(MYSQLI_ASSOC);
    $stmtAgent->close();
}

// Fetch data from countypackages table
$sqlCounty = "SELECT customerName, phoneNumber, sendingFrom, packageColor, sendingTo, status
              FROM countypackages
              WHERE username = ? AND status = 'Undelivered'";

$stmtCounty = $conn->prepare($sqlCounty);
$stmtCounty->bind_param("s", $username);
$stmtCounty->execute();
$resultCounty = $stmtCounty->get_result();

if (!$resultCounty) {
    echo "Error: " . $stmtCounty->error;
} else {
    $packagesCounty = $resultCounty->fetch_all(MYSQLI_ASSOC);
    $stmtCounty->close();
}

// Fetch data from doorsteppackages table
$sqlDoorstep = "SELECT customerName, phoneNumber, sendingTo, extraInfo status
                FROM doorsteppackages
                WHERE username = ? AND status = 'Undelivered'";

$stmtDoorstep = $conn->prepare($sqlDoorstep);
$stmtDoorstep->bind_param("s", $username);
$stmtDoorstep->execute();
$resultDoorstep = $stmtDoorstep->get_result();

if (!$resultDoorstep) {
    echo "Error: " . $stmtDoorstep->error;
} else {
    $packagesDoorstep = $resultDoorstep->fetch_all(MYSQLI_ASSOC);
    $stmtDoorstep->close();
}

// Combine data from all tables
$allPackages = array_merge($packagesAgent, $packagesCounty, $packagesDoorstep);

// Output as JSON
header('Content-Type: application/json');
echo json_encode($allPackages);
?>
