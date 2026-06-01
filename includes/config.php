<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'firesale');

// Site Configuration
define('SITE_NAME', 'Fire Sale');
define('SITE_URL', 'http://localhost/firesale/');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['customer_id']);
}

// Function to check if admin is logged in
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

// Function to redirect
function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit();
}

// Function to sanitize input
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim(htmlspecialchars($data)));
}

// Function to get cart count
function getCartCount() {
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}

// Function to get product by ID
function getProductById($id) {
    global $conn;
    $id = (int)$id;
    $query = "SELECT * FROM products WHERE product_id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}
?>