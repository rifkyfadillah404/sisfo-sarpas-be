<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;

class BarangApiController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->get();

        $fortmated = $barangs -> map(function ($barang) {
            return [
                'id' => $barang->id,
                'nama' => $barang->nama,
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
            'data' => $fortmated
        ]);
    }
}
