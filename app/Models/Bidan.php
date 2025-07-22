<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidan extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'bidan';

    public function pemeriksaanAnak()
    {
        return $this->hasMany(PemeriksaanAnak::class);
    }

    public function pemeriksaanIbu()
    {
        return $this->hasMany(PemeriksaanIbu::class);
    }
}
