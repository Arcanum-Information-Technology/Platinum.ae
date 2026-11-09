<?php

namespace App\Services;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\OpeningHour;
use App\Models\Setting;

class SchemaService
{
    public function getRestaurantSchema(): array
    {
        $siteName = Setting::get('site_name', 'Saffron & Thyme');
        $siteUrl = config('app.url', url('/'));
        $phone = Setting::get('restaurant_phone', '+1 (555) 234-5678');
        $email = Setting::get('restaurant_email', 'dine@saffronandthyme.com');
        $address = Setting::get('restaurant_address', '124 Gourmet Boulevard');
        $city = Setting::get('restaurant_city', 'San Francisco');
        $state = Setting::get('restaurant_state', 'CA');
        $postalCode = Setting::get('restaurant_postal_code', '94102');
        $country = Setting::get('restaurant_country', 'US');
        $lat = Setting::get('restaurant_latitude', '37.7749');
        $lng = Setting::get('restaurant_longitude', '-122.4194');
        $priceRange = Setting::get('restaurant_price_range', '$$$');
        $cuisine = Setting::get('restaurant_cuisine', 'Modern Continental & Artisanal Fusion');
        $logo = Setting::get('site_logo', asset('assets/images/logo.png'));
        $image = Setting::get('restaurant_hero_image', asset('assets/images/restaurant-exterior.jpg'));

        // Opening hours specification
        $hours = OpeningHour::orderBy('day_of_week')->get();
        $openingHoursSpec = [];
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        foreach ($hours as $h) {
            if ($h->is_closed) {
                continue;
            }
            $day = $dayNames[$h->day_of_week] ?? $h->day_name;
            if ($h->open_time_1 && $h->close_time_1) {
                $openingHoursSpec[] = [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => "https://schema.org/{$day}",
                    'opens' => $h->open_time_1,
                    'closes' => $h->close_time_1,
                ];
            }
            if ($h->open_time_2 && $h->close_time_2) {
                $openingHoursSpec[] = [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => "https://schema.org/{$day}",
                    'opens' => $h->open_time_2,
                    'closes' => $h->close_time_2,
                ];
            }
        }

        // Social Profiles
        $sameAs = array_filter([
            Setting::get('social_facebook'),
            Setting::get('social_instagram'),
            Setting::get('social_twitter'),
            Setting::get('social_tripadvisor'),
        ]);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Restaurant',
            '@id' => "{$siteUrl}/#restaurant",
            'name' => $siteName,
            'image' => str_starts_with($image, 'http') ? $image : asset($image),
            'logo' => str_starts_with($logo, 'http') ? $logo : asset($logo),
            'url' => $siteUrl,
            'telephone' => $phone,
            'email' => $email,
            'priceRange' => $priceRange,
            'servesCuisine' => $cuisine,
            'menu' => route('menu.index'),
            'hasMenu' => route('menu.index'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressLocality' => $city,
                'addressRegion' => $state,
                'postalCode' => $postalCode,
                'addressCountry' => $country,
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $lat,
                'longitude' => (float) $lng,
            ],
            'openingHoursSpecification' => $openingHoursSpec,
            'sameAs' => array_values($sameAs),
        ];
    }

    public function getMenuItemSchema(MenuItem $item): array
    {
        $image = $item->primary_image ? (str_starts_with($item->primary_image, 'http') ? $item->primary_image : asset($item->primary_image)) : null;

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'MenuItem',
            'name' => $item->name,
            'description' => $item->short_description ?: $item->name,
            'image' => $image,
            'offers' => [
                '@type' => 'Offer',
                'price' => (string) $item->effective_price,
                'priceCurrency' => Setting::get('currency_code', 'USD'),
                'availability' => $item->is_available ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'url' => $item->url,
            ],
        ];

        if ($item->calories) {
            $schema['nutrition'] = [
                '@type' => 'NutritionInformation',
                'calories' => "{$item->calories} calories",
            ];
        }

        if ($item->is_vegetarian) {
            $schema['suitableForDiet'] = 'https://schema.org/VegetarianDiet';
        } elseif ($item->is_vegan) {
            $schema['suitableForDiet'] = 'https://schema.org/VeganDiet';
        }

        return $schema;
    }

    public function getCategorySchema(Category $category): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'MenuSection',
            'name' => $category->name,
            'description' => $category->description,
            'url' => route('menu.category', $category->slug),
        ];
    }

    public function getWebPageSchema(string $title, string $description, string $url): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $title,
            'description' => $description,
            'url' => $url,
            'publisher' => [
                '@type' => 'Restaurant',
                'name' => Setting::get('site_name', 'Saffron & Thyme'),
                'url' => config('app.url', url('/')),
            ],
        ];
    }

    public function getBreadcrumbSchema(array $crumbs): array
    {
        $items = [];
        $i = 1;
        foreach ($crumbs as $name => $url) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $i++,
                'name' => $name,
                'item' => $url,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    public function getFaqSchema(array $faqs): array
    {
        $elements = [];
        foreach ($faqs as $faq) {
            $elements[] = [
                '@type' => 'Question',
                'name' => $faq['question'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'] ?? '',
                ],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $elements,
        ];
    }
}
