<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Peminjaman extends Model
{
    protected $table = 'peminjamen'; // Laravel pakai plural default, jadi perlu didefinisikan
    protected $fillable = ['barang_id', 'nama_peminjam', 'alasan_meminjam', 'kondisi_barang', 'tanggal_pinjam', 'jumlah'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
