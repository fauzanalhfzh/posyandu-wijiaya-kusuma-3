<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ibu extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    protected $table = 'ibu';

    public function anak()
    {
        return $this->hasMany(Anak::class);
    }
}
