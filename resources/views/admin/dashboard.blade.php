@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid p-0" style="max-width: 100%; overflow-x: hidden;">
        <!-- Dashboard Header -->
        <div
            class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4 gap-3">
            <div class="flex-grow-1">
                <h1 class="fw-bold text-dark m-0 mb-2 fs-3">
                    <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Admin
                </h1>
                <p class="text-muted mb-0 small">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}! Berikut
                    adalah ringkasan sistem hari ini.</p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="badge bg-gradient text-white p-2 rounded-3 small"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-calendar3 me-1"></i>{{ date('d M Y') }}
                </div>
                <div class="badge bg-gradient text-white p-2 rounded-3 small"
                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="bi bi-clock me-1"></i>{{ date('H:i') }}
                </div>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="row g-4 mb-5">
            <!-- Barang -->
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100 stats-card"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white-50 mb-2 fw-medium">Total Barang</h6>
                                <h2 class="fw-bold mb-0">{{ $jumlahBarang }}</h2>
                                <small class="text-white-50">
                                    <i class="bi bi-arrow-up me-1"></i>
                                </small>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-box-fill fs-1 text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peminjaman -->
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100 stats-card"
                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white-50 mb-2 fw-medium">Total Peminjaman</h6>
                                <h2 class="fw-bold mb-0">{{ $jumlahPeminjaman }}</h2>
                                <small class="text-white-50">
                                    <i class="bi bi-arrow-up me-1"></i>
                                </small>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-arrow-left-right fs-1 text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengembalian -->
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100 stats-card"
                    style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white-50 mb-2 fw-medium">Total Pengembalian</h6>
                                <h2 class="fw-bold mb-0">{{ $jumlahPengembalian }}</h2>
                                <small class="text-white-50">
                                    <i class="bi bi-arrow-up me-1"></i>
                                </small>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-arrow-return-left fs-1 text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Bar Chart -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-white py-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title m-0 fw-bold">📊 Statistik Sarpas</h5>
                                <p class="text-muted mb-0 small">Grafik perbandingan data sistem</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <canvas id="barChart" height="280"></canvas>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-white py-4">
                        <h5 class="card-title m-0 fw-bold">⚡ Menu Cepat</h5>
                        <p class="text-muted mb-0 small">Akses cepat ke fitur utama</p>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-grid gap-3">
                            <a href="{{ route('barang.index') }}" class="btn btn-outline-primary text-start p-3 border-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-3 p-2 me-3">
                                        <i class="bi bi bi-box-fill text-primary fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Data Barang</div>
                                        <small class="text-muted">Kelola barang data barang</small>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.peminjaman.index') }}"
                                class="btn btn-outline-success text-start p-3 border-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-3 p-2 me-3">
                                        <i class="bi bi-clipboard-plus text-success fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Daftar Peminjaman</div>
                                        <small class="text-muted">Kelola peminjaman barang</small>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.pengembalian.index') }}"
                                class="btn btn-outline-info text-start p-3 border-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 rounded-3 p-2 me-3">
                                        <i class="bi bi-arrow-return-left text-info fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Daftar Pengembalian</div>
                                        <small class="text-muted">Kelola pengembalian barang</small>
                                    </div>
                                </div>
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
        /* Stats Cards Animation */
        .stats-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .stats-card:hover::before {
            left: 100%;
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stats-icon {
            transition: transform 0.3s ease;
        }

        .stats-card:hover .stats-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Modern Card Enhancements */
        .card {
            transition: all 0.3s ease;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        /* Quick Action Buttons */
        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-info:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Chart Container */
        #barChart {
            border-radius: 12px;
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Loading Animation */
        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .loading {
            animation: pulse 2s infinite;
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .d-flex.gap-3 {
                gap: 0.5rem !important;
            }

            .badge {
                font-size: 0.7rem !important;
                padding: 0.4rem 0.6rem !important;
            }

            .fs-3 {
                font-size: 1.5rem !important;
            }

            .btn-outline-primary,
            .btn-outline-success,
            .btn-outline-info {
                padding: 0.75rem !important;
            }

            .row.g-4 {
                --bs-gutter-x: 1rem;
                --bs-gutter-y: 1rem;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding: 0 !important;
            }

            .main-content {
                padding: 0.75rem !important;
            }

            .card-body {
                padding: 0.75rem !important;
            }

            .stats-card .card-body {
                padding: 1rem !important;
            }

            .d-flex.flex-column.flex-lg-row {
                gap: 1rem !important;
            }
        }

        /* Fix overflow issues */
        .container-fluid,
        .row,
        .col-lg-8,
        .col-lg-4,
        .col-md-6 {
            max-width: 100%;
            overflow-x: hidden;
        }

        .card {
            max-width: 100%;
            word-wrap: break-word;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Modern Bar Chart with Gradient
        const barCtx = document.getElementById('barChart').getContext('2d');

        // Create gradients
        const gradient1 = barCtx.createLinearGradient(0, 0, 0, 400);
        gradient1.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
        gradient1.addColorStop(1, 'rgba(118, 75, 162, 0.2)');

        const gradient2 = barCtx.createLinearGradient(0, 0, 0, 400);
        gradient2.addColorStop(0, 'rgba(240, 147, 251, 0.8)');
        gradient2.addColorStop(1, 'rgba(245, 87, 108, 0.2)');

        const gradient3 = barCtx.createLinearGradient(0, 0, 0, 400);
        gradient3.addColorStop(0, 'rgba(79, 172, 254, 0.8)');
        gradient3.addColorStop(1, 'rgba(0, 242, 254, 0.2)');

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['📦 Barang', '📋 Peminjaman', '↩️ Pengembalian'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $jumlahBarang }}, {{ $jumlahPeminjaman }}, {{ $jumlahPengembalian }}],
                    backgroundColor: [gradient1, gradient2, gradient3],
                    borderColor: [
                        'rgba(102, 126, 234, 1)',
                        'rgba(240, 147, 251, 1)',
                        'rgba(79, 172, 254, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return context[0].label.replace(/[📦📋↩️]/g, '').trim();
                            },
                            label: function(context) {
                                return `Total: ${context.parsed.y} item`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0,
                            color: '#64748b',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return value + ' item';
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Add loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stats-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
@endpush
