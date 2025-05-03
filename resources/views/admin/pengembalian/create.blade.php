@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>{{ isset($pengembalian) ? 'Edit' : 'Tambah' }} Pengembalian</h2>
    <form action="{{ isset($pengembalian) ? route('pengembalian.update', $pengembalian->id) : route('pengembalian.store') }}" method="POST">
        @csrf
        @if(isset($pengembalian)) @method('PUT') @endif

        <div class="mb-3">
            <label>Peminjaman</label>
            <select name="peminjaman_id" class="form-control" required>
                <option value="">-- Pilih Peminjaman --</option>
                @foreach ($peminjaman as $p)
                    <option value="{{ $p->id }}" {{ (old('peminjaman_id', $pengembalian->peminjaman_id ?? '') == $p->id) ? 'selected' : '' }}>
                        {{ $p->nama_peminjam }} - {{ $p->barang->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', $pengembalian->tanggal_kembali ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan', $pengembalian->keterangan ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($pengembalian) ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection
