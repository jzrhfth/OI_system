<?php
session_start();
include('includes/dbconnection.php');
$page_title = "Inventory";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Office Supplies System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Sora:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .main-content { margin-left: 240px; padding: 24px; }
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/header.php'; ?>

    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Inventory Management</h1>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Items</div>
                <div class="stat-value"></div>
                <div class="stat-change positive"></div>
                <i class="fa-solid fa-boxes-stacked stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">In Stock</div>
                <div class="stat-value"></div>
                <div class="stat-change positive"></div>
                <i class="fa-solid fa-check-circle stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">Low Stock</div>
                <div class="stat-value"></div>
                <div class="stat-change negative"></div>
                <i class="fa-solid fa-triangle-exclamation stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">Out of Stock</div>
                <div class="stat-value"></div>
                <div class="stat-change negative"></div>
                <i class="fa-solid fa-circle-xmark stat-icon-bg"></i>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="tables-grid">
            <div class="table-card">
                <div class="table-title">
                    <span>All Office Supplies</span>
                    <a href="#" class="btn-new"><i class="fa-solid fa-plus"></i> Add New Item</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Stock Quantity</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add Item Modal -->
    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Add New Item</h3>
                <button class="modal-close" onclick="closeModal('addModal')"><i class="fa-solid fa-times"></i></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" placeholder="e.g. A4 Paper Ream" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select>
                            <option>Paper Products</option>
                            <option>Writing Instruments</option>
                            <option>Desk Accessories</option>
                            <option>Printer Supplies</option>
                            <option>Meeting Supplies</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stock Quantity</label>
                        <input type="number" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label>Reorder Level</label>
                        <input type="number" placeholder="10" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('addModal')">Cancel</button>
                    <button type="submit" class="btn-save">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal Functions
        function openModal(modalId) { document.getElementById(modalId).classList.add('active'); }
        function closeModal(modalId) { document.getElementById(modalId).classList.remove('active'); }

        // Event Listeners
        document.querySelector('.btn-new').addEventListener('click', function(e) {
            e.preventDefault();
            openModal('addModal');
        });

        document.querySelectorAll('a[title="Edit"]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                // In a real app, you'd fetch data for the specific item and populate the modal
                openModal('editModal'); // editModal is not in the provided HTML, but this is how it would work
            });
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.classList.remove('active');
            }
        }
    </script>
</body>
</html>