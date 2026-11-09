<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $page = Page::published()->where('slug', 'menu')->first();
        $categories = Category::published()->with(['activeMenuItems.category', 'activeMenuItems.subcategory'])->orderBy('sort_order')->get();
        $items = MenuItem::published()->available()->search($request->query('search'))->orderBy('sort_order')->paginate(12);

        return view('website.menu-index', compact('categories', 'items', 'page'));
    }

    public function category(string $categorySlug): View
    {
        $category = Category::published()
            ->where('slug', $categorySlug)
            ->with('subcategories')
            ->firstOrFail();

        $items = MenuItem::published()
            ->available()
            ->where('category_id', $category->id)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('website.category-detail', compact('category', 'items'));
    }

    public function subcategory(string $categorySlug, string $subcategorySlug): View
    {
        $category = Category::published()
            ->where('slug', $categorySlug)
            ->firstOrFail();

        $subcategory = Subcategory::published()
            ->where('category_id', $category->id)
            ->where('slug', $subcategorySlug)
            ->firstOrFail();

        $items = MenuItem::published()
            ->available()
            ->where('subcategory_id', $subcategory->id)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('website.category-detail', [
            'category' => $category,
            'subcategory' => $subcategory,
            'items' => $items,
        ]);
    }

    public function item(string $categorySlug, ?string $subcategorySlug = null, ?string $itemSlug = null): View
    {
        $category = Category::published()->where('slug', $categorySlug)->firstOrFail();

        // 3-segment route: /menu/{category}/{subcategory}/{item}
        if ($itemSlug) {
            $subcategory = Subcategory::published()->where('category_id', $category->id)->where('slug', $subcategorySlug)->first();
            $item = MenuItem::published()
                ->where('category_id', $category->id)
                ->where('slug', $itemSlug)
                ->firstOrFail();

            $relatedItems = MenuItem::published()
                ->available()
                ->where('category_id', $category->id)
                ->where('id', '!=', $item->id)
                ->take(3)
                ->get();

            return view('website.food-detail', compact('item', 'relatedItems', 'category', 'subcategory'));
        }

        // 2-segment route: /menu/{category}/{secondSlug}
        // 1. Check if secondSlug is a subcategory
        $subcategory = Subcategory::published()
            ->where('category_id', $category->id)
            ->where('slug', $subcategorySlug)
            ->first();

        if ($subcategory) {
            $items = MenuItem::published()
                ->available()
                ->where('subcategory_id', $subcategory->id)
                ->orderBy('sort_order')
                ->paginate(12);

            return view('website.category-detail', [
                'category' => $category,
                'subcategory' => $subcategory,
                'items' => $items,
            ]);
        }

        // 2. Otherwise check if secondSlug is a direct menu item
        $item = MenuItem::published()
            ->where('category_id', $category->id)
            ->where('slug', $subcategorySlug)
            ->firstOrFail();

        $relatedItems = MenuItem::published()
            ->available()
            ->where('category_id', $category->id)
            ->where('id', '!=', $item->id)
            ->take(3)
            ->get();

        return view('website.food-detail', compact('item', 'relatedItems', 'category'));
    }
}
