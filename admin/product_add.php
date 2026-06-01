<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/config.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = sanitize($_POST['product_name']);
    $category = sanitize($_POST['category']);
    $price = (float)$_POST['price'];
    $stock_quantity = (int)$_POST['stock_quantity'];
    $description = sanitize($_POST['description']);
    $sizes = sanitize($_POST['sizes']);
    
    // Handle image upload
    $image_url = '';
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['product_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $new_filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
            $upload_path = '../assets/uploads/' . $new_filename;
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_path)) {
                $image_url = $new_filename;
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid file type. Allowed: jpg, jpeg, png, gif.";
        }
    }
    
    if (empty($error)) {
        $query = "INSERT INTO products (product_name, category, price, stock_quantity, description, image_url, sizes) 
                  VALUES ('$product_name', '$category', $price, $stock_quantity, '$description', '$image_url', '$sizes')";
        if (mysqli_query($conn, $query)) {
            $success = "Product added successfully!";
            // Clear form (optional)
            $_POST = array();
        } else {
            $error = "Database error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Fire Sale Admin</title>
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
                    <h1><i class="fas fa-plus-circle"></i> Add New Product</h1>
                    <a href="products.php" class="btn btn-secondary">Back to Products</a>
                </div>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text" name="product_name" class="form-control" required value="<?php echo isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category *</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">Select Category</option>
                                        <option value="Clothing" <?php echo (isset($_POST['category']) && $_POST['category']=='Clothing') ? 'selected' : ''; ?>>Clothing</option>
                                        <option value="Footwear" <?php echo (isset($_POST['category']) && $_POST['category']=='Footwear') ? 'selected' : ''; ?>>Footwear</option>
                                        <option value="Electronics" <?php echo (isset($_POST['category']) && $_POST['category']=='Electronics') ? 'selected' : ''; ?>>Electronics</option>
                                        <option value="Accessories" <?php echo (isset($_POST['category']) && $_POST['category']=='Accessories') ? 'selected' : ''; ?>>Accessories</option>
                                        <option value="Home" <?php echo (isset($_POST['category']) && $_POST['category']=='Home') ? 'selected' : ''; ?>>Home</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price ($) *</label>
                                    <input type="number" step="0.01" name="price" class="form-control" required value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock Quantity *</label>
                                    <input type="number" name="stock_quantity" class="form-control" required value="<?php echo isset($_POST['stock_quantity']) ? $_POST['stock_quantity'] : ''; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sizes (comma separated, e.g., S,M,L,XL)</label>
                                <input type="text" name="sizes" class="form-control" value="<?php echo isset($_POST['sizes']) ? htmlspecialchars($_POST['sizes']) : 'S,M,L,XL'; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Image</label>
                                <input type="file" name="product_image" class="form-control" accept="image/*">
                                <small class="text-muted">Leave empty for no image. Allowed: jpg, jpeg, png, gif</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                            <a href="products.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>