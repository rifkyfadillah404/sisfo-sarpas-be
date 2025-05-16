<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Pengembalians;

class PengembalianController extends Controller
{
    // Menyimpan data pengembalian
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengembali' => 'required|string|max:255',
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_kembali' => 'required|date',
            'jumlah_dikembalikan' => 'required|integer|min:1',
            'status' => 'required|in:pending,complete,damage',
            'kondisi' => 'required|string|max:255',
            'denda' => 'nullable|numeric|min:0',
        ]);

        // Temukan peminjaman berdasarkan ID
        $peminjaman = Peminjaman::with('barang')->findOrFail($validated['peminjaman_id']);

        // Cek apakah peminjaman sudah dikembalikan (status = 'returned')
        if ($peminjaman->status === 'returned') {
            return response()->json([
                'success' => false,
                'message' => 'Barang dari peminjaman ini sudah dikembalikan dan tidak dapat dikembalikan lagi.'
            ], 400);
        }

        // Cek apakah peminjaman sudah di-ACC oleh admin
        if ($peminjaman->status != 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman ini belum di-ACC oleh admin.'
            ], 400);
        }

        // Proses pengembalian
        $pengembalian = Pengembalians::create([
            'nama_pengembali'     => $validated['nama_pengembali'],
            'peminjaman_id'       => $validated['peminjaman_id'],
            'tanggal_kembali'     => $validated['tanggal_kembali'],
            'jumlah_dikembalikan' => $validated['jumlah_dikembalikan'],
            'status'              => $validated['status'],
            'kondisi'             => $validated['kondisi'],
            'denda'               => $validated['denda'] ?? 0,
        ]);
        
        // Hitung keterlambatan dan denda
        $pengembalian->hitungKeterlambatan();

        // Update status peminjaman menjadi 'returned'
        $peminjaman->update(['status' => 'returned']);

        // Tambah stok barang kembali
        if ($peminjaman->barang) {
            $peminjaman->barang->increment('stok', $validated['jumlah_dikembalikan']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pengembalian berhasil disimpan.',
            'data'    => $pengembalian
        ], 201);
    }


    // Menampilkan semua data pengembalian
    public function index()
    {
        // Mengambil data pengembalian dengan relasi peminjaman
        $pengembalians = Pengembalians::with('peminjaman')->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $pengembalians
        ]);
    }

    // Menampilkan detail pengembalian berdasarkan ID
    public function show($id)
    {
        // Mencari pengembalian berdasarkan ID
        $pengembalian = Pengembalians::with('peminjaman')->find($id);

        // Jika pengembalian tidak ditemukan
        if (!$pengembalian) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengembalian tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pengembalian
        ]);
    }

    // Menampilkan peminjaman yang belum dikembalikan
    public function getPeminjamanBelumDikembalikan()
    {
        // Hanya ambil peminjaman yang sudah disetujui admin dan belum dikembalikan
        $peminjaman = Peminjaman::with('barang')
            ->where('status', 'approved')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $peminjaman
        ]);
    }
}
