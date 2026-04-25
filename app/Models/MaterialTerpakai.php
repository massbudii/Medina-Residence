<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTerpakai extends Model
{
    protected $guarded = [];

    public function kawasan()
    {
        return $this->belongsTo(Kawasan::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
