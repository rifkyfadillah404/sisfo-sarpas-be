<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Tampilkan semua permintaan peminjaman
    public function index(Request $request)
    {
        // Start the query builder with relationships
        $query = Peminjaman::with('user', 'barang');
        
        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_peminjam', 'like', "%{$search}%");
        }
        
        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Get results ordered by latest
        $peminjamans = $query->latest()->get();
        
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // Tampilkan detail 1 peminjaman
    public function show($id)
    {
        $peminjaman = Peminjaman::with('user', 'barang')->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    // Admin menyetujui permintaan peminjaman
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = $peminjaman->barang;

        if ($barang->stok < $peminjaman->jumlah) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        $barang->stok -= $peminjaman->jumlah;
        $barang->save();

        $peminjaman->status = 'approved';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    // Admin menolak peminjaman
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'rejected';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }
    
    // Admin mengembalikan peminjaman
    public function return($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Hanya bisa dikembalikan jika statusnya approved
        if ($peminjaman->status != 'approved') {
            return redirect()->back()->with('error', 'Hanya peminjaman yang disetujui yang dapat dikembalikan.');
        }
        
        // Kembalikan stok barang
        $barang = $peminjaman->barang;
        $barang->stok += $peminjaman->jumlah;
        $barang->save();
        
        // Update status peminjaman
        $peminjaman->status = 'returned';
        $peminjaman->tanggal_kembali = now();
        $peminjaman->save();
        
        return redirect()->back()->with('success', 'Peminjaman telah dikembalikan.');
    }
}

