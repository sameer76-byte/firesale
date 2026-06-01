-- Create Database
CREATE DATABASE firesale;
USE firesale;

-- Customers Table
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(200) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    description TEXT,
    image_url VARCHAR(255),
    sizes VARCHAR(100) DEFAULT 'S,M,L,XL',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders Table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    customer_id INT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    shipping_address TEXT NOT NULL,
    billing_address TEXT NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    order_status VARCHAR(50) DEFAULT 'pending',
    tracking_number VARCHAR(100),
    guest_checkout TINYINT DEFAULT 0,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL
);

-- Order Items Table
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    size VARCHAR(10),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Payments Table
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_status VARCHAR(50) DEFAULT 'pending',
    amount DECIMAL(10,2) NOT NULL,
    transaction_id VARCHAR(100),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- Reviews Table
CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    customer_id INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
);

-- Admin Users Table
CREATE TABLE admin_users (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Insert Sample Admin (password: admin123)
INSERT INTO admin_users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@firesale.com');

-- Insert Sample Products
INSERT INTO products (product_name, category, price, stock_quantity, description, image_url, sizes) VALUES
('FireStorm Hoodie', 'Clothing', 59.99, 50, 'Premium cotton hoodie with flame design. Perfect for cold evenings.', 'hoodie.jpg', 'S,M,L,XL,XXL'),
('Blaze Running Shoes', 'Footwear', 89.99, 30, 'Lightweight running shoes with fire-red accents.', 'shoes.jpg', '7,8,9,10,11'),
('Inferno Backpack', 'Accessories', 45.99, 100, 'Durable backpack with heat-resistant material.', 'backpack.jpg', 'One Size'),
('Flame Wireless Earbuds', 'Electronics', 79.99, 75, 'High-quality sound with fire-inspired design.', 'earbuds.jpg', 'One Size'),
('Ember Mug', 'Home', 24.99, 200, 'Temperature control mug keeps your drink hot.', 'mug.jpg', 'One Size'),
('Phoenix T-Shirt', 'Clothing', 29.99, 150, 'Soft cotton t-shirt with phoenix graphic.', 'tshirt.jpg', 'S,M,L,XL'),
('Heat Gloves', 'Accessories', 19.99, 80, 'Warm thermal gloves for winter.', 'gloves.jpg', 'S,M,L'),
('FireFly Drone', 'Electronics', 299.99, 15, 'Mini drone with LED lights.', 'drone.jpg', 'One Size');

-- Insert Sample Reviews
INSERT INTO reviews (product_id, customer_id, rating, comment) VALUES
(1, 1, 5, 'Amazing hoodie! Very comfortable and looks great.'),
(1, 1, 4, 'Good quality, runs slightly small.'),
(2, 1, 5, 'Best running shoes I''ve ever owned!');

-- =============================================
-- ADD MORE PRODUCTS (GEN Z VIBE)
-- Clothing (now 10 products total)
-- =============================================
INSERT INTO products (product_name, category, price, stock_quantity, description, image_url, sizes) VALUES
('Viral Flame Hoodie', 'Clothing', 69.99, 45, 'The hoodie that broke TikTok. Fire gradient with embroidered flame. "Main character energy."', 'flame_hoodie.jpg', 'S,M,L,XL,XXL'),
('Y2K Ember Cargos', 'Clothing', 59.99, 30, 'Baggy cargo pants with subtle ember pattern. Side pockets for phone & wallet. Gen Z essential.', 'cargos.jpg', 'XS,S,M,L,XL'),
('Glow-in-Dark Phoenix Tee', 'Clothing', 34.99, 80, '100% cotton tee with phoenix graphic that glows at raves & parties.', 'phoenix_tee.jpg', 'S,M,L,XL'),
('Heatwave Mesh Top', 'Clothing', 29.99, 60, 'Breathable mesh top for festivals. Fire print under blacklight. Unisex.', 'mesh_top.jpg', 'S,M,L'),
('Campfire Quarter-Zip', 'Clothing', 54.99, 40, 'Cozy sherpa quarter-zip with campfire patch. Perfect for coffee shop hangs.', 'quarter_zip.jpg', 'S,M,L,XL,XXL');

-- =============================================
-- Footwear (now 8 products)
-- =============================================
INSERT INTO products (product_name, category, price, stock_quantity, description, image_url, sizes) VALUES
('Inferno Slides', 'Footwear', 29.99, 120, 'Cloud-soft slides with flame strap. Indoor/outdoor. "Slides SZN"', 'slides.jpg', '6,7,8,9,10,11,12'),
('Firestorm Boots', 'Footwear', 119.99, 25, 'Waterproof combat boots with red-hot sole. Urban explorer approved.', 'boots.jpg', '7,8,9,10,11,12'),
('Ember Sneakers', 'Footwear', 79.99, 50, 'Low-top sneakers with orange-glow laces. Reflective fire stripe.', 'ember_sneakers.jpg', '7,8,9,10,11');

-- =============================================
-- Electronics (now 8 products)
-- =============================================
INSERT INTO products (product_name, category, price, stock_quantity, description, image_url, sizes) VALUES
('FireBuds Pro', 'Electronics', 129.99, 60, 'Noise-cancelling earbuds with fire equalizer app. 30hr battery. "Lit audio"', 'firebuds.jpg', 'One Size'),
('Flame RGB Keyboard', 'Electronics', 89.99, 35, 'Mechanical keyboard with 16.8M colors. Fire wave effect. Hot-swappable.', 'keyboard.jpg', 'One Size'),
('Inferno Power Bank', 'Electronics', 39.99, 150, '20,000mAh with digital flame display. Charges 3 devices at once.', 'powerbank.jpg', 'One Size');

-- =============================================
-- Accessories (now 10 products)
-- =============================================
INSERT INTO products (product_name, category, price, stock_quantity, description, image_url, sizes) VALUES
('Flame Chain Necklace', 'Accessories', 24.99, 100, 'Stainless steel chain with flame pendant. Iced out.', 'necklace.jpg', 'One Size'),
('Ember Beanie', 'Accessories', 19.99, 85, 'Ribbed beanie with embroidered ember. One size fits most.', 'beanie.jpg', 'One Size'),
('Fire Socks (3-pack)', 'Accessories', 15.99, 200, 'Cotton blend crew socks with flame graphics. "Hot feet" collection.', 'socks.jpg', 'One Size'),
('Heatwave Sunglasses', 'Accessories', 34.99, 70, 'Polarized shades with orange-tinted lenses. UV400 protection.', 'sunglasses.jpg', 'One Size'),
('Flame Phone Grip', 'Accessories', 9.99, 300, 'Pop-socket style grip with fire design. MagSafe compatible.', 'phone_grip.jpg', 'One Size');

-- =============================================
-- Home (now 8 products)
-- =============================================
INSERT INTO products (product_name, category, price, stock_quantity, description, image_url, sizes) VALUES
('Firefly Lamp', 'Home', 49.99, 40, 'LED lamp with flickering flame effect. Rechargeable. 8hr runtime.', 'lamp.jpg', 'One Size'),
('Ember Coaster Set', 'Home', 12.99, 150, 'Set of 4 heat-resistant coasters with ember design. Silicone.', 'coasters.jpg', 'One Size'),
('Flame Throw Blanket', 'Home', 44.99, 55, 'Sherpa fleece blanket with fire pattern. Extra warm.', 'blanket.jpg', 'One Size');

-- =============================================
-- Additional: Bestsellers / Trending badge (optional meta)
-- =============================================
-- (No need to alter table, but you can add a 'trending' column later if desired)

-- Verify counts per category
SELECT category, COUNT(*) as total_products FROM products GROUP BY category ORDER BY category;