<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_barang_id', 'nama', 'foto', 'kode', 'stok'];

    // Relasi ke kategori barang
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Menambahkan akses data stok yang lebih mudah
    public function getStokAvailableAttribute()
    {
        // Hitung jumlah barang yang belum dikembalikan
        $jumlahDipinjam = \App\Models\Peminjaman::where('barang_id', $this->id)
            ->whereDoesntHave('pengembalian') // hanya yg belum dikembalikan
            ->sum('jumlah');

        return $this->stok - $jumlahDipinjam;
    }
}
