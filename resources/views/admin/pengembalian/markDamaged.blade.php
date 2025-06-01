@extends('layouts.app')

@section('title', 'Input Denda Pengembalian Rusak')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Input Denda Kerusakan</h2>
            <p class="text-muted">Tetapkan denda untuk barang yang dikembalikan dalam kondisi rusak</p>
        </div>  
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">

        <!-- Form Card -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="card-title m-0 fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Input Denda Kerusakan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengembalian.updateDamaged', $pengembalian->id) }}" method="POST">
                        @csrf

                        <div class="alert alert-warning border-0 mb-4">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                                <div>
                                    <strong>Perhatian!</strong>
                                    <p class="mb-0 mt-1">Pastikan Anda telah memeriksa kondisi barang dengan teliti sebelum menetapkan denda kerusakan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="denda" class="form-label fw-semibold">
                                Jumlah Denda Kerusakan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-currency-dollar text-muted"></i>
                                </span>
                                <input type="number"
                                       name="denda_kerusakan"
                                       id="denda"
                                       class="form-control border-start-0 ps-0 @error('denda_kerusakan') is-invalid @enderror"
                                       placeholder="Masukkan jumlah denda dalam Rupiah"
                                       required
                                       min="0"
                                       step="1000"
                                       value="{{ old('denda_kerusakan') }}">
                                @error('denda_kerusakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Masukkan jumlah denda dalam Rupiah (contoh: 50000 untuk Rp 50.000)</small>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Simpan Denda
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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

    .avatar-initial {
        font-weight: 600;
        font-size: 1.2rem;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
        padding: 15px 20px;
    }

    .alert {
        border-radius: 8px;
    }

    .border {
        border-color: #e9ecef !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format currency input
        const dendaInput = document.getElementById('denda');

        dendaInput.addEventListener('input', function(e) {
            // Remove non-numeric characters except for the decimal point
            let value = e.target.value.replace(/[^\d]/g, '');

            // Update the input value
            e.target.value = value;
        });

        // Add confirmation before submitting
        document.querySelector('form').addEventListener('submit', function(e) {
            const dendaValue = dendaInput.value;
            const formattedDenda = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(dendaValue);

            if (!confirm(`Apakah Anda yakin ingin menetapkan denda sebesar ${formattedDenda}?`)) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
