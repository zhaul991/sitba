<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspeksi extends Model
{
    protected $table = 'inspeksis';

    protected $fillable = [
        'bandara_id',
        'tanggal',
        'jenis_inspeksi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function bandara(): BelongsTo
    {
        return $this->belongsTo(Bandara::class);
    }

    public function petugas(): BelongsToMany
    {
        return $this->belongsToMany(
            Petugas::class,
            'inspeksi_petugas',
            'inspeksi_id',
            'petugas_id'
        )->withTimestamps();
    }

    public function temuans(): HasMany
    {
        return $this->hasMany(Temuan::class);
    }
}
