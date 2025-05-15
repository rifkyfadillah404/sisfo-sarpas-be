@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Data Peminjaman</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- Tabel Peminjaman --}}
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Tanggal Pinjam</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $pinjam)
                        <tr>
                            <td>{{ $pinjam->nama_peminjam }}</td>
                            <td>{{ $pinjam->barang->nama ?? '-' }}</td>
                            <td>{{ $pinjam->jumlah }}</td>
                            <td>{{ $pinjam->alasan_meminjam }}</td>
                            <td>
                                @if($pinjam->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($pinjam->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($pinjam->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($pinjam->status == 'returned')
                                    <span class="badge bg-secondary">Dikembalikan</span>
                                @endif
                            </td>
                            <td>{{ $pinjam->tanggal_pinjam }}</td>
                            <td>
                                {{-- Tombol aksi sesuai status --}}
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
                                    <span class="text-muted fst-italic">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
