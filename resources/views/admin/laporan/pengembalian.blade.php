{{-- resources/views/admin/laporan/pengembalian.blade.php --}}

@extends('layouts.app')

@section('title', 'Laporan Pengembalian')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-arrow-return-left me-2"></i>Laporan Pengembalian</h2>
            <p class="text-muted">Data riwayat pengembalian barang dari peminjam</p>
        </div>
        <button onclick="printReport()" class="btn btn-primary d-flex align-items-center">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>
    
    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-primary-subtle text-primary rounded-3 p-3 me-3">
                        <i class="bi bi-arrow-return-left fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Total Pengembalian</h6>
                        <h4 class="fw-bold mb-0">{{ count($pengembalian) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-success-subtle text-success rounded-3 p-3 me-3">
                        <i class="bi bi-check-circle fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Selesai</h6>
                        <h4 class="fw-bold mb-0">{{ $pengembalian->where('status', 'complete')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-danger-subtle text-danger rounded-3 p-3 me-3">
                        <i class="bi bi-exclamation-diamond fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Rusak</h6>
                        <h4 class="fw-bold mb-0">{{ $pengembalian->where('status', 'damage')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-info-subtle text-info rounded-3 p-3 me-3">
                        <i class="bi bi-cash-coin fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Total Denda</h6>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($pengembalian->sum('denda'), 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('laporan.pengembalian') }}" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="search" class="form-control border-start-0 ps-0" 
                            placeholder="Cari nama pengembali..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-funnel text-muted"></i>
                        </span>
                        <select name="status" id="status" class="form-select border-start-0 ps-0">
                            <option value="">Semua Status</option>
                            <option value="complete" {{ request('status') == 'complete' ? 'selected' : '' }}>Selesai</option>
                            <option value="damage" {{ request('status') == 'damage' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-calendar3 text-muted"></i>
                        </span>
                        <input type="date" name="tanggal" id="tanggal" class="form-control border-start-0 ps-0" 
                            value="{{ request('tanggal') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center px-4">
                        <i class="bi bi-filter me-2"></i> Filter Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm" id="reportCard">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 fw-bold">Data Pengembalian Barang</h5>
            <div class="print-date d-none">
                <small class="text-muted">Dicetak pada: {{ now()->format('d M Y H:i') }}</small>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Nama Pengembali</th>
                            <th class="py-3">Barang</th>
                            <th class="py-3">Tanggal Pinjam</th>
                            <th class="py-3">Tanggal Kembali</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end pe-4">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengembalian as $kembali)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initial rounded-circle bg-light text-primary me-2">
                                            {{ substr($kembali->nama_pengembali ?? 'A', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $kembali->nama_pengembali ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $kembali->peminjaman->barang->nama ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-calendar3 me-1"></i> 
                                        {{ \Carbon\Carbon::parse($kembali->peminjaman->tanggal_pinjam)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-calendar-check me-1"></i> 
                                        {{ \Carbon\Carbon::parse($kembali->tanggal_kembali)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($kembali->status == 'complete')
                                        <span class="badge bg-success-subtle text-success d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                        </span>
                                    @elseif($kembali->status == 'damage')
                                        <span class="badge bg-danger-subtle text-danger d-flex align-items-center">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Rusak
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning d-flex align-items-center">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if ($kembali->denda > 0)
                                        <span class="badge bg-danger-subtle text-danger">
                                            <i class="bi bi-cash me-1"></i>
                                            Rp {{ number_format($kembali->denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-secondary">
                                            <i class="bi bi-dash-circle me-1"></i> Tanpa Denda
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                                        <h5 class="mt-3">Belum Ada Data Pengembalian</h5>
                                        <p class="text-muted">Belum ada data pengembalian yang tersedia saat ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-box { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; }
    .badge { font-weight: 500; padding: 0.5rem 0.75rem; display: inline-flex; align-items: center; }
    .badge i { margin-right: 0.25rem; }
    .form-control, .form-select, .input-group-text, .btn { border-radius: 6px; padding: .5rem .75rem; }
    .input-group .form-control, .input-group .form-select { min-height: 42px; }
    .input-group-text { background-color: transparent; }
    .avatar-initial {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    @media print {
        .sidebar, .btn, #filterForm, .navbar { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; }
        .print-date { display: block !important; }
        .container-fluid { padding: 0 !important; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Handling search and filter on keyup
        document.getElementById('search')?.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('filterForm').submit();
            }
        });
    });
    
    // Print functionality
    function printReport() {
        document.querySelectorAll('.print-date').forEach(el => el.classList.remove('d-none'));
        window.print();
    }
</script>
@endpush
