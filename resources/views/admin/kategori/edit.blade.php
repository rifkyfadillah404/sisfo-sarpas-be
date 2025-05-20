@extends('layouts.app')

@section('title', 'Edit Kategori')

@push('styles')
    <style>
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            border: 1px solid #e0e0e0;
            background-color: #f9f9f9;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
            background-color: #fff;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 0.5rem;
            color: #444;
        }

        .input-group-text {
            background-color: #f0f4f8;
            border: 1px solid #e0e0e0;
            border-right: none;
            color: #6c757d;
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

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card">
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
                                <label for="nama" class="form-label">Nama Kategori</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        value="{{ old('nama', $kategori->nama) }}" placeholder="Masukkan nama kategori"
                                        required>
                                </div>
                                <small class="text-muted mt-1">Contoh: Elektronik, Peralatan Kantor, Alat Tulis,
                                    dll.</small>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
