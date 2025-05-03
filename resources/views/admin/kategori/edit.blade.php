<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e9eff1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            background-color: #ffffff;
        }

        .card-body {
            padding: 2rem;
            background-color: #fafafa;
            border-radius: 10px;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.4rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            box-shadow: none;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #6c757d;
            box-shadow: 0 0 0 0.25rem rgba(108, 117, 125, 0.25);
        }

        .btn-custom {
            border-radius: 10px;
            background-color: #28a745;
            color: white;
            font-weight: 600;
            padding: 10px 18px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn-custom:hover {
            background-color: #218838;
        }

        .btn-secondary {
            border-radius: 10px;
            padding: 10px 18px;
            background-color: #6c757d;
            color: white;
            font-weight: 600;
            width: 100%;
            text-align: center;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alert {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
        }

        .alert ul {
            list-style-type: none;
            padding-left: 0;
        }

        .alert li {
            padding: 4px 0;
        }

        /* Focus effect for the input fields */
        .form-control:focus {
            border-color: #5e6e77;
            box-shadow: 0 0 0 0.25rem rgba(94, 110, 119, 0.2);
        }
    </style>
</head>
<body>
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Edit Kategori</h2>

            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $kategori->nama) }}" required>
                </div>

                <button type="submit" class="btn btn-custom">Update</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>

            {{-- Tampilkan pesan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
