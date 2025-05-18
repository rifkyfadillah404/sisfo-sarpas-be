<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Pengembalians;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        // Set tanggal_pengembalian to 7 days (default) after approval
        $peminjaman->tanggal_pengembalian = Carbon::now()->addDays(7)->toDateString();
        $peminjaman->status = 'approved';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui dengan batas pengembalian ' . $peminjaman->tanggal_pengembalian);
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

        if ($peminjaman->status != 'approved') {
            return redirect()->back()->with('error', 'Hanya peminjaman yang disetujui yang dapat dikembalikan.');
        }

        $barang = $peminjaman->barang;
        $barang->stok += $peminjaman->jumlah;
        $barang->save();

        // Hitung denda jika terlambat
        $denda = 0;
        $today = Carbon::now();
        $tanggalKembali = Carbon::parse($peminjaman->tanggal_pengembalian);
        
        if ($today->gt($tanggalKembali)) {
            // Terlambat, hitung denda
            // Default: 10000 per hari keterlambatan
            $hariTerlambat = $today->diffInDays($tanggalKembali);
            $denda = $hariTerlambat * 10000; // Rp 10.000 per hari
        }

        // Buat entri pengembalian
        Pengembalians::create([
            'peminjaman_id' => $peminjaman->id,
            'nama_pengembali' => $peminjaman->nama_peminjam,
            'tanggal_kembali' => now(),
            'jumlah_dikembalikan' => $peminjaman->jumlah,
            'kondisi' => 'baik', // atau ambil dari input form jika perlu
            'denda' => $denda,
            'status' => 'complete',
        ]);

        $peminjaman->status = 'returned';
        $peminjaman->save();

        $successMessage = 'Peminjaman telah dikembalikan.';
        if ($denda > 0) {
            $successMessage .= ' Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->back()->with('success', $successMessage);
    }
}
