<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoTemuan extends Model
{
    protected $fillable = [
        'temuan_id',
        'nama_file',
        'keterangan',
    ];


    public function temuan()
    {
        return $this->belongsTo(Temuan::class);
    }
}
