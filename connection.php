<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "134981 project";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>