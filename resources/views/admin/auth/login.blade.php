<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Aplikasi Peminjaman Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }

        .card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
            border-color: #86b7fe;
        }

        .btn-primary {
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .input-group .form-control {
            border-right: 0;
        }

        .input-group .btn {
            border-left: 0;
            background: #fff;
            color: #6c757d;
            border-radius: 0 0.5rem 0.5rem 0;
            transition: background-color 0.3s ease;
        }

        .input-group .btn:hover {
            background-color: #f1f1f1;
        }

        .logo {
            max-height: 80px;
            margin-bottom: 1.5rem;
        }

        .alert {
            border-radius: 0.5rem;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">

    <div class="container" style="max-width: 460px;">
        <div class="card shadow-sm w-100">
            <div class="card-body text-center">

                <!-- Logo -->
                <img src="{{ asset('assets/LogoTB.png') }}" alt="Logo SMK Taruna Bhakti" class="logo">

                <!-- Judul -->
                <h4 class="mb-4 text-primary fw-semibold">Selamat Datang</h4>

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3 text-start">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Masukkan password Anda" required>
                            <button class="btn border" type="button" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
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

        togglePasswordBtn.addEventListener('click', function() {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>

</body>

</html>
