<?php
$page_title = "Product Details";
include 'includes/config.php';
include 'includes/header.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = getProductById($product_id);

if (!$product) {
    echo '<div class="container"><div class="alert alert-danger">Product not found!</div></div>';
    include 'includes/footer.php';
    exit;
}

// Get reviews
$review_query = "SELECT r.*, c.name as customer_name FROM reviews r 
                 JOIN customers c ON r.customer_id = c.customer_id 
                 WHERE r.product_id = $product_id ORDER BY r.created_at DESC";
$reviews = mysqli_query($conn, $review_query);

// Get average rating
$avg_query = "SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews WHERE product_id = $product_id";
$avg_result = mysqli_fetch_assoc(mysqli_query($conn, $avg_query));
$avg_rating = round($avg_result['avg_rating'], 1);
$total_reviews = $avg_result['total'];
?>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="catalog.php">Shop</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($product['product_name']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images with Zoom -->
        <div class="col-md-6 mb-4">
            <div class="zoom-container" style="border-radius: 15px; overflow: hidden; background: white; padding: 20px;">
                <img src="assets/uploads/<?php echo $product['image_url'] ?: 'placeholder.jpg'; ?>" 
                     class="zoom-img w-100" alt="<?php echo $product['product_name']; ?>">
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <span class="badge-fire"><?php echo $product['category']; ?></span>
            <h1 class="mt-2"><?php echo htmlspecialchars($product['product_name']); ?></h1>
            
            <div class="star-rating mb-2">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="<?php echo $i <= $avg_rating ? 'fas' : 'far'; ?> fa-star" style="color: #fcbf49;"></i>
                <?php endfor; ?>
                <span class="text-muted">(<?php echo $total_reviews; ?> reviews)</span>
            </div>
            
            <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
            <p class="text-muted">Stock: <?php echo $product['stock_quantity']; ?> units</p>
            
            <hr>
            
            <p><strong>Description:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            
            <!-- Size Selection -->
            <div class="mb-3">
                <label class="form-label fw-bold">Select Size:</label>
                <div class="d-flex gap-2 flex-wrap">
                    <?php 
                    $sizes = explode(',', $product['sizes']);
                    foreach($sizes as $size): 
                    ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="size" value="<?php echo trim($size); ?>" id="size_<?php echo trim($size); ?>">
                            <label class="form-check-label" for="size_<?php echo trim($size); ?>">
                                <?php echo trim($size); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Quantity -->
            <div class="mb-3">
                <label class="form-label fw-bold">Quantity:</label>
                <input type="number" id="quantity" class="form-control" style="width: 100px;" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>">
            </div>
            
            <!-- Add to Cart Form -->
            <form class="add-to-cart-form" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                <input type="hidden" id="selected_size" name="size" value="">
                <input type="hidden" id="selected_quantity" name="quantity" value="1">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Fan Reviews <i class="fas fa-star" style="color: #fcbf49;"></i></h3>
            <hr>
            
            <?php if (isLoggedIn()): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Write a Review</h5>
                        <form method="POST" action="product.php?id=<?php echo $product_id; ?>">
                            <div class="mb-3">
                                <label>Rating</label>
                                <div class="star-rating">
                                    <i class="far fa-star" onclick="setRating(1)"></i>
                                    <i class="far fa-star" onclick="setRating(2)"></i>
                                    <i class="far fa-star" onclick="setRating(3)"></i>
                                    <i class="far fa-star" onclick="setRating(4)"></i>
                                    <i class="far fa-star" onclick="setRating(5)"></i>
                                </div>
                                <input type="hidden" name="rating" id="rating" value="5">
                            </div>
                            <div class="mb-3">
                                <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience..." required></textarea>
                            </div>
                            <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <a href="login.php">Login</a> to write a review.
                </div>
            <?php endif; ?>
            
            <?php 
            if (isset($_POST['submit_review']) && isLoggedIn()) {
                $rating = (int)$_POST['rating'];
                $comment = sanitize($_POST['comment']);
                $customer_id = $_SESSION['customer_id'];
                $insert = "INSERT INTO reviews (product_id, customer_id, rating, comment) 
                          VALUES ($product_id, $customer_id, $rating, '$comment')";
                if (mysqli_query($conn, $insert)) {
                    echo '<div class="alert alert-success">Review submitted!</div>';
                    echo '<meta http-equiv="refresh" content="2">';
                }
            }
            ?>
            
            <?php while($review = mysqli_fetch_assoc($reviews)): ?>
                <div class="review-item mb-3 p-3" style="background: #f8f9fa; border-radius: 10px;">
                    <strong><?php echo htmlspecialchars($review['customer_name']); ?></strong>
                    <div class="star-rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="<?php echo $i <= $review['rating'] ? 'fas' : 'far'; ?> fa-star" style="color: #fcbf49;"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="mt-2"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                    <small class="text-muted"><?php echo date('F j, Y', strtotime($review['created_at'])); ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('input[name="size"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('selected_size').value = this.value;
    });
});

document.getElementById('quantity').addEventListener('change', function() {
    document.getElementById('selected_quantity').value = this.value;
});

document.querySelector('.add-to-cart-form').addEventListener('submit', function(e) {
    if (!document.getElementById('selected_size').value) {
        e.preventDefault();
        alert('Please select a size');
        return false;
    }
});
</script>

<?php include 'includes/footer.php'; ?>