<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $CpID = $_POST['CpID'];
    $courierName = $_POST['courierName'];

    // Check if Ctracking_id is empty
    $checkCtrackingIdSql = "SELECT Ctracking_id FROM countypackages WHERE CpID = ?";
    $stmtCheckCtrackingId = $conn->prepare($checkCtrackingIdSql);
    $stmtCheckCtrackingId->bind_param("i", $CpID);
    $stmtCheckCtrackingId->execute();
    $stmtCheckCtrackingId->bind_result($existingCtrackingId);
    $stmtCheckCtrackingId->fetch();
    $stmtCheckCtrackingId->close();

    if (empty($existingCtrackingId)) {
        // Ctracking_id is empty, insert new row
        $insertLocationsSql = "INSERT INTO courier_locations (Ctracking_id, customerName, username, latitude, longitude) VALUES ((SELECT Ctracking_id FROM countypackages WHERE CpID = ?), (SELECT customerName FROM countypackages WHERE CpID = ?), ?, 'default_latitude', 'default_longitude')";
        $stmtInsertLocations = $conn->prepare($insertLocationsSql);
        $stmtInsertLocations->bind_param("iss", $CpID, $CpID, $courierName);
        $success = $stmtInsertLocations->execute();
        $stmtInsertLocations->close();
    } else {
        // Ctracking_id is not empty, update existing row
        $updateLocationsSql = "UPDATE courier_locations SET Ctracking_id = (SELECT Ctracking_id FROM countypackages WHERE CpID = ?), customerName = (SELECT customerName FROM countypackages WHERE CpID = ?) WHERE username = ?";
        $stmtUpdateLocations = $conn->prepare($updateLocationsSql);
        $stmtUpdateLocations->bind_param("iss", $CpID, $CpID, $courierName);
        $success = $stmtUpdateLocations->execute();
        $stmtUpdateLocations->close();
    }

    // Update countypackages table
    $updatePackagesSql = "UPDATE countypackages SET courier = ? WHERE CpID = ?";
    $stmtPackages = $conn->prepare($updatePackagesSql);
    $stmtPackages->bind_param("si", $courierName, $CpID);
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
