<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_barang_id', $request->kategori);
        }

        $barangs = $query->latest()->get();
        $kategori = KategoriBarang::all(); // untuk dropdown

        return view('admin.barang.index', compact('barangs', 'kategori'));
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
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:100|unique:barangs,kode',
            'stok' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['kategori_barang_id', 'nama', 'kode', 'stok',]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-barang', 'public');
            $data['foto'] = $path; // simpan tanpa "storage/"
        }

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
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:100|unique:barangs,kode,' . $id,
            'stok' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['kategori_barang_id', 'nama', 'kode', 'stok']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }

            $path = $request->file('foto')->store('foto-barang', 'public');
            $data['foto'] = $path;
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Cek relasi peminjaman
        if ($barang->peminjaman()->exists()) {
            return back()->with('error', 'Barang tidak dapat dihapus karena masih dipinjam.');
        }

        // Hapus foto fisik jika ada
        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
