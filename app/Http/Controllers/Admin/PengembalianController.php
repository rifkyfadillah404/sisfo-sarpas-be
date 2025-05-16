<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Pengembalians;

class PengembalianController extends Controller
{
    /**
     * Tampilkan daftar pengembalian ke admin.
     */
    public function index(Request $request)
    {
        // Start the query builder with relationships
        $query = Pengembalians::with(['peminjaman', 'peminjaman.barang']);
        
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_pengembali', 'like', "%{$search}%");
        }
        
        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Apply date filter if provided
        if ($request->has('tanggal') && !empty($request->tanggal)) {
            $query->whereDate('tanggal_kembali', $request->tanggal);
        }
        
        // Get results ordered by latest
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

        // Hitung keterlambatan dan denda
        $pengembalian->hitungKeterlambatan();
        
        $pengembalian->update(['status' => 'complete']);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'returned']);

        // Kembalikan stok barang
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
     * Menyimpan denda untuk pengembalian rusak.
     */
    public function updateDamaged(Request $request, $id)
    {
        $validated = $request->validate([
            'denda' => 'required|numeric|min:0',
        ]);

        $pengembalian = Pengembalians::findOrFail($id);

        $pengembalian->update([
            'status' => 'damage',
            'denda' => $validated['denda'],
        ]);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'rejected']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->increment('stok', $pengembalian->jumlah_dikembalikan);
        }

        return redirect()->route('admin.pengembalian.index')->with('success', 'Denda pengembalian rusak berhasil diperbarui.');
    }
}
