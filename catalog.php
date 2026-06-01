<?php
$page_title = "Shop - Fire Sale Catalog";
include 'includes/config.php';
include 'includes/header.php';

// Get filter parameters
$category = isset($_GET['category']) ? sanitize($_GET['category']) : '';
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 1000;
$sort = isset($_GET['sort']) ? sanitize($_GET['sort']) : 'newest';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Build WHERE clause
$where = "WHERE 1=1";
if ($category) {
    $where .= " AND category = '$category'";
}
if ($search) {
    $where .= " AND (product_name LIKE '%$search%' OR description LIKE '%$search%')";
}
$where .= " AND price BETWEEN $min_price AND $max_price";

// Build ORDER BY
switch ($sort) {
    case 'price_low':
        $order = "ORDER BY price ASC";
        break;
    case 'price_high':
        $order = "ORDER BY price DESC";
        break;
    case 'name_asc':
        $order = "ORDER BY product_name ASC";
        break;
    default:
        $order = "ORDER BY product_id DESC";
}

// Get total count for pagination
$count_query = "SELECT COUNT(*) as total FROM products $where";
$count_result = mysqli_query($conn, $count_query);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Get products
$query = "SELECT * FROM products $where $order LIMIT $offset, $limit";
$products = mysqli_query($conn, $query);

// Get distinct categories for filter sidebar
$cat_query = "SELECT DISTINCT category FROM products ORDER BY category";
$categories = mysqli_query($conn, $cat_query);
?>

<div class="container py-4">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3 mb-4">
            <div class="sidebar">
                <h5><i class="fas fa-filter"></i> Filters</h5>
                <hr>
                
                <!-- Search -->
                <form method="GET" action="catalog.php" id="filterForm">
                    <div class="mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search products..." 
                               value="<?php echo htmlspecialchars($search); ?>"
                               id="searchInput">
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" id="categorySelect">
                            <option value="">All Categories</option>
                            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?php echo $cat['category']; ?>" 
                                    <?php echo $category == $cat['category'] ? 'selected' : ''; ?>>
                                    <?php echo $cat['category']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="mb-3">
                        <label class="form-label">Price Range</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="min_price" class="form-control" 
                                       placeholder="Min" value="<?php echo $min_price; ?>" step="1">
                            </div>
                            <div class="col-6">
                                <input type="number" name="max_price" class="form-control" 
                                       placeholder="Max" value="<?php echo $max_price; ?>" step="1">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sort By -->
                    <div class="mb-3">
                        <label class="form-label">Sort By</label>
                        <select name="sort" class="form-select">
                            <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                            <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                            <option value="name_asc" <?php echo $sort == 'name_asc' ? 'selected' : ''; ?>>Name: A to Z</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    <a href="catalog.php" class="btn btn-secondary w-100 mt-2">Reset All</a>
                </form>
            </div>
        </div>
        
        <!-- Product Grid -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Products <span class="text-muted fs-6">(<?php echo $total_rows; ?> items)</span></h4>
            </div>
            
            <?php if (mysqli_num_rows($products) > 0): ?>
                <div class="row" id="productGrid">
                    <?php while($product = mysqli_fetch_assoc($products)): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="product-card">
                                <div class="product-img-container">
                                    <img src="assets/uploads/<?php echo $product['image_url'] ?: 'placeholder.jpg'; ?>" 
                                         class="product-img" alt="<?php echo $product['product_name']; ?>">
                                    <?php if($product['stock_quantity'] <= 0): ?>
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">Out of Stock</span>
                                    <?php elseif($product['stock_quantity'] < 10): ?>
                                        <span class="badge bg-warning position-absolute top-0 start-0 m-2">Low Stock</span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                    <p class="text-muted small"><?php echo $product['category']; ?></p>
                                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                                    <a href="product.php?id=<?php echo $product['product_id']; ?>" class="btn btn-primary w-100">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page-1; ?>&category=<?php echo urlencode($category); ?>&search=<?php echo urlencode($search); ?>&min_price=<?php echo $min_price; ?>&max_price=<?php echo $max_price; ?>&sort=<?php echo $sort; ?>">
                                    Previous
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>&category=<?php echo urlencode($category); ?>&search=<?php echo urlencode($search); ?>&min_price=<?php echo $min_price; ?>&max_price=<?php echo $max_price; ?>&sort=<?php echo $sort; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page+1; ?>&category=<?php echo urlencode($category); ?>&search=<?php echo urlencode($search); ?>&min_price=<?php echo $min_price; ?>&max_price=<?php echo $max_price; ?>&sort=<?php echo $sort; ?>">
                                    Next
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-search fa-3x mb-3"></i>
                    <h5>No products found</h5>
                    <p>Try adjusting your filters or search terms.</p>
                    <a href="catalog.php" class="btn btn-primary">Clear Filters</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Auto-submit on filter change (optional)
document.getElementById('categorySelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

// Debounced search
let searchTimeout;
document.getElementById('searchInput').addEventListener('keyup', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500);
});
</script>

<?php include 'includes/footer.php'; ?>