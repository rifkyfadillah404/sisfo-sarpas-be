{{-- resources/views/admin/laporan_peminjaman.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Laporan peminjaman</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Peminjam</th>
                    <th>Barang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $pinjam)
                    <tr>
                        <td>{{ $pinjam->user->name ?? '-' }}</td>
                        <td>{{ $pinjam->barang->nama ?? '-' }}</td>
                        <td>{{ $pinjam->tanggal_pinjam }}</td>
                        <td>{{ $pinjam->status ?? 'Belum dikembalikan' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
