@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Data Pengembalian Barang</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Pengembali</th>
                        <th>Barang</th>
                        <th>Jumlah Dikembalikan</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Kondisi</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $pengembalian)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pengembalian->nama_pengembali }}</td>
                            <td>{{ $pengembalian->peminjaman->barang->nama ?? '-' }}</td>
                            <td>{{ $pengembalian->jumlah_dikembalikan }}</td>
                            <td>{{ $pengembalian->tanggal_kembali }}</td>
                            <td>
                                <span class="badge
                                    {{ $pengembalian->status === 'complete' ? 'bg-success' :
                                       ($pengembalian->status === 'damage' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ $pengembalian->status ? ucfirst($pengembalian->status) : 'Pending' }}
                                </span>
                            </td>
                            <td>{{ $pengembalian->kondisi ?? '-' }}</td>
                            <td>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                            <td>
                                @if ($pengembalian->status !== 'complete' && $pengembalian->status !== 'damage')
                                    <form action="{{ route('admin.pengembalian.approve', $pengembalian->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm mb-1"
                                            onclick="return confirm('Yakin ingin menyelesaikan pengembalian ini?')">
                                            Selesaikan
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.pengembalian.markDamaged', $pengembalian->id) }}" method="GET" style="display:inline-block;">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tandai barang ini rusak?')">
                                            Tandai Rusak
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
