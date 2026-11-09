<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Media;
use App\Models\MenuItem;
use App\Models\NavigationItem;
use App\Models\Offer;
use App\Models\OpeningHour;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ShakespeareWebsiteSeeder extends Seeder
{
    public function run(): void
    {
        $dataFile = database_path('data/shakespeare_website_data.json');

        if (!File::exists($dataFile)) {
            $this->command?->error("Website data file not found at: {$dataFile}");
            return;
        }

        $data = json_decode(File::get($dataFile), true);

        DB::transaction(function () use ($data) {
            // 1. Settings
            if (!empty($data['settings'])) {
                foreach ($data['settings'] as $s) {
                    Setting::updateOrCreate(
                        ['key' => $s['key']],
                        [
                            'value' => $s['value'],
                            'group' => $s['group'] ?? 'general',
                            'type' => $s['type'] ?? 'text',
                            'description' => $s['description'] ?? null,
                        ]
                    );
                }
            }

            // 2. Opening Hours
            if (!empty($data['opening_hours'])) {
                foreach ($data['opening_hours'] as $h) {
                    OpeningHour::updateOrCreate(
                        ['day_of_week' => $h['day_of_week']],
                        [
                            'day_name' => $h['day_name'] ?? '',
                            'is_closed' => $h['is_closed'] ?? false,
                            'open_time_1' => $h['open_time_1'] ?? null,
                            'close_time_1' => $h['close_time_1'] ?? null,
                            'open_time_2' => $h['open_time_2'] ?? null,
                            'close_time_2' => $h['close_time_2'] ?? null,
                            'note' => $h['note'] ?? null,
                            'sort_order' => $h['sort_order'] ?? 0,
                        ]
                    );
                }
            }

            // 3. Categories & Subcategories
            $catMap = [];
            if (!empty($data['categories'])) {
                foreach ($data['categories'] as $c) {
                    $cat = Category::updateOrCreate(
                        ['slug' => $c['slug']],
                        [
                            'name' => $c['name'],
                            'description' => $c['description'] ?? null,
                            'image' => $c['image'] ?? null,
                            'status' => $c['status'] ?? 'published',
                            'sort_order' => $c['sort_order'] ?? 0,
                        ]
                    );
                    $catMap[$c['id']] = $cat->id;
                }
            }

            $subMap = [];
            if (!empty($data['subcategories'])) {
                foreach ($data['subcategories'] as $sub) {
                    $parentId = $catMap[$sub['category_id']] ?? null;
                    if (!$parentId && !empty($catMap)) {
                        $parentId = reset($catMap);
                    }

                    $sModel = Subcategory::updateOrCreate(
                        ['slug' => $sub['slug']],
                        [
                            'category_id' => $parentId,
                            'name' => $sub['name'],
                            'description' => $sub['description'] ?? null,
                            'image' => $sub['image'] ?? null,
                            'status' => $sub['status'] ?? 'published',
                            'sort_order' => $sub['sort_order'] ?? 0,
                        ]
                    );
                    $subMap[$sub['id']] = $sModel->id;
                }
            }

            // 4. Menu Items with exact images and details
            if (!empty($data['menu_items'])) {
                foreach ($data['menu_items'] as $item) {
                    $catId = $catMap[$item['category_id']] ?? null;
                    if (!$catId && !empty($catMap)) {
                        $catId = reset($catMap);
                    }

                    $subId = !empty($item['subcategory_id']) ? ($subMap[$item['subcategory_id']] ?? null) : null;

                    MenuItem::updateOrCreate(
                        ['slug' => $item['slug']],
                        [
                            'category_id' => $catId,
                            'subcategory_id' => $subId,
                            'name' => $item['name'],
                            'short_description' => $item['short_description'] ?? null,
                            'full_description' => $item['full_description'] ?? null,
                            'price' => $item['price'] ?? 0,
                            'discounted_price' => $item['discounted_price'] ?? null,
                            'primary_image' => $item['primary_image'] ?? null,
                            'gallery_images' => $item['gallery_images'] ?? [],
                            'ingredients' => $item['ingredients'] ?? null,
                            'allergens' => $item['allergens'] ?? null,
                            'calories' => $item['calories'] ?? null,
                            'preparation_time' => $item['preparation_time'] ?? null,
                            'serving_size' => $item['serving_size'] ?? null,
                            'is_vegetarian' => $item['is_vegetarian'] ?? false,
                            'is_vegan' => $item['is_vegan'] ?? false,
                            'is_spicy' => $item['is_spicy'] ?? false,
                            'spice_level' => $item['spice_level'] ?? 0,
                            'is_featured' => $item['is_featured'] ?? false,
                            'is_available' => $item['is_available'] ?? true,
                            'sort_order' => $item['sort_order'] ?? 0,
                            'tags' => $item['tags'] ?? null,
                            'status' => $item['status'] ?? 'published',
                        ]
                    );
                }
            }

            // Sync default images to storage uploads and register in Media library
            $menuItemsDir = public_path('menu-items');
            $storageUploadsDir = storage_path('app/public/uploads/2026/10');
            if (File::isDirectory($menuItemsDir)) {
                if (!File::isDirectory($storageUploadsDir)) {
                    File::makeDirectory($storageUploadsDir, 0755, true);
                }

                foreach (File::files($menuItemsDir) as $file) {
                    $filename = $file->getFilename();
                    $destPath = $storageUploadsDir . '/' . $filename;
                    if (!File::exists($destPath)) {
                        File::copy($file->getRealPath(), $destPath);
                    }

                    Media::firstOrCreate(
                        ['filename' => $filename],
                        [
                            'original_name' => $filename,
                            'path' => 'uploads/2026/10/' . $filename,
                            'disk' => 'public',
                            'mime_type' => $file->getExtension() === 'png' ? 'image/png' : 'image/jpeg',
                            'size' => $file->getSize(),
                            'alt_text' => pathinfo($filename, PATHINFO_FILENAME),
                            'title' => pathinfo($filename, PATHINFO_FILENAME),
                            'created_by' => 1,
                        ]
                    );
                }
            }

            // 5. Pages & Page Sections
            if (!empty($data['pages'])) {
                foreach ($data['pages'] as $p) {
                    $page = Page::updateOrCreate(
                        ['slug' => $p['slug']],
                        [
                            'title' => $p['title'],
                            'template' => $p['template'] ?? 'default',
                            'status' => $p['status'] ?? 'published',
                            'published_at' => $p['published_at'] ?? now(),
                            'featured_image' => $p['featured_image'] ?? null,
                            'excerpt' => $p['excerpt'] ?? null,
                            'content' => $p['content'] ?? null,
                            'sort_order' => $p['sort_order'] ?? 0,
                            'is_system' => $p['is_system'] ?? false,
                        ]
                    );

                    if (!empty($p['sections'])) {
                        foreach ($p['sections'] as $sec) {
                            PageSection::updateOrCreate(
                                [
                                    'page_id' => $page->id,
                                    'section_type' => $sec['section_type'],
                                    'sort_order' => $sec['sort_order'] ?? 1,
                                ],
                                [
                                    'is_active' => $sec['is_active'] ?? true,
                                    'data' => $sec['data'] ?? [],
                                ]
                            );
                        }
                    }
                }
            }

            // 6. Navigation Items
            if (!empty($data['navigation_items'])) {
                foreach ($data['navigation_items'] as $nav) {
                    NavigationItem::updateOrCreate(
                        [
                            'location' => $nav['location'],
                            'title' => $nav['title'],
                            'url' => $nav['url'],
                        ],
                        [
                            'parent_id' => $nav['parent_id'] ?? null,
                            'sort_order' => $nav['sort_order'] ?? 0,
                            'target' => $nav['target'] ?? '_self',
                            'is_active' => $nav['is_active'] ?? true,
                        ]
                    );
                }
            }

            // 7. Testimonials
            if (!empty($data['testimonials'])) {
                foreach ($data['testimonials'] as $t) {
                    Testimonial::updateOrCreate(
                        ['customer_name' => $t['customer_name'], 'content' => $t['content']],
                        [
                            'customer_role' => $t['customer_role'] ?? null,
                            'rating' => $t['rating'] ?? 5,
                            'avatar' => $t['avatar'] ?? null,
                            'status' => $t['status'] ?? 'published',
                            'is_featured' => $t['is_featured'] ?? false,
                            'sort_order' => $t['sort_order'] ?? 0,
                        ]
                    );
                }
            }

            // 8. FAQs
            if (!empty($data['faqs'])) {
                foreach ($data['faqs'] as $faq) {
                    Faq::updateOrCreate(
                        ['question' => $faq['question']],
                        [
                            'answer' => $faq['answer'],
                            'category' => $faq['category'] ?? 'general',
                            'status' => $faq['status'] ?? 'published',
                            'sort_order' => $faq['sort_order'] ?? 0,
                        ]
                    );
                }
            }

            // 9. Offers
            if (!empty($data['offers'])) {
                foreach ($data['offers'] as $offer) {
                    Offer::updateOrCreate(
                        ['slug' => $offer['slug']],
                        [
                            'title' => $offer['title'],
                            'subtitle' => $offer['subtitle'] ?? null,
                            'description' => $offer['description'] ?? null,
                            'badge' => $offer['badge'] ?? null,
                            'image' => $offer['image'] ?? null,
                            'discount_amount' => $offer['discount_amount'] ?? null,
                            'promo_code' => $offer['promo_code'] ?? null,
                            'start_date' => $offer['start_date'] ?? null,
                            'end_date' => $offer['end_date'] ?? null,
                            'is_active' => $offer['is_active'] ?? true,
                            'is_featured' => $offer['is_featured'] ?? false,
                            'sort_order' => $offer['sort_order'] ?? 0,
                        ]
                    );
                }
            }
        });
    }
}
