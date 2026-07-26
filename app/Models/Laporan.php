<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Laporan extends Model
{
    protected $fillable = [
        'bandara_id',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'keterangan',
        'file_surat',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function bandara(): BelongsTo
    {
        return $this->belongsTo(Bandara::class);
    }

    public function temuans(): BelongsToMany
    {
        return $this->belongsToMany(Temuan::class, 'laporan_temuan')
            ->withPivot([
                'menutup_temuan',
                'catatan_verifikasi',
            ])
            ->withTimestamps();
    }
}