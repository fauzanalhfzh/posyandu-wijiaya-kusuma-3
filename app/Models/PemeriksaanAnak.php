<?php

namespace App\Models;

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
}
