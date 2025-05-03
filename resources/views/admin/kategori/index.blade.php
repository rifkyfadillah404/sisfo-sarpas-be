@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Kategori Barang</h3>


    <div class="card shadow-sm">
        <div class="card-body">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Kategori</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" action="" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        // Menyiapkan form untuk penghapusan
        const form = document.getElementById('deleteForm');
        form.action = '/kategori/' + id;

        // Menampilkan modal konfirmasi
        const myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
    }
</script>
@endpush
