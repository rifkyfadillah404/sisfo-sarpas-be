@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid p-0">
        <!-- Dashboard Header with stats summary -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
            </h2>
            <div class="badge bg-primary-subtle text-primary p-2">
                <i class="bi bi-calendar3 me-1"></i> {{ date('d M Y') }}
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="row g-4 mb-4">
            <!-- Barang -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm border-0 bg-gradient h-100 overflow-hidden position-relative">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="icon-box bg-primary text-white rounded-3 p-3 me-3">
                            <i class="bi bi-box-fill fs-1"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase fw-semibold text-muted mb-1">Jumlah Barang</h6>
                            <h3 class="fw-bold mb-0 display-6">{{ $jumlahBarang }}</h3>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 opacity-10">
                        <i class="bi bi-box-fill" style="font-size: 5rem;"></i>
                    </div>
                </div>
            </div>

            <!-- Peminjaman -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm border-0 bg-gradient h-100 overflow-hidden position-relative">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="icon-box bg-success text-white rounded-3 p-3 me-3">
                            <i class="bi bi-arrow-left-right fs-1"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase fw-semibold text-muted mb-1">Peminjaman</h6>
                            <h3 class="fw-bold mb-0 display-6">{{ $jumlahPeminjaman }}</h3>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 opacity-10">
                        <i class="bi bi-arrow-left-right" style="font-size: 5rem;"></i>
                    </div>
                </div>
            </div>

            <!-- Pengembalian -->
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm border-0 bg-gradient h-100 overflow-hidden position-relative">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="icon-box bg-warning text-dark rounded-3 p-3 me-3">
                            <i class="bi bi-arrow-return-left fs-1"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase fw-semibold text-muted mb-1">Pengembalian</h6>
                            <h3 class="fw-bold mb-0 display-6">{{ $jumlahPengembalian }}</h3>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 opacity-10">
                        <i class="bi bi-arrow-return-left" style="font-size: 5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Activity Section -->
        <div class="row g-4">
            <!-- Left Column: Charts -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title m-0 fw-bold">Statistik Sarpas</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" height="300"></canvas>
                    </div>
                </div>
                
                <div class="row g-4">
                    <!-- Pie Chart -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="card-title m-0 fw-bold">Distribusi</h5>
                            </div>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div style="width: 260px; height: 260px;">
                                    <canvas id="pieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Stats -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="card-title m-0 fw-bold">Status Penggunaan</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-semibold">Barang Tersedia</span>
                                        <span class="text-muted small">{{ $jumlahBarang - $jumlahPeminjaman + $jumlahPengembalian }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                            style="width: {{ ($jumlahBarang > 0) ? (($jumlahBarang - $jumlahPeminjaman + $jumlahPengembalian) / $jumlahBarang * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-semibold">Barang Dipinjam</span>
                                        <span class="text-muted small">{{ $jumlahPeminjaman - $jumlahPengembalian }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                            style="width: {{ ($jumlahBarang > 0) ? (($jumlahPeminjaman - $jumlahPengembalian) / $jumlahBarang * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-semibold">Tingkat Pengembalian</span>
                                        <span class="text-muted small">{{ ($jumlahPeminjaman > 0) ? round(($jumlahPengembalian / $jumlahPeminjaman) * 100) : 0 }}%</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                            style="width: {{ ($jumlahPeminjaman > 0) ? (($jumlahPengembalian / $jumlahPeminjaman) * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Quick Info & Actions -->
            <div class="col-lg-4">
                <!-- System Info -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title m-0 fw-bold">Informasi Sistem</h5>
                    </div>
                    <div class="card-body pb-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted"><i class="bi bi-calendar-check me-2"></i> Status</span>
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted"><i class="bi bi-person-check me-2"></i> Pengguna Aktif</span>
                                <span class="fw-medium">{{ isset($jumlahUser) ? $jumlahUser : '?' }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted"><i class="bi bi-check-circle me-2"></i> Persentase Pengembalian</span>
                                <span class="fw-medium">{{ ($jumlahPeminjaman > 0) ? round(($jumlahPengembalian / $jumlahPeminjaman) * 100) : 0 }}%</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title m-0 fw-bold">Pintasan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('barang.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Tambah Barang
                            </a>
                            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-success">
                                <i class="bi bi-clipboard-plus me-2"></i> Daftar Peminjaman
                            </a>
                            <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-warning text-dark">
                                <i class="bi bi-arrow-return-left me-2"></i> Daftar Pengembalian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            transition: all 0.2s ease;
            border-radius: 10px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        
        .icon-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .progress {
            border-radius: 10px;
            background-color: #f5f5f5;
            overflow: hidden;
        }
        
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .bg-gradient {
            background: linear-gradient(to right, #ffffff, #f8f9fa);
        }
        
        .btn {
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 500;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Shared chart options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        usePointStyle: true,
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 10,
                    cornerRadius: 6,
                    usePointStyle: true
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        };

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
                        'rgba(13, 110, 253, 0.8)',
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderColor: [
                        'rgb(13, 110, 253)',
                        'rgb(25, 135, 84)',
                        'rgb(255, 193, 7)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverOffset: 4
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: true,
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Data Statistik Sarpas',
                        padding: {
                            bottom: 20
                        },
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut', // Changed from pie to doughnut for a more modern look
            data: {
                labels: ['Barang', 'Peminjaman', 'Pengembalian'],
                datasets: [{
                    data: [{{ $jumlahBarang }}, {{ $jumlahPeminjaman }}, {{ $jumlahPengembalian }}],
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.8)',
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderColor: [
                        'rgb(13, 110, 253)',
                        'rgb(25, 135, 84)',
                        'rgb(255, 193, 7)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                ...commonOptions,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            boxWidth: 12,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
