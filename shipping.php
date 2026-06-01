<?php
$page_title = "Shipping & Returns Policy - Fire Sale";
include 'includes/config.php';
include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0"><i class="fas fa-truck"></i> Shipping & Returns Policy</h1>
                </div>
                <div class="card-body">
                    <p class="text-muted">Last updated: January 2025</p>
                    
                    <h4>1. Shipping Destinations</h4>
                    <p>We currently ship to addresses within the United States. International shipping is coming soon. For U.S. territories, please contact support@firesale.com.</p>
                    
                    <h4>2. Processing Time</h4>
                    <p>Orders are processed within <strong>1-2 business days</strong> (excluding weekends/holidays). You will receive a confirmation email once your order ships.</p>
                    
                    <h4>3. Shipping Rates & Delivery Times</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr><th>Method</th><th>Estimated Delivery</th><th>Cost</th><th>Order Value Threshold</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Standard</td><td>5-7 business days</td><td>$5.99</td><td>Free on orders $50+</td></tr>
                                <tr><td>Express</td><td>2-3 business days</td><td>$12.99</td><td>-</td></tr>
                                <tr><td>Overnight</td><td>1-2 business days</td><td>$24.99</td><td>-</td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <h4>4. Order Tracking</h4>
                    <p>Once your order ships, you'll receive a tracking number via email. You can also track your order on our <a href="order_tracking.php">Order Tracking page</a>.</p>
                    
                    <h4>5. Lost or Damaged Packages</h4>
                    <p>If your package is lost or arrives damaged, contact us within 7 days of delivery. We'll work with the carrier to resolve issues and may offer a replacement or refund.</p>
                    
                    <h4>6. Returns & Refunds</h4>
                    <p><strong>30-Day Return Policy:</strong> You may return unworn, unwashed, undamaged items with original tags within 30 days of delivery.</p>
                    <ul>
                        <li><strong>Final Sale items:</strong> Gift cards, clearance, and underwear cannot be returned.</li>
                        <li><strong>Return shipping:</strong> Customer pays return shipping unless the item was defective or incorrect.</li>
                        <li><strong>Refund processing:</strong> Refunds issued to original payment method within 7-10 business days of receiving the return.</li>
                    </ul>
                    
                    <h4>7. How to Initiate a Return</h4>
                    <ol>
                        <li>Email <strong>returns@firesale.com</strong> with your order number and reason for return.</li>
                        <li>You'll receive a return authorization (RA) number and instructions.</li>
                        <li>Pack items securely and ship to the address provided.</li>
                        <li>Keep tracking confirmation until refund is processed.</li>
                    </ol>
                    
                    <h4>8. Exchanges</h4>
                    <p>For exchanges (size/color), please return the original item and place a new order. This ensures the fastest delivery.</p>
                    
                    <h4>9. Holiday Returns</h4>
                    <p>Purchases made between November 1 and December 25 can be returned until January 31 of the following year.</p>
                    
                    <h4>10. Contact Us</h4>
                    <p>For shipping or returns questions:</p>
                    <address>
                        Fire Sale Returns Department<br>
                        123 Flame Boulevard<br>
                        Fire City, FC 90210<br>
                        Email: returns@firesale.com<br>
                        Phone: +1 (555) 123-4567
                    </address>
                    
                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Demo Notice:</strong> This site is a demonstration project. Shipping and return policies are simulated. Real purchases are not being fulfilled.
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="terms.php" class="btn btn-outline-primary">Terms & Conditions</a>
                    <a href="privacy.php" class="btn btn-outline-secondary">Privacy Policy</a>
                    <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>