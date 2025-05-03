@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Data Pengembalian</h2>
    <a href="{{ route('pengembalian.create') }}" class="btn btn-primary mb-3">Tambah Pengembalian</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Peminjam</th>
                <th>Barang</th>
                <th>Tanggal Kembali</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengembalian as $item)
                <tr>
                    <td>{{ $item->peminjaman->nama_peminjam }}</td>
                    <td>{{ $item->peminjaman->barang->nama }}</td>
                    <td>{{ $item->tanggal_kembali }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <a href="{{ route('pengembalian.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pengembalian.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
