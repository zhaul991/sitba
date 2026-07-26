<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(
        string $action,
        string $model,
        int $modelId,
        string $description
    ): void {

        ActivityLog::create([
            'user_id' => Auth::id() ?? 1,
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
        ]);
    }
}
