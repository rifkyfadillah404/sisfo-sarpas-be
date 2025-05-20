@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-arrow-left-right me-2"></i>Data Peminjaman</h2>
            <p class="text-muted">Kelola semua permintaan dan proses peminjaman barang</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger d-flex align-items-center border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- <!-- Status Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-primary-subtle text-primary rounded-3 p-3 me-3">
                        <i class="bi bi-arrow-left-right fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Total Peminjaman</h6>
                        <h4 class="fw-bold mb-0">{{ count($peminjamans) }}</h4>
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
                        <h4 class="fw-bold mb-0">{{ $peminjamans->where('status', 'pending')->count() }}</h4>
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
                        <h4 class="fw-bold mb-0">{{ $peminjamans->where('status', 'approved')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-secondary-subtle text-secondary rounded-3 p-3 me-3">
                        <i class="bi bi-arrow-return-left fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Dikembalikan</h6>
                        <h4 class="fw-bold mb-0">{{ $peminjamans->where('status', 'returned')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                            placeholder="Cari nama peminjam..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-funnel text-muted"></i>
                        </span>
                        <select name="status" class="form-select border-start-0 ps-0">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center px-4">
                        <i class="bi bi-filter me-2"></i> Filter Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Nama Peminjam</th>
                            <th class="py-3">Barang</th>
                            <th class="py-3">Jumlah</th>
                            <th class="py-3">Alasan</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Tanggal Pinjam</th>
                            <th class="py-3">Tanggal Kembali</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $pinjam)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initial rounded-circle bg-light text-primary me-2">
                                            {{ substr($pinjam->nama_peminjam, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $pinjam->nama_peminjam }}</h6>
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
                                    <span class="badge bg-secondary-subtle text-dark">{{ $pinjam->jumlah }}</span>
                                </td>
                                <td>
                                    <p class="mb-0 small text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip" title="{{ $pinjam->alasan_meminjam }}">
                                        {{ $pinjam->alasan_meminjam }}
                                    </p>
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
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ date('d M Y', strtotime($pinjam->tanggal_pinjam)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($pinjam->tanggal_pengembalian)
                                        <span class="badge {{ now()->gt(Carbon::parse($pinjam->tanggal_pengembalian)) && $pinjam->status == 'approved' ? 'bg-danger-subtle text-danger' : 'bg-light text-dark' }}">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            {{ date('d M Y', strtotime($pinjam->tanggal_pengembalian)) }}
                                            @if(now()->gt(Carbon::parse($pinjam->tanggal_pengembalian)) && $pinjam->status == 'approved')
                                                <span class="ms-1">
                                                    <i class="bi bi-exclamation-triangle-fill"></i> Terlambat
                                                </span>
                                            @endif
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 text-center">
                                    @if($pinjam->status == 'pending')
                                        <div class="btn-group">
                                            <form method="POST" action="{{ route('admin.peminjaman.approve', $pinjam->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success d-flex align-items-center me-1" data-bs-toggle="tooltip" title="Setujui">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.peminjaman.reject', $pinjam->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center" data-bs-toggle="tooltip" title="Tolak">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($pinjam->status == 'approved')
                                        <form method="POST" action="{{ route('admin.peminjaman.return', $pinjam->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary d-flex align-items-center mx-auto" data-bs-toggle="tooltip" title="Proses Pengembalian">
                                                <i class="bi bi-arrow-return-left"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-light text-secondary">Tidak ada aksi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                                        <h5 class="mt-3">Belum Ada Data Peminjaman</h5>
                                        <p class="text-muted">Silahkan tunggu hingga ada permintaan peminjaman baru</p>
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
    .table th { font-weight: 600; font-size: 0.9rem; }
    .table td { vertical-align: middle; padding-top: 1rem; padding-bottom: 1rem; }
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
    });
</script>
@endpush
