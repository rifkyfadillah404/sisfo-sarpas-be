<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengembalians extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengembali',
        'peminjaman_id',
        'tanggal_kembali',
        'jumlah_dikembalikan',
        'kondisi',
        'denda', // ini bisa dihapus jika sudah tidak digunakan
        'denda_keterlambatan',
        'denda_kerusakan',
        'status',
    ];

    // Accessor attributes
    protected $appends = ['total_denda', 'hari_terlambat'];

    // Relasi ke Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Get total denda attribute
     *
     * @return float
     */
    public function getTotalDendaAttribute()
    {
        return ($this->denda_keterlambatan ?? 0) + ($this->denda_kerusakan ?? 0);
    }

    /**
     * Get hari terlambat attribute
     *
     * @return int
     */
    public function getHariTerlambatAttribute()
    {
        $peminjaman = $this->peminjaman;

        if (!$peminjaman) {
            return 0;
        }

        $tanggalJatuhTempo = Carbon::parse($peminjaman->tanggal_pengembalian);
        $tanggalKembali = Carbon::parse($this->tanggal_kembali);

        if ($tanggalKembali->greaterThan($tanggalJatuhTempo)) {
            return $tanggalKembali->diffInDays($tanggalJatuhTempo);
        }

        return 0;
    }

    /**
     * Hitung keterlambatan dan simpan ke denda_keterlambatan.
     * Denda dihitung sebesar Rp 10.000 per hari keterlambatan.
     *
     * @return void
     */
    public function hitungKeterlambatan()
    {
        $peminjaman = $this->peminjaman;

        if (!$peminjaman) {
            return;
        }

        $tanggalJatuhTempo = Carbon::parse($peminjaman->tanggal_pengembalian);
        $tanggalKembali = Carbon::parse($this->tanggal_kembali);

        if ($tanggalKembali->greaterThan($tanggalJatuhTempo)) {
            $hariTerlambat = $tanggalKembali->diffInDays($tanggalJatuhTempo);
            $denda = $hariTerlambat * 10000;

            $this->denda_keterlambatan = $denda;
            $this->save();
        }
    }
}
