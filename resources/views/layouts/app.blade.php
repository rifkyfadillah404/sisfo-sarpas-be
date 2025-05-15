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

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome (opsional tambahan ikon) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-color: #f8f9fa;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #1e3a8a;
            color: white;
            padding: 1rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: transform 0.3s ease;
            z-index: 1050;
        }

        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: background-color 0.3s ease, color 0.3s ease;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-color: #3b82f6;
            color: white;
        }

        .sidebar a.active {
            background-color: #2563eb;
            color: white;
        }

        .sidebar i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 1rem 0;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        .navbar {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content,
            .navbar {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Navbar khusus mobile -->
    <nav class="navbar navbar-light bg-light d-md-none px-3">
        <button class="btn btn-outline-primary" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4 class="text-center">Sisfo-Sarpas</h4>
        <div class="sidebar-divider"></div>

        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.index') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori
        </a>
        <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.index') ? 'active' : '' }}">
            <i class="bi bi-box"></i> Data Barang
        </a>
        <div class="sidebar-divider"></div>
        <a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.index') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Peminjaman
        </a>
        <a href="{{ route('admin.pengembalian.index') }}" class="{{ request()->routeIs('admin.pengembalian.index') ? 'active' : '' }}">
            <i class="bi bi-arrow-return-left"></i> Pengembalian
        </a>
        <div class="sidebar-divider"></div>
        <a href="{{ route('laporan.peminjaman') }}" class="{{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}">
            <i class="bi bi-file-earmark"></i> Laporan Peminjaman
        </a>
        <a href="{{ route('laporan.pengembalian') }}" class="{{ request()->routeIs('laporan.pengembalian') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-check"></i> Laporan Pengembalian
        </a>
        <a href="{{ route('laporan.stok') }}" class="{{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
            <i class="bi bi-boxes"></i> Laporan Stok
        </a>
        <div class="sidebar-divider"></div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    @stack('scripts')

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        });
    </script>

</body>
</html>
