@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Peminjaman</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Peminjam</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Alasan</th>
                <th>Status</th>
                <th>Tanggal Pinjam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $pinjam)
            <tr>
                <td>{{ $pinjam->nama_peminjam }}</td>
                <td>{{ $pinjam->barang->nama ?? '-' }}</td>
                <td>{{ $pinjam->jumlah }}</td>
                <td>{{ $pinjam->alasan_meminjam }}</td>
                <td>
                    @if($pinjam->status == 'pending')
                        <span class="badge bg-warning">Menunggu</span>
                    @elseif($pinjam->status == 'approved')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($pinjam->status == 'rejected')
                        <span class="badge bg-danger">Ditolak</span>
                    @elseif($pinjam->status == 'returned')
                        <span class="badge bg-danger">dikembalikan</span>
                    @endif
                </td>
                <td>{{ $pinjam->tanggal_pinjam }}</td>
                <td>
                    {{-- Tampilkan tombol aksi sesuai status --}}
                    @if($pinjam->status == 'pending')
                        <form method="POST" action="{{ route('admin.peminjaman.approve', $pinjam->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Setujui</button>
                        </form>

                        <form method="POST" action="{{ route('admin.peminjaman.reject', $pinjam->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    @elseif($pinjam->status == 'approved')
                        <form method="POST" action="{{ route('admin.peminjaman.return', $pinjam->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-primary btn-sm">Kembalikan</button>
                        </form>
                    @else
                        <em>Tidak ada aksi</em>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
