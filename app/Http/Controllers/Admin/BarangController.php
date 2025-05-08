<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->get();
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategori = KategoriBarang::all();
        return view('admin.barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'nama' => 'required',
            'kode' => 'required|unique:barangs,kode',
            'stok' => 'required|numeric',
            'foto' => 'nullable|url',
        ]);

        $data = $request->all();
        $data['foto'] = $request->input('foto');

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = KategoriBarang::all();
        return view('admin.barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'nama' => 'required',
            'kode' => 'required|unique:barangs,kode,' . $id,
            'stok' => 'required|numeric',
            'foto' => 'nullable|url',
        ]);

        $data = $request->all();
        $data['foto'] = $request->input('foto');

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

    // Optional: Cek apakah barang punya peminjaman
    if ($barang->peminjaman()->exists()) {
        return back()->with('error', 'Barang tidak dapat dihapus karena masih dipinjam.');
    }

    // Tidak perlu hapus file jika hanya URL
    $barang->delete();

    return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
}


}
