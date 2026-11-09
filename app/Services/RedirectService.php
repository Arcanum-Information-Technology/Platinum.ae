<?php

namespace App\Services;

use App\Models\Redirect;

class RedirectService
{
    public function findRedirect(string $path): ?Redirect
    {
        $normalized = '/' . ltrim(parse_url($path, PHP_URL_PATH), '/');

        try {
            return Redirect::active()
                ->where('source_url', $normalized)
                ->first();
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function createRedirect(string $source, string $destination, int $statusCode = 301): ?Redirect
    {
        $normalizedSource = '/' . ltrim(parse_url($source, PHP_URL_PATH), '/');
        $normalizedDest = str_starts_with($destination, 'http') ? $destination : ('/' . ltrim(parse_url($destination, PHP_URL_PATH), '/'));

        // Prevent self redirect or loop
        if ($normalizedSource === $normalizedDest) {
            return null;
        }

        // Prevent reverse loop
        $reverse = Redirect::where('source_url', $normalizedDest)
            ->where('destination_url', $normalizedSource)
            ->first();

        if ($reverse) {
            $reverse->delete();
        }

        return Redirect::updateOrCreate(
            ['source_url' => $normalizedSource],
            [
                'destination_url' => $normalizedDest,
                'status_code' => $statusCode,
                'is_active' => true,
            ]
        );
    }
}
