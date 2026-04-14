<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kawasan extends Model
{
    protected $guarded = [];

    // relasi

    public function typeUnits()
    {
        return $this->belongsToMany(TypeUnit::class);
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }
}
