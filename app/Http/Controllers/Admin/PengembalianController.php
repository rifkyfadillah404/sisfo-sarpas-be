<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.barang')->get();
        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    public function create()
    {
        $peminjaman = Peminjaman::all();
        return view('admin.pengembalian.create', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Pengembalian::create($request->all());
        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $peminjaman = Peminjaman::all();
        return view('admin.pengembalian.edit', compact('pengembalian', 'peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update($request->all());
        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();
        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
