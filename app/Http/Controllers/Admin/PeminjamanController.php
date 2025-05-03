<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('barang')->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('admin.peminjaman.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required',
            'tanggal_pinjam' => 'required|date',
            'jumlah' => 'required|numeric',
        ]);

        Peminjaman::create($request->all());
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required',
            'tanggal_pinjam' => 'required|date',
            'jumlah' => 'required|numeric',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->all());
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
