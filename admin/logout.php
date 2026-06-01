<?php
// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset admin session variables
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);

// Destroy the session completely
session_destroy();

// Redirect to admin login page
header("Location: login.php");
exit();
?>