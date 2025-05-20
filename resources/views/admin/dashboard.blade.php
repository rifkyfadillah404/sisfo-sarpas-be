
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid p-0">
        <!-- Dashboard Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
            </h2>
            <div class="badge bg-light text-dark p-2">
                <i class="bi bi-calendar3 me-1"></i> {{ date('d M Y') }}
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="row g-3 mb-4">
            <!-- Barang -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="bg-primary text-white rounded p-3 me-3">
                            <i class="bi bi-box-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Jumlah Barang</h6>
                            <h3 class="fw-bold mb-0">{{ $jumlahBarang }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peminjaman -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="bg-success text-white rounded p-3 me-3">
                            <i class="bi bi-arrow-left-right fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Peminjaman</h6>
                            <h3 class="fw-bold mb-0">{{ $jumlahPeminjaman }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengembalian -->
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="bg-warning text-dark rounded p-3 me-3">
                            <i class="bi bi-arrow-return-left fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pengembalian</h6>
                            <h3 class="fw-bold mb-0">{{ $jumlahPengembalian }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-3">
            <!-- Bar Chart -->
            <div class="col-lg-8">
                <div class="card border-0 mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="card-title m-0">Statistik Sarpas</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card border-0">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="card-title m-0">Menu Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="{{ route('barang.create') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Barang
                            </a>
                            <a href="{{ route('admin.peminjaman.index') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-clipboard-plus me-2"></i> Daftar Peminjaman
                            </a>
                            <a href="{{ route('admin.pengembalian.index') }}" class="list-group-item list-group-item-action">
                                <i class="bi bi-arrow-return-left me-2"></i> Daftar Pengembalian
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="card border-0 mt-3">
                    <div class="card-header bg-light border-0 py-3">
                        <h5 class="card-title m-0">Informasi Sistem</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                <span><i class="bi bi-calendar-check me-2"></i> Status</span>
                                <span class="badge bg-success">Aktif</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                <span><i class="bi bi-check-circle me-2"></i> Persentase Pengembalian</span>
                                <span>{{ ($jumlahPeminjaman > 0) ? round(($jumlahPengembalian / $jumlahPeminjaman) * 100) : 0 }}%</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .progress {
            background-color: #f5f5f5;
        }

        .badge {
            font-weight: 500;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Barang', 'Peminjaman', 'Pengembalian'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $jumlahBarang }}, {{ $jumlahPeminjaman }}, {{ $jumlahPengembalian }}],
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.7)',
                        'rgba(25, 135, 84, 0.7)',
                        'rgba(255, 193, 7, 0.7)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endpush

