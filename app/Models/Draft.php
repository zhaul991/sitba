<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Draft extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama_draft',
        'file',
        'uploaded_by',
    ];


    public function uploader()
    {
        return $this->belongsTo(
            User::class,
            'uploaded_by'
        );
    }
}
