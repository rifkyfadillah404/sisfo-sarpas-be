<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar - Aplikasi Peminjaman Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body, html {
        height: 100%;
    }
    .password-wrapper {
        position: relative;
    }
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
  </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-center">

<div class="container" style="max-width: 500px;">
  <div class="card shadow w-100">
    <div class="card-body text-center">

      <!-- Logo -->
      <img src="{{ asset('assets/LogoTB.png') }}" alt="Logo SMK Taruna Bhakti" class="mb-3" style="max-height: 100px;">

      <!-- Judul -->
      <h5 class="mb-4">Daftar Akun</h5>

      <!-- Form Register -->
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3 text-start">
          <label for="name" class="form-label">Nama</label>
          <input
            type="text"
            name="name"
            id="name"
            class="form-control"
            value="{{ old('name') }}"
            placeholder="Masukkan nama Anda"
            required
            autofocus
          >
        </div>

        <div class="mb-3 text-start">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            value="{{ old('email') }}"
            placeholder="Masukkan email Anda"
            required
          >
        </div>

        <div class="mb-3 text-start">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            name="password"
            id="password"
            class="form-control"
            placeholder="Masukkan password Anda"
            required
          >
        </div>

        <div class="mb-3 text-start">
          <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="form-control"
            placeholder="Konfirmasi password Anda"
            required
          >
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Daftar</button>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger mt-3 text-start">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </form>

      <div class="mt-3">
        <a href="{{ route('login') }}">Sudah punya akun? Login</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
