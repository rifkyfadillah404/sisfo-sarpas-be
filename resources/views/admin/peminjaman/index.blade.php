@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Data Peminjaman</h2>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Peminjam</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $item)
                <tr>
                    <td>{{ $item->nama_peminjam }}</td>
                    <td>{{ $item->barang->nama }}</td>
                    <td>{{ $item->tanggal_pinjam }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>
                        <a href="{{ route('peminjaman.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" style="display:inline;">
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
