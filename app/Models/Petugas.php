<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Petugas extends Model
{
    protected $table = 'petugas';

    protected $fillable = [
        'nama_petugas',
        'nip',
    ];

    public function inspeksis(): BelongsToMany
    {
        return $this->belongsToMany(
            Inspeksi::class,
            'inspeksi_petugas',
            'petugas_id',
            'inspeksi_id'
        )->withTimestamps();
    }
}
