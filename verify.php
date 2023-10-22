<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit();
}

// Check if OTP is stored in the session
if (!isset($_SESSION['otp']) || !isset($_SESSION['email']) || !isset($_SESSION['phone'])) {
    header("Location: login.php"); // Redirect back to login if OTP is not set
    exit();
}

if (isset($_POST['verify'])) {
    $enteredOTP = $_POST['entered_otp'];

    // Check if the entered OTP matches the one stored in the session
    if ($enteredOTP == $_SESSION['otp']) {
        // OTP is verified, proceed with login or signup
        $email = $_SESSION['email'];
        $phone = $_SESSION['phone'];

        // Implement the logic to complete the signup or login here
        // You can use the $email and $phone variables for further actions.

        // Clear the OTP and related session data
        unset($_SESSION['otp']);
        unset($_SESSION['email']);
        unset($_SESSION['phone']);

        header("Location: welcome.php"); // Redirect to the welcome page after successful verification
    } else {
        $error_message = "Incorrect OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>OTP Verification</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">OTP Verification</p>
            <?php
                if (isset($error_message)) {
                    echo '<p style="color: red;">' . $error_message . '</p>';
                }
            ?>
            <div class="input-group">
                <input type="text" placeholder="Enter OTP" name="entered_otp" required>
            </div>
            <div class="input-group">
                <button name="verify" class="btn">Verify OTP</button>
            </div>
        </form>
    </div>
</body>
</html>
