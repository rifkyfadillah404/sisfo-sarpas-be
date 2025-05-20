@extends('layouts.app')

@section('title', 'Daftar Pengembalian')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-arrow-return-left me-2"></i>Daftar Pengembalian</h2>
            <p class="text-muted">Kelola data pengembalian barang dari peminjam</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
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
                        <i class="bi bi-arrow-return-left fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Total Pengembalian</h6>
                        <h4 class="fw-bold mb-0">{{ count($pengembalians) }}</h4>
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
                        <h4 class="fw-bold mb-0">{{ $pengembalians->where('status', 'complete')->count() }}</h4>
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
                        <h4 class="fw-bold mb-0">{{ $pengembalians->where('status', 'pending')->count() }}</h4>
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
                        <h4 class="fw-bold mb-0">{{ $pengembalians->where('status', 'damage')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.pengembalian.index') }}" class="row g-3">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                            placeholder="Cari nama pengembali..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-funnel text-muted"></i>
                        </span>
                        <select name="status" class="form-select border-start-0 ps-0">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
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
                        <input type="date" name="tanggal" class="form-control border-start-0 ps-0"
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
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Nama Pengembali</th>
                            <th class="py-3">Barang</th>
                            <th class="py-3">Jumlah</th>
                            <th class="py-3">Tanggal Kembali</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Kondisi</th>
                            <th class="py-3">Denda</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $pengembalian)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-initial rounded-circle bg-light text-primary me-2">
                                            {{ substr($pengembalian->nama_pengembali, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $pengembalian->nama_pengembali }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $pengembalian->peminjaman->barang->nama ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-dark">{{ $pengembalian->jumlah_dikembalikan }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ date('d M Y', strtotime($pengembalian->tanggal_kembali)) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($pengembalian->status == 'complete')
                                        <span class="badge bg-success-subtle text-success d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                        </span>
                                    @elseif($pengembalian->status == 'damage')
                                        <span class="badge bg-danger-subtle text-danger d-flex align-items-center">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Rusak
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning d-flex align-items-center">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pengembalian->kondisi)
                                        <span class="small text-truncate" data-bs-toggle="tooltip" title="{{ $pengembalian->kondisi }}">
                                            {{ Str::limit($pengembalian->kondisi, 20) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pengembalian->total_denda > 0)
                                        <span class="badge bg-danger-subtle text-danger">
                                            Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}
                                        </span>
                                        @if ($pengembalian->hari_terlambat > 0)
                                            <span class="badge bg-warning-subtle text-warning d-block mt-1">
                                                <i class="bi bi-clock-history me-1"></i>Terlambat {{ $pengembalian->hari_terlambat }} hari
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="px-4 text-center">
                                    @if ($pengembalian->status !== 'complete' && $pengembalian->status !== 'damage')
                                        <div class="btn-group">
                                            <form method="POST" action="{{ route('admin.pengembalian.approve', $pengembalian->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success d-flex align-items-center me-1"
                                                    data-bs-toggle="tooltip" title="Selesaikan"
                                                    onclick="return confirm('Selesaikan pengembalian ini?')">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.pengembalian.markDamaged', $pengembalian->id) }}"
                                                class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                data-bs-toggle="tooltip" title="Tandai Rusak">
                                                <i class="bi bi-exclamation-triangle"></i>
                                            </a>
                                        </div>
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
