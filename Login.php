<?php
require 'vendor/autoload.php';
include 'connection.php';

use Twilio\Rest\Client;

session_start();

error_reporting(0);

if (isset($_SESSION['name'])) {
    header("Location: welcome.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Use password_verify to check if entered password matches hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on user role
            switch ($_SESSION['role']) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'agent':
                    header("Location: agentDashboard.php");
                    break;
                case 'vendor':
                    header("Location: welcome.php");
                    break;
                case 'courier':
                    header("Location: courierDashboard.php");
                    break;
                default:
                    header("Location: welcome.php");
                    break;
            }
        } else {
            echo "<script>alert('Incorrect Password.')</script>";
        }
    } else {
        echo "<script>alert('User not found.')</script>";
    }

    $stmt->close();
    $conn->close();
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
                
                <li><a href="landing.html">Home</a></li>
                
                <li><a href="Signup.php">Sign Up </a></li>
            </ul>
        </nav>
    </header>
<body>
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