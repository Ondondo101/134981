<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['name'];

// Fetch data from agentPackages table
$sqlAgent = "SELECT ApId, customerName, phoneNumber, sendingFrom, packageColor, sendingTo, status
            FROM agentPackages
            WHERE username = ?";

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
$sqlCounty = "SELECT  CpId, customerName, phoneNumber, sendingFrom, packageColor, sendingTo, status
              FROM countypackages
              WHERE username = ?";

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
$sqlDoorstep = "SELECT  DpId, customerName, phoneNumber, sendingTo, extraInfo, status
                FROM doorsteppackages
                WHERE username = ?";

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="packages.css">
    <title>User Packages</title>
</head>

<body>
<button id="backButton" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Back
                </button>

                <script>
                document.getElementById('backButton').addEventListener('click', function() {
                    window.history.back();
                });
                </script>
    <h2>My Packages</h2>

    <?php foreach ($allPackages as $package) : ?>
        <div class="package-card">
    <p>
        <?php
        if (isset($package['ApId'])) {
            echo 'agentpackages';
        } elseif (isset($package['CpId'])) {
            echo 'countypackages';
        } elseif (isset($package['DpId'])) {
            echo 'doorsteppackages';
        } else {
            echo 'Unknown Table';
        }
        ?>
    </p>
    <p>Status: <?php echo $package['status']; ?></p>
    <p>To: <?php echo $package['sendingTo']; ?></P>
</div>

    <?php endforeach; ?>
</body>

</html>
