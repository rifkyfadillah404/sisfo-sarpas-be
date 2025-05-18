<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans'; // Menambahkan properti $table jika nama tabel tidak sesuai dengan konvensi

    protected $fillable = [
        'user_id',
        'barang_id',
        'nama_peminjam',
        'alasan_meminjam',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'status',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengembalian()
    {
    return $this->hasOne(Pengembalians::class);
    }
}
