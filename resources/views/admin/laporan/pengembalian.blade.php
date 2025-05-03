{{-- resources/views/admin/laporan/pengembalian.blade.php --}}

@extends('layouts.app')

@section('title', 'Laporan Pengembalian')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Laporan pengembalian</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Peminjam</th>
                    <th>Barang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengembalian as $kembali)
                    <tr>
                        <td>{{ $kembali->peminjaman->user->name ?? '-' }}</td>
                        <td>{{ $kembali->peminjaman->barang->nama ?? '-' }}</td>
                        <td>{{ $kembali->peminjaman->tanggal_pinjam }}</td>
                        <td>{{ $kembali->tanggal_kembali }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
