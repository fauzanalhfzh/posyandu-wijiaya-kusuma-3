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

    public function getUsiaBalitaAttribute()
    {
        // Mengakses tanggal lahir dari relasi anak
        $anak = $this->anak; // Relasi ke model Anak

        if ($anak && $anak->tgl_lahir) {
            // Menghitung usia balita berdasarkan tanggal lahir
            return Carbon::parse($anak->tgl_lahir)->age * 12; // Menghitung usia dalam bulan
        }

        return null; // Jika anak tidak ada atau tanggal lahir tidak ada
    }
}
