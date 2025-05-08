<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengembalians;

class PengembalianUserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_kembali' => 'required|date',
            'kondisi_barang' => 'nullable|string|max:255',
            'status' => 'required|in:complete,damage',
        ]);

        $peminjaman = Peminjaman::with('pengembalian')->findOrFail($validated['peminjaman_id']);

        // Cek apakah peminjaman ini milik user yang login
        if ($peminjaman->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Cek apakah sudah dikembalikan
        if ($peminjaman->pengembalian) {
            return response()->json(['message' => 'Barang sudah dikembalikan'], 400);
        }

        // Simpan data pengembalian
        $pengembalian = Pengembalians::create([
            'nama_pengembali' => auth()->user()->name, // atau pakai nama dari relasi user
            'peminjaman_id' => $validated['peminjaman_id'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'kondisi_barang' => $validated['kondisi_barang'],
            'status' => $validated['status'],
        ]);

        // (Opsional) update status peminjaman
        $peminjaman->update(['status' => 'returned']);

        return response()->json([
            'message' => 'Pengembalian berhasil dicatat',
            'data' => $pengembalian,
        ], 201);
    }
}
