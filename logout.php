<?php
// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables (customer session data)
unset($_SESSION['customer_id']);
unset($_SESSION['customer_name']);
unset($_SESSION['customer_email']);

// Destroy the session completely
session_destroy();

// Redirect to homepage after logout
header("Location: index.php");
exit();
?>