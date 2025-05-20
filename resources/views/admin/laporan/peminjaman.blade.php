{{-- resources/views/admin/laporan_peminjaman.blade.php --}}

@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-arrow-left-right me-2"></i>Laporan Peminjaman</h2>
            <p class="text-muted">Data riwayat peminjaman barang</p>
        </div>
        <button onclick="printReport()" class="btn btn-primary d-flex align-items-center">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>

    {{-- <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-primary-subtle text-primary rounded-3 p-3 me-3">
                        <i class="bi bi-arrow-left-right fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Total Peminjaman</h6>
                        <h4 class="fw-bold mb-0">{{ count($data) }}</h4>
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
                        <h6 class="text-muted mb-1 small text-uppercase">Disetujui</h6>
                        <h4 class="fw-bold mb-0">{{ $data->where('status', 'approved')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-warning-subtle text-warning rounded-3 p-3 me-3">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Menunggu</h6>
                        <h4 class="fw-bold mb-0">{{ $data->where('status', 'pending')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-info-subtle text-info rounded-3 p-3 me-3">
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Total Barang Dipinjam</h6>
                        <h4 class="fw-bold mb-0">{{ $data->sum('jumlah') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('laporan.peminjaman') }}" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="search" class="form-control border-start-0 ps-0"
                            placeholder="Cari nama peminjam..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-funnel text-muted"></i>
                        </span>
                        <select name="status" id="status" class="form-select border-start-0 ps-0">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
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
            <h5 class="card-title m-0 fw-bold">Data Peminjaman Barang</h5>
            <div class="print-date d-none">
                <small class="text-muted">Dicetak pada: {{ now()->format('d M Y H:i') }}</small>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Nama Peminjam</th>
                            <th class="py-3">Barang</th>
                            <th class="py-3">Tanggal Pinjam</th>
                            <th class="py-3 text-center">Jumlah</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Alasan Meminjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $pinjam)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initial rounded-circle bg-light text-primary me-2">
                                            {{ substr($pinjam->nama_peminjam ?? 'A', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $pinjam->nama_peminjam ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $pinjam->barang->nama ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-dark">{{ $pinjam->jumlah }}</span>
                                </td>
                                <td>
                                    @if($pinjam->status == 'pending')
                                        <span class="badge bg-warning-subtle text-warning d-flex align-items-center">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                        </span>
                                    @elseif($pinjam->status == 'approved')
                                        <span class="badge bg-success-subtle text-success d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill me-1"></i> Disetujui
                                        </span>
                                    @elseif($pinjam->status == 'rejected')
                                        <span class="badge bg-danger-subtle text-danger d-flex align-items-center">
                                            <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                        </span>
                                    @elseif($pinjam->status == 'returned')
                                        <span class="badge bg-secondary-subtle text-secondary d-flex align-items-center">
                                            <i class="bi bi-arrow-return-left me-1"></i> Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($pinjam->alasan_meminjam))
                                        <span class="small text-truncate" data-bs-toggle="tooltip" title="{{ $pinjam->alasan_meminjam }}">
                                            {{ Str::limit($pinjam->alasan_meminjam, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                                        <h5 class="mt-3">Belum Ada Data Peminjaman</h5>
                                        <p class="text-muted">Belum ada data peminjaman yang tersedia saat ini</p>
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
