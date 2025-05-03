@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Data Barang</h3>


    <div class="card shadow-sm">
        <div class="card-body">
            <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->kategori->nama }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada Barang.</td>
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
                <p>Apakah Anda yakin ingin menghapus barang ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function confirmDelete(id) {
            // Menyiapkan form untuk penghapusan
            const form = document.getElementById('deleteForm');
            form.action = '/barang/' + id;

            // Menampilkan modal konfirmasi
            const myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            myModal.show();
        }
    </script>
@endpush
@endsection
