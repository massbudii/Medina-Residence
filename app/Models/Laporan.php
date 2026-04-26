<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'kawasan_id',
        'dari',
        'sampai',
        'dibuat_oleh',
        'disetujui_oleh',
        'status',
    ];

    // relasi ke kawasan
    public function kawasan()
    {
        return $this->belongsTo(Kawasan::class);
    }

    // 🔥 SESUAI CONTROLLER
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function penyetuju()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
