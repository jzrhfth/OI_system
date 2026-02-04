-- dboffice SQL schema and sample data
-- Drop and create database
DROP DATABASE IF EXISTS `dboffice`;
CREATE DATABASE `dboffice` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dboffice`;

-- Departments
CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Categories
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Items / Inventory
CREATE TABLE items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category_id INT,
  stock_quantity INT NOT NULL DEFAULT 0,
  reorder_level INT NOT NULL DEFAULT 0,
  status ENUM('In Stock','Low Stock','Out of Stock') NOT NULL DEFAULT 'In Stock',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Users (lightweight)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(80) NOT NULL UNIQUE,
  full_name VARCHAR(150) NOT NULL,
  department_id INT,
  email VARCHAR(150),
  role VARCHAR(50) DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Admins
CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO admin (username, password) VALUES
  ('admin', '0192023a7bbd73250516f069df18b500');

-- Requests (MRS)
CREATE TABLE requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mrs_no VARCHAR(50) NOT NULL UNIQUE,
  request_date DATE NOT NULL,
  department_id INT,
  requested_by_user_id INT,
  status ENUM('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
  FOREIGN KEY (requested_by_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Request items (line items for each MRS)
CREATE TABLE request_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  request_id INT NOT NULL,
  item_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE,
  FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Indexes for performance
CREATE INDEX idx_items_category ON items(category_id);
CREATE INDEX idx_requests_dept ON requests(department_id);

-- End of schema
