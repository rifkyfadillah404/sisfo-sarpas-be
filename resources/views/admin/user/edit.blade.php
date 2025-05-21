@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="container-fluid p-0">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0"><i class="bi bi-person-gear me-2"></i>Edit Pengguna</h2>
                <p class="text-muted">Perbarui data pengguna dalam sistem</p>
            </div>
            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Nama -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text" name="name" id="name"
                                        class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Nama lengkap pengguna yang akan ditampilkan di sistem</small>
                            </div>

                            <!-- Email (Readonly) -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" id="email" class="form-control border-start-0 ps-0 bg-light"
                                        value="{{ $user->email }}" readonly disabled>
                                </div>
                                <small class="text-muted">Email tidak dapat diubah</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password Baru <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" id="password"
                                        class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                        placeholder="Masukkan password baru" required>
                                    <button class="btn btn-outline-secondary border-start-0" type="button"
                                        id="togglePassword">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Minimal 6 karakter, kombinasi huruf dan angka</small>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock-fill text-muted"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control border-start-0 ps-0" placeholder="Konfirmasi password baru"
                                        required>
                                    <button class="btn btn-outline-secondary border-start-0" type="button"
                                        id="toggleConfirmPassword">
                                        <i class="bi bi-eye" id="confirmEyeIcon"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Masukkan kembali password untuk konfirmasi</small>
                            </div>
                        </div>
                    </div>

                    <!-- Role (Hidden) -->
                    <input type="hidden" name="role" value="user">
                    @error('role')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror

                    <hr class="my-4">

                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary px-4">
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

        .form-check-input:checked {
            background-color: #1E40AF;
            border-color: #1E40AF;
        }

        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            display: inline-flex;
            align-items: center;
        }

        .badge i {
            margin-right: 0.25rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });

        // Toggle Confirm Password Visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const confirmEyeIcon = document.getElementById('confirmEyeIcon');

            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                confirmEyeIcon.classList.remove('bi-eye');
                confirmEyeIcon.classList.add('bi-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                confirmEyeIcon.classList.remove('bi-eye-slash');
                confirmEyeIcon.classList.add('bi-eye');
            }
        });
    </script>
@endpush
