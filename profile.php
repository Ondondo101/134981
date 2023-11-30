<?php
session_start();

include 'connection.php';

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from the database
$username = $_SESSION['name'];

$sql = "SELECT * FROM users WHERE name = '$username'";
$result = $conn->query($sql);

if (!$result) {
    echo "Error fetching user data: " . $conn->error;
    exit();
}

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user information in the database
    $newProfile_picture = $_POST["Profile_picture"];
    $newBusinessName = $_POST["businessName"];
    $newPhone = $_POST["phone"];
    $newEmail = $_POST["email"];
    $newPassword = $_POST["password"]; // Ensure you handle password securely (e.g., hash it)
    $newRole = $_POST["role"];

    // Check if the password is provided and not empty
    if (!empty($_POST["password"])) {
        $newPassword = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the new password
        $updateSql = "UPDATE users SET Profile_picture = '$newProfile_picture', name = '$newBusinessName', Phone = '$newPhone', email = '$newEmail', password = '$newPassword', role = '$newRole' WHERE name = '$username'";
    } else {
        // If password is not provided, update other fields excluding the password
        $updateSql = "UPDATE users SET name = '$newBusinessName', Phone = '$newPhone', email = '$newEmail', role = '$newRole' WHERE name = '$username'";
    }

    if ($conn->query($updateSql) === TRUE) {
        echo "User information updated successfully.";
        // Refresh user data after update
        $result = $conn->query($sql);
        $userData = $result->fetch_assoc();
    } else {
        echo "Error updating user information: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>User Profile</title>
</head>
<body>
    <button id="backButton" class="btn btn-default">
        <i class="fas fa-arrow-left"></i> Back
    </button>

    <script>
        document.getElementById('backButton').addEventListener('click', function () {
            window.history.back();
        });
    </script> 
    <div class="profile-container">
        <form type = "file" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="user-info">
                <div class="info-row">
                    <label for="businessName">Business Name</label>
                    <input type="text" id="businessName" name="businessName" value="<?php echo $userData['name']; ?>">
                </div>
                <div class="info-row">
                    <label for="phone">M-Pesa Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $userData['Phone']; ?>">
                </div>
                <div class="info-row">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $userData['email']; ?>">
                </div>
                <div class="info-row">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep the current password">
            </div>
            <div class="info-row">
                <label for="role">Role</label>
                <input type="text" id="role" name="role" value="<?php echo $userData['role']; ?>">
            </div>
            <button type="submit" id="update-btn">Update</button>
        </form>
    </div>
</body>
</html>
