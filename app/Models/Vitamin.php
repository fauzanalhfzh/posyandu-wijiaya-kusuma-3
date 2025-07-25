<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vitamin extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'vitamin';

    public function pemeriksaanAnak()
    {
        return $this->hasMany(PemeriksaanAnak::class);
    }
}
