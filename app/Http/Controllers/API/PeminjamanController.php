<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;

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
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'kondisi_barang' => 'nullable|string|max:255',
            'status' => 'in:pending,approved,rejected',
        ]);


        if (!isset($validated['tanggal_pengembalian'])) {
            $validated['tanggal_pengembalian'] = $validated['tanggal_pinjam'];
        }


        $barang = \App\Models\Barang::find($validated['barang_id']);

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
                'tanggal_pengembalian' => $peminjaman->tanggal_pengembalian,
                'kondisi_barang' => $peminjaman->kondisi_barang,
                'status' => $peminjaman->status,
                'barang' => [
                    'id' => $peminjaman->barang->id,
                    'nama' => $peminjaman->barang->nama
                ]
            ]
        ], 201);
    }

    //buat riwayat

    public function index(Request $request)
    {
        $user = $request->user();

        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => $peminjamans
        ]);
    }
}
