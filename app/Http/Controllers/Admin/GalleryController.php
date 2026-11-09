<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::withCount('items')->orderBy('sort_order')->paginate(15);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = SlugService::generate($validated['title'], Gallery::class);

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'cover_image' => $validated['cover_image'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        ActivityLog::log('gallery_created', "Created photo gallery '{$gallery->title}'", $gallery);

        return redirect()->route('admin.galleries.items', $gallery->id)->with('success', 'Gallery created! You can now add photos.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:galleries,slug,' . $gallery->id],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $gallery->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'cover_image' => $validated['cover_image'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        ActivityLog::log('gallery_updated', "Updated gallery '{$gallery->title}'", $gallery);

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $title = $gallery->title;
        $gallery->delete();

        ActivityLog::log('gallery_deleted', "Deleted gallery '{$title}'");

        return redirect()->route('admin.galleries.index')->with('success', "Gallery '{$title}' deleted.");
    }

    public function items(Gallery $gallery): View
    {
        $gallery->load('items');
        return view('admin.galleries.items', compact('gallery'));
    }

    public function addItem(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'image_path' => ['required', 'string', 'max:500'],
            'title' => ['nullable', 'string', 'max:255'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string'],
        ]);

        $maxSort = $gallery->items()->max('sort_order') ?? 0;

        GalleryItem::create([
            'gallery_id' => $gallery->id,
            'image_path' => $validated['image_path'],
            'title' => $validated['title'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $maxSort + 1,
        ]);

        ActivityLog::log('gallery_item_added', "Added image to gallery '{$gallery->title}'", $gallery);

        return back()->with('success', 'Photo added to gallery.');
    }

    public function deleteItem(Gallery $gallery, GalleryItem $item): RedirectResponse
    {
        $item->delete();
        return back()->with('success', 'Photo removed from gallery.');
    }
}
