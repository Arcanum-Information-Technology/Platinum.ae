<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = [
        'source_url',
        'destination_url',
        'status_code',
        'is_active',
        'hit_count',
        'last_accessed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'status_code' => 'integer',
            'hit_count' => 'integer',
            'last_accessed_at' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function recordHit(): void
    {
        $this->increment('hit_count');
        $this->update(['last_accessed_at' => now()]);
    }
}
