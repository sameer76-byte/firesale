<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/config.php';

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = sanitize($_POST['order_status']);
    $tracking_number = sanitize($_POST['tracking_number']);
    
    $update = "UPDATE orders SET order_status = '$new_status', tracking_number = '$tracking_number' WHERE order_id = $order_id";
    mysqli_query($conn, $update);
    $success = "Order #$order_id updated successfully!";
}

// Get all orders with customer details
$orders_query = "SELECT o.*, c.name as customer_name, c.email as customer_email 
                 FROM orders o 
                 LEFT JOIN customers c ON o.customer_id = c.customer_id 
                 ORDER BY o.order_date DESC";
$orders_result = mysqli_query($conn, $orders_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Fire Sale Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #fff5f0 0%, #ffe8e0 100%);
        }
        .sidebar {
            background: linear-gradient(135deg, #d62828, #f77f00);
            min-height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .status-pending { background: #ffc107; color: #000; }
        .status-processing { background: #17a2b8; color: #fff; }
        .status-shipped { background: #007bff; color: #fff; }
        .status-delivered { background: #28a745; color: #fff; }
        .status-cancelled { background: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <h3 class="text-white text-center p-3"><i class="fas fa-fire"></i> Fire Sale Admin</h3>
                <hr class="text-white">
                <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="products.php"><i class="fas fa-box"></i> Products</a>
                <a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
                <a href="reviews.php"><i class="fas fa-star"></i> Reviews</a>
                <a href="users.php"><i class="fas fa-users"></i> Users</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-shopping-cart"></i> Order Management</h1>
                </div>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tracking #</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = mysqli_fetch_assoc($orders_result)): ?>
                                <tr>
                                    <td>#<?php echo $order['order_id']; ?></td>
                                    <td><?php echo date('M d, Y h:i A', strtotime($order['order_date'])); ?></td>
                                    <td>
                                        <?php 
                                        if ($order['customer_name']) {
                                            echo htmlspecialchars($order['customer_name']) . '<br><small>' . htmlspecialchars($order['customer_email']) . '</small>';
                                        } else {
                                            echo '<span class="text-muted">Guest Checkout</span><br><small>' . htmlspecialchars($order['email']) . '</small>';
                                        }
                                        ?>
                                    </td>
                                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                            <?php echo ucfirst($order['order_status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $order['tracking_number'] ?: '—'; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order['order_id']; ?>">
                                            <i class="fas fa-eye"></i> View/Update
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Order Details Modal -->
                                <div class="modal fade" id="orderModal<?php echo $order['order_id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Order #<?php echo $order['order_id']; ?> Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Order Items -->
                                                <?php
                                                $items_query = "SELECT oi.*, p.product_name 
                                                               FROM order_items oi 
                                                               JOIN products p ON oi.product_id = p.product_id 
                                                               WHERE oi.order_id = " . $order['order_id'];
                                                $items = mysqli_query($conn, $items_query);
                                                ?>
                                                <h6>Order Items</h6>
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr><th>Product</th><th>Size</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    $subtotal = 0;
                                                    while ($item = mysqli_fetch_assoc($items)): 
                                                        $item_subtotal = $item['price'] * $item['quantity'];
                                                        $subtotal += $item_subtotal;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                            <td><?php echo $item['size'] ?: '—'; ?></td>
                                                            <td><?php echo $item['quantity']; ?></td>
                                                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                                                            <td>$<?php echo number_format($item_subtotal, 2); ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="table-active"><td colspan="4" class="text-end fw-bold">Total:</td><td>$<?php echo number_format($subtotal, 2); ?></td></tr>
                                                    </tfoot>
                                                </table>
                                                
                                                <hr>
                                                <h6>Customer Information</h6>
                                                <p><strong>Name:</strong> <?php echo $order['customer_name'] ?: 'Guest'; ?><br>
                                                <strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?><br>
                                                <strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?><br>
                                                <strong>Shipping Address:</strong><br><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?><br>
                                                <strong>Billing Address:</strong><br><?php echo nl2br(htmlspecialchars($order['billing_address'])); ?></p>
                                                
                                                <hr>
                                                <h6>Update Order Status</h6>
                                                <form method="POST">
                                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <select name="order_status" class="form-select">
                                                                <option value="pending" <?php echo $order['order_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="processing" <?php echo $order['order_status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                                <option value="shipped" <?php echo $order['order_status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                                                <option value="delivered" <?php echo $order['order_status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                                <option value="cancelled" <?php echo $order['order_status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" name="tracking_number" class="form-control" placeholder="Tracking Number" value="<?php echo htmlspecialchars($order['tracking_number']); ?>">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" name="update_status" class="btn btn-primary w-100">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>