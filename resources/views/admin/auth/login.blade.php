<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Aplikasi Peminjaman Barang</title>
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
      <h5 class="mb-4">Login</h5>

      <!-- Form Login -->
      <form method="POST" action="{{ route('login') }}">
        @csrf

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
            autofocus
          >
        </div>

        <div class="mb-3 text-start">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Masukkan password Anda"
                    required
                >
                <button
                    class="btn bg-white border rounded-end px-3 border-start-0"
                    type="button"
                    id="togglePassword"
                >
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>




        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Login</button>
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

    </div>
  </div>
</div>

<script>
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePasswordBtn.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        eyeIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
</script>


</body>
</html>
