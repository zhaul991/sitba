<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temuan extends Model
{
    protected $fillable = [
        'inspeksi_id',
        'nomor_temuan',
        'uraian_temuan',
        'unsur_elemen',
        'tingkat_risiko',
        'lokasi',
        'status',
        'tanggal_close',
        'keterangan_penutupan',
    ];

    protected $casts = [
        'tanggal_close' => 'date',
    ];

    public function inspeksi()
    {
        return $this->belongsTo(Inspeksi::class);
    }

    public function foto()
    {
        return $this->hasMany(FotoTemuan::class);
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class);
    }
}
