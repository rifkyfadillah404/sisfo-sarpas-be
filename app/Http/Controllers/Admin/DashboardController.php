<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalians;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'jumlahBarang' => Barang::count(),
            'jumlahPeminjaman' => Peminjaman::count(),
            'jumlahPengembalian' => Pengembalians::count(),
        ]);
    }

    public function laporanStok()
    {
        $barangs = Barang::all();
        return view('admin.laporan.stok', compact('barangs'));
    }

    public function laporanPeminjaman()
    {
        $peminjaman = Peminjaman::with('barang', 'user')->get();
        return view('admin.laporan.peminjaman', compact('peminjaman'));
    }

    public function laporanPengembalian()
    {
        $pengembalian = Pengembalians::with('peminjaman.barang', 'peminjaman.user')->get();
        return view('admin.laporan.pengembalian', compact('pengembalian'));
    }

}
