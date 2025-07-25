<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemeriksaanIbu extends Model
{
    use SoftDeletes;

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
}
