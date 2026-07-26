<?php

namespace App\Observers;

use App\Models\Temuan;
use App\Models\ActivityLog;

class TemuanObserver
{
    /**
     * Handle the Temuan "created" event.
     */
    public function created(Temuan $temuan): void
    {
        ActivityLog::create([
            'user_id' => auth()->id() ?? 1,
            'action' => 'create',
            'model' => 'Temuan',
            'model_id' => $temuan->id,
            'description' => 'Membuat temuan ' . $temuan->nomor_temuan,
        ]);
    }


    /**
     * Handle the Temuan "updated" event.
     */
    public function updated(Temuan $temuan): void
    {
        ActivityLog::create([
            'user_id' => auth()->id() ?? 1,
            'action' => 'update',
            'model' => 'Temuan',
            'model_id' => $temuan->id,
            'description' => 'Mengubah data temuan ' . $temuan->nomor_temuan,
        ]);
    }


    /**
     * Handle the Temuan "deleted" event.
     */
    public function deleted(Temuan $temuan): void
    {
        ActivityLog::create([
            'user_id' => auth()->id() ?? 1,
            'action' => 'delete',
            'model' => 'Temuan',
            'model_id' => $temuan->id,
            'description' => 'Menghapus temuan ' . $temuan->nomor_temuan,
        ]);
    }
}
