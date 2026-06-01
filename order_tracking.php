<?php
$page_title = "Track Your Order - Fire Sale";
include 'includes/config.php';
include 'includes/header.php';

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$email = isset($_GET['email']) ? sanitize($_GET['email']) : '';
$tracking_result = null;
$error = '';

// If order ID is provided (e.g., from success page), show tracking directly
if ($order_id > 0 && !isset($_POST['track'])) {
    // For logged-in users, we can fetch by customer_id
    if (isLoggedIn()) {
        $customer_id = $_SESSION['customer_id'];
        $query = "SELECT o.*, 
                         (SELECT COUNT(*) FROM order_items WHERE order_id = o.order_id) as item_count 
                  FROM orders o 
                  WHERE o.order_id = $order_id AND (o.customer_id = $customer_id OR o.email = '{$_SESSION['customer_email']}')";
        $result = mysqli_query($conn, $query);
        $tracking_result = mysqli_fetch_assoc($result);
        if (!$tracking_result) {
            $error = "Order not found or you don't have permission to view it.";
        }
    } else {
        // Guest – we need to ask for email to confirm
        // So we'll show a form instead of auto-display
        $error = "Please enter your email address to view order details.";
    }
}

// Handle tracking form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['track'])) {
    $track_order_id = (int)$_POST['order_id'];
    $track_email = sanitize($_POST['email']);
    
    $query = "SELECT o.*, 
                     (SELECT COUNT(*) FROM order_items WHERE order_id = o.order_id) as item_count 
              FROM orders o 
              WHERE o.order_id = $track_order_id AND o.email = '$track_email'";
    $result = mysqli_query($conn, $query);
    $tracking_result = mysqli_fetch_assoc($result);
    
    if (!$tracking_result) {
        $error = "No order found with that Order ID and Email combination.";
    }
}

// If user is logged in, show their recent orders as a list
if (isLoggedIn() && !$tracking_result && !isset($_GET['order_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $orders_query = "SELECT order_id, order_date, total_amount, order_status, tracking_number 
                     FROM orders 
                     WHERE customer_id = $customer_id 
                     ORDER BY order_date DESC 
                     LIMIT 10";
    $recent_orders = mysqli_query($conn, $orders_query);
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3><i class="fas fa-truck"></i> Track Your Order</h3>
                </div>
                <div class="card-body">
                    
                    <!-- Error Message -->
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <!-- If order is found, display details -->
                    <?php if ($tracking_result): ?>
                        <div class="tracking-details">
                            <h4 class="text-center">Order #<?php echo $tracking_result['order_id']; ?></h4>
                            <p class="text-center text-muted">Placed on <?php echo date('F j, Y', strtotime($tracking_result['order_date'])); ?></p>
                            
                            <!-- Status Timeline -->
                            <div class="status-timeline mb-4">
                                <?php
                                $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                                $current_status = $tracking_result['order_status'];
                                $current_index = array_search($current_status, $statuses);
                                ?>
                                <div class="d-flex justify-content-between">
                                    <div class="text-center <?php echo $current_index >= 0 ? 'text-success' : 'text-muted'; ?>">
                                        <i class="fas fa-clock fa-2x"></i>
                                        <p>Pending</p>
                                    </div>
                                    <div class="text-center <?php echo $current_index >= 1 ? 'text-success' : 'text-muted'; ?>">
                                        <i class="fas fa-cogs fa-2x"></i>
                                        <p>Processing</p>
                                    </div>
                                    <div class="text-center <?php echo $current_index >= 2 ? 'text-success' : 'text-muted'; ?>">
                                        <i class="fas fa-shipping-fast fa-2x"></i>
                                        <p>Shipped</p>
                                    </div>
                                    <div class="text-center <?php echo $current_index >= 3 ? 'text-success' : 'text-muted'; ?>">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                        <p>Delivered</p>
                                    </div>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo (($current_index + 1) / count($statuses)) * 100; ?>%"></div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Order Status</h6>
                                    <span class="badge bg-<?php 
                                        echo $tracking_result['order_status'] == 'delivered' ? 'success' : 
                                            ($tracking_result['order_status'] == 'cancelled' ? 'danger' : 'warning'); 
                                    ?> p-2">
                                        <?php echo ucfirst($tracking_result['order_status']); ?>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <h6>Tracking Number</h6>
                                    <p><?php echo $tracking_result['tracking_number'] ?: 'Not yet assigned'; ?></p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Total Amount</h6>
                                    <p class="price">$<?php echo number_format($tracking_result['total_amount'], 2); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Items</h6>
                                    <p><?php echo $tracking_result['item_count']; ?> product(s)</p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <h6>Shipping Address</h6>
                                <p><?php echo nl2br(htmlspecialchars($tracking_result['shipping_address'])); ?></p>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="catalog.php" class="btn btn-outline-primary">Continue Shopping</a>
                                <?php if ($tracking_result['order_status'] == 'delivered'): ?>
                                    <button class="btn btn-success" onclick="alert('Thanks for shopping with Fire Sale! Leave a review on our products.')">
                                        <i class="fas fa-star"></i> Rate Your Purchase
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                    <?php else: ?>
                        
                        <!-- Tracking Form -->
                        <form method="POST" action="order_tracking.php">
                            <div class="mb-3">
                                <label for="order_id" class="form-label">Order ID *</label>
                                <input type="number" name="order_id" id="order_id" class="form-control" 
                                       placeholder="e.g., 12" required value="<?php echo isset($_GET['order_id']) ? (int)$_GET['order_id'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address (used at checkout) *</label>
                                <input type="email" name="email" id="email" class="form-control" 
                                       placeholder="your@email.com" required>
                            </div>
                            <button type="submit" name="track" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Track Order
                            </button>
                        </form>
                        
                        <!-- For logged-in users, show recent orders -->
                        <?php if (isLoggedIn() && isset($recent_orders) && mysqli_num_rows($recent_orders) > 0): ?>
                            <hr>
                            <h5 class="mt-4">Your Recent Orders</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($order = mysqli_fetch_assoc($recent_orders)): ?>
                                        <tr>
                                            <td>#<?php echo $order['order_id']; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                            <td>
                                                <span class="badge bg-<?php 
                                                    echo $order['order_status'] == 'delivered' ? 'success' : 
                                                        ($order['order_status'] == 'cancelled' ? 'danger' : 'warning'); 
                                                ?>">
                                                    <?php echo ucfirst($order['order_status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="order_tracking.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    Track
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-timeline .fa-2x {
    font-size: 1.8rem;
}
@media (max-width: 576px) {
    .status-timeline .fa-2x {
        font-size: 1.2rem;
    }
    .status-timeline p {
        font-size: 0.7rem;
    }
}
</style>

<?php include 'includes/footer.php'; ?>