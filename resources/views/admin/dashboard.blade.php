@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2 class="mb-4 fw-semibold text-dark">Dashboard Admin</h2>

    <div class="row">
        <!-- Barang -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-box-fill fs-1 opacity-75"></i>
                    </div>
                    <div>
                        <div class="text-uppercase small fw-semibold">Jumlah Barang</div>
                        <h3 class="fw-bold mb-0">{{ $jumlahBarang }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peminjaman -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 bg-success text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-arrow-left-right fs-1 opacity-75"></i>
                    </div>
                    <div>
                        <div class="text-uppercase small fw-semibold">Jumlah Peminjaman</div>
                        <h3 class="fw-bold mb-0">{{ $jumlahPeminjaman }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengembalian -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 bg-warning text-dark h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-arrow-return-left fs-1 opacity-75"></i>
                    </div>
                    <div>
                        <div class="text-uppercase small fw-semibold">Jumlah Pengembalian</div>
                        <h3 class="fw-bold mb-0">{{ $jumlahPengembalian }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <!-- Diagram Batang -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom text-primary fw-semibold text-center">
                    <i class="bi bi-bar-chart-fill me-1"></i> Diagram Batang
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div style="width: 250px; height: 250px;">
                        <canvas id="barChart" width="250" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pie Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom text-success fw-semibold">
                    <i class="bi bi-pie-chart-fill me-1"></i> Diagram Lingkaran
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div style="width: 240px; height: 240px;">
                        <canvas id="pieChart" width="240" height="240"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card:hover {
            transform: scale(1.01);
            transition: all 0.2s ease-in-out;
        }

        .card-body i {
            filter: drop-shadow(1px 1px 1px rgba(0, 0, 0, 0.2));
        }

        h3.fw-bold {
            font-size: 2rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Barang', 'Peminjaman', 'Pengembalian'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $jumlahBarang }}, {{ $jumlahPeminjaman }}, {{ $jumlahPengembalian }}],
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107'],
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                animation: {
                    duration: 1200,
                    easing: 'easeOutBounce'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }

        });


        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Barang', 'Peminjaman', 'Pengembalian'],
                datasets: [{
                    data: [{{ $jumlahBarang }}, {{ $jumlahPeminjaman }}, {{ $jumlahPengembalian }}],
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 16,
                            padding: 10
                        }
                    }
                }
            }
        });
    </script>
@endpush
