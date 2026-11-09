<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubcategoryRequest;
use App\Http\Requests\Admin\UpdateSubcategoryRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubcategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Subcategory::query()->with('category')->withCount('menuItems');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where('name', 'like', "%{$term}%");
        }

        $subcategories = $query->orderBy('sort_order')->paginate(15);
        $categories = Category::orderBy('name')->get();

        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(StoreSubcategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $slug = $data['slug'] ?: SlugService::generate($data['name'], Subcategory::class);

        $subcategory = Subcategory::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'status' => $data['status'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        ActivityLog::log('subcategory_created', "Created subcategory '{$subcategory->name}'", $subcategory);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory): RedirectResponse
    {
        $data = $request->validated();

        $subcategory->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'status' => $data['status'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        ActivityLog::log('subcategory_updated', "Updated subcategory '{$subcategory->name}'", $subcategory);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory): RedirectResponse
    {
        $name = $subcategory->name;
        $subcategory->delete();

        ActivityLog::log('subcategory_deleted', "Deleted subcategory '{$name}'");

        return redirect()->route('admin.subcategories.index')->with('success', "Subcategory '{$name}' deleted.");
    }
}
