<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background-color: #0000ff;
            color: white;
            padding: 1rem;
            min-height: 100vh;
        }

        .sidebar h4 {
            font-weight: 700;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 12px;
            border-radius: 6px;
            margin: 6px 0;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar a:hover {
            background-color: #0000BF;
            color: #f8f9fa;
        }

        .sidebar i {
            margin-right: 10px;
            font-size: 20px;
        }

        .main-content {
            flex-grow: 1;
            padding: 2rem;
        }

        .card-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .card-title {
            font-weight: 600;
        }

        .card-text {
            font-size: 2rem;
            font-weight: 700;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4">Sisfo-Sarpas</h4>

        <a href="{{ route('admin.dashboard') }}">
            <!-- Dashboard Icon -->
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('barang.index') }}">
            <!-- Box Icon -->
            <i class="bi bi-box"></i> Data Barang
        </a>
        <a href="{{ route('kategori.index') }}">
            <!-- Tags Icon -->
            <i class="bi bi-tags"></i> Kategori
        </a>
        <a href="{{ route('admin.peminjaman.index') }}">
            <i class="bi bi-arrow-left-right"></i> Peminjaman
        </a>
        <a href="{{ route('laporan.peminjaman') }}">
            <!-- File Icon -->
            <i class="bi bi-file-earmark"></i> Laporan Peminjaman
        </a>
        <a href="{{ route('laporan.pengembalian') }}">
            <!-- File Check Icon -->
            <i class="bi bi-file-earmark-check"></i> Laporan Pengembalian
        </a>
        <a href="{{ route('laporan.stok') }}">
            <!-- Boxes Icon -->
            <i class="bi bi-boxes"></i> Laporan Stok
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <!-- Log Out Icon -->
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


</body>
</html>
