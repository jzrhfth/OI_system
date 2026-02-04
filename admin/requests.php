<?php
session_start();
include('includes/dbconnection.php');
$page_title = "All Requests";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Requests - Office Supplies System</title>
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
            <h1 class="dashboard-title">All Requests</h1>
        </div>

        <!-- Requests Table -->
        <div class="tables-grid">
            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>MRS No.</th>
                            <th>Date</th>
                            <th>Department</th>
                            <th>Requested By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </main>
</body>
</html>