<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/config.php';

// Get sales data for chart
$sales_query = "SELECT DATE(order_date) as sale_date, SUM(total_amount) as daily_sales 
                FROM orders 
                WHERE order_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                GROUP BY DATE(order_date)
                ORDER BY sale_date ASC";
$sales_result = mysqli_query($conn, $sales_query);

$dates = [];
$sales = [];
while ($row = mysqli_fetch_assoc($sales_result)) {
    $dates[] = date('M d', strtotime($row['sale_date']));
    $sales[] = $row['daily_sales'];
}

// Get stats
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders"))['total'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM customers"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fire Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
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
                <a href="reviews.php"><i class="fas fa-star"></i> Reviews</a>
                <a href="users.php"><i class="fas fa-users"></i> Users</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Dashboard</h1>
                    <div>Welcome, <?php echo $_SESSION['admin_username']; ?></div>
                </div>
                
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stat-card text-center">
                            <i class="fas fa-shopping-cart fa-3x text-primary"></i>
                            <h3 class="mt-2"><?php echo $total_orders; ?></h3>
                            <p>Total Orders</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card text-center">
                            <i class="fas fa-dollar-sign fa-3x text-success"></i>
                            <h3 class="mt-2">$<?php echo number_format($total_revenue, 2); ?></h3>
                            <p>Total Revenue</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card text-center">
                            <i class="fas fa-box fa-3x text-warning"></i>
                            <h3 class="mt-2"><?php echo $total_products; ?></h3>
                            <p>Products</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card text-center">
                            <i class="fas fa-users fa-3x text-info"></i>
                            <h3 class="mt-2"><?php echo $total_customers; ?></h3>
                            <p>Customers</p>
                        </div>
                    </div>
                </div>
                
                <!-- Sales Chart -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Last 7 Days Sales</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [{
                    label: 'Daily Sales ($)',
                    data: <?php echo json_encode($sales); ?>,
                    borderColor: '#d62828',
                    backgroundColor: 'rgba(214, 40, 40, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
</body>
</html>