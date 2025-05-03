<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = ['peminjaman_id', 'tanggal_kembali', 'keterangan'];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
