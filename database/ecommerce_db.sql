-- SQL for ecommerce_db
CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

-- Users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  price DECIMAL(10,2),
  image_url VARCHAR(255)
);

-- Orders
CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total_price DECIMAL(10,2),
  status VARCHAR(50) DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order items
CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  quantity INT,
  price DECIMAL(10,2)
);

-- Admins (simple)
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  password VARCHAR(255)
);

-- Sample admin
INSERT INTO admins (username, password) VALUES ('admin', MD5('admin123'));

-- Sample products
INSERT INTO products (name, price, image_url) VALUES
('Wireless Headphones', 2500.00, 'https://via.placeholder.com/200?text=Headphones'),
('Smart Watch', 4000.00, 'https://via.placeholder.com/200?text=Smart+Watch'),
('Laptop Bag', 1500.00, 'https://via.placeholder.com/200?text=Laptop+Bag'),
('Bluetooth Speaker', 3000.00, 'https://via.placeholder.com/200?text=Speaker');
