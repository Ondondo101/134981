<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ApID = $_POST['ApID'];
    $courierName = $_POST['courierName'];

    // Check if Atracking_id is empty
    $checkAtrackingIdSql = "SELECT Atracking_id FROM agentpackages WHERE ApID = ?";
    $stmtCheckAtrackingId = $conn->prepare($checkAtrackingIdSql);
    $stmtCheckAtrackingId->bind_param("i", $ApID);
    $stmtCheckAtrackingId->execute();
    $stmtCheckAtrackingId->bind_result($existingAtrackingId);
    $stmtCheckAtrackingId->fetch();
    $stmtCheckAtrackingId->close();

    if (empty($existingAtrackingId)) {
        // Atracking_id is empty, insert new row
        $insertLocationsSql = "INSERT INTO courier_locations (Atracking_id, customerName, username, latitude, longitude) VALUES ((SELECT Atracking_id FROM agentpackages WHERE ApID = ?), (SELECT customerName FROM agentpackages WHERE ApID = ?), ?, 'default_latitude', 'default_longitude')";
        $stmtInsertLocations = $conn->prepare($insertLocationsSql);
        $stmtInsertLocations->bind_param("iss", $ApID, $ApID, $courierName);
        $success = $stmtInsertLocations->execute();
        $stmtInsertLocations->close();
    } else {
        // Atracking_id is not empty, update existing row
        $updateLocationsSql = "UPDATE courier_locations SET Atracking_id = (SELECT Atracking_id FROM agentpackages WHERE ApID = ?), customerName = (SELECT customerName FROM agentpackages WHERE ApID = ?) WHERE username = ?";
        $stmtUpdateLocations = $conn->prepare($updateLocationsSql);
        $stmtUpdateLocations->bind_param("iss", $ApID, $ApID, $courierName);
        $success = $stmtUpdateLocations->execute();
        $stmtUpdateLocations->close();
    }

    // Update agentpackages table
    $updatePackagesSql = "UPDATE agentpackages SET courier = ? WHERE ApID = ?";
    $stmtPackages = $conn->prepare($updatePackagesSql);
    $stmtPackages->bind_param("si", $courierName, $ApID);
    $success = $stmtPackages->execute() && $success;
    $stmtPackages->close();

    if ($success) {
        echo 'Courier assigned successfully';
    } else {
        echo 'Error assigning courier';
    }
}

$conn->close();
?>
