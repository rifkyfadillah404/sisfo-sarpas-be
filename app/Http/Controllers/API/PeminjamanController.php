<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
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
            'kondisi_barang' => 'nullable|string|max:255',
            'status' => 'in:pending,approved,rejected',
        ]);

        // Cek status barang, jika rusak tidak bisa dipinjam
        $barang = \App\Models\Barang::find($validated['barang_id']);
        if (!$barang || $barang->status === 'rusak') {
            return response()->json([
                'message' => 'Barang tidak dapat dipinjam karena rusak',
                'status' => 'error'
            ], 422);
        }

        // Cek ketersediaan stok
        if ($barang->getStokAvailableAttribute() < $validated['jumlah']) {
            return response()->json([
                'message' => 'Stok barang tidak mencukupi',
                'status' => 'error',
                'stok_tersedia' => $barang->getStokAvailableAttribute()
            ], 422);
        }

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
                'kondisi_barang' => $peminjaman->kondisi_barang,
                'status' => $peminjaman->status,
                'barang' => [
                    'id' => $peminjaman->barang->id,
                    'nama' => $peminjaman->barang->nama
                ]
            ]
        ], 201);
    }

    public function index(Request $request)
    {
        $user = $request->user(); // Dari Sanctum

        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => $peminjamans
        ]);
    }
}
