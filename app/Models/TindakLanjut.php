<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{

    protected $fillable = [

        'temuan_id',
        'rencana_perbaikan',
        'pic',
        'deadline',
        'status',
        'catatan',

    ];


    protected $casts = [
        'deadline' => 'date',
    ];


    public function temuan()
    {
        return $this->belongsTo(Temuan::class);
    }

}
