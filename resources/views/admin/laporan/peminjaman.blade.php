{{-- resources/views/admin/laporan_peminjaman.blade.php --}}

@extends('layouts.app')

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

    .badge-status {
        padding: 0.4em 0.75em;
        font-size: 0.85rem;
        border-radius: 0.5rem;
        font-weight: 500;
    }

    .badge-returned {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-pending {
        background-color: #f8d7da;
        color: #842029;
    }
</style>

<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Laporan Peminjaman</h3>

    <div class="table-responsive shadow-sm">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Nama Peminjam</th>
                    <th>Barang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $pinjam)
                    <tr class="text-center">
                        <td>{{ $pinjam->nama_peminjam ?? '-' }}</td>
                        <td>{{ $pinjam->barang->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>{{ $pinjam->jumlah ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
