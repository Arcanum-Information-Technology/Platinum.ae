<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\OpeningHour;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Setting;
use App\Models\Testimonial;

class PageBuilderService
{
    public static function getAvailableSections(): array
    {
        $sections = PlatinumSections::definitions();
        $sections['hero'] = $sections['plat_hero'];
        return $sections;
    }

    public function getSectionData(PageSection $section): array
    {
        $type = $section->section_type;
        $data = $section->data ?? [];

        // Attach live models if needed
        if ($type === 'plat_brands' || $type === 'plat_branches_showcase') {
            $data['categories'] = Category::published()->with(['activeMenuItems' => function ($q) {
                $q->take(6);
            }])->orderBy('sort_order')->get();
        } elseif ($type === 'plat_hours_booking') {
            $data['hours'] = OpeningHour::orderBy('sort_order')->get();
            $data['categories'] = Category::published()->orderBy('sort_order')->get();
        } elseif ($type === 'plat_testimonials' || $type === 'sh_reviews') {
            $data['testimonials'] = Testimonial::published()->orderBy('sort_order')->get();
        } elseif ($type === 'plat_about_intro' || $type === 'plat_story_ceo') {
            $data['panini_item'] = MenuItem::where('slug', 'like', '%panini%')->first();
        } elseif ($type === 'featured_food') {
            $limit = data_get($data, 'limit', 6);
            $data['items'] = MenuItem::with(['category', 'subcategory'])
                ->published()
                ->available()
                ->featured()
                ->take($limit)
                ->get();
        } elseif ($type === 'food_grid') {
            $limit = data_get($data, 'limit', 12);
            $data['categories'] = Category::published()->with(['activeMenuItems' => function ($q) use ($limit) {
                $q->take($limit);
            }])->orderBy('sort_order')->get();
        } elseif ($type === 'food_categories') {
            $data['categories'] = Category::published()->orderBy('sort_order')->get();
        } elseif ($type === 'testimonials') {
            $data['testimonials'] = Testimonial::published()->orderBy('sort_order')->take(6)->get();
        } elseif ($type === 'faq') {
            $data['faqs'] = Faq::published()->orderBy('sort_order')->get();
        } elseif ($type === 'gallery') {
            $limit = data_get($data, 'limit', 6);
            $gallery = Gallery::active()->with(['items' => function ($q) use ($limit) {
                $q->take($limit);
            }])->first();
            $data['gallery'] = $gallery;
        } elseif ($type === 'opening_hours' || $type === 'contact_info') {
            $data['hours'] = OpeningHour::orderBy('day_of_week')->get();
        }

        return $data;
    }
}
