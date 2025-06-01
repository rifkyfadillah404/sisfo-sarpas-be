@extends('layouts.app')

@section('title', 'Tambah Barang')

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

        .preview-container {
            width: 100%;
            height: 200px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            overflow: hidden;
            background-color: #f9f9f9;
        }

        .preview-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .preview-placeholder {
            color: #aaa;
            font-size: 14px;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0"><i class="bi bi-box-seam me-2"></i>Tambah Barang</h2>
                <p class="text-muted">Tambahkan barang baru ke dalam inventaris</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex align-items-center">
                        <i class="bi bi-plus-circle me-2"></i>
                        <span>Tambah Barang Baru</span>
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

                        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data"
                            id="formBarang">
                            @csrf

                            <div class="mb-4">
                                <label for="nama" class="form-label fw-semibold">Nama Barang <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-box-seam text-muted"></i>
                                    </span>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control border-start-0 ps-0 @error('nama') is-invalid @enderror"
                                        value="{{ old('nama') }}" placeholder="Masukkan nama barang" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Nama lengkap barang yang akan ditampilkan</small>
                            </div>

                            <div class="mb-4">
                                <label for="kode" class="form-label fw-semibold">Kode Barang <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-upc-scan text-muted"></i>
                                    </span>
                                    <input type="text" name="kode" id="kode"
                                        class="form-control border-start-0 ps-0 @error('kode') is-invalid @enderror"
                                        value="{{ old('kode') }}" placeholder="Masukkan kode barang" required>
                                    @error('kode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Kode unik untuk identifikasi barang</small>
                            </div>

                            <div class="mb-4">
                                <label for="kategori_barang_id" class="form-label fw-semibold">Kategori <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-tags text-muted"></i>
                                    </span>
                                    <select name="kategori_barang_id" id="kategori_barang_id"
                                        class="form-select border-start-0 ps-0 @error('kategori_barang_id') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}"
                                                {{ old('kategori_barang_id') == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_barang_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Kategori untuk pengelompokan barang</small>
                            </div>

                            <div class="mb-4">
                                <label for="stok" class="form-label fw-semibold">Stok <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-123 text-muted"></i>
                                    </span>
                                    <input type="number" name="stok" id="stok"
                                        class="form-control border-start-0 ps-0 @error('stok') is-invalid @enderror"
                                        value="{{ old('stok') }}" placeholder="Masukkan jumlah stok" min="0"
                                        required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Jumlah stok barang yang tersedia</small>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label fw-semibold">Foto Barang</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-image text-muted"></i>
                                    </span>
                                    <input type="file" name="foto" id="foto"
                                        class="form-control border-start-0 ps-0 @error('foto') is-invalid @enderror"
                                        accept="image/*" onchange="previewImage(this)">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="preview-container mt-2" id="imagePreview">
                                    <div class="preview-placeholder">
                                        <i class="bi bi-image fs-2 d-block mb-2"></i>
                                        <span>Preview foto akan ditampilkan di sini</span>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, JPEG. Maks: 2MB</small>
                            </div>

                            <hr class="my-4">

                            <!-- Tombol Submit -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-x-circle me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-2"></i> Simpan Barang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = `
                <div class="preview-placeholder">
                    <i class="bi bi-image fs-2 d-block mb-2"></i>
                    <span>Preview foto akan ditampilkan di sini</span>
                </div>
            `;
            }
        }
    </script>
@endpush
