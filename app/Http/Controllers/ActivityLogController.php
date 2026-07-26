<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;

        $activities = ActivityLog::query()
            ->with('user')
            ->when($filter, function ($query) use ($filter) {
                $query->where('action', $filter);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('aktivitas.index', compact(
            'activities',
            'filter'
        ));
    }
}
