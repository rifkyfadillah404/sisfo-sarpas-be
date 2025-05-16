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
        :root {
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --secondary-color: #6c757d;
            --light-bg: #f9fafb;
            --border-radius: 0.75rem;
        }

        body,
        html {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 3rem;
        }

        .form-control {
            padding: 0.8rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: var(--border-radius);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            border-color: var(--primary-color);
            background-color: #fff;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: var(--border-radius);
            padding: 0.8rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(59, 130, 246, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .input-group .form-control {
            border-right: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group .btn {
            border: 1px solid #e5e7eb;
            border-left: 0;
            background: #f9fafb;
            color: var(--secondary-color);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            transition: background-color 0.3s ease;
        }

        .input-group .btn:hover {
            background-color: #f1f1f1;
        }

        .logo {
            max-height: 90px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .welcome-text {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .welcome-text::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 3px;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">

    <div class="container" style="max-width: 480px;">
        <div class="card shadow-sm w-100">
            <div class="card-body text-center">

                <!-- Logo -->
                <img src="{{ asset('assets/LogoTB.png') }}" alt="Logo SMK Taruna Bhakti" class="logo">

                <!-- Judul -->
                <h4 class="welcome-text">Selamat Datang</h4>

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4 text-start">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-envelope text-secondary"></i>
                            </span>
                            <input type="email" name="email" id="email" class="form-control border-start-0"
                                value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4 text-start">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-lock text-secondary"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control border-start-0"
                                placeholder="Masukkan password Anda" required>
                            <button class="btn border" type="button" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-4 text-start">
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
        <div class="text-center mt-3 text-secondary">
            <small>&copy; {{ date('Y') }} SMK Taruna Bhakti - Aplikasi Peminjaman Barang</small>
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

        // Add subtle animation for form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formControls = document.querySelectorAll('.form-control');
            formControls.forEach((control, index) => {
                control.style.opacity = '0';
                control.style.transform = 'translateY(10px)';
                control.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                
                setTimeout(() => {
                    control.style.opacity = '1';
                    control.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });
        });
    </script>

</body>

</html>
