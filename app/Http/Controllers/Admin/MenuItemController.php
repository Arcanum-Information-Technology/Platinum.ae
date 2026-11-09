<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenuItemRequest;
use App\Http\Requests\Admin\UpdateMenuItemRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Subcategory;
use App\Services\RedirectService;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function __construct(
        protected RedirectService $redirectService
    ) {}

    public function index(Request $request): View
    {
        $query = MenuItem::query()->with(['category', 'subcategory']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('short_description', 'like', "%{$term}%");
            });
        }

        $items = $query->orderBy('sort_order')->paginate(15);
        $categories = Category::orderBy('name')->get();

        return view('admin.menu-items.index', compact('items', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();
        return view('admin.menu-items.create', compact('categories'));
    }

    public function store(StoreMenuItemRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $slug = $data['slug'] ?: SlugService::generate($data['name'], MenuItem::class);

        // Process array inputs if sent as comma-separated strings
        $ingredients = is_string($request->input('ingredients'))
            ? array_filter(array_map('trim', explode(',', $request->input('ingredients'))))
            : $request->input('ingredients', []);

        $allergens = is_string($request->input('allergens'))
            ? array_filter(array_map('trim', explode(',', $request->input('allergens'))))
            : $request->input('allergens', []);

        $tags = is_string($request->input('tags'))
            ? array_filter(array_map('trim', explode(',', $request->input('tags'))))
            : $request->input('tags', []);

        $menuItem = MenuItem::create([
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'] ?? null,
            'name' => $data['name'],
            'slug' => $slug,
            'short_description' => $data['short_description'] ?? null,
            'full_description' => $data['full_description'] ?? null,
            'price' => $data['price'],
            'discounted_price' => $data['discounted_price'] ?? null,
            'primary_image' => $data['primary_image'] ?? null,
            'gallery_images' => $data['gallery_images'] ?? [],
            'ingredients' => $ingredients,
            'allergens' => $allergens,
            'calories' => $data['calories'] ?? null,
            'preparation_time' => $data['preparation_time'] ?? null,
            'serving_size' => $data['serving_size'] ?? null,
            'is_vegetarian' => $request->boolean('is_vegetarian'),
            'is_vegan' => $request->boolean('is_vegan'),
            'is_spicy' => $request->boolean('is_spicy'),
            'spice_level' => $data['spice_level'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_available' => $request->boolean('is_available', true),
            'sort_order' => $data['sort_order'] ?? 0,
            'tags' => $tags,
            'status' => $data['status'],
        ]);

        // SEO
        $menuItem->seo()->create([
            'meta_title' => $data['meta_title'] ?? $menuItem->name,
            'meta_description' => $data['meta_description'] ?? $menuItem->short_description,
            'og_image' => $menuItem->primary_image,
            'schema_type' => 'MenuItem',
        ]);

        ActivityLog::log('menu_item_created', "Created dish '{$menuItem->name}'", $menuItem);

        return redirect()->route('admin.menu-items.index')
            ->with('success', "Dish '{$menuItem->name}' created successfully.");
    }

    public function edit(MenuItem $menuItem): View
    {
        $menuItem->load('seo');
        $categories = Category::with('subcategories')->orderBy('name')->get();
        return view('admin.menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem): RedirectResponse
    {
        $data = $request->validated();
        $oldSlug = $menuItem->slug;
        $newSlug = $data['slug'];

        if ($oldSlug !== $newSlug && $request->boolean('create_redirect')) {
            $catSlug = $menuItem->category?->slug ?? 'menu';
            $this->redirectService->createRedirect("/menu/{$catSlug}/{$oldSlug}", "/menu/{$catSlug}/{$newSlug}", 301);
        }

        $ingredients = is_string($request->input('ingredients'))
            ? array_filter(array_map('trim', explode(',', $request->input('ingredients'))))
            : $request->input('ingredients', []);

        $allergens = is_string($request->input('allergens'))
            ? array_filter(array_map('trim', explode(',', $request->input('allergens'))))
            : $request->input('allergens', []);

        $tags = is_string($request->input('tags'))
            ? array_filter(array_map('trim', explode(',', $request->input('tags'))))
            : $request->input('tags', []);

        $menuItem->update([
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'] ?? null,
            'name' => $data['name'],
            'slug' => $newSlug,
            'short_description' => $data['short_description'] ?? null,
            'full_description' => $data['full_description'] ?? null,
            'price' => $data['price'],
            'discounted_price' => $data['discounted_price'] ?? null,
            'primary_image' => $data['primary_image'] ?? null,
            'gallery_images' => $data['gallery_images'] ?? [],
            'ingredients' => $ingredients,
            'allergens' => $allergens,
            'calories' => $data['calories'] ?? null,
            'preparation_time' => $data['preparation_time'] ?? null,
            'serving_size' => $data['serving_size'] ?? null,
            'is_vegetarian' => $request->boolean('is_vegetarian'),
            'is_vegan' => $request->boolean('is_vegan'),
            'is_spicy' => $request->boolean('is_spicy'),
            'spice_level' => $data['spice_level'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_available' => $request->boolean('is_available', true),
            'sort_order' => $data['sort_order'] ?? 0,
            'tags' => $tags,
            'status' => $data['status'],
        ]);

        $menuItem->seo()->updateOrCreate(
            ['seoble_id' => $menuItem->id, 'seoble_type' => MenuItem::class],
            [
                'meta_title' => $data['meta_title'] ?? $menuItem->name,
                'meta_description' => $data['meta_description'] ?? $menuItem->short_description,
                'og_image' => $menuItem->primary_image,
                'schema_type' => 'MenuItem',
            ]
        );

        ActivityLog::log('menu_item_updated', "Updated dish '{$menuItem->name}'", $menuItem);

        return redirect()->route('admin.menu-items.index')
            ->with('success', "Dish '{$menuItem->name}' updated successfully.");
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $name = $menuItem->name;
        $menuItem->delete();

        ActivityLog::log('menu_item_deleted', "Deleted dish '{$name}'");

        return redirect()->route('admin.menu-items.index')
            ->with('success', "Dish '{$name}' deleted.");
    }

    public function toggleAvailable(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->is_available = !$menuItem->is_available;
        $menuItem->save();

        return back()->with('success', "Availability updated for '{$menuItem->name}'.");
    }

    public function toggleFeatured(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->is_featured = !$menuItem->is_featured;
        $menuItem->save();

        return back()->with('success', "Featured status updated for '{$menuItem->name}'.");
    }
}
