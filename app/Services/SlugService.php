<?php

namespace App\Services;

use Illuminate\Support\Str;

class SlugService
{
    public static function generate(string $name, string $modelClass, ?int $ignoreId = null, string $field = 'slug'): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::slugExists($slug, $modelClass, $ignoreId, $field)) {
            $count++;
            $slug = "{$originalSlug}-{$count}";
        }

        return $slug;
    }

    protected static function slugExists(string $slug, string $modelClass, ?int $ignoreId, string $field): bool
    {
        $query = $modelClass::where($field, $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->withTrashed()->exists();
    }
}
