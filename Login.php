<?php
require 'vendor/autoload.php';
include 'connection.php';

use Twilio\Rest\Client;

session_start();

error_reporting(0);

if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
}

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            header("Location: welcome.php");
        } else {
            echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
        }
    }


    if ($result->num_rows > 0) {
        // Generate and send OTP
        $otp = generateOTP();
        $phone = retrievePhoneNumber($phone); // Implement a function to retrieve user's phone number

        if (sendOTP($otp, $phone)) {
            // Store OTP in the session for verification
            $_SESSION['otp'] = $otp;
            $_SESSION['phone'] = $phone;

            header("Location: verify.php"); // Redirect to OTP verification page
        } else {
            echo "<script>alert('Failed to send OTP. Please try again.')</script>";
        }
    }
function generateOTP() {
    return rand(100000, 999999);
}

function retrievePhoneNumber($phone) {
    // Implement logic to retrieve the user's phone number associated with the provided email
    // You may need to modify your database schema to store phone numbers or use a related table.
    // For simplicity, we assume a direct mapping of email to phone number.
    // Replace this with your own logic.
    // Example: $phone = "1234567890";
    return $phone;
}


function sendOTP($otp, $phone) {
    // Use your Twilio credentials
	$twilioSid = 'ACda2564fccdb5071b163cf2d42e3c7303';
	$twilioAuthToken = '960bbcf79b319c5266e037fed5cc9699';
	$twilioPhoneNumber = '+254752052001';

    // Initialize Twilio client
    $twilio = new Client($twilioSid, $twilioAuthToken);

    // Send OTP via SMS
    try {
        $message = $twilio->messages->create(
            $phone, // User's phone number
            array(
                'from' => $twilioPhoneNumber,
                'body' => "Your OTP is: $otp"
            )
        );
        return true;
    } catch (Exception $e) {
        // Handle any exceptions or errors
        return false;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="nstyle.css">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	

	<title>Login</title>
</head>
<body>
<header>
	<nav>
            <div class="logo">
            <img src="deli.png" alt="Company Logo">
            </div>

            <form method="get" action="track.php" class="package-tracking-form">
            <label for="tracking-id"></label>
            <input type="text" name="tracking-id" id="tracking-id" placeholder="Enter your tracking ID" required>
            <button type="submit">Track</button>
            </form>

            <ul class="nav-links">
                
                <li><a href="landing.html">Home</a></li>
                
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
			<p class="login-register-text">Don't have an account? <a href="signup.php">Register Here</a>.</p>
		</form>
	</div>
</body>
 
<footer>
        <p>&copy; 2023 Logistics & Courier</p>
    </footer>
</html>