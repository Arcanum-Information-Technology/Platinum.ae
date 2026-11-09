<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SeoMetadata;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        $settings = Setting::getGroup('seo');
        $routeSeos = SeoMetadata::whereNotNull('route_name')->get();

        return view('admin.seo.index', compact('settings', 'routeSeos'));
    }

    public function updateDefaults(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'default_meta_title' => ['required', 'string', 'max:255'],
            'default_meta_description' => ['required', 'string', 'max:500'],
            'default_og_image' => ['nullable', 'string', 'max:500'],
            'google_site_verification' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val, 'seo');
        }

        ActivityLog::log('seo_defaults_updated', 'Updated global SEO meta tags and social card settings');

        return back()->with('success', 'Global SEO settings saved.');
    }
}
