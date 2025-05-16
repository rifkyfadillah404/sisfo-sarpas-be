<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Support\Facades\Log;

class BarangApiController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->get();

        $formatted = $barangs->map(function ($barang) {
            // Buat URL yang benar untuk foto
            $fotoUrl = null;
            if ($barang->foto) {
                // Jika path sudah berisi 'storage/', hapus agar tidak duplikat
                $fotoPath = $barang->foto;
                if (str_starts_with($fotoPath, 'storage/')) {
                    $fotoPath = substr($fotoPath, 8);
                }
                $fotoUrl = url('storage/' . $fotoPath);
            }

            return [
                'id' => $barang->id,
                'nama' => $barang->nama,
                'foto' => $fotoUrl,
                'kode' => $barang->kode,
                'stok' => $barang->stok,
                'id_kategori' => $barang->kategori_barang_id,
                'kategori' => [
                    'id' => $barang->kategori->id,
                    'nama_kategori' => $barang->kategori->nama,
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formatted
        ]);
    }
}
