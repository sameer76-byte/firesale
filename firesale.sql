-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 03:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `firesale`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_id`, `username`, `password`, `email`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@firesale.com');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `password`, `address`, `phone`, `created_at`) VALUES
(1, 'Sameer Prasad', 'sameerprasad981@gmail.com', '$2y$10$hi3wFOyLnDdRfxF1hBEYpugtij6Dx01.RyDY5a/iEjbkvO.05WD5C', '5 no azad hind nagar\r\nnear netaji boys club', '07980595668', '2026-05-29 06:21:40'),
(2, 'Amit Chatterjee', 'amit.c@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '15/2 Lake Road, Kolkata - 700029', '9876543210', '2026-05-29 06:30:34'),
(3, 'Priya Mukherjee', 'priya.m@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '22B S.P. Mukherjee Road, Howrah - 711101', '9830123456', '2026-05-29 06:30:34'),
(4, 'Sayan Das', 'sayan.d@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '45/A College Street, Burdwan - 713101', '9748552211', '2026-05-29 06:30:34'),
(5, 'Riya Banerjee', 'riya.b@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Flat 3B, 6/1 Jatin Bagchi Road, Kolkata - 700029', '9007788990', '2026-05-29 06:30:34'),
(6, 'Arindam Sen', 'arindam.s@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '7/1A Sarat Bose Road, Kolkata - 700020', '9874123654', '2026-05-29 06:30:34'),
(7, 'Debjani Nandy', 'debjani.n@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '12/3 R.N. Mukherjee Road, Siliguri - 734001', '9647123456', '2026-05-29 06:30:34'),
(8, 'Rajib Chakraborty', 'rajib.c@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'House 22, Bidhan Pally, Durgapur - 713201', '7003123456', '2026-05-29 06:30:34'),
(9, 'Moumita Ghosh', 'moumita.g@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '89/1A Bondel Road, Kolkata - 700019', '9830456789', '2026-05-29 06:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `customer_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `billing_address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `order_status` varchar(50) DEFAULT 'pending',
  `tracking_number` varchar(100) DEFAULT NULL,
  `guest_checkout` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `customer_id`, `total_amount`, `shipping_address`, `billing_address`, `email`, `phone`, `order_status`, `tracking_number`, `guest_checkout`) VALUES
(1, '2026-05-29 11:53:35', 1, 119.96, '5 no azad hind nagar', 'near netaji boys club', 'sameerprasad981@gmail.com', '07980595668', 'shipped', '1212121212', 0),
(2, '2026-05-14 12:03:26', 2, 149.98, '15/2 Lake Road, Kolkata - 700029', '15/2 Lake Road, Kolkata - 700029', 'amit.c@example.com', '9876543210', 'delivered', 'TRK123456001', 0),
(3, '2026-05-24 12:03:26', 2, 79.99, '15/2 Lake Road, Kolkata - 700029', '15/2 Lake Road, Kolkata - 700029', 'amit.c@example.com', '9876543210', 'shipped', 'TRK123456002', 0),
(4, '2026-05-19 12:03:26', 3, 45.99, '22B S.P. Mukherjee Road, Howrah - 711101', '22B S.P. Mukherjee Road, Howrah - 711101', 'priya.m@example.com', '9830123456', 'delivered', 'TRK123456003', 0),
(5, '2026-05-27 12:03:26', 4, 129.99, '45/A College Street, Burdwan - 713101', '45/A College Street, Burdwan - 713101', 'sayan.d@example.com', '9748552211', 'processing', 'TRK123456004', 0),
(6, '2026-05-28 12:03:26', 5, 89.99, 'Flat 3B, 6/1 Jatin Bagchi Road, Kolkata - 700029', 'Flat 3B, 6/1 Jatin Bagchi Road, Kolkata - 700029', 'riya.b@example.com', '9007788990', 'pending', NULL, 0),
(7, '2026-05-22 12:03:26', 6, 299.99, '7/1A Sarat Bose Road, Kolkata - 700020', '7/1A Sarat Bose Road, Kolkata - 700020', 'arindam.s@example.com', '9874123654', 'shipped', 'TRK123456005', 0),
(8, '2025-04-29 10:30:00', 1, 124.97, '123 Fire St, Flame City', '123 Fire St, Flame City', 'john@example.com', '555-1234', 'delivered', 'TRK789001', 0),
(9, '2025-05-01 14:15:00', 3, 69.99, '22B S.P. Mukherjee Road, Howrah - 711101', '22B S.P. Mukherjee Road, Howrah - 711101', 'priya.m@example.com', '9830123456', 'delivered', 'TRK789002', 0),
(10, '2025-05-04 11:45:00', 4, 179.98, '45/A College Street, Burdwan - 713101', '45/A College Street, Burdwan - 713101', 'sayan.d@example.com', '9748552211', 'delivered', 'TRK789003', 0),
(11, '2025-05-07 09:20:00', 5, 54.99, 'Flat 3B, 6/1 Jatin Bagchi Road, Kolkata - 700029', 'Flat 3B, 6/1 Jatin Bagchi Road, Kolkata - 700029', 'riya.b@example.com', '9007788990', 'shipped', 'TRK789004', 0),
(12, '2025-05-11 16:30:00', 6, 194.96, '7/1A Sarat Bose Road, Kolkata - 700020', '7/1A Sarat Bose Road, Kolkata - 700020', 'arindam.s@example.com', '9874123654', 'delivered', 'TRK789005', 0),
(13, '2025-05-14 13:10:00', 7, 324.98, '12/3 R.N. Mukherjee Road, Siliguri - 734001', '12/3 R.N. Mukherjee Road, Siliguri - 734001', 'debjani.n@example.com', '9647123456', 'processing', 'TRK789006', 0),
(14, '2025-05-17 12:00:00', 8, 319.97, 'House 22, Bidhan Pally, Durgapur - 713201', 'House 22, Bidhan Pally, Durgapur - 713201', 'rajib.c@example.com', '7003123456', 'shipped', 'TRK789007', 0),
(15, '2025-05-20 10:15:00', 9, 129.99, '89/1A Bondel Road, Kolkata - 700019', '89/1A Bondel Road, Kolkata - 700019', 'moumita.g@example.com', '9830456789', 'delivered', 'TRK789008', 0),
(16, '2025-05-24 17:45:00', 2, 44.99, '15/2 Lake Road, Kolkata - 700029', '15/2 Lake Road, Kolkata - 700029', 'amit.c@example.com', '9876543210', 'pending', NULL, 0),
(17, '2026-05-29 12:06:22', 4, 89.99, '45/A College Street, Burdwan - 713101', '45/A College Street, Burdwan - 713101', 'sayan.d@example.com', '9748552211', 'processing', 'TRK789010', 0),
(18, '2026-05-29 13:31:14', 1, 44.99, '5 no azad hind nagar', 'near netaji boys club', 'sameerprasad981@gmail.com', '07980595668', 'delivered', '000000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `size`) VALUES
(1, 1, 6, 4, 29.99, 'L'),
(2, 1, 1, 1, 59.99, 'L'),
(3, 1, 2, 1, 89.99, '9'),
(4, 2, 4, 1, 79.99, 'One Size'),
(5, 3, 3, 1, 45.99, 'One Size'),
(6, 4, 9, 1, 129.99, 'One Size'),
(7, 5, 2, 1, 89.99, '8'),
(8, 6, 8, 1, 299.99, 'One Size'),
(9, 7, 4, 1, 79.99, 'One Size'),
(10, 7, 5, 1, 24.99, 'One Size'),
(11, 7, 7, 1, 19.99, 'M'),
(12, 8, 9, 1, 69.99, 'L'),
(13, 9, 1, 1, 59.99, 'XL'),
(14, 9, 11, 1, 89.99, 'One Size'),
(15, 9, 14, 1, 19.99, 'One Size'),
(16, 10, 13, 1, 54.99, 'M'),
(17, 11, 2, 1, 89.99, '10'),
(18, 12, 2, 1, 89.99, '8'),
(19, 12, 1, 1, 59.99, 'L'),
(20, 12, 5, 1, 24.99, 'One Size'),
(21, 12, 7, 1, 19.99, 'S'),
(22, 13, 8, 1, 299.99, 'One Size'),
(23, 13, 14, 1, 24.99, 'One Size'),
(24, 14, 9, 1, 129.99, 'One Size'),
(25, 15, 17, 1, 44.99, 'One Size'),
(26, 16, 2, 1, 89.99, '9'),
(27, 18, 27, 1, 44.99, 'One Size');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` varchar(50) DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `payment_status`, `amount`, `transaction_id`, `payment_date`) VALUES
(1, 1, 'Credit Card', 'completed', 119.96, 'TXN_1780035815_2038', '2026-05-29 06:23:35'),
(2, 1, 'Credit Card', 'completed', 149.98, 'TXN_AMIT001', '2026-05-29 06:33:53'),
(3, 2, 'UPI', 'completed', 79.99, 'TXN_AMIT002', '2026-05-29 06:33:53'),
(4, 3, 'Debit Card', 'completed', 45.99, 'TXN_PRIYA001', '2026-05-29 06:33:53'),
(5, 4, 'Credit Card', 'completed', 129.99, 'TXN_SAYAN001', '2026-05-29 06:33:53'),
(6, 5, 'UPI', 'pending', 89.99, 'TXN_RIYA001', '2026-05-29 06:33:53'),
(7, 6, 'Credit Card', 'completed', 299.99, 'TXN_ARINDAM001', '2026-05-29 06:33:53'),
(8, 7, 'Credit Card', 'completed', 124.97, 'TXN_OD7', '2026-05-29 06:36:23'),
(9, 8, 'UPI', 'completed', 69.99, 'TXN_OD8', '2026-05-29 06:36:23'),
(10, 9, 'Debit Card', 'completed', 179.98, 'TXN_OD9', '2026-05-29 06:36:23'),
(11, 10, 'Credit Card', 'completed', 54.99, 'TXN_OD10', '2026-05-29 06:36:23'),
(12, 11, 'UPI', 'completed', 89.99, 'TXN_OD11', '2026-05-29 06:36:23'),
(13, 12, 'Credit Card', 'completed', 194.96, 'TXN_OD12', '2026-05-29 06:36:23'),
(14, 13, 'Debit Card', 'completed', 324.98, 'TXN_OD13', '2026-05-29 06:36:23'),
(15, 14, 'UPI', 'completed', 129.99, 'TXN_OD14', '2026-05-29 06:36:23'),
(16, 15, 'Credit Card', 'pending', 44.99, 'TXN_OD15', '2026-05-29 06:36:23'),
(17, 16, 'UPI', 'completed', 89.99, 'TXN_OD16', '2026-05-29 06:36:23'),
(18, 18, 'Credit Card', 'completed', 44.99, 'TXN_1780041674_3901', '2026-05-29 08:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `sizes` varchar(100) DEFAULT 'S,M,L,XL',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `price`, `stock_quantity`, `description`, `image_url`, `sizes`, `created_at`) VALUES
(1, 'FireStorm Hoodie', 'Clothing', 59.99, 50, 'Premium cotton hoodie with flame design. Perfect for cold evenings.', 'hoodie.jpg', 'S,M,L,XL,XXL', '2026-05-29 06:19:58'),
(2, 'Blaze Running Shoes', 'Footwear', 89.99, 30, 'Lightweight running shoes with fire-red accents.', 'shoes.jpg', '7,8,9,10,11', '2026-05-29 06:19:58'),
(3, 'Inferno Backpack', 'Accessories', 45.99, 100, 'Durable backpack with heat-resistant material.', 'backpack.jpg', 'One Size', '2026-05-29 06:19:58'),
(4, 'Flame Wireless Earbuds', 'Electronics', 79.99, 75, 'High-quality sound with fire-inspired design.', 'earbuds.jpg', 'One Size', '2026-05-29 06:19:58'),
(5, 'Ember Mug', 'Home', 24.99, 200, 'Temperature control mug keeps your drink hot.', 'mug.jpg', 'One Size', '2026-05-29 06:19:58'),
(6, 'Phoenix T-Shirt', 'Clothing', 29.99, 146, 'Soft cotton t-shirt with phoenix graphic.', 'tshirt.jpg', 'S,M,L,XL', '2026-05-29 06:19:58'),
(7, 'Heat Gloves', 'Accessories', 19.99, 80, 'Warm thermal gloves for winter.', 'gloves.jpg', 'S,M,L', '2026-05-29 06:19:58'),
(8, 'FireFly Drone', 'Electronics', 299.99, 15, 'Mini drone with LED lights.', 'drone.jpg', 'One Size', '2026-05-29 06:19:58'),
(9, 'Viral Flame Hoodie', 'Clothing', 69.99, 45, 'The hoodie that broke TikTok. Fire gradient with embroidered flame. \"Main character energy.\"', 'flame_hoodie.jpg', 'S,M,L,XL,XXL', '2026-05-29 06:25:39'),
(10, 'Y2K Ember Cargos', 'Clothing', 59.99, 30, 'Baggy cargo pants with subtle ember pattern. Side pockets for phone & wallet. Gen Z essential.', 'cargos.jpg', 'XS,S,M,L,XL', '2026-05-29 06:25:39'),
(11, 'Glow-in-Dark Phoenix Tee', 'Clothing', 34.99, 80, '100% cotton tee with phoenix graphic that glows at raves & parties.', 'phoenix_tee.jpg', 'S,M,L,XL', '2026-05-29 06:25:39'),
(12, 'Heatwave Mesh Top', 'Clothing', 29.99, 60, 'Breathable mesh top for festivals. Fire print under blacklight. Unisex.', 'mesh_top.jpg', 'S,M,L', '2026-05-29 06:25:39'),
(13, 'Campfire Quarter-Zip', 'Clothing', 54.99, 40, 'Cozy sherpa quarter-zip with campfire patch. Perfect for coffee shop hangs.', 'quarter_zip.jpg', 'S,M,L,XL,XXL', '2026-05-29 06:25:39'),
(14, 'Inferno Slides', 'Footwear', 29.99, 120, 'Cloud-soft slides with flame strap. Indoor/outdoor. \"Slides SZN\"', 'slides.jpg', '6,7,8,9,10,11,12', '2026-05-29 06:25:39'),
(15, 'Firestorm Boots', 'Footwear', 119.99, 25, 'Waterproof combat boots with red-hot sole. Urban explorer approved.', 'boots.jpg', '7,8,9,10,11,12', '2026-05-29 06:25:39'),
(16, 'Ember Sneakers', 'Footwear', 79.99, 50, 'Low-top sneakers with orange-glow laces. Reflective fire stripe.', 'ember_sneakers.jpg', '7,8,9,10,11', '2026-05-29 06:25:39'),
(17, 'FireBuds Pro', 'Electronics', 129.99, 60, 'Noise-cancelling earbuds with fire equalizer app. 30hr battery. \"Lit audio\"', 'firebuds.jpg', 'One Size', '2026-05-29 06:25:39'),
(18, 'Flame RGB Keyboard', 'Electronics', 89.99, 35, 'Mechanical keyboard with 16.8M colors. Fire wave effect. Hot-swappable.', 'keyboard.jpg', 'One Size', '2026-05-29 06:25:39'),
(19, 'Inferno Power Bank', 'Electronics', 39.99, 150, '20,000mAh with digital flame display. Charges 3 devices at once.', 'powerbank.jpg', 'One Size', '2026-05-29 06:25:39'),
(20, 'Flame Chain Necklace', 'Accessories', 24.99, 100, 'Stainless steel chain with flame pendant. Iced out.', 'necklace.jpg', 'One Size', '2026-05-29 06:25:39'),
(21, 'Ember Beanie', 'Accessories', 19.99, 85, 'Ribbed beanie with embroidered ember. One size fits most.', 'beanie.jpg', 'One Size', '2026-05-29 06:25:39'),
(22, 'Fire Socks (3-pack)', 'Accessories', 15.99, 200, 'Cotton blend crew socks with flame graphics. \"Hot feet\" collection.', 'socks.jpg', 'One Size', '2026-05-29 06:25:39'),
(23, 'Heatwave Sunglasses', 'Accessories', 34.99, 70, 'Polarized shades with orange-tinted lenses. UV400 protection.', 'sunglasses.jpg', 'One Size', '2026-05-29 06:25:39'),
(24, 'Flame Phone Grip', 'Accessories', 9.99, 300, 'Pop-socket style grip with fire design. MagSafe compatible.', 'phone_grip.jpg', 'One Size', '2026-05-29 06:25:39'),
(25, 'Firefly Lamp', 'Home', 49.99, 40, 'LED lamp with flickering flame effect. Rechargeable. 8hr runtime.', 'lamp.jpg', 'One Size', '2026-05-29 06:25:39'),
(26, 'Ember Coaster Set', 'Home', 12.99, 150, 'Set of 4 heat-resistant coasters with ember design. Silicone.', 'coasters.jpg', 'One Size', '2026-05-29 06:25:39'),
(27, 'Flame Throw Blanket', 'Home', 19.99, 50, 'Sherpa fleece blanket with fire pattern. Extra warm.', 'blanket.jpg', 'One Size', '2026-05-29 06:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `customer_id`, `rating`, `comment`, `created_at`) VALUES
(4, 23, 1, 4, 'super cool, best glasses in this price ;)', '2026-05-29 06:28:41'),
(5, 1, 2, 5, 'Dada darun hoodie! Ar ekta nilam. Very warm and stylish.', '2026-05-29 06:32:04'),
(6, 1, 3, 4, 'Good quality but size runs a bit small. Go one size up.', '2026-05-29 06:32:04'),
(7, 1, 5, 5, '🔥🔥🔥 Best hoodie for winter evenings in Kolkata.', '2026-05-29 06:32:04'),
(8, 1, 7, 4, 'My son loves it. Delivery was fast.', '2026-05-29 06:32:04'),
(9, 2, 2, 5, 'Perfect for morning walks in the park. Lightweight and looks great.', '2026-05-29 06:32:04'),
(10, 2, 4, 4, 'Comfortable shoes. Would be 5 star if price was a bit lower.', '2026-05-29 06:32:04'),
(11, 2, 6, 5, 'Ekdum joss! Very bhalo quality.', '2026-05-29 06:32:04'),
(12, 2, 8, 5, 'Bought for my husband – he wears them daily.', '2026-05-29 06:32:04'),
(13, 2, 9, 4, 'Good grip, but sizing is off by half.', '2026-05-29 06:32:04'),
(14, 3, 3, 5, 'College bag er jonno perfect. Onek compartment ache.', '2026-05-29 06:32:04'),
(15, 3, 5, 4, 'Stylish and durable. Zippers are strong.', '2026-05-29 06:32:04'),
(16, 3, 7, 5, 'Use this for trekking – waterproof and light.', '2026-05-29 06:32:04'),
(17, 3, 2, 5, 'Ami toh onek din khujchilam emon bag. Finally peyechi.', '2026-05-29 06:32:04'),
(18, 4, 4, 5, 'Battery lasts long, sound quality is amazing. Fire theme looks cool.', '2026-05-29 06:32:04'),
(19, 4, 6, 4, 'Good for the price. Mic could be better.', '2026-05-29 06:32:04'),
(20, 4, 8, 5, 'Best earbuds under 100$. Bass is punchy.', '2026-05-29 06:32:04'),
(21, 4, 1, 5, 'I use them while coding – no disturbance.', '2026-05-29 06:32:04'),
(22, 4, 9, 4, 'Fits well, but case is a bit bulky.', '2026-05-29 06:32:04'),
(23, 5, 3, 5, 'Cha garam thake bohu kshon. Office er jonno darun.', '2026-05-29 06:32:04'),
(24, 5, 5, 4, 'Great gift idea. Keeps coffee warm for hours.', '2026-05-29 06:32:04'),
(25, 5, 7, 5, 'Winter er jonno best invention.', '2026-05-29 06:32:04'),
(26, 5, 2, 5, 'I love this mug. Even my dad uses it now.', '2026-05-29 06:32:04'),
(27, 6, 1, 5, 'Soft cotton, print doesn’t fade. Going to buy more colours.', '2026-05-29 06:32:04'),
(28, 6, 4, 4, 'Cool design. Fits perfectly.', '2026-05-29 06:32:04'),
(29, 6, 6, 5, 'Tee ta darun lagche. Ami festival e porchi.', '2026-05-29 06:32:04'),
(30, 6, 8, 5, 'My favourite casual t‑shirt now.', '2026-05-29 06:32:04'),
(31, 7, 9, 5, 'Morning ride er jonno perfect. Gloves ta khub garam rakhe.', '2026-05-29 06:32:04'),
(32, 7, 2, 4, 'Good for winter, but touchscreen support could be better.', '2026-05-29 06:32:04'),
(33, 7, 5, 5, 'Small size fits my hands well.', '2026-05-29 06:32:04'),
(34, 7, 7, 5, 'Exactly as described. Fast shipping.', '2026-05-29 06:32:04'),
(35, 8, 3, 5, 'Ekdum bhalo drone! Stable flight, camera quality is decent.', '2026-05-29 06:32:04'),
(36, 8, 6, 4, 'Fun toy for kids. Battery life is okay.', '2026-05-29 06:32:04'),
(37, 8, 9, 5, 'Beginner friendly. Easy to control.', '2026-05-29 06:32:04'),
(38, 8, 1, 5, 'I use it for hobby photography. Worth the price.', '2026-05-29 06:32:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
