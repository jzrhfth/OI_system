<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .admin-header {
            background-color: #ffffff;
            height: 64px;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-container {
            position: relative;
            display: none;
        }

        @media (min-width: 768px) {
            .search-container {
                display: block;
            }
        }

        .search-input {
            padding: 8px 16px 8px 36px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
            font-size: 14px;
            width: 240px;
            transition: all 0.2s ease;
            outline: none;
            color: #333;
        }

        .search-input:focus {
            background-color: #ffffff;
            border-color: #4A90E2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 14px;
        }

        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 18px;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-btn:hover {
            background-color: #f0f2f5;
            color: #333;
        }

        .notification-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            background-color: #ff4444;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        .user-profile:hover {
            background-color: #f0f2f5;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background-color: #4A90E2;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info {
            display: none;
            flex-direction: column;
        }

        @media (min-width: 768px) {
            .user-info {
                display: flex;
            }
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .user-role {
            font-size: 11px;
            color: #999;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <button class="icon-btn" style="margin-right: 8px;">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h2 class="header-title">Dashboard</h2>
        </div>

        <div class="header-right">
            <div class="search-container">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" class="search-input" placeholder="Search...">
            </div>

            <button class="icon-btn" title="Notifications">
                <i class="fa-regular fa-bell"></i>
                <span class="notification-badge"></span>
            </button>

            <button class="icon-btn" title="Settings">
                <i class="fa-solid fa-gear"></i>
            </button>

            <div class="user-profile">
                <div class="user-avatar">AD</div>
                <div class="user-info">
                    <span class="user-name">Admin User</span>
                    <span class="user-role">Administrator</span>
                </div>
                <i class="fa-solid fa-chevron-down" style="font-size: 12px; color: #999; margin-left: 4px;"></i>
            </div>
        </div>
    </header>
</body>
</html>