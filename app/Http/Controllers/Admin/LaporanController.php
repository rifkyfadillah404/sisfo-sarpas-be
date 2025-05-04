<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class LaporanController extends Controller
{
    public function stok()
    {
        $data = Barang::all();
        return view('admin.laporan.stok', compact('data'));
    }

    public function peminjaman()
    {
        $data = Peminjaman::with('user', 'barang')->latest()->get();
        return view('admin.laporan.peminjaman', compact('data')); // Ganti $peminjaman dengan $data
    }

    public function pengembalian()
    {
        $pengembalian = Pengembalian::with('peminjaman.user', 'peminjaman.barang')->latest()->get();
        return view('admin.laporan.pengembalian', compact('pengembalian'));
    }
}
