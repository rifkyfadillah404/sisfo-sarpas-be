@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>{{ isset($peminjaman) ? 'Edit' : 'Tambah' }} Peminjaman</h2>
    <form action="{{ isset($peminjaman) ? route('peminjaman.update', $peminjaman->id) : route('peminjaman.store') }}" method="POST">
        @csrf
        @if(isset($peminjaman)) @method('PUT') @endif

        <div class="mb-3">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" class="form-control" value="{{ old('nama_peminjam', $peminjaman->nama_peminjam ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Barang</label>
            <select name="barang_id" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach ($barang as $b)
                    <option value="{{ $b->id }}" {{ (old('barang_id', $peminjaman->barang_id ?? '') == $b->id) ? 'selected' : '' }}>
                        {{ $b->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $peminjaman->jumlah ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($peminjaman) ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection
