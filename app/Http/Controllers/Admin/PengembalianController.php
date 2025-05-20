<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalians;
use App\Models\Peminjaman;

class PengembalianController extends Controller
{
    /**
     * Tampilkan daftar pengembalian ke admin.
     */
    public function index(Request $request)
    {
        $query = Pengembalians::with(['peminjaman', 'peminjaman.barang']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_pengembali', 'like', "%{$search}%");
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('tanggal') && !empty($request->tanggal)) {
            $query->whereDate('tanggal_kembali', $request->tanggal);
        }

        $pengembalians = $query->latest()->get();

        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    /**
     * Menyetujui pengembalian (status 'complete').
     */
    public function approve($id)
    {
        $pengembalian = Pengembalians::findOrFail($id);

        if ($pengembalian->status === 'complete') {
            return redirect()->route('admin.pengembalian.index')->with('error', 'Pengembalian ini sudah diselesaikan.');
        }

        // Hitung keterlambatan dan denda keterlambatan
        $pengembalian->hitungKeterlambatan();

        $pengembalian->update(['status' => 'complete']);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'returned']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->increment('stok', $pengembalian->jumlah_dikembalikan);
        }

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil disetujui.');
    }

    /**
     * Menandai pengembalian sebagai rusak (status 'damage').
     */
    public function reject($id)
    {
        $pengembalian = Pengembalians::findOrFail($id);

        $pengembalian->update(['status' => 'damage']);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'rejected']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->decrement('stok', $pengembalian->jumlah_dikembalikan);
        }

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian barang rusak berhasil ditandai.');
    }

    /**
     * Menampilkan form input denda untuk pengembalian rusak.
     */
    public function markDamaged($id)
    {
        $pengembalian = Pengembalians::findOrFail($id);
        return view('admin.pengembalian.markDamaged', compact('pengembalian'));
    }

    /**
     * Menyimpan denda kerusakan.
     */
    public function updateDamaged(Request $request, $id)
    {
        $validated = $request->validate([
            'denda_kerusakan' => 'required|numeric|min:0',
        ]);

        $pengembalian = Pengembalians::findOrFail($id);

        $pengembalian->update([
            'status' => 'damage',
            'denda_kerusakan' => $validated['denda_kerusakan'],
        ]);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'rejected']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->increment('stok', $pengembalian->jumlah_dikembalikan);
        }

        return redirect()->route('admin.pengembalian.index')->with('success', 'Denda kerusakan berhasil diperbarui.');
    }
}
