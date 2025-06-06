<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistem Informasi Peminjaman dan Pengembalian Barang">
    <meta name="author" content="Rifky">

    <title>@yield('title', 'Dashboard Admin')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts - Admin Standard Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- FontAwesome (opsional tambahan ikon) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            /* Modern Admin Color Palette */
            --primary-color: #2563eb;
            --primary-light: #3b82f6;
            --primary-dark: #1d4ed8;
            --primary-hover: #1e40af;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;

            /* Neutral Colors */
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;

            /* Layout */
            --sidebar-width: 280px;
            --sidebar-collapsed: 70px;
            --transition-speed: 0.3s;
            --border-radius: 0.75rem;
            --border-radius-sm: 0.5rem;
            --border-radius-lg: 1rem;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            box-sizing: border-box;
        }

        html {
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
            font-variation-settings: normal;
            min-height: 100vh;
            background-color: var(--gray-50);
            margin: 0;
            line-height: 1.6;
            color: var(--gray-700);
            font-weight: 400;
            letter-spacing: -0.01em;
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(145deg, var(--gray-900) 0%, var(--gray-800) 100%);
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: all var(--transition-speed) ease;
            z-index: 1050;
            box-shadow: var(--shadow-xl);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
            border-right: 1px solid var(--gray-700);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 1.5rem 1.2rem 1rem;
            text-align: center;
            position: relative;
        }

        .sidebar-logo {
            font-weight: 800;
            font-size: 1.5rem;
            color: white;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .sidebar-logo i {
            color: #60a5fa;
            margin-right: 0.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 1rem 1.2rem;
            margin-bottom: 0.5rem;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.08);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 600;
            margin-right: 10px;
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        .user-info {
            line-height: 1.2;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .menu-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            padding: 1.2rem 1.5rem 0.5rem;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            padding: 0 1rem;
            margin-bottom: 1rem;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 0.3rem;
            transition: all var(--transition-speed) ease;
            font-weight: 500;
            position: relative;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }

        .sidebar a.active {
            background-color: var(--primary-hover);
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: white;
            border-radius: 0 4px 4px 0;
        }

        .sidebar i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            transition: all var(--transition-speed) ease;
        }

        .sidebar a:hover i {
            transform: scale(1.1);
        }

        .sidebar-divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
            margin: 0.8rem 1rem;
            opacity: 0.5;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            transition: margin-left var(--transition-speed) ease;
            min-height: 100vh;
            background-color: var(--gray-50);
            width: calc(100% - var(--sidebar-width));
            max-width: calc(100vw - var(--sidebar-width));
            overflow-x: hidden;
            box-sizing: border-box;
        }

        /* Modern Card Styles */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: all var(--transition-speed) ease;
            background: white;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--gray-50), white);
            border-bottom: 1px solid var(--gray-200);
            padding: 1.5rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Modern Button Styles */
        .btn {
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all var(--transition-speed) ease;
            border: none;
            font-size: 0.875rem;
            letter-spacing: 0.025em;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        /* Modern Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--gray-800);
            font-weight: 600;
            letter-spacing: -0.025em;
        }

        .text-muted {
            color: var(--gray-500) !important;
        }

        /* Modern Badge Styles */
        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: var(--border-radius-sm);
            font-size: 0.75rem;
            letter-spacing: 0.025em;
        }

        .navbar {
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) ease;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            width: calc(100% - var(--sidebar-width));
            max-width: calc(100vw - var(--sidebar-width));
        }

        .navbar-brand {
            font-weight: 600;
        }

        .btn-toggle-sidebar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background-color: #f0f5ff;
            color: var(--primary-color);
            transition: all 0.2s ease;
        }

        .btn-toggle-sidebar:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .logout-link {
            margin-top: 2rem;
            background-color: rgba(255, 59, 48, 0.15);
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .logout-link:hover {
            background-color: rgba(255, 59, 48, 0.3);
        }

        .logout-link i {
            color: rgba(255, 110, 100, 0.9);
        }

        /* Responsive untuk mobile */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            }

            .main-content,
            .navbar {
                margin-left: 0;
                width: 100%;
                max-width: 100vw;
                padding: 1rem;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .overlay.show {
                opacity: 1;
                visibility: visible;
            }
        }

        /* Responsive untuk tablet */
        @media (max-width: 1200px) {
            .main-content {
                padding: 1rem;
            }
        }

        /* Fix untuk overflow horizontal */
        body {
            overflow-x: hidden;
        }

        .container-fluid {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Ensure all Bootstrap components are responsive */
        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col-lg-8,
        .col-lg-4,
        .col-md-6,
        .col-md-4 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        /* Mobile specific fixes */
        @media (max-width: 992px) {
            .navbar {
                width: 100% !important;
                max-width: 100vw !important;
                margin-left: 0 !important;
            }

            .main-content {
                width: 100% !important;
                max-width: 100vw !important;
                margin-left: 0 !important;
                padding-top: 80px;
                /* Space for mobile navbar */
            }

            .sidebar {
                width: 280px !important;
                top: 0;
            }
        }

        @media (max-width: 576px) {
            .d-flex.gap-3 {
                gap: 0.5rem !important;
            }

            .badge {
                font-size: 0.7rem !important;
                padding: 0.4rem 0.6rem !important;
            }

            .main-content {
                padding-top: 70px !important;
                /* Reduced for smaller screens */
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Mobile Navbar -->
    <nav class="navbar navbar-expand-lg d-lg-none py-2 px-3 fixed-top">
        <div class="container-fluid px-0">
            <a class="navbar-brand" href="#">Sisfo-Sarpas</a>
            <button class="btn-toggle-sidebar" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Overlay -->
    <div class="overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
            </div>
            <i class="text-white fst-normal fw-bold">Sisfo-Sarpas</i>
        </div>

        <!-- User Profile Section -->
        <div class="user-profile">
            <div class="user-avatar">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>

        <!-- Dashboard Section -->
        <div class="menu-category">Dashboard</div>
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </div>

        <!-- Data Master Section -->
        <div class="menu-category">Data Master</div>
        <div class="sidebar-menu">
            <a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <i class="bi bi-person"></i> User
            </a>
            <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
            <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Data Barang
            </a>
        </div>

        <!-- Transaksi Section -->
        <div class="menu-category">Transaksi</div>
        <div class="sidebar-menu">
            <a href="{{ route('admin.peminjaman.index') }}"
                class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i> Peminjaman
            </a>
            <a href="{{ route('admin.pengembalian.index') }}"
                class="{{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-return-left"></i> Pengembalian
            </a>
        </div>

        <!-- Laporan Section -->
        <div class="menu-category">Laporan</div>
        <div class="sidebar-menu">
            <a href="{{ route('laporan.peminjaman') }}"
                class="{{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Peminjaman
            </a>
            <a href="{{ route('laporan.pengembalian') }}"
                class="{{ request()->routeIs('laporan.pengembalian') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-check"></i> Pengembalian
            </a>
            <a href="{{ route('laporan.stok') }}" class="{{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
                <i class="bi bi-boxes"></i> Stok Barang
            </a>
        </div>

        <div class="sidebar-divider"></div>

        <!-- Logout Link with special styling -->
        <div class="sidebar-menu">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    @stack('scripts')

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const mainContent = document.querySelector('.main-content');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            toggleBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking on links (on mobile)
            const sidebarLinks = sidebar.querySelectorAll('a');
            if (window.innerWidth <= 992) {
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                    });
                });
            }
        });
    </script>

</body>

</html>
