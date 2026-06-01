<?php
$page_title = "Home - Premium Fire-themed Gear";
include 'includes/config.php';
include 'includes/header.php';

// Get featured products
$query = "SELECT * FROM products ORDER BY product_id DESC LIMIT 8";
$result = mysqli_query($conn, $query);
?>

<!-- Hero Banner -->
<div class="hero-section" style="background: linear-gradient(135deg, #d62828, #f77f00, #fcbf49); padding: 80px 0; margin-bottom: 50px;">
    <div class="container text-center text-white">
        <h1 class="display-3 fw-bold animate__animated animate__fadeInDown">
            <i class="fas fa-fire"></i> Ignite Your Style!
        </h1>
        <p class="lead fs-4">Premium fire-themed gear for the bold and fearless</p>
        <a href="catalog.php" class="btn btn-light btn-lg mt-3">
            <i class="fas fa-shopping-bag"></i> Shop Now
        </a>
    </div>
</div>

<div class="container">
    <!-- Categories Section -->
    <h2 class="text-center mb-4">Shop by Category</h2>
    <div class="row mb-5">
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center category-card" style="cursor: pointer;" onclick="location.href='catalog.php?category=Clothing'">
                <div class="card-body">
                    <i class="fas fa-tshirt fa-3x" style="color: #d62828;"></i>
                    <h5 class="mt-2">Clothing</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center category-card" style="cursor: pointer;" onclick="location.href='catalog.php?category=Footwear'">
                <div class="card-body">
                    <i class="fas fa-shoe-prints fa-3x" style="color: #d62828;"></i>
                    <h5 class="mt-2">Footwear</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center category-card" style="cursor: pointer;" onclick="location.href='catalog.php?category=Electronics'">
                <div class="card-body">
                    <i class="fas fa-headphones fa-3x" style="color: #d62828;"></i>
                    <h5 class="mt-2">Electronics</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center category-card" style="cursor: pointer;" onclick="location.href='catalog.php?category=Accessories'">
                <div class="card-body">
                    <i class="fas fa-gem fa-3x" style="color: #d62828;"></i>
                    <h5 class="mt-2">Accessories</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <h2 class="text-center mb-4">Featured Products</h2>
    <div class="row">
        <?php while ($product = mysqli_fetch_assoc($result)): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="product-card">
                <div class="product-img-container">
                    <img src="assets/uploads/<?php echo $product['image_url'] ?: 'placeholder.jpg'; ?>" 
                         class="product-img" alt="<?php echo $product['product_name']; ?>">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                    <p class="text-muted"><?php echo $product['category']; ?></p>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <a href="product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-primary w-100">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Guest Checkout Banner -->
    <div class="guest-checkout-banner text-center">
        <h4><i class="fas fa-bolt"></i> Quick & Easy Checkout!</h4>
        <p>Don't have an account? No problem! Checkout as a guest.</p>
        <a href="checkout.php" class="btn btn-light">Guest Checkout <i class="fas fa-arrow-right"></i></a>
    </div>
</div>

<style>
.category-card {
    transition: transform 0.3s, box-shadow 0.3s;
}
.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
.hero-section {
    clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
}
</style>

<?php include 'includes/footer.php'; ?>