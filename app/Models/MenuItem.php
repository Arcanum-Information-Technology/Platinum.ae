<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'short_description',
        'full_description',
        'price',
        'discounted_price',
        'primary_image',
        'gallery_images',
        'ingredients',
        'allergens',
        'calories',
        'preparation_time',
        'serving_size',
        'is_vegetarian',
        'is_vegan',
        'is_spicy',
        'spice_level',
        'is_featured',
        'is_available',
        'sort_order',
        'tags',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discounted_price' => 'decimal:2',
            'gallery_images' => 'array',
            'ingredients' => 'array',
            'allergens' => 'array',
            'tags' => 'array',
            'is_vegetarian' => 'boolean',
            'is_vegan' => 'boolean',
            'is_spicy' => 'boolean',
            'spice_level' => 'integer',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class)->withTrashed();
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMetadata::class, 'seoble');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereHas('category', function ($q) {
                $q->whereNull('deleted_at')->where('status', 'published');
            });
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('short_description', 'like', "%{$term}%")
              ->orWhere('full_description', 'like', "%{$term}%");
        });
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->discounted_price ?? $this->price);
    }

    public function getHasDiscountAttribute(): bool
    {
        return !is_null($this->discounted_price) && $this->discounted_price < $this->price;
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->has_discount || $this->price <= 0) {
            return null;
        }

        return (int) round((($this->price - $this->discounted_price) / $this->price) * 100);
    }

    public function getUrlAttribute(): string
    {
        $cat = $this->category && !$this->category->trashed() ? $this->category : null;
        $sub = $this->subcategory && !$this->subcategory->trashed() ? $this->subcategory : null;

        if ($sub && $cat) {
            return route('menu.subitem', [
                'categorySlug' => $cat->slug,
                'subcategorySlug' => $sub->slug,
                'itemSlug' => $this->slug,
            ]);
        }

        if ($cat) {
            return route('menu.item', [
                'categorySlug' => $cat->slug,
                'itemSlug' => $this->slug,
            ]);
        }

        return route('menu.index');
    }
}
