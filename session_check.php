<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    // Clear session and boot user back to login if they aren't an admin
    session_destroy();
    header("Location: ../auth/admin_login.php?error=access_denied");
    exit();
}
?>