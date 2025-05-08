<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalians extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengembali',
        'peminjaman_id',
        'tanggal_kembali',
        'kondisi_barang',
        'status'
    ];

    // Relasi ke Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
