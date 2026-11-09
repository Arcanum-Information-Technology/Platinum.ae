<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Media;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_pages' => Page::count(),
            'published_pages' => Page::published()->count(),
            'draft_pages' => Page::draft()->count(),
            'categories' => Category::count(),
            'menu_items' => MenuItem::count(),
            'featured_items' => MenuItem::featured()->count(),
            'media_count' => Media::count(),
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'total_bookings' => ContactMessage::bookings()->count(),
            'unread_bookings' => ContactMessage::bookings()->unread()->count(),
            'total_franchise' => ContactMessage::franchise()->count(),
            'unread_franchise' => ContactMessage::franchise()->unread()->count(),
            'total_contact' => ContactMessage::contact()->count(),
            'unread_contact' => ContactMessage::contact()->unread()->count(),
        ];

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        $recentMessages = ContactMessage::latest()
            ->take(6)
            ->get();

        $recentMenuItems = MenuItem::with('category')
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentActivities', 'recentMessages', 'recentMenuItems'));
    }
}
