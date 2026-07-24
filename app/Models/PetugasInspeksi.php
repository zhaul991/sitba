<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetugasInspeksi extends Model
{
    protected $table = 'inspeksi_petugas';

    protected $fillable = [
        'inspeksi_id',
        'petugas_id',
    ];

    public function inspeksi(): BelongsTo
    {
        return $this->belongsTo(Inspeksi::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class);
    }
}
