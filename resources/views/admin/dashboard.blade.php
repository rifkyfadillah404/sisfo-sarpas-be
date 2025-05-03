@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2 class="mb-4 fw-bold">Dashboard Admin</h2>

    <div class="row">
        <!-- Card Jumlah Barang -->
        <div class="col-md-4 mb-3">
            <div class="card card-custom text-white bg-primary shadow-lg hover-shadow-lg border-0">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Barang</h5>
                    <p class="card-text display-4">{{ $jumlahBarang }}</p>
                </div>
            </div>
        </div>

        <!-- Card Jumlah Peminjaman -->
        <div class="col-md-4 mb-3">
            <div class="card card-custom text-white bg-success shadow-lg hover-shadow-lg border-0">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Peminjaman</h5>
                    <p class="card-text display-4">{{ $jumlahPeminjaman }}</p>
                </div>
            </div>
        </div>

        <!-- Card Jumlah Pengembalian -->
        <div class="col-md-4 mb-3">
            <div class="card card-custom text-white bg-warning shadow-lg hover-shadow-lg border-0">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Pengembalian</h5>
                    <p class="card-text display-4">{{ $jumlahPengembalian }}</p>
                </div>
            </div>
        </div>
    </div>

<div class="row mt-4">
    <!-- Diagram Kotak -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title text-center">Diagram Batang</h5>
                <div style="max-width: 400px; margin: auto;">
                    <canvas id="barChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram Lingkaran -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title text-center">Diagram Lingkaran</h5>
                <div style="max-width: 300px; margin: auto;">
                    <canvas id="pieChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <style>
        .card-custom {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .display-4 {
            font-size: 2rem;
            font-weight: 700;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Diagram Batang (Horizontal)
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Barang', 'Peminjaman', 'Pengembalian'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $jumlahBarang }}, {{ $jumlahPeminjaman }}, {{ $jumlahPengembalian }}],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107']
                }]
            },
            options: {
                responsive: true,
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

        // Diagram Lingkaran
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Barang', 'Peminjaman', 'Pengembalian'],
                datasets: [{
                    data: [{{ $jumlahBarang }}, {{ $jumlahPeminjaman }}, {{ $jumlahPengembalian }}],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 15
                        }
                    }
                }
            }
        });
    </script>
@endpush
