<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriBarang::query();

        // Jika ada pencarian, filter nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%');
        }

        // Jangan pakai get() langsung jika ingin paginasi nanti
        $kategori = $query->get(); // GUNAKAN QUERY BUKAN get() DI ATAS

        return view('admin.kategori.index', compact('kategori'));
    }


    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);
        KategoriBarang::create(['nama' => $request->nama]);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required']);
        $kategori = KategoriBarang::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriBarang::findOrFail($id);

        // Cek apakah ada barang dalam kategori ini yang sedang dipinjam (dan belum dikembalikan)
        $adaBarangDipinjam = $kategori->barangs()->whereHas('peminjaman', function ($query) {
            $query->whereDoesntHave('pengembalian'); // artinya masih dipinjam
        })->exists();

        if ($adaBarangDipinjam) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak dapat dihapus karena ada barang yang sedang dipinjam.');
        }

        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
