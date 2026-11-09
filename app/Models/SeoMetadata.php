<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMetadata extends Model
{
    protected $table = 'seo_metadata';

    protected $fillable = [
        'seoble_type',
        'seoble_id',
        'route_name',
        'meta_title',
        'meta_description',
        'canonical_url',
        'robots',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_type',
        'custom_json_ld',
    ];

    protected function casts(): array
    {
        return [
            'custom_json_ld' => 'array',
        ];
    }

    public function seoble(): MorphTo
    {
        return $this->morphTo();
    }
}
