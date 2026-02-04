    <style>
        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: #ffffff;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 70px;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar .nav {
            list-style-type: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .sidebar .nav-item {
            margin-bottom: 5px;
            padding: 0 15px;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            color: #5f6368;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
            color: #333;
        }

        .sidebar .nav-item.active > .nav-link {
            background-color: #7c8cf5;
            color: white;
        }

        .sidebar .nav-item.active > .nav-link .nav-icon i,
        .sidebar .nav-item.active > .nav-link .menu-arrow {
            color: white;
        }

        .sidebar .nav-icon {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        .sidebar .menu-title {
            flex-grow: 1;
        }

        /* Submenu Styles */
        .sidebar .nav-item .submenu {
            display: none;
            padding-left: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
            background: #fff;
        }

        .sidebar .nav-item.active .submenu {
            display: block;
            max-height: 500px;
        }

        .sidebar .nav-item .submenu-item {
            list-style: none;
            padding: 5px 0 5px 0;
        }

        .sidebar .nav-item .submenu-item li a {
            padding: 8px 15px 8px 45px; /* Indented */
            display: block;
            color: #6c757d;
            font-size: 13px;
            text-decoration: none;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-item .submenu-item li a i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 12px;
        }

        .sidebar .nav-item .submenu-item li a:hover,
        .sidebar .nav-item .submenu-item li a.active {
            color: #7c8cf5;
            background: #f0f2ff;
        }

        .sidebar .nav-item .nav-link .menu-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
            font-size: 12px;
        }

        .sidebar .nav-item.active > .nav-link .menu-arrow {
            transform: rotate(180deg);
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .d-none {
            display: none;
        }
        
        /* Mobile styles adaptation */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
    <aside class="sidebar" id="sidebar">
        <ul class="nav">
            <li class="nav-item" data-page="dashboard.php">
                <a class="nav-link" href="dashboard.php">
                    <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item" data-page="inventory.php">
                <a class="nav-link" href="inventory.php">
                    <span class="nav-icon"><i class="fas fa-boxes"></i></span>
                    <span class="menu-title">Inventory</span>
                </a>
            </li>

            <li class="nav-item" data-page="requests.php">
                <a class="nav-link" href="requests.php">
                    <span class="nav-icon"><i class="fas fa-file-invoice"></i></span>
                    <span class="menu-title">Requests</span>
                </a>
            </li>

            <li class="nav-item has-submenu" data-page="profile.php change-password.php">
                <a class="nav-link" href="#">
                    <span class="nav-icon"><i class="fas fa-cog"></i></span>
                    <span class="menu-title">Settings</span>
                    <i class="fas fa-chevron-down menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li><a href="profile.php"><i class="fas fa-user"></i> My Profile</a></li>
                        <li><a href="change-password.php"><i class="fas fa-key"></i> Change Password</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item" data-page="logout.php">
                <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to log out?');">
                    <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="menu-title">Log Out</span>
                </a>
            </li>
        </ul>
    </aside>
    <div class="sidebar-overlay d-none" id="sidebarOverlay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = "<?php echo basename($_SERVER['PHP_SELF']); ?>";
            const navItems = document.querySelectorAll('.sidebar .nav-item');
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.mobile-nav-toggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Function to open a submenu
            function openSubmenu(submenu) {
                if (submenu) {
                    submenu.style.maxHeight = submenu.scrollHeight + "px";
                }
            }

            // Function to close a submenu
            function closeSubmenu(submenu) {
                if (submenu) {
                    submenu.style.maxHeight = '0';
                }
            }

            // Set active state for the current page
            navItems.forEach(item => {
                const pages = item.getAttribute('data-page');
                if (pages && pages.split(' ').includes(currentPage)) {
                    item.classList.add('active');
                    // If the active item is in a submenu, also open the submenu
                    if (item.closest('.submenu')) {
                        const parentLi = item.closest('.has-submenu');
                        if (parentLi) {
                            parentLi.classList.add('active');
                            openSubmenu(parentLi.querySelector('.submenu'));
                        }
                    } else if (item.classList.contains('has-submenu')) {
                        openSubmenu(item.querySelector('.submenu'));
                    }
                }
            });

            // Dropdown functionality
            const submenuLinks = document.querySelectorAll('.sidebar .nav-item.has-submenu > a');
            submenuLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const parentLi = this.closest('.has-submenu');
                    parentLi.classList.toggle('active');
                    
                    // Ensure smooth transition by explicitly setting height
                    const submenu = parentLi.querySelector('.submenu');
                    if (parentLi.classList.contains('active')) {
                        openSubmenu(submenu);
                    } else {
                        closeSubmenu(submenu);
                    }
                });
            });

            // Sidebar toggle for mobile
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.add('open');
                    sidebarOverlay.classList.remove('d-none');
                });
            }

            // Close sidebar when overlay is clicked
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    this.classList.add('d-none');
                });
            }
        });
    </script>