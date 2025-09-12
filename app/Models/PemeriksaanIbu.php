<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemeriksaanIbu extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    protected $table = 'pemeriksaan_ibu';

    public function ibu()
    {
        return $this->belongsTo(Ibu::class);
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class);
    }

    protected static function booted()
    {
        static::creating(function ($pemeriksaanIbu) {
            // Menghitung usia ibu sebelum menyimpan
            if ($pemeriksaanIbu->ibu_id && $pemeriksaanIbu->tanggal_pemeriksaan) {
                $ibu = Ibu::find($pemeriksaanIbu->ibu_id); // Get the mother record
                $tanggalPemeriksaan = Carbon::parse($pemeriksaanIbu->tanggal_pemeriksaan); // Get the examination date

                if ($ibu) {
                    $tglLahir = Carbon::parse($ibu->tgl_lahir); // Get the mother's birthdate
                    $usiaIbu = $tglLahir->diffInYears($tanggalPemeriksaan); // Calculate the mother's age in years
                    $pemeriksaanIbu->usia_ibu = $usiaIbu; // Set the calculated age
                }
            }
        });
    }
}
