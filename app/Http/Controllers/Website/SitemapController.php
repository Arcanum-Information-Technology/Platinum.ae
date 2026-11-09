<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Subcategory;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $pages = Page::published()->where('slug', '!=', 'home')->get();
        $categories = Category::published()->get();
        $subcategories = Subcategory::published()->with('category')->get();
        $menuItems = MenuItem::published()->available()->with(['category', 'subcategory'])->get();

        $content = view('website.sitemap', compact('pages', 'categories', 'subcategories', 'menuItems'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
