<?php
// includes/db.php
$host = "localhost";
$user = "root";
$pass = ""; 
$dbname = "leave_mgmt_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>