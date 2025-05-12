@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold text-center mb-4">Kategori Barang</h2>

            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="kategoriTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold">No</th>
                                    <th class="fw-bold">Nama Kategori</th>
                                    <th class="text-center fw-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategori as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                                                <i class="fas fa-trash-alt me-1"></i>Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-database fa-3x text-muted mb-3"></i>
                                                <h5 class="fw-light text-muted">Belum ada kategori</h5>
                                                <a href="{{ route('kategori.create') }}" class="btn btn-sm btn-primary mt-2">Tambah Kategori Baru</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-0 text-muted">Menampilkan {{ count($kategori) }} dari {{ count($kategori) }} kategori</p>
                        </div>
                        <div class="col-md-6">
                            <div class="pagination justify-content-end mb-0">
                                <!-- If you have pagination controls, place them here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus - Improved Design -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                </div>
                <p class="text-center fs-5">Apakah Anda yakin ingin menghapus kategori ini?</p>
                <p class="text-center text-muted small">Tindakan ini tidak dapat dibatalkan</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <form id="deleteForm" method="POST" action="" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash-alt me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<style>
    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    /* Custom styling for DataTables search */
    .dataTables_filter {
        margin-bottom: 15px;
    }

    .dataTables_filter input {
        border-radius: 4px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        width: 250px;
    }

    .dataTables_filter input:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: 0;
    }

    .card {
        transition: all 0.3s ease;
    }

    .btn {
        font-weight: 500;
    }

    .table>:not(caption)>*>* {
        padding: 0.75rem 1.25rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable with custom options
        const dataTable = $('#kategoriTable').DataTable({
            language: {
                search: "Cari:",
                searchPlaceholder: "Cari kategori...",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(difilter dari _MAX_ total entri)",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            },
            dom: '<"top"fl>rt<"bottom"ip><"clear">',
            pageLength: 10,
            responsive: true
        });
    });

    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = '/kategori/' + id;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>
@endpush
