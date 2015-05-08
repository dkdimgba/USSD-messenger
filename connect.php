<?php
$servername = "mysql.hostinger.in";
$username = "u233251005_user1";
$password = "password1";
$dbname = "u233251005_db1";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>