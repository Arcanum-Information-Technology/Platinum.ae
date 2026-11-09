<?php

namespace App\Support;

class AssetUrl
{
    public static function make(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return '';
        }

        // Normalize localhost/127.0.0.1 full URLs pointing to storage or public paths
        if (preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?/(storage/.*)$#i', $path, $matches)) {
            $path = $matches[3];
        } elseif (preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?/(menu-items/.*)$#i', $path, $matches)) {
            $path = $matches[3];
        }

        // If it's an external URL (e.g. https://images.unsplash.com or cloud storage), return as-is
        if (preg_match('#^(https?:)?//#i', $path) || str_starts_with($path, 'data:')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');

        // Check if file exists directly in public/
        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        // If path points to storage/uploads/... or menu-items/..., check public/menu-items/ fallback
        $filename = basename($cleanPath);
        if (file_exists(public_path('menu-items/' . $filename))) {
            return asset('menu-items/' . $filename);
        }

        // Standard asset URL resolution
        $segments = explode('/', $cleanPath);
        $encoded = implode('/', array_map('rawurlencode', $segments));

        return asset($encoded);
    }
}
