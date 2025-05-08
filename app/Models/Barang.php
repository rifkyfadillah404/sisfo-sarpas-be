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
        // Menghitung stok yang tersedia dengan mengurangi peminjaman yang belum dikembalikan
        $stokDipinjam = $this->peminjaman()->whereNull('tanggal_kembali')->sum('jumlah');
        return $this->stok - $stokDipinjam;
    }
}
