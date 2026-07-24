<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bandara extends Model
{
    protected $fillable = [
        'nama_bandara',
        'kode_bandara',
        'lokasi',
        'status'
    ];

    public function inspeksis()
    {
        return $this->hasMany(Inspeksi::class);
    }


    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
}
