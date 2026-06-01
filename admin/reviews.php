<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/config.php';

// Handle review deletion
if (isset($_GET['delete'])) {
    $review_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM reviews WHERE review_id = $review_id");
    header("Location: reviews.php");
    exit();
}

$reviews = mysqli_query($conn, "SELECT r.*, p.product_name, c.name as customer_name 
                                FROM reviews r 
                                JOIN products p ON r.product_id = p.product_id 
                                JOIN customers c ON r.customer_id = c.customer_id 
                                ORDER BY r.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews - Fire Sale Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #d62828, #f77f00);
            min-height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-0">
                <h3 class="text-white text-center p-3"><i class="fas fa-fire"></i> Admin</h3>
                <hr class="text-white">
                <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="products.php"><i class="fas fa-box"></i> Products</a>
                <a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
                <a href="reviews.php"><i class="fas fa-star"></i> Reviews</a>
                <a href="users.php"><i class="fas fa-users"></i> Users</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            
            <div class="col-md-10 p-4">
                <h1>Customer Reviews</h1>
                
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($review = mysqli_fetch_assoc($reviews)): ?>
                            <tr>
                                <td><?php echo $review['review_id']; ?></td>
                                <td><?php echo htmlspecialchars($review['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($review['customer_name']); ?></td>
                                <td>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="<?php echo $i <= $review['rating'] ? 'fas' : 'far'; ?> fa-star" style="color: #fcbf49;"></i>
                                    <?php endfor; ?>
                                </td>
                                <td><?php echo substr(htmlspecialchars($review['comment']), 0, 100); ?>...</td>
                                <td><?php echo date('M d, Y', strtotime($review['created_at'])); ?></td>
                                <td>
                                    <a href="reviews.php?delete=<?php echo $review['review_id']; ?>" 
                                       class="btn btn-danger btn-sm" onclick="return confirm('Delete this review?')">
                                        <i class="fas fa-trash"></i> Remove
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
</body>
</html>