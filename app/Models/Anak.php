<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anak extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    protected $table = 'anak';

    public function ibu()
    {
        return $this->belongsTo(Ibu::class);
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class);
    }

    public function pemeriksaanAnak()
    {
        return $this->hasMany(PemeriksaanAnak::class);
    }
}
