@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0"><i class="bi bi-people me-2"></i>Manajemen Pengguna</h2>
                <p class="text-muted">Kelola daftar pengguna sistem</p>
            </div>
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary d-flex align-items-center">
                <i class="bi bi-person-plus me-2"></i> Tambah Pengguna
            </a>
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

        <!-- Search Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.user.index') }}" class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Cari nama atau email pengguna..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="submit"
                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-search me-2"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 px-4">No</th>
                                <th class="py-3">Nama</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Tanggal Dibuat</th>
                                <th class="py-3 text-end pe-4" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td class="px-4">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-initial rounded-circle bg-primary-subtle text-primary me-2">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.user.edit', $user->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $user->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-3">
                                            <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                                            <h5 class="mt-2">Belum Ada Data Pengguna</h5>
                                            <p class="text-muted">Silahkan tambahkan pengguna baru dengan mengklik tombol
                                                "Tambah Pengguna"</p>
                                            <a href="{{ route('admin.user.create') }}" class="btn btn-primary mt-2">
                                                <i class="bi bi-person-plus me-2"></i> Tambah Pengguna
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($users, 'hasPages') && $users->hasPages())
                    <div class="p-4 border-top">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Apakah Anda yakin?</h5>
                    <p class="text-muted">Pengguna yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-trash me-2"></i> Hapus
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

        .avatar-initial {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            display: inline-flex;
            align-items: center;
        }

        .badge i {
            margin-right: 0.25rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('admin.user.destroy', '') }}/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
@endpush
