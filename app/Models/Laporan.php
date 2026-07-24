<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
        ];
    }

    public function bandara(): BelongsTo
    {
        return $this->belongsTo(Bandara::class);
    }
}
