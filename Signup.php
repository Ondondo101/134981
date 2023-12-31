<?php
require 'vendor/autoload.php';
include 'connection.php';

use Twilio\Rest\Client;

error_reporting(0);

session_start();

if (isset($_SESSION['name'])) {
    header("Location: welcome.php");
}

if (isset($_POST['submit'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $role = $_POST['role']; // Added line to get user role

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users (name, email, password, role)
                    VALUES ('$username', '$email', '$hashedPassword', '$role')";
            $result = mysqli_query($conn, $sql);

            // Check if the user role is 'agent' and insert branch information
            if ($result && $role === 'agent') {
                $branchName = $_POST['branchName']; // Added line to get branch name for agent
                $location = $_POST['location'];
                $sqlBranch = "INSERT INTO branch (B_name, Agent_name, location)
                              VALUES ('$branchName', '$username', '$location')";
                $resultBranch = mysqli_query($conn, $sqlBranch);
                if (!$resultBranch) {
                    echo "<script>alert('Error inserting branch information.')</script>";
                } 
            }

            if ($result) {
                echo "<script>alert('Wow! User Registration Completed.')</script>";
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Woops! Something Wrong Went.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Already Exists.')</script>";
        }
    } else {
        echo "<script>alert('Password Not Matched.')</script>";
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
	

	<title>Signup</title>
</head>
<br>
<body>
	<header>
	<nav>
		<a href="landing.html">
		<div class="logo">
			<img src="deli.png" alt="Company Logo">
		</div>
	</a>


            <form method="get" action="track.php" class="package-tracking-form">
            <label for="tracking-id"></label>
            <input type="text" name="tracking-id" id="tracking-id" placeholder="Enter your tracking ID" required>
            <button type="submit">Track</button>
            </form>

            <ul class="nav-links">
                
                <li><a href="landing.php">Home</a></li>
            
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
	<div class="container" style= "height:800px" >
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Username" name="name" value="<?php echo $username; ?>" required>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
	

			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
            <div class="input-group">
            <label for="role">Select Role:</label>
            <select id="role" name="role" required onchange="handleRoleChange()">

                <option value="agent">Agent</option>
                <option value="vendor">Vendor</option>
                <option value="courier">Courier</option>
            </select>
        </div>

        <div class="input-group" id="branchInput">
            <label for="branchName">Branch Name:</label>
            <input type="text" id="branchName" name="branchName">
        </div>
        <div class="input-group" id="locationInput">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location">
        </div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="Login.php">Login Here</a>.</p>
			
		</form>
	</div>
    <script>
    function handleRoleChange() {
        var roleSelect = document.getElementById("role");
        var branchInput = document.getElementById("branchInput");
        var locationInputs = document.getElementById("locationInputs");

        // If the selected role is "vendor", show the branch and location inputs; otherwise, hide them
        if (roleSelect.value === "agent") {
            branchInput.style.display = "block";
            locationInputs.style.display = "block";
        } else {
            branchInput.style.display = "none";
            locationInputs.style.display = "none";
        }
    }
</script>

</body>

</html>