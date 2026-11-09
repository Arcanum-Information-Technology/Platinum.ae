<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::query()->with('user');

        if ($request->filled('action')) {
            $query->where('action', $request->query('action'));
        }

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where('description', 'like', "%{$term}%");
        }

        $logs = $query->latest()->paginate(25);

        return view('admin.activity-logs.index', compact('logs'));
    }
}
