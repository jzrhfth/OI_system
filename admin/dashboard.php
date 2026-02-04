<?php
session_start();
include('includes/dbconnection.php');
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}
$page_title = "Dashboard";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Office Supplies System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Sora:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* Ensure main content is positioned correctly with fixed sidebar */
        .main-content {
            margin-left: 240px;
            padding: 24px;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body> 
    <?php include_once 'includes/sidebar.php'; ?>
    <?php include_once 'includes/header.php'; ?>

    <main class="main-content">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard Overview</h1>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Requests</div>
                <div class="stat-value"></div>
                <div class="stat-change positive"></div>
                <i class="fa-solid fa-file-invoice stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending Approval</div>
                <div class="stat-value"></div>
                <div class="stat-change negative"></div>
                <i class="fa-solid fa-clock stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">Approved</div>
                <div class="stat-value"></div>
                <div class="stat-change positive"></div>
                <i class="fa-solid fa-check-circle stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">Low Stock Items</div>
                <div class="stat-value"></div>
                <div class="stat-change negative"></div>
                <i class="fa-solid fa-triangle-exclamation stat-icon-bg"></i>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <h2 class="chart-title">Requests Overview</h2>
                </div>
                <div class="chart-container">
                    <canvas id="requestsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Requests Table -->
        <div class="tables-grid">
            <div class="table-card">
                <div class="table-title">
                    <span>Recent Requests</span>
                </div>
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
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Requests Chart
        const requestsCtx = document.getElementById('requestsChart').getContext('2d');
        new Chart(requestsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Requests',
                    data: [],
                    borderColor: '#4169e1',
                    backgroundColor: 'rgba(65, 105, 225, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 0,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f0f0f0', drawBorder: false } },
                    x: { grid: { display: false, drawBorder: false } }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });

        // Department Chart
        // Check if element exists before initializing to prevent errors
        const deptChartEl = document.getElementById('deptChart');
        if (deptChartEl) {
            const deptCtx = deptChartEl.getContext('2d');
            new Chart(deptCtx, {
                type: 'doughnut',
                data: {
                    labels: ['IT', 'HR', 'Ops', 'Finance'],
                    datasets: [{
                        data: [45, 25, 20, 10],
                        backgroundColor: ['#4169e1', '#ef4444', '#10b981', '#f59e0b'],
                        borderWidth: 0,
                        spacing: 2
                    }]
                },  
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } }
                }
            });
        }
    </script>
</body>
</html>