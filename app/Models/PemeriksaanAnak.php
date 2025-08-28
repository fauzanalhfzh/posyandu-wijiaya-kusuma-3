<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemeriksaanAnak extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    protected $table = 'pemeriksaan_anak';

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class);
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class);
    }

    public function vitamin()
    {
        return $this->belongsTo(Vitamin::class);
    }

    public function imunisasi()
    {
        return $this->belongsTo(Imunisasi::class);
    }

    protected static function booted()
    {
        static::creating(function ($pemeriksaanAnak) {
            // Menghitung usia balita sebelum menyimpan
            if ($pemeriksaanAnak->anak_id && $pemeriksaanAnak->tanggal_pemeriksaan) {
                $anak = Anak::find($pemeriksaanAnak->anak_id);
                $tanggalPemeriksaan = Carbon::parse($pemeriksaanAnak->tanggal_pemeriksaan);

                if ($anak) {
                    $tglLahir = Carbon::parse($anak->tgl_lahir);
                    $usiaBalita = $tglLahir->diffInMonths($tanggalPemeriksaan);
                    $pemeriksaanAnak->usia_balita = $usiaBalita;
                }
            }
        });
    }
}
