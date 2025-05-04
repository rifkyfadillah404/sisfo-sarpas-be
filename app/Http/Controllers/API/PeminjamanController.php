<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:255',
            'alasan_meminjam' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'status' => 'in:pending,approved,rejected,returned',
        ]);

        $peminjaman = Peminjaman::create($validated);
        $peminjaman->load(['barang', 'user']); // load barang untuk relasi

        return response()->json([
            'message' => 'Peminjaman berhasil ditambahkan',
            'data' => [
                'id' => $peminjaman->id,
                'nama_peminjam' => $peminjaman->nama_peminjam,
                'alasan_meminjam' => $peminjaman->alasan_meminjam,
                'jumlah' => $peminjaman->jumlah,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'status' => $peminjaman->status,
                'barang' => [
                    'id' => $peminjaman->barang->id,
                    'nama' => $peminjaman->barang->nama
                ]
            ]
        ], 201);
    }
}
