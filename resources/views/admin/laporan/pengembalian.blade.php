{{-- resources/views/admin/laporan/pengembalian.blade.php --}}

@extends('layouts.app')

@section('title', 'Laporan Pengembalian')

@section('content')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f9fa;
    }

    h3 {
        color: #343a40;
    }

    .table {
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead {
        background-color: #e9ecef;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #fdfdfe;
    }

    .table tbody tr:hover {
        background-color: #f1f3f5;
    }
</style>

<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Laporan Pengembalian</h3>

    <div class="table-responsive shadow-sm">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Nama Peminjam</th>
                    <th>Barang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Denda</th> <!-- Kolom Denda ditambahkan -->
                </tr>
            </thead>
            <tbody>
                @foreach ($pengembalian as $kembali)
                    <tr class="text-center">
                        <td>{{ $kembali->peminjaman->user->name ?? '-' }}</td>
                        <td>{{ $kembali->peminjaman->barang->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($kembali->peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($kembali->tanggal_kembali)->format('d M Y') }}</td>
                        <td>Rp {{ number_format($kembali->denda, 0, ',', '.') }}</td> <!-- Denda ditampilkan -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
