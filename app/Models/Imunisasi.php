<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imunisasi extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'imunisasi';

    public function anak()
    {
        return $this->hasMany(Anak::class);
    }
}
