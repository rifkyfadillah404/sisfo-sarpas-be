@extends('layouts.app')

@section('title', 'Daftar Pengembalian')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 fw-bold">Daftar Pengembalian</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- Tabel Pengembalian --}}
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Pengembali</th>
                        <th>Barang</th>
                        <th>Jumlah Dikembalikan</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Kondisi</th>
                        <th>Denda</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $pengembalian)
                    <tr>
                        <td>{{ $pengembalian->nama_pengembali }}</td>
                        <td>{{ $pengembalian->peminjaman->barang->nama ?? '-' }}</td>
                        <td>{{ $pengembalian->jumlah_dikembalikan }}</td>
                        <td>{{ $pengembalian->tanggal_kembali }}</td>
                        <td>
                            @if($pengembalian->status == 'complete')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($pengembalian->status == 'damage')
                                <span class="badge bg-danger">Rusak</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @endif
                        </td>
                        <td>{{ $pengembalian->kondisi ?? '-' }}</td>
                        <td>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                        <td>
                            @if ($pengembalian->status !== 'complete' && $pengembalian->status !== 'damage')
                                <form method="POST" action="{{ route('admin.pengembalian.approve', $pengembalian->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm" onclick="return confirm('Selesaikan pengembalian ini?')">Selesaikan</button>
                                </form>

                                <form method="POST" action="{{ route('admin.pengembalian.markDamaged', $pengembalian->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Tandai sebagai rusak?')">Tandai Rusak</button>
                                </form>
                            @else
                                <span class="text-muted fst-italic">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
