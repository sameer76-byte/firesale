<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/config.php';

// Handle user deletion (optional)
if (isset($_GET['delete'])) {
    $user_id = (int)$_GET['delete'];
    // First, delete reviews (foreign key cascade handles it, but safer to delete orders first if needed)
    mysqli_query($conn, "DELETE FROM orders WHERE customer_id = $user_id");
    mysqli_query($conn, "DELETE FROM reviews WHERE customer_id = $user_id");
    mysqli_query($conn, "DELETE FROM customers WHERE customer_id = $user_id");
    $success = "User deleted successfully!";
}

// Fetch all customers with order count
$query = "SELECT c.*, COUNT(o.order_id) as order_count 
          FROM customers c 
          LEFT JOIN orders o ON c.customer_id = o.customer_id 
          GROUP BY c.customer_id 
          ORDER BY c.created_at DESC";
$customers = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Fire Sale Admin</title>
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
                <a href="users.php"><i class="fas fa-users"></i> Users</a>
                <a href="reviews.php"><i class="fas fa-star"></i> Reviews</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-users"></i> Registered Users</h1>
                </div>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Orders</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = mysqli_fetch_assoc($customers)): ?>
                            <tr>
                                <td><?php echo $user['customer_id']; ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone'] ?: '—'); ?></td>
                                <td><?php echo htmlspecialchars(substr($user['address'], 0, 50) ?: '—'); ?></td>
                                <td>
                                    <span class="badge bg-primary"><?php echo $user['order_count']; ?> orders</span>
                                 </td>
                                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <a href="users.php?delete=<?php echo $user['customer_id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Delete user <?php echo addslashes($user['name']); ?>? This will also delete their orders and reviews.')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                 </td>
                            </tr>
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