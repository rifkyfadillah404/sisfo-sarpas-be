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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome (untuk lebih banyak ikon jika diperlukan) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
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
            margin-left: 250px; /* Memberikan ruang untuk sidebar yang fixed */
        }

        /* Custom Styles for Header */
        .navbar {
            margin-left: 250px; /* Membuat navbar terpisah dari sidebar */
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4">Sisfo-Sarpas</h4>

        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="{{ route('barang.index') }}"><i class="bi bi-box"></i> Data Barang</a>
        <a href="{{ route('kategori.index') }}"><i class="bi bi-tags"></i> Kategori</a>
        <a href="{{ route('admin.peminjaman.index') }}"><i class="bi bi-arrow-left-right"></i> Peminjaman</a>
        <a href="{{ route('admin.pengembalian.index') }}"><i class="bi bi-arrow-return-left"></i> Pengembalian</a>
        <a href="{{ route('laporan.peminjaman') }}"><i class="bi bi-file-earmark"></i> Laporan Peminjaman</a>
        <a href="{{ route('laporan.pengembalian') }}"><i class="bi bi-file-earmark-check"></i> Laporan Pengembalian</a>
        <a href="{{ route('laporan.stok') }}"><i class="bi bi-boxes"></i> Laporan Stok</a>
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

</body>
</html>
