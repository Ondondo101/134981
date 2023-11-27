<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['name'];

// Fetch data from agentPackages table
$sqlAgent = "SELECT ApId, customerName, phoneNumber, sendingFrom, FromAgent, packageColor, sendingTo, ToAgent, status
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
$sqlCounty = "SELECT  CpId, customerName, phoneNumber, sendingFrom,  FromAgent, packageColor, sendingTo, ToAgent, status
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
$sqlDoorstep = "SELECT  DpId, customerName, phoneNumber, sendingFrom, FromAgent, sendingTo, extraInfo, status
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
        <?php
        $title = '';
        if (isset($package['ApId'])) {
            $title = 'Agent Packages';
        } elseif (isset($package['CpId'])) {
            $title = 'County Packages';
        } elseif (isset($package['DpId'])) {
            $title = 'Doorstep Packages';
        } else {
            $title = 'Unknown Table';
        }
        ?>
        <h3><?php echo $title; ?></h3>
        <p>Status: <?php echo $package['status']; ?></p>
        <p>To: <?php echo $package['sendingTo']; ?>
            <?php
            if (isset($package['DpId'])) {
                // Display extraInfo field for doorstep packages
                echo ' - ' . $package['extraInfo'];
            } else {
                // Display ToAgent field for other packages
                echo ' - ' . $package['ToAgent'] . ' Agent';
            }
            ?>
        </p>
        <p>From: <?php echo $package['sendingFrom']; ?> - <?php echo $package['FromAgent']; ?> Agent</p>
    </div>
<?php endforeach; ?>

</body>

</html>
