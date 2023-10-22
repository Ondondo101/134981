<?php

require 'vendor/autoload.php';
include 'connection.php';

use Twilio\Rest\Client;

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: login.php");
}
function generateOTP() {
    return rand(100000, 999999);
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
	$phone = $_POST[ 'phone'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);

    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $otp = generateOTP(); // Generate OTP

            // Store OTP in the session
            $_SESSION['otp'] = $otp;

            // Use your Twilio credentials
            $twilioSid = 'ACda2564fccdb5071b163cf2d42e3c7303';
            $twilioAuthToken = '960bbcf79b319c5266e037fed5cc9699';
            $twilioPhoneNumber = '+254752052001';

            // Initialize Twilio client
            $twilio = new Client($twilioSid, $twilioAuthToken);

            // Send OTP via SMS
            $message = $twilio->messages->create(
                $email, // User's phone number
                array(
                    'from' => $twilioPhoneNumber,
                    'body' => "Your OTP is: $otp"
                )
			
            );
			$_SESSION['phone'] = $phone;
		// Redirect to OTP verification page
           header("Location: verify.php");
}

            $sql = "INSERT INTO users (username, email, phone, password) VALUES ('$username', '$email', '$phone', '$password')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('User Registration Completed. Check your phone for OTP.')</script>";
                $username = "";
                $email = "";
				$phone = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Something went wrong.')</script>";
            }
        } else {
            echo "<script>alert('Email Already Exists.')</script>";
        }
    } else {
        echo "<script>alert('Password Not Matched.')</script>";
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
	

	<title>Signup</title>
</head>
<body>
	<header>
	<nav>
            <div class="logo">
			 <img src="deli.png" alt="Company Logo" >
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
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
    			<input type="text" placeholder="Phone Number" name="phone" value="<?php echo $phone; ?>" required>
			</div>

			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="Login.php">Login Here</a>.</p>
		</form>
	</div>
</body>
 
<footer>
        <p>&copy; 2023 Logistics & Courier</p>
    </footer>
</html>