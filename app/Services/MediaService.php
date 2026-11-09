<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    protected string $disk = 'public';

    public function upload(UploadedFile $file, array $attributes = []): Media
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension() ?: 'jpg';
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        $subfolder = 'uploads/' . date('Y/m');
        $randomName = Str::random(24) . '.' . strtolower($extension);
        $path = $file->storeAs($subfolder, $randomName, $this->disk);

        $width = null;
        $height = null;

        // Extract dimensions if image
        if (str_starts_with($mimeType, 'image/') && function_exists('getimagesize')) {
            $imageInfo = @getimagesize($file->getRealPath());
            if ($imageInfo) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];
            }
        }

        return Media::create([
            'filename' => $randomName,
            'original_name' => $originalName,
            'path' => $path,
            'disk' => $this->disk,
            'mime_type' => $mimeType,
            'size' => $size,
            'width' => $width,
            'height' => $height,
            'alt_text' => $attributes['alt_text'] ?? pathinfo($originalName, PATHINFO_FILENAME),
            'title' => $attributes['title'] ?? pathinfo($originalName, PATHINFO_FILENAME),
            'caption' => $attributes['caption'] ?? null,
            'created_by' => Auth::id(),
        ]);
    }

    public function delete(Media $media): bool
    {
        if (Storage::disk($media->disk)->exists($media->path)) {
            Storage::disk($media->disk)->delete($media->path);
        }

        return $media->delete();
    }
}
