@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0"><i class="bi bi-box-seam me-2"></i>Data Barang</h2>
                <p class="text-muted">Kelola inventaris barang pada sistem</p>
            </div>
            <a href="{{ route('barang.create') }}" class="btn btn-primary d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i> Tambah Barang
            </a>
        </div>

        <!-- Alert Messages -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search & Filter Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('barang.index') }}" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Cari nama atau kode barang..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-funnel text-muted"></i>
                            </span>
                            <select name="kategori" class="form-select border-start-0 ps-0">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('kategori') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit"
                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-filter me-2"></i> Filter
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
                                <th class="py-3 px-4">Foto Barang</th>
                                <th class="py-3">Nama Barang</th>
                                <th class="py-3">Kode</th>
                                <th class="py-3">Kategori</th>
                                <th class="py-3">Stok</th>
                                <th class="py-3 text-end pe-4" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangs as $item)
                                <tr>
                                    <td class="px-4">
                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                                class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-secondary" style="font-size: 1.5rem"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-1 fw-semibold">{{ $item->nama }}</h6>
                                       
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $item->kode }}</span></td>
                                    <td><span
                                            class="badge bg-primary-subtle text-primary">{{ $item->kategori->nama }}</span>
                                    </td>
                                    <td>
                                        @if ($item->stok > 10)
                                            <span class="badge bg-success-subtle text-success">
                                                <i class="bi bi-check-circle-fill me-1"></i> {{ $item->stok }}
                                            </span>
                                        @elseif($item->stok > 0)
                                            <span class="badge bg-warning-subtle text-warning">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $item->stok }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">
                                                <i class="bi bi-x-circle-fill me-1"></i> Kosong
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('barang.edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                title="Edit Barang">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')"
                                                    data-bs-toggle="tooltip" title="Hapus Barang">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                                            <h5 class="mt-3">Belum Ada Data Barang</h5>
                                            <p class="text-muted">Silahkan tambahkan barang baru dengan mengklik tombol
                                                "Tambah Barang"</p>
                                            <a href="{{ route('barang.create') }}" class="btn btn-primary mt-2">
                                                <i class="bi bi-plus-circle me-2"></i> Tambah Barang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($barangs, 'hasPages') && $barangs->hasPages())
                    <div class="p-4 border-top">
                        {{ $barangs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                        Konfirmasi Hapus Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger-subtle rounded-circle p-3 me-3">
                            <i class="bi bi-trash text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Hapus Barang</h6>
                            <p class="mb-0 text-muted" id="deleteItemName">Apakah Anda yakin ingin menghapus barang ini?
                            </p>
                        </div>
                    </div>
                    <div class="alert alert-warning border-0">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan. Barang akan dihapus secara permanen
                        dari sistem.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Hapus Barang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .table th {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .table td {
            vertical-align: middle;
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-control,
        .form-select,
        .input-group-text,
        .btn {
            border-radius: 6px;
            padding: .5rem .75rem;
        }

        .input-group .form-control,
        .input-group .form-select {
            min-height: 42px;
        }

        .input-group-text {
            background-color: transparent;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        function confirmDelete(id, itemName) {
            const form = document.getElementById('deleteForm');
            const itemNameElement = document.getElementById('deleteItemName');

            form.action = `{{ route('barang.destroy', '') }}/${id}`;
            itemNameElement.textContent = `Apakah Anda yakin ingin menghapus barang "${itemName}"?`;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        function showCannotDeleteAlert(itemName, borrowingCount) {
            const itemNameElement = document.getElementById('cannotDeleteItemName');
            const messageElement = document.getElementById('cannotDeleteMessage');

            itemNameElement.textContent = `"${itemName}" Sedang Dipinjam`;
            messageElement.textContent =
                `Barang ini tidak dapat dihapus karena masih ada ${borrowingCount} peminjaman yang belum dikembalikan.`;

            const modal = new bootstrap.Modal(document.getElementById('cannotDeleteModal'));
            modal.show();
        }
    </script>
@endpush
