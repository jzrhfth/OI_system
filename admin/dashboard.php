<?php
session_start();
include('includes/dbconnection.php');
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
                <div class="stat-value">152</div>
                <div class="stat-change positive">▲ 12.5%</div>
                <i class="fa-solid fa-file-invoice stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending Approval</div>
                <div class="stat-value">12</div>
                <div class="stat-change negative">▼ 2.1%</div>
                <i class="fa-solid fa-clock stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">Approved</div>
                <div class="stat-value">135</div>
                <div class="stat-change positive">▲ 8.4%</div>
                <i class="fa-solid fa-check-circle stat-icon-bg"></i>
            </div>
            <div class="stat-card">
                <div class="stat-label">Low Stock Items</div>
                <div class="stat-value">4</div>
                <div class="stat-change negative">▼ 1 item</div>
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
                    <a href="requests.php" class="btn-new"><i class="fa-solid fa-plus"></i> Create New</a>
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
                        <tr>
                            <td>MRS-2026-005</td>
                            <td>Oct 24, 2025</td>
                            <td style="font-weight: 600;">IT Department</td>
                            <td>Alex Johnson</td>
                            <td><span class="status-badge pending">Pending</span></td>
                            <td><a href="#" style="color: #3498db;"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                        <tr>
                            <td>MRS-2026-004</td>
                            <td>Oct 23, 2025</td>
                            <td style="font-weight: 600;">Human Resources</td>
                            <td>Sarah Smith</td>
                            <td><span class="status-badge approved">Approved</span></td>
                            <td><a href="#" style="color: #3498db;"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                        <tr>
                            <td>MRS-2026-003</td>
                            <td>Oct 22, 2025</td>
                            <td style="font-weight: 600;">Operations</td>
                            <td>Mike Brown</td>
                            <td><span class="status-badge approved">Approved</span></td>
                            <td><a href="#" style="color: #3498db;"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                        <tr>
                            <td>MRS-2026-002</td>
                            <td>Oct 21, 2025</td>
                            <td style="font-weight: 600;">Finance</td>
                            <td>Emily Davis</td>
                            <td><span class="status-badge approved">Approved</span></td>
                            <td><a href="#" style="color: #3498db;"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
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
                    data: [12, 19, 15, 25, 22, 30, 28, 35, 40, 45, 42, 50],
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