CREATE DATABASE restaurant_db;
USE restaurant_db;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','employee','customer') DEFAULT 'customer',
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    status ENUM('active','inactive') DEFAULT 'active'
);
CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    status ENUM('available','unavailable') DEFAULT 'available',
    FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE CASCADE
);
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    order_status ENUM('pending','preparing','completed','cancelled') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE,
    FOREIGN KEY (menu_id)
        REFERENCES menu(id)
        ON DELETE CASCADE
);
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    payment_method ENUM('cash','card','online') NOT NULL,
    payment_status ENUM('paid','unpaid') DEFAULT 'paid',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE
);
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    position VARCHAR(100),
    salary DECIMAL(10,2),
    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
UPDATE menu SET image='https://images.unsplash.com/photo-1600891964092-4316c288032e?auto=format&fit=crop&w=800&q=70' WHERE id=1;
UPDATE menu SET image='https://images.unsplash.com/photo-1498579150354-977475b7ea0b?auto=format&fit=crop&w=800&q=70' WHERE id=2;
UPDATE menu SET image='https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=70' WHERE id=3;
SELECT * FROM menu;