<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    redirect('checkout.php');
}

// Mock payment validation
$card_number = preg_replace('/\s+/', '', $_POST['card_number']);
if (!preg_match('/^4242/', $card_number)) {
    $_SESSION['payment_error'] = 'Invalid card number. Use test card: 4242 4242 4242 4242';
    redirect('checkout.php');
}

$total_amount = (float)$_POST['total_amount'];
$email = sanitize($_POST['email']);
$full_name = sanitize($_POST['full_name']);
$phone = sanitize($_POST['phone']);
$shipping_address = sanitize($_POST['shipping_address']);
$billing_address = sanitize($_POST['billing_address']);

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Create order
    $customer_id = isLoggedIn() ? $_SESSION['customer_id'] : 'NULL';
    $order_date = date('Y-m-d H:i:s');
    $order_status = 'pending';
    $guest_checkout = isLoggedIn() ? 0 : 1;
    
    $order_query = "INSERT INTO orders (order_date, customer_id, total_amount, shipping_address, 
                    billing_address, email, phone, order_status, guest_checkout) 
                    VALUES ('$order_date', $customer_id, $total_amount, '$shipping_address', 
                    '$billing_address', '$email', '$phone', '$order_status', $guest_checkout)";
    
    mysqli_query($conn, $order_query);
    $order_id = mysqli_insert_id($conn);
    
    // Add order items
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $size = sanitize($item['size']);
        
        $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price, size) 
                       VALUES ($order_id, $product_id, $quantity, $price, '$size')";
        mysqli_query($conn, $item_query);
        
        // Update stock
        $update_stock = "UPDATE products SET stock_quantity = stock_quantity - $quantity 
                         WHERE product_id = $product_id";
        mysqli_query($conn, $update_stock);
    }
    
    // Create payment record
    $payment_method = 'Credit Card';
    $payment_status = 'completed';
    $transaction_id = 'TXN_' . time() . '_' . rand(1000, 9999);
    
    $payment_query = "INSERT INTO payments (order_id, payment_method, payment_status, amount, transaction_id) 
                      VALUES ($order_id, '$payment_method', '$payment_status', $total_amount, '$transaction_id')";
    mysqli_query($conn, $payment_query);
    
    // Update order status
    $update_order = "UPDATE orders SET order_status = 'processing' WHERE order_id = $order_id";
    mysqli_query($conn, $update_order);
    
    mysqli_commit($conn);
    
    // Clear cart
    unset($_SESSION['cart']);
    
    // Redirect to success page
    header("Location: order_success.php?order_id=$order_id");
    exit();
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    $_SESSION['payment_error'] = 'Payment failed. Please try again.';
    redirect('checkout.php');
}
?>