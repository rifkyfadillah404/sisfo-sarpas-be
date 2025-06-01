@extends('layouts.app')

@section('title', 'Edit Kategori')

@push('styles')
    <style>
        .form-control,
        .form-select,
        .input-group-text,
        .btn {
            border-radius: 6px;
            padding: .5rem .75rem;
        }

        .input-group .form-control,
        .input-group .form-select {
            min-height: 42px;
        }

        .input-group-text {
            background-color: transparent;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 0.5rem;
            color: #444;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            color: white;
            font-weight: 600;
            border-bottom: none;
            padding: 15px 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0"><i class="bi bi-pencil-square me-2"></i>Edit Kategori</h2>
                <p class="text-muted">Perbarui data kategori barang</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2"></i>
                        <span>Edit Kategori</span>
                    </div>
                    <div class="card-body p-4">
                        <!-- Alert Error -->
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <div class="d-flex">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div>
                                        <strong>Terjadi kesalahan!</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" id="formKategori">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="nama" class="form-label fw-semibold">Nama Kategori <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-tag text-muted"></i>
                                    </span>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control border-start-0 ps-0 @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $kategori->nama) }}" placeholder="Masukkan nama kategori"
                                        required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Contoh: Elektronik, Peralatan Kantor, Alat Tulis, dll.</small>
                            </div>

                            <hr class="my-4">

                            <!-- Tombol Submit -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-x-circle me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
