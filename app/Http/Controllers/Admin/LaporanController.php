<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengembalians;

class LaporanController extends Controller
{
    public function stok(Request $request)
    {
        $query = Barang::with('kategori');

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
        }

        // Apply kategori filter
        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->where('kategori_barang_id', $request->kategori);
        }

        $data = $query->get();
        return view('admin.laporan.stok', compact('data'));
    }

    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with('user', 'barang');

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_peminjam', 'like', '%' . $request->search . '%');
        }

        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Apply date filter
        if ($request->has('tanggal') && !empty($request->tanggal)) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }

        $data = $query->latest()->get();
        return view('admin.laporan.peminjaman', compact('data'));
    }

    public function pengembalian(Request $request)
    {
        $query = Pengembalians::with('peminjaman.user', 'peminjaman.barang');

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_pengembali', 'like', '%' . $request->search . '%');
        }

        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Apply date filter
        if ($request->has('tanggal') && !empty($request->tanggal)) {
            $query->whereDate('tanggal_kembali', $request->tanggal);
        }

        $pengembalian = $query->latest()->get();
        return view('admin.laporan.pengembalian', compact('pengembalian'));
    }
}
