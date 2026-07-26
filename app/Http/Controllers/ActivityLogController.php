<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::latest()
            ->with('user')
            ->paginate(15);

        return view('aktivitas.index', compact('activities'));
    }
}
