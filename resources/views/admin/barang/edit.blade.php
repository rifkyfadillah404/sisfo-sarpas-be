@extends('layouts.app')

@section('title', 'Edit Barang')

@push('styles')
    <style>
        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            border: 1px solid #e0e0e0;
            background-color: #f9f9f9;
        }

        .form-control:focus,
        .form-select:focus {
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

        .current-image {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px;
            background-color: #f9f9f9;
            margin-top: 15px;
        }

        .current-image img {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 6px;
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2"></i>
                        <span>Edit Barang</span>
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

                        <form action="{{ route('barang.update', $barang->id) }}" method="POST"
                            enctype="multipart/form-data" id="formBarang">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        value="{{ old('nama', $barang->nama) }}" placeholder="Masukkan nama barang"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode Barang</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" name="kode" id="kode" class="form-control"
                                        value="{{ old('kode', $barang->kode) }}" placeholder="Masukkan kode barang"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="kategori_barang_id" class="form-label">Kategori</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                    <select name="kategori_barang_id" id="kategori_barang_id" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}"
                                                {{ old('kategori_barang_id', $barang->kategori_barang_id) == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-123"></i></span>
                                    <input type="number" name="stok" id="stok" class="form-control"
                                        value="{{ old('stok', $barang->stok) }}" placeholder="Masukkan jumlah stok"
                                        min="0" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label">Foto Barang</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-image"></i></span>
                                    <input type="file" name="foto" id="foto" class="form-control"
                                        accept="image/*" onchange="previewImage(this)">
                                </div>

                                @if ($barang->foto)
                                    <div class="current-image mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-image-fill me-2 text-primary"></i>
                                            <span class="fw-medium">Foto Saat Ini:</span>
                                        </div>
                                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto {{ $barang->nama }}"
                                            class="img-fluid">
                                    </div>
                                @endif

                                <div class="preview-container mt-3" id="imagePreview"
                                    style="{{ $barang->foto ? 'display: none;' : '' }}">
                                    <div class="preview-placeholder">
                                        <i class="bi bi-image fs-2 d-block mb-2"></i>
                                        <span>Preview foto baru akan ditampilkan di sini</span>
                                    </div>
                                </div>
                                <small class="text-muted mt-1 d-block">Format: JPG, PNG, JPEG. Maks: 2MB. Kosongkan jika
                                    tidak ingin mengubah foto.</small>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('barang.index') }}" class="btn btn-secondary">
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

@push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const currentImage = document.querySelector('.current-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    preview.style.display = 'flex';

                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = `
                <div class="preview-placeholder">
                    <i class="bi bi-image fs-2 d-block mb-2"></i>
                    <span>Preview foto baru akan ditampilkan di sini</span>
                </div>
            `;

                if (currentImage) {
                    currentImage.style.display = 'block';
                    preview.style.display = 'none';
                } else {
                    preview.style.display = 'flex';
                }
            }
        }
    </script>
@endpush
