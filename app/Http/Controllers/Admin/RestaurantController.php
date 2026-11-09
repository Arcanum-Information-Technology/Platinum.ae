<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function index(): View
    {
        return $this->info();
    }

    public function info(): View
    {
        $info = Setting::getGroup('restaurant');
        return view('admin.restaurant.info', compact('info'));
    }

    public function update(Request $request): RedirectResponse
    {
        return $this->updateInfo($request);
    }

    public function updateInfo(Request $request): RedirectResponse
    {
        $fields = [
            'restaurant_short_desc' => 'textarea',
            'restaurant_full_desc' => 'textarea',
            'restaurant_phone' => 'text',
            'restaurant_email' => 'text',
            'restaurant_address' => 'text',
            'restaurant_city' => 'text',
            'restaurant_state' => 'text',
            'restaurant_country' => 'text',
            'restaurant_postal_code' => 'text',
            'restaurant_latitude' => 'text',
            'restaurant_longitude' => 'text',
            'restaurant_price_range' => 'text',
            'restaurant_cuisine' => 'text',
            'restaurant_hero_image' => 'image',
        ];

        foreach ($fields as $key => $type) {
            Setting::set($key, $request->input($key, ''), 'restaurant', $type);
        }

        ActivityLog::log('restaurant_info_updated', 'Updated restaurant location, contacts, and profile');

        return back()->with('success', 'Restaurant profile updated successfully.');
    }
}
