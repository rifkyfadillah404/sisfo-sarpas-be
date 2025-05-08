<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Tampilkan semua permintaan peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with('user', 'barang')->latest()->get();
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

}

