<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationItem extends Model
{
    protected $fillable = [
        'location',
        'parent_id',
        'title',
        'url_type',
        'url',
        'target',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc');
    }

    public function scopeLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getResolvedUrlAttribute(): string
    {
        if (str_starts_with($this->url, 'http://') || str_starts_with($this->url, 'https://') || str_starts_with($this->url, '#')) {
            return $this->url;
        }

        return url($this->url);
    }
}
