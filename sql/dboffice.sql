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

INSERT INTO departments (name) VALUES
  ('IT Department'),
  ('Human Resources'),
  ('Operations'),
  ('Finance');

-- Categories
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT INTO categories (name) VALUES
  ('Paper Products'),
  ('Writing Instruments'),
  ('Desk Accessories'),
  ('Printer Supplies'),
  ('Meeting Supplies');

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

-- Sample items from attachments
INSERT INTO items (name, category_id, stock_quantity, reorder_level, status) VALUES
  ('A4 Paper Ream (500 Sheets)', 1, 120, 50, 'In Stock'),
  ('Black Ballpoint Pens (Box of 50)', 2, 45, 50, 'Low Stock'),
  ('Stapler, Standard Size', 3, 30, 20, 'In Stock'),
  ('Toner Cartridge (HP LaserJet)', 4, 5, 10, 'Low Stock'),
  ('Whiteboard Markers (4-Pack)', 5, 0, 15, 'Out of Stock');

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

INSERT INTO users (username, full_name, department_id, email, role) VALUES
  ('ajohnson', 'Alex Johnson', 1, 'alex.johnson@example.com', 'staff'),
  ('ssmith', 'Sarah Smith', 2, 'sarah.smith@example.com', 'staff'),
  ('mbrown', 'Mike Brown', 3, 'mike.brown@example.com', 'staff'),
  ('edavis', 'Emily Davis', 4, 'emily.davis@example.com', 'staff');

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

-- Sample requests from attachments
INSERT INTO requests (mrs_no, request_date, department_id, requested_by_user_id, status) VALUES
  ('MRS-2026-005', '2025-10-24', 1, 1, 'Pending'),
  ('MRS-2026-004', '2025-10-23', 2, 2, 'Approved'),
  ('MRS-2026-003', '2025-10-22', 3, 3, 'Approved'),
  ('MRS-2026-002', '2025-10-21', 4, 4, 'Rejected');

-- Request items (line items for each MRS)
CREATE TABLE request_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  request_id INT NOT NULL,
  item_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE,
  FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Example request items (optional starter data)
INSERT INTO request_items (request_id, item_id, quantity) VALUES
  (1, 4, 2), -- MRS-2026-005 requests 2 Toner Cartridges
  (2, 5, 4), -- MRS-2026-004 requests 4 Whiteboard Marker packs
  (3, 3, 1), -- MRS-2026-003 requests 1 Stapler
  (4, 2, 10); -- MRS-2026-002 requests 10 Ballpoint Pens

-- Indexes for performance
CREATE INDEX idx_items_category ON items(category_id);
CREATE INDEX idx_requests_dept ON requests(department_id);

-- End of schema
