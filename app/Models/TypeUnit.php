<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeUnit extends Model
{
    protected $guarded = [];

    public function kawasans()
    {
        return $this->belongsToMany(Kawasan::class);
    }
}
