<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\SeoMetadata;
use App\Services\MediaService;
use App\Services\PageBuilderService;
use App\Services\RedirectService;
use App\Services\SlugService;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected RedirectService $redirectService
    ) {}

    public function index(Request $request): View
    {
        $query = Page::query()->with('author');

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where('title', 'like', "%{$term}%")
                  ->orWhere('slug', 'like', "%{$term}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $pages = $query->orderBy('sort_order', 'asc')->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $slug = $data['slug'] ?: SlugService::generate($data['title'], Page::class);

        $page = Page::create([
            'title' => $data['title'],
            'slug' => $slug,
            'template' => $data['template'],
            'status' => $data['status'],
            'featured_image' => $data['featured_image'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'published_at' => $data['status'] === 'published' ? ($data['published_at'] ?? now()) : null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        // Save SEO
        $page->seo()->create([
            'meta_title' => $data['meta_title'] ?? $data['title'],
            'meta_description' => $data['meta_description'] ?? ($data['excerpt'] ?? null),
            'canonical_url' => $data['canonical_url'] ?? null,
            'robots' => $data['robots'] ?? 'index, follow',
            'og_title' => $data['og_title'] ?? $data['title'],
            'og_description' => $data['og_description'] ?? ($data['excerpt'] ?? null),
            'og_image' => $data['og_image'] ?? ($data['featured_image'] ?? null),
            'twitter_title' => $data['twitter_title'] ?? ($data['og_title'] ?? $data['title']),
            'twitter_description' => $data['twitter_description'] ?? ($data['og_description'] ?? ($data['excerpt'] ?? null)),
            'twitter_image' => $data['twitter_image'] ?? ($data['og_image'] ?? ($data['featured_image'] ?? null)),
        ]);

        ActivityLog::log('page_created', "Created page '{$page->title}'", $page);

        return redirect()->route('admin.pages.sections', $page->id)
            ->with('success', 'Page created! You can now configure its sections.');
    }

    public function edit(Page $page): View
    {
        $page->load('seo');
        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $data = $request->validated();
        $oldSlug = $page->slug;
        $newSlug = $data['slug'];

        if ($oldSlug !== $newSlug && $request->boolean('create_redirect')) {
            $this->redirectService->createRedirect("/{$oldSlug}", "/{$newSlug}", 301);
        }

        $page->update([
            'title' => $data['title'],
            'slug' => $newSlug,
            'template' => $data['template'],
            'status' => $data['status'],
            'featured_image' => $data['featured_image'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'published_at' => $data['status'] === 'published' ? ($data['published_at'] ?? $page->published_at ?? now()) : null,
            'updated_by' => Auth::id(),
        ]);

        // Update or create SEO
        $page->seo()->updateOrCreate(
            ['seoble_id' => $page->id, 'seoble_type' => Page::class],
            [
                'meta_title' => $data['meta_title'] ?? $data['title'],
                'meta_description' => $data['meta_description'] ?? $data['excerpt'],
                'canonical_url' => $data['canonical_url'] ?? null,
                'robots' => $data['robots'] ?? 'index, follow',
                'og_title' => $data['og_title'] ?? $data['title'],
                'og_description' => $data['og_description'] ?? $data['excerpt'],
                'og_image' => $data['og_image'] ?? $data['featured_image'],
                'twitter_title' => $data['og_title'] ?? $data['title'],
                'twitter_description' => $data['og_description'] ?? $data['excerpt'],
                'twitter_image' => $data['og_image'] ?? $data['featured_image'],
            ]
        );

        ActivityLog::log('page_updated', "Updated page '{$page->title}'", $page);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->is_system) {
            return back()->with('error', 'Core system pages cannot be deleted.');
        }

        $title = $page->title;
        $page->delete();

        ActivityLog::log('page_deleted', "Deleted page '{$title}'");

        return redirect()->route('admin.pages.index')
            ->with('success', "Page '{$title}' moved to trash.");
    }

    public function duplicate(Page $page): RedirectResponse
    {
        $newTitle = $page->title . ' (Copy)';
        $newSlug = SlugService::generate($newTitle, Page::class);

        $newPage = $page->replicate([
            'is_system',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
        $newPage->title = $newTitle;
        $newPage->slug = $newSlug;
        $newPage->status = 'draft';
        $newPage->is_system = false;
        $newPage->created_by = Auth::id();
        $newPage->updated_by = Auth::id();
        $newPage->save();

        // Duplicate sections
        foreach ($page->sections as $sec) {
            $newSec = $sec->replicate(['created_at', 'updated_at']);
            $newSec->page_id = $newPage->id;
            $newSec->save();
        }

        ActivityLog::log('page_duplicated', "Duplicated page '{$page->title}' as '{$newPage->title}'", $newPage);

        return redirect()->route('admin.pages.sections', $newPage->id)
            ->with('success', "Page duplicated as '{$newPage->title}'.");
    }

    public function sections(Page $page): View
    {
        $page->load('sections');
        $availableSections = PageBuilderService::getAvailableSections();

        return view('admin.pages.sections', compact('page', 'availableSections'));
    }

    public function addSection(Request $request, Page $page): RedirectResponse
    {
        $request->validate([
            'section_type' => ['required', 'string'],
        ]);

        $available = PageBuilderService::getAvailableSections();
        $type = $request->input('section_type');

        if (!isset($available[$type])) {
            return back()->with('error', 'Invalid section type.');
        }

        $maxSort = $page->sections()->max('sort_order') ?? 0;

        PageSection::create([
            'page_id' => $page->id,
            'section_type' => $type,
            'sort_order' => $maxSort + 1,
            'data' => $available[$type]['defaults'] ?? [],
            'is_active' => true,
        ]);

        ActivityLog::log('section_added', "Added section '{$type}' to page '{$page->title}'", $page);

        return back()->with('success', "Section added successfully.");
    }

    public function updateSection(Request $request, Page $page, PageSection $section): RedirectResponse
    {
        $data = $request->input('data', []);

        if ($request->boolean('structured')) {
            foreach ($request->file('upload', []) as $key => $file) {
                if ($file instanceof UploadedFile) {
                    $media = app(MediaService::class)->upload($file);
                    $data[$key] = 'storage/'.$media->path;
                }
            }
            $section->data = $this->normalizeSectionData(is_array($data) ? $data : []);
        } else {
            $existing = $section->data ?? [];
            foreach ($data as $key => $value) {
                if (!is_array($existing[$key] ?? null)) {
                    $existing[$key] = $value;
                }
            }
            $section->data = $existing;
        }

        $section->save();

        ActivityLog::log('section_updated', "Updated section #{$section->id} on page '{$page->title}'", $page);

        return back()->with('success', 'Section configuration saved.');
    }

    public function toggleSection(Page $page, PageSection $section): RedirectResponse
    {
        $section->is_active = !$section->is_active;
        $section->save();

        return back()->with('success', 'Section status updated.');
    }

    public function storeSection(Request $request, Page $page): RedirectResponse
    {
        return $this->addSection($request, $page);
    }

    public function destroySection(Page $page, PageSection $section): RedirectResponse
    {
        return $this->deleteSection($page, $section);
    }

    public function deleteSection(Page $page, PageSection $section): RedirectResponse
    {
        $section->delete();
        ActivityLog::log('section_deleted', "Removed section from page '{$page->title}'", $page);

        return back()->with('success', 'Section removed.');
    }

    public function reorderSections(Request $request, Page $page): JsonResponse
    {
        $order = $request->input('order', []); // array of section IDs

        foreach ($order as $index => $id) {
            PageSection::where('page_id', $page->id)
                ->where('id', $id)
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function normalizeSectionData(array $data): array
    {
        $clean = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = $this->normalizeSectionData($value);
                if ($this->isListOfRows($value)) {
                    $value = array_values(array_filter($value, fn ($row) => is_array($row) && $this->rowHasContent($row)));
                }
            }
            $clean[$key] = $value;
        }

        return $clean;
    }

    private function isListOfRows(array $value): bool
    {
        if ($value === []) {
            return false;
        }

        foreach ($value as $key => $row) {
            if (!is_array($row) || (!is_int($key) && !ctype_digit((string) $key))) {
                return false;
            }
        }

        return true;
    }

    private function rowHasContent(array $row): bool
    {
        foreach ($row as $value) {
            if (is_array($value) && $this->rowHasContent($value)) {
                return true;
            }
            if (is_string($value) && trim($value) !== '') {
                return true;
            }
        }

        return false;
    }
}
