<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product_id'];
    $product_name = sanitize($_POST['product_name']);
    $price = (float)$_POST['price'];
    $size = sanitize($_POST['size']);
    $quantity = (int)$_POST['quantity'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id && $item['size'] == $size) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }    
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'name' => $product_name,
            'price' => $price,
            'size' => $size,
            'quantity' => $quantity
        ];
    }
    
    echo json_encode(['success' => true, 'message' => 'Added to cart!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>