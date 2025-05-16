@extends('layouts.app')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-boxes me-2"></i>Laporan Stok Barang</h2>
            <p class="text-muted">Informasi mengenai ketersediaan stok seluruh barang</p>
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
                        <i class="bi bi-boxes fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Total Barang</h6>
                        <h4 class="fw-bold mb-0">{{ count($data) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-success-subtle text-success rounded-3 p-3 me-3">
                        <i class="bi bi-box-seam-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Total Stok</h6>
                        <h4 class="fw-bold mb-0">{{ $data->sum('stok') }}</h4>
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
                        <h6 class="text-muted mb-1 small text-uppercase">Stok Kosong</h6>
                        <h4 class="fw-bold mb-0">{{ $data->where('stok', 0)->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-warning-subtle text-warning rounded-3 p-3 me-3">
                        <i class="bi bi-tags fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase">Kategori</h6>
                        <h4 class="fw-bold mb-0">{{ $data->pluck('kategori.nama')->unique()->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('laporan.stok') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="search" class="form-control border-start-0 ps-0" 
                            placeholder="Cari nama barang..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-funnel text-muted"></i>
                        </span>
                        <select name="kategori" id="kategori" class="form-select border-start-0 ps-0">
                            <option value="">Semua Kategori</option>
                            @foreach($data->pluck('kategori.nama', 'kategori.id')->unique() as $id => $nama)
                                @if($nama)
                                <option value="{{ $id }}" {{ request('kategori') == $id ? 'selected' : '' }}>
                                    {{ $nama }}
                                </option>
                                @endif
                            @endforeach
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
    <div class="card border-0 shadow-sm" id="reportCard">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 fw-bold">Data Stok Barang</h5>
            <div class="print-date d-none">
                <small class="text-muted">Dicetak pada: {{ now()->format('d M Y H:i') }}</small>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">Nama Barang</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3 text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $barang)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        @if(isset($barang->foto) && $barang->foto)
                                            <img src="{{ asset($barang->foto) }}" alt="{{ $barang->nama }}" 
                                                class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-box text-secondary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $barang->nama }}</h6>
                                            @if(isset($barang->kode))
                                            <small class="text-muted">{{ $barang->kode }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary-subtle text-primary">{{ $barang->kategori->nama ?? '-' }}</span></td>
                                <td class="text-center">
                                    @if($barang->stok > 10)
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="bi bi-check-circle-fill me-1"></i> {{ $barang->stok }}
                                        </span>
                                    @elseif($barang->stok > 0)
                                        <span class="badge bg-warning-subtle text-warning">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $barang->stok }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">
                                            <i class="bi bi-x-circle-fill me-1"></i> Kosong
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                                        <h5 class="mt-3">Belum Ada Data Barang</h5>
                                        <p class="text-muted">Silahkan tambahkan data barang terlebih dahulu</p>
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
    .form-control, .form-select, .input-group-text, .btn { border-radius: 6px; padding: .5rem .75rem; }
    .input-group .form-control, .input-group .form-select { min-height: 42px; }
    .input-group-text { background-color: transparent; }
    
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
    // Client-side filtering
    document.addEventListener('DOMContentLoaded', function() {
        // Handling search and filter on keyup
        document.getElementById('search').addEventListener('keyup', function(e) {
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
