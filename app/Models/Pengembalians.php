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
        'jumlah_dikembalikan',
        'kondisi',
        'denda',
        'status',
        'hari_terlambat',
        'denda_keterlambatan',
        'total_denda'
    ];

    // Relasi ke Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
    
    // Menghitung hari terlambat
    public function hitungKeterlambatan()
    {
        $tenggat = \Carbon\Carbon::parse($this->peminjaman->tanggal_pinjam)->addDays(7); // Batas waktu 7 hari
        $tanggalKembali = \Carbon\Carbon::parse($this->tanggal_kembali);
        
        if ($tanggalKembali->gt($tenggat)) {
            $this->hari_terlambat = $tanggalKembali->diffInDays($tenggat);
            $this->denda_keterlambatan = $this->hari_terlambat * 5000; // Denda per hari Rp 5.000
            $this->total_denda = $this->denda + $this->denda_keterlambatan;
            $this->save();
        }
        
        return $this;
    }
}
