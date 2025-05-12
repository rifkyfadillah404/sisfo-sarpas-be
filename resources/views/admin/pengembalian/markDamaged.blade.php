@extends('layouts.app')

@section('title', 'Input Denda Pengembalian Rusak')

@section('content')
<div class="container mt-4">
    <h2>Input Denda untuk Pengembalian Rusak</h2>

    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <div class="card mt-4">
        <div class="card-body">
           <form action="{{ route('admin.pengembalian.updateDamaged', $pengembalian->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_pengembali" class="form-label">Nama Pengembali</label>
                    <input type="text" class="form-control" id="nama_pengembali" value="{{ $pengembalian->nama_pengembali }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="jumlah_dikembalikan" class="form-label">Jumlah Dikembalikan</label>
                    <input type="number" class="form-control" id="jumlah_dikembalikan" value="{{ $pengembalian->jumlah_dikembalikan }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="denda" class="form-label">Denda (Rp)</label>
                    <input type="number" name="denda" class="form-control @error('denda') is-invalid @enderror" id="denda" required min="0">
                    @error('denda')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-danger">Simpan Denda</button>
                <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
