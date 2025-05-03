@extends('layouts.app') {{-- Misal file layout kamu bernama layouts/admin.blade.php --}}

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Laporan stok barang</h3>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
                <tr>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ $barang->kategori->nama ?? '-' }}</td>
                    <td>{{ $barang->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
