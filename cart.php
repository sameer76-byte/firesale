<?php
$page_title = "Shopping Cart";
include 'includes/config.php';
include 'includes/header.php';

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $key => $qty) {
            if ($qty > 0) {
                $_SESSION['cart'][$key]['quantity'] = (int)$qty;
            } else {
                unset($_SESSION['cart'][$key]);
            }
        }
        echo '<div class="alert alert-success">Cart updated!</div>';
    }
    
    if (isset($_POST['remove_item'])) {
        unset($_SESSION['cart'][$_POST['remove_index']]);
        echo '<div class="alert alert-success">Item removed!</div>';
    }
}
?>

<div class="container py-4">
    <h1><i class="fas fa-shopping-cart"></i> Your Cart</h1>
    
    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">
            Your cart is empty. <a href="catalog.php">Continue Shopping</a>
        </div>
    <?php else: ?>
        <form method="POST">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $index => $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo $item['size']; ?></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <input type="number" name="quantity[<?php echo $index; ?>]" 
                                           value="<?php echo $item['quantity']; ?>" min="1" style="width: 70px;">
                                </td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                                <td>
                                    <button type="submit" name="remove_item" value="1" 
                                            class="btn btn-danger btn-sm"
                                            onclick="this.form.remove_index.value=<?php echo $index; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <input type="hidden" name="remove_index" value="">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-active">
                            <td colspan="4" class="text-end fw-bold">Total:</td>
                            <td colspan="2" class="fw-bold">$<?php echo number_format($total, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="catalog.php" class="btn btn-secondary">Continue Shopping</a>
                <div>
                    <button type="submit" name="update_cart" class="btn btn-warning">Update Cart</button>
                    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>