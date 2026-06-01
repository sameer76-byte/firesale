<?php
$page_title = "Order Confirmation";
include 'includes/config.php';
include 'includes/header.php';

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order = mysqli_fetch_assoc(mysqli_query($conn, $order_query));

if (!$order) {
    echo '<div class="container"><div class="alert alert-danger">Order not found!</div></div>';
    include 'includes/footer.php';
    exit;
}
?>

<div class="container py-5 text-center">
    <div class="card shadow-lg">
        <div class="card-body py-5">
            <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
            <h1 class="mt-3">Thank You for Your Order!</h1>
            <p class="lead">Order #<?php echo $order_id; ?></p>
            <p>We've sent a confirmation email to <strong><?php echo htmlspecialchars($order['email']); ?></strong></p>
            <hr>
            <h5>Order Summary</h5>
            <p>Total Amount: <strong>$<?php echo number_format($order['total_amount'], 2); ?></strong></p>
            <p>Status: <span class="badge bg-warning"><?php echo $order['order_status']; ?></span></p>
            <a href="order_tracking.php?order_id=<?php echo $order_id; ?>" class="btn btn-primary">
                Track Your Order
            </a>
            <a href="catalog.php" class="btn btn-outline-secondary">Continue Shopping</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>