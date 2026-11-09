<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'badge',
        'image',
        'discount_amount',
        'promo_code',
        'start_date',
        'end_date',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeCurrent(Builder $query): Builder
    {
        $now = now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $now);
            });
    }

    public function getIsValidAttribute(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($this->start_date && $this->start_date > $now) {
            return false;
        }
        if ($this->end_date && $this->end_date < $now) {
            return false;
        }

        return true;
    }
}
