<?php
$page_title = "Checkout";
include 'includes/config.php';
include 'includes/header.php';

if (empty($_SESSION['cart'])) {
    redirect('cart.php');
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<div class="container py-4">
    <div class="checkout-steps">
        <div class="step active">1. Cart Review</div>
        <div class="step">2. Shipping Info</div>
        <div class="step">3. Payment</div>
    </div>
    
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Shipping Information</h4>
                </div>
                <div class="card-body">
                    <form id="checkoutForm" method="POST" action="payment_process.php">
                        <div class="mb-3">
                            <label>Full Name *</label>
                            <input type="text" name="full_name" class="form-control" required 
                                   value="<?php echo isLoggedIn() ? htmlspecialchars($_SESSION['customer_name']) : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label>Email Address *</label>
                            <input type="email" name="email" class="form-control" required
                                   value="<?php echo isLoggedIn() ? htmlspecialchars($_SESSION['customer_email']) : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label>Phone Number *</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Shipping Address *</label>
                            <textarea name="shipping_address" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label>Billing Address *</label>
                            <textarea name="billing_address" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <h5 class="mt-4">Payment Information</h5>
                        <div class="mb-3">
                            <label>Card Number *</label>
                            <input type="text" name="card_number" class="form-control" 
                                   placeholder="4242 4242 4242 4242" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Expiry Date *</label>
                                <input type="text" name="expiry" class="form-control" placeholder="MM/YY" required>
                            </div>
                            <div class="col-md-6">
                                <label>CVV *</label>
                                <input type="text" name="cvv" class="form-control" placeholder="123" required>
                            </div>
                        </div>
                        
                        <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
                            Place Order - $<?php echo number_format($total, 2); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="mb-2">
                            <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                            Size: <?php echo $item['size']; ?> | Qty: <?php echo $item['quantity']; ?><br>
                            $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                    <h5>Total: $<?php echo number_format($total, 2); ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>