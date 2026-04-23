<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Type;

class MaterialKawasan extends Model
{
    protected $table = 'material_kawasan';

    protected $guarded = [];


    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function kawasan()
    {
        return $this->belongsTo(Kawasan::class);
    }
}
