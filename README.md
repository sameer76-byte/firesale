# 🔥 Fire Sale – E-Commerce Management System

Fire Sale is a fully functional e-commerce web application designed for fire-themed merchandise. It features a complete product catalog, advanced search/filters, a live shopping cart, secure checkout options, order tracking, product reviews, and an admin dashboard with sales analytics.

## ✨ Features

### User Side
- **Product Catalog:** Built-in search, category/price filters, sorting, and pagination.
- **Product Details:** Size selection, interactive image zoom, and dynamic stock status.
- **Shopping Cart:** Session-based, asynchronous shopping cart using AJAX (add/remove items smoothly).
- **Checkout:** Streamlined guest checkout and registered user checkout flows.
- **Authentication:** Secure user registration & login system featuring hashed passwords.
- **Order Tracking:** Visual status timeline showing order progress from processing to delivered.
- **Reviews:** Interactive product review system with star ratings.

### Admin Side
- **Secure Authentication:** Protected admin-only login gateway.
- **Sales Analytics:** Interactive dashboard visualising the last 7 days of sales using Chart.js.
- **Product Management:** Complete CRUD functionality for inventory, including multi-format image uploads.
- **Order Management:** Real-time updates for order statuses and courier tracking numbers.
- **User Management:** Secure administrative interface to view or remove customer accounts.
- **Moderation Tools:** Ability to audit and delete inappropriate or spam product reviews.

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript (jQuery, Chart.js)
- **Backend:** PHP 7.4+ (Procedural architecture, Session-based state management)
- **Database:** MySQL (InnoDB engine, 7 relational tables)
- **Environment:** Apache HTTP Server via XAMPP

## 📁 Project Structure

```text
firesale/
├── index.php, shop.php, product.php, cart.php, checkout.php
├── account.php, login.php, register.php
├── order_detail.php, order_success.php, sidebar.php
├── config/                  # Database configuration files
├── includes/                # Global layout components (header, footer, etc.)
├── api/                     # Backend AJAX processing endpoints
├── assets/                  # CSS stylesheets, JS scripts, and uploaded media
└── ecommerce_database.sql   # Complete database schema and layout
```

## 🚀 Installation

1. **Install XAMPP** and start Apache & MySQL.
2. Clone this repository into `C:\xampp\htdocs\firesale\`.
3. Open phpMyAdmin, create database `firesale`.
4. Import `sql/firesale.sql`.
5. Update `includes/config.php` if needed (default: root, no password).
6. Access `http://localhost/firesale/`.

## 🔐 Default Admin Login

- **URL:** `http://localhost/firesale/admin/login.php`
- **Username:** `admin`
- **Password:** `password`

## 👥 Sample Customer Login

- Email: `john@example.com`
- Password: `password123`

## 📸 Screenshots

| Homepage | Admin Dashboard |
|----------|----------------|
| ![Homepage](screenshots/homepage.png) | ![Admin Dashboard](screenshots/admin_dashboard.png) |

*(Add your own screenshots in a `screenshots/` folder.)*

## 📄 License

This project is for educational purposes. Free to use and modify.

## 👨‍💻 Authors

- Sameer Prasad
