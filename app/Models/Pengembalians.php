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
        'denda',
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
        return $this->denda ?? 0;
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
     * Hitung keterlambatan dan denda berdasarkan tanggal pinjam dan tanggal kembali.
     * Denda dihitung sebesar Rp 10.000 per hari keterlambatan.
     *
     * @return void
     */
    public function hitungKeterlambatan()
    {
        // Dapatkan peminjaman terkait
        $peminjaman = $this->peminjaman;

        if (!$peminjaman) {
            return;
        }

        // Konversi tanggal ke Carbon untuk kemudahan perhitungan
        $tanggalJatuhTempo = Carbon::parse($peminjaman->tanggal_pengembalian);
        $tanggalKembali = Carbon::parse($this->tanggal_kembali);

        // Jika tanggal kembali lebih dari tanggal jatuh tempo, hitung keterlambatan
        if ($tanggalKembali->greaterThan($tanggalJatuhTempo)) {
            // Hitung selisih hari (keterlambatan)
            $hariTerlambat = $tanggalKembali->diffInDays($tanggalJatuhTempo);

            // Hitung denda (Rp 10.000 per hari)
            $denda = $hariTerlambat * 10000;

            // Update denda
            $this->denda = $denda;
            $this->save();
        }
    }
}

