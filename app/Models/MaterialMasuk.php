<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialMasuk extends Model
{
    protected $table = 'material_masuk';

    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function kawasan()
    {
        return $this->belongsTo(Kawasan::class);
    }
}
