<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Category::query()->withCount(['subcategories', 'menuItems']);

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where('name', 'like', "%{$term}%");
        }

        $categories = $query->orderBy('sort_order')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $slug = $data['slug'] ?: SlugService::generate($data['name'], Category::class);

        $category = Category::create([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'icon' => $data['icon'] ?? null,
            'status' => $data['status'],
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        if (!empty($data['meta_title']) || !empty($data['meta_description'])) {
            $category->seo()->create([
                'meta_title' => $data['meta_title'] ?? $data['name'],
                'meta_description' => $data['meta_description'] ?? $data['description'],
                'schema_type' => 'MenuSection',
            ]);
        }

        ActivityLog::log('category_created', "Created menu category '{$category->name}'", $category);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        $category->load('seo');
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        $category->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'icon' => $data['icon'] ?? null,
            'status' => $data['status'],
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        $category->seo()->updateOrCreate(
            ['seoble_id' => $category->id, 'seoble_type' => Category::class],
            [
                'meta_title' => $data['meta_title'] ?? $data['name'],
                'meta_description' => $data['meta_description'] ?? $data['description'],
                'schema_type' => 'MenuSection',
            ]
        );

        ActivityLog::log('category_updated', "Updated menu category '{$category->name}'", $category);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $name = $category->name;
        $category->subcategories()->delete();
        $category->delete();

        ActivityLog::log('category_deleted', "Deleted category '{$name}'");

        return redirect()->route('admin.categories.index')->with('success', "Category '{$name}' deleted.");
    }
}
