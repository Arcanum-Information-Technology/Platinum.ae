<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(Request $request): View
    {
        $group = $request->query('tab', 'general');
        $validGroups = ['general', 'branding', 'social', 'header_footer', 'integrations'];

        if (!in_array($group, $validGroups)) {
            $group = 'general';
        }

        $allSettings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('group', 'allSettings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $group = $request->input('group', 'general');
        $settings = $request->input('settings', []);

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, $group);
        }

        Setting::clearCache();

        ActivityLog::log('settings_updated', "Updated {$group} application settings");

        return back()->with('success', 'Settings updated successfully.');
    }
}
