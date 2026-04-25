<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];

    public function materialKawasan()
    {
       return $this->hasMany(MaterialKawasan::class);
    }

    public function materialMasuk()
    {
        return $this->hasMany(MaterialMasuk::class);
    }

    public function materialTerpakai()
    {
        return $this->hasMany(MaterialTerpakai::class);
    }


}
