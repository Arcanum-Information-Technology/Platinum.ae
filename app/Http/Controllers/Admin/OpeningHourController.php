<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\OpeningHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OpeningHourController extends Controller
{
    public function index(): View
    {
        $hours = OpeningHour::orderBy('sort_order')->get();
        return view('admin.opening-hours.index', compact('hours'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->input('hours', []);

        foreach ($data as $id => $row) {
            $hour = OpeningHour::find($id);
            if ($hour) {
                $hour->update([
                    'is_closed' => isset($row['is_closed']),
                    'open_time_1' => $row['open_time_1'] ?? null,
                    'close_time_1' => $row['close_time_1'] ?? null,
                    'open_time_2' => $row['open_time_2'] ?? null,
                    'close_time_2' => $row['close_time_2'] ?? null,
                    'note' => $row['note'] ?? null,
                ]);
            }
        }

        ActivityLog::log('opening_hours_updated', 'Updated restaurant weekly opening hours schedule');

        return back()->with('success', 'Opening hours schedule saved.');
    }
}
