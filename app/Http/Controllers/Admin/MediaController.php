<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService
    ) {}

    public function index(Request $request): View
    {
        $query = Media::query()->with('creator');

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where('filename', 'like', "%{$term}%")
                  ->orWhere('original_name', 'like', "%{$term}%")
                  ->orWhere('alt_text', 'like', "%{$term}%");
        }

        $media = $query->latest()->paginate(24);

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => ['required', 'array'],
            'files.*' => ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:10240'], // 10MB max
        ]);

        $uploadedCount = 0;
        foreach ($request->file('files') as $file) {
            $this->mediaService->upload($file);
            $uploadedCount++;
        }

        ActivityLog::log('media_uploaded', "Uploaded {$uploadedCount} new media asset(s)");

        return back()->with('success', "{$uploadedCount} image(s) uploaded successfully.");
    }

    public function destroy(Media $medium): RedirectResponse
    {
        $this->mediaService->delete($medium);
        ActivityLog::log('media_deleted', "Deleted media file '{$medium->original_name}'");

        return back()->with('success', 'Media asset deleted.');
    }

    // JSON API for modal picker
    public function apiList(Request $request): JsonResponse
    {
        return $this->apiIndex($request);
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $query = Media::query();

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where('original_name', 'like', "%{$term}%")
                  ->orWhere('alt_text', 'like', "%{$term}%");
        }

        $items = $query->latest()->take(60)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'url' => $item->url,
                'original_name' => $item->original_name,
                'alt_text' => $item->alt_text,
                'formatted_size' => $item->formatted_size,
            ];
        });

        return response()->json(['data' => $items]);
    }

    public function apiUpload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:10240'],
        ]);

        $media = $this->mediaService->upload($request->file('file'));

        ActivityLog::log('media_uploaded_api', "Uploaded media asset '{$media->original_name}'");

        return response()->json([
            'id' => $media->id,
            'url' => $media->url,
            'original_name' => $media->original_name,
            'alt_text' => $media->alt_text,
        ]);
    }
}
