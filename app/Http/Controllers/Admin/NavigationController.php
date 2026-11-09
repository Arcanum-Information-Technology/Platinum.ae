<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\NavigationItem;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NavigationController extends Controller
{
    public function index(): View
    {
        $headerItems = NavigationItem::location('header')->orderBy('sort_order')->get();
        $footerLinks = NavigationItem::location('footer_links')->orderBy('sort_order')->get();
        $footerLegal = NavigationItem::location('footer_legal')->orderBy('sort_order')->get();
        $publishedPages = Page::published()->orderBy('title')->get();

        return view('admin.navigation.index', compact('headerItems', 'footerLinks', 'footerLegal', 'publishedPages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'location' => ['required', 'string', 'in:header,footer_links,footer_legal'],
            'title' => ['required', 'string', 'max:100'],
            'url' => ['required', 'string', 'max:255'],
            'url_type' => ['required', 'string'],
            'target' => ['required', 'string', 'in:_self,_blank'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $item = NavigationItem::create([
            'location' => $validated['location'],
            'title' => $validated['title'],
            'url' => $validated['url'],
            'url_type' => $validated['url_type'],
            'target' => $validated['target'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => true,
        ]);

        ActivityLog::log('navigation_item_created', "Created navigation link '{$item->title}'");

        return back()->with('success', 'Navigation link created.');
    }

    public function update(Request $request, NavigationItem $navigation): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'url' => ['required', 'string', 'max:255'],
            'target' => ['required', 'string', 'in:_self,_blank'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $navigation->update([
            'title' => $validated['title'],
            'url' => $validated['url'],
            'target' => $validated['target'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        ActivityLog::log('navigation_item_updated', "Updated navigation link '{$navigation->title}'");

        return back()->with('success', 'Navigation link updated.');
    }

    public function destroy(NavigationItem $navigation): RedirectResponse
    {
        $navigation->delete();
        ActivityLog::log('navigation_item_deleted', 'Deleted navigation link');

        return back()->with('success', 'Navigation link removed.');
    }
}
