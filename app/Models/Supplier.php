<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Supplier extends Model
{
    protected $guarded = [];

    /**
     * Accessor No HP dengan penanganan dekripsi aman.
     */
    public function getNoHpAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Mutator No HP untuk enkripsi data baru.
     */
    public function setNoHpAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['no_hp'] = $value;
        } else {
            $this->attributes['no_hp'] = Crypt::encryptString($value);
        }
    }

    /**
     * Accessor Alamat Supplier dengan penanganan dekripsi aman.
     */
    public function getAlamatSupplierAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Mutator Alamat Supplier untuk enkripsi data baru.
     */
    public function setAlamatSupplierAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['alamat_supplier'] = $value;
        } else {
            $this->attributes['alamat_supplier'] = Crypt::encryptString($value);
        }
    }

    public function materialMasuk()
    {
        return $this->hasMany(MaterialMasuk::class);
    }
}
