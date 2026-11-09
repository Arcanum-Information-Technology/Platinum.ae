<?php

namespace App\Services;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\SeoMetadata;
use App\Models\Setting;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;

class SeoService
{
    public function __construct(
        protected SchemaService $schemaService
    ) {}

    public function getMetadata(?Model $entity = null, ?string $routeName = null): array
    {
        $siteName = Setting::get('site_name', 'Saffron & Thyme');
        $defaultDesc = Setting::get('default_meta_description', 'Experience exquisite dining with the finest ingredients and culinary artistry.');
        $defaultImage = Setting::get('default_og_image', asset('assets/images/og-default.jpg'));
        $currentUrl = url()->current();

        $seo = null;
        if ($entity && method_exists($entity, 'seo') && $entity->seo) {
            $seo = $entity->seo;
        } elseif ($routeName) {
            $seo = SeoMetadata::where('route_name', $routeName)->first();
        }

        // Title resolution
        $rawTitle = $seo?->meta_title;
        if (!$rawTitle && $entity) {
            $rawTitle = $entity->title ?? $entity->name ?? null;
        }
        if (!$rawTitle && $routeName) {
            $rawTitle = ucfirst(str_replace(['.', '-', '_'], ' ', $routeName));
        }
        $title = $rawTitle ? "{$rawTitle} | {$siteName}" : $siteName;

        // Description resolution
        $description = $seo?->meta_description;
        if (!$description && $entity) {
            $description = $entity->short_description ?? $entity->excerpt ?? $defaultDesc;
        }
        $description = $description ? strip_tags($description) : $defaultDesc;

        // Canonical URL resolution
        $canonical = $seo?->canonical_url ?: $currentUrl;

        // Robots
        $robots = $seo?->robots ?: 'index, follow';

        // Open Graph
        $ogTitle = $seo?->og_title ?: $rawTitle ?: $siteName;
        $ogDescription = $seo?->og_description ?: $description;
        $ogImage = $seo?->og_image;
        if (!$ogImage && $entity) {
            $ogImage = $entity->primary_image ?? $entity->featured_image ?? $entity->image ?? null;
        }
        $ogImage = $ogImage ? (str_starts_with($ogImage, 'http') ? $ogImage : asset($ogImage)) : $defaultImage;

        // Twitter
        $twitterTitle = $seo?->twitter_title ?: $ogTitle;
        $twitterDescription = $seo?->twitter_description ?: $ogDescription;
        $twitterImage = $seo?->twitter_image ? (str_starts_with($seo->twitter_image, 'http') ? $seo->twitter_image : asset($seo->twitter_image)) : $ogImage;

        // Schema JSON-LD
        $schema = null;
        if ($entity instanceof MenuItem) {
            $schema = $this->schemaService->getMenuItemSchema($entity);
        } elseif ($entity instanceof Page && $entity->slug === 'home') {
            $schema = $this->schemaService->getRestaurantSchema();
        } elseif ($entity instanceof Category) {
            $schema = $this->schemaService->getCategorySchema($entity);
        } else {
            $schema = $this->schemaService->getWebPageSchema($title, $description, $currentUrl);
        }

        return [
            'title' => $title,
            'raw_title' => $rawTitle,
            'meta_description' => $description,
            'canonical_url' => $canonical,
            'robots' => $robots,
            'og_title' => $ogTitle,
            'og_description' => $ogDescription,
            'og_image' => $ogImage,
            'og_url' => $canonical,
            'og_type' => $entity instanceof MenuItem ? 'restaurant.menu_item' : 'website',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $twitterTitle,
            'twitter_description' => $twitterDescription,
            'twitter_image' => $twitterImage,
            'schema_json_ld' => $schema,
        ];
    }
}
