<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $DpId = $_POST['DpId'];
    $courierName = $_POST['courierName'];

    // Check if Dtracking_id is empty
    $checkDtrackingIdSql = "SELECT Dtracking_id FROM doorsteppackages WHERE DpId = ?";
    $stmtCheckDtrackingId = $conn->prepare($checkDtrackingIdSql);
    $stmtCheckDtrackingId->bind_param("i", $DpId);
    $stmtCheckDtrackingId->execute();
    $stmtCheckDtrackingId->bind_result($existingDtrackingId);
    $stmtCheckDtrackingId->fetch();
    $stmtCheckDtrackingId->close();

    if (empty($existingDtrackingId)) {
        // Dtracking_id is empty, insert new row
        $insertLocationsSql = "INSERT INTO courier_locations (Dtracking_id, customerName, username, latitude, longitude) VALUES ((SELECT Dtracking_id FROM doorsteppackages WHERE DpId = ?), (SELECT customerName FROM doorsteppackages WHERE DpId = ?), ?, 'default_latitude', 'default_longitude')";
        $stmtInsertLocations = $conn->prepare($insertLocationsSql);
        $stmtInsertLocations->bind_param("iss", $DpId, $DpId, $courierName);
        $success = $stmtInsertLocations->execute();
        $stmtInsertLocations->close();
    } else {
        // Dtracking_id is not empty, update existing row
        $updateLocationsSql = "UPDATE courier_locations SET Dtracking_id = (SELECT Dtracking_id FROM doorsteppackages WHERE DpId = ?), customerName = (SELECT customerName FROM doorsteppackages WHERE DpId = ?) WHERE username = ?";
        $stmtUpdateLocations = $conn->prepare($updateLocationsSql);
        $stmtUpdateLocations->bind_param("iss", $DpId, $DpId, $courierName);
        $success = $stmtUpdateLocations->execute();
        $stmtUpdateLocations->close();
    }

    // Update doorsteppackages table
    $updatePackagesSql = "UPDATE doorsteppackages SET courier = ? WHERE DpId = ?";
    $stmtPackages = $conn->prepare($updatePackagesSql);
    $stmtPackages->bind_param("si", $courierName, $DpId);
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
