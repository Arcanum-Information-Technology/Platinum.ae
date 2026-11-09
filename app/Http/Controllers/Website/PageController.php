<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        // Reserved special system routes
        if ($slug === 'offers') {
            $offers = Offer::active()->orderBy('sort_order')->get();
            return view('website.offers', compact('offers'));
        }

        $page = Page::published()->where('slug', $slug)->first();

        if (!$page) {
            abort(404, 'Page not found');
        }

        return view('website.page', compact('page'));
    }

    public function brandSubpage(string $brandSlug): View
    {
        $normalized = match ($brandSlug) {
            'shakespeare', 'shakespeare-middle-east' => 'shakespeare-middle-east',
            'otantik', 'otantik-cafe-restaurant' => 'otantik-cafe-restaurant',
            'chinese', 'chinese-connection' => 'chinese-connection',
            default => $brandSlug,
        };

        $page = Page::published()->where('slug', $normalized)->first();

        if (!$page) {
            $page = Page::published()->where('slug', 'brands/' . $normalized)->first();
        }

        if (!$page) {
            abort(404, 'Brand sub-page not found');
        }

        return view('website.page', compact('page'));
    }

    public function preview(Request $request, int $id): View
    {
        if (!Auth::check() || !Auth::user()->can('pages.view')) {
            abort(403, 'Unauthorized preview access');
        }

        $page = Page::findOrFail($id);

        return view('website.page', [
            'page' => $page,
            'isPreview' => true,
        ]);
    }
}
