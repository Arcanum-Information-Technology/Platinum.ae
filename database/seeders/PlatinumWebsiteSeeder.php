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

class PlatinumWebsiteSeeder extends Seeder
{
    public function run(): void
    {
        $dataFile = database_path('data/platinum_website_data.json');

        if (!File::exists($dataFile)) {
            $this->command?->error("Platinum website data file not found at: {$dataFile}");
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
                            'is_public' => true,
                        ]
                    );
                }
            }
            Setting::clearCache();

            // 2. Opening Hours
            if (!empty($data['opening_hours'])) {
                OpeningHour::truncate();
                foreach ($data['opening_hours'] as $h) {
                    OpeningHour::create([
                        'day_of_week' => $h['day_of_week'],
                        'day_name' => $h['day_name'] ?? '',
                        'is_closed' => $h['is_closed'] ?? false,
                        'open_time_1' => $h['open_time_1'] ?? null,
                        'close_time_1' => $h['close_time_1'] ?? null,
                        'note' => $h['note'] ?? null,
                        'sort_order' => $h['sort_order'] ?? 0,
                    ]);
                }
            }

            // 3. Categories & Subcategories
            // Clean old
            MenuItem::query()->forceDelete();
            Subcategory::query()->forceDelete();
            Category::query()->forceDelete();

            $catMap = [];
            if (!empty($data['categories'])) {
                foreach ($data['categories'] as $c) {
                    $cat = Category::create([
                        'name' => $c['name'],
                        'slug' => $c['slug'],
                        'description' => $c['description'] ?? null,
                        'image' => $c['image'] ?? null,
                        'status' => $c['status'] ?? 'published',
                        'sort_order' => $c['sort_order'] ?? 0,
                        'is_featured' => $c['is_featured'] ?? true,
                    ]);
                    $catMap[$c['id']] = $cat->id;
                }
            }

            $subMap = [];
            if (!empty($data['subcategories'])) {
                foreach ($data['subcategories'] as $sub) {
                    $parentId = $catMap[$sub['category_id']] ?? (reset($catMap) ?: 1);

                    $sModel = Subcategory::create([
                        'category_id' => $parentId,
                        'name' => $sub['name'],
                        'slug' => $sub['slug'],
                        'description' => $sub['description'] ?? null,
                        'status' => $sub['status'] ?? 'published',
                        'sort_order' => $sub['sort_order'] ?? 0,
                    ]);
                    $subMap[$sub['id']] = $sModel->id;
                }
            }

            // 4. Menu Items
            if (!empty($data['menu_items'])) {
                foreach ($data['menu_items'] as $item) {
                    $catId = $catMap[$item['category_id']] ?? (reset($catMap) ?: 1);
                    $subId = !empty($item['subcategory_id']) ? ($subMap[$item['subcategory_id']] ?? null) : null;

                    MenuItem::create([
                        'category_id' => $catId,
                        'subcategory_id' => $subId,
                        'name' => $item['name'],
                        'slug' => $item['slug'],
                        'short_description' => $item['short_description'] ?? null,
                        'full_description' => $item['full_description'] ?? null,
                        'price' => $item['price'] ?? 0,
                        'discounted_price' => $item['discounted_price'] ?? null,
                        'primary_image' => $item['primary_image'] ?? null,
                        'ingredients' => $item['ingredients'] ?? [],
                        'allergens' => $item['allergens'] ?? [],
                        'calories' => $item['calories'] ?? null,
                        'preparation_time' => $item['preparation_time'] ?? null,
                        'serving_size' => $item['serving_size'] ?? null,
                        'is_vegetarian' => $item['is_vegetarian'] ?? false,
                        'is_vegan' => $item['is_vegan'] ?? false,
                        'is_spicy' => $item['is_spicy'] ?? false,
                        'spice_level' => $item['spice_level'] ?? 0,
                        'is_featured' => $item['is_featured'] ?? true,
                        'is_available' => $item['is_available'] ?? true,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'status' => $item['status'] ?? 'published',
                    ]);
                }
            }

            // 5. Pages & Sections
            PageSection::truncate();
            Page::query()->forceDelete();

            $pagesConfig = [
                [
                    'title' => 'Home',
                    'slug' => 'home',
                    'template' => 'home',
                    'status' => 'published',
                    'is_system' => true,
                    'sort_order' => 1,
                    'sections' => [
                        [
                            'section_type' => 'plat_hero',
                            'sort_order' => 1,
                            'data' => [
                                'badge' => 'Culinary Excellence Across The UAE',
                                'title' => 'Platinum Hospitality Management',
                                'subtitle' => 'Your strategic partner in culinary excellence, delivering world-class hospitality solutions through quality, efficiency, and sustainable growth.',
                                'cta_text' => 'Discover Our Brands',
                                'cta_link' => '#our-brands',
                                'cta2_text' => 'Book Table Online',
                                'cta2_link' => '#book-table',
                                'hero_image' => 'images/platinum/hero/platinum-hero.jpg',
                            ],
                        ],
                        [
                            'section_type' => 'plat_brands',
                            'sort_order' => 2,
                            'data' => [
                                'badge' => 'Signature Portfolio',
                                'title' => 'OUR BRANDS',
                                'subtitle' => 'Discover our restaurant locations across the region, each offering the same signature experience.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_about_intro',
                            'sort_order' => 3,
                            'data' => [
                                'badge' => 'Company Overview',
                                'title' => 'Platinum Hospitality Management',
                                'description' => 'Platinum Hospitality Management is a UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts. As a trusted partner in the hospitality industry, we specialize in delivering refined culinary experiences supported by strong operational expertise and sustainable growth strategies.',
                                'ceo_title' => 'CEO & Founder PLATINUM HOSPITALITY',
                                'image' => 'images/platinum/dishes/vegetarian-sandwich-panini-with-spinach-leaves-tomatoes-and-cheese.jpg',
                                'cta_text' => 'Connect With Us Anytime',
                                'cta_link' => '/contact',
                                'inquiry_heading' => 'Business & Partnership Inquiries',
                                'inquiry_text' => 'Reach out to Platinum Hospitality Management for brand partnerships, restaurant management solutions, and hospitality collaborations.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_why_choose_us',
                            'sort_order' => 4,
                            'data' => [
                                'badge' => 'The Platinum Standard',
                                'title' => 'Why Platinum Hospitality Management',
                                'subtitle' => 'A trusted partner delivering excellence across every aspect of hospitality management.',
                                'pillars' => [
                                    [
                                        'title' => 'Operational Excellence',
                                        'desc' => 'Streamlined systems that ensure consistency, efficiency, and quality.',
                                        'icon' => 'gauge',
                                    ],
                                    [
                                        'title' => 'Brand-Centric Approach',
                                        'desc' => 'Every concept retains its unique identity while benefiting from strong management.',
                                        'icon' => 'shield-check',
                                    ],
                                    [
                                        'title' => 'Proven Industry Expertise',
                                        'desc' => 'Decades of experience managing successful F&B brands across diverse hospitality segments.',
                                        'icon' => 'award',
                                    ],
                                    [
                                        'title' => 'Scalable Growth Models',
                                        'desc' => 'Built for long-term expansion, high asset performance, and sustainable profitability.',
                                        'icon' => 'trending-up',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_philosophy',
                            'sort_order' => 5,
                            'data' => [
                                'badge' => 'Our Core Philosophy',
                                'title' => 'Where Hospitality Goes Beyond Food',
                                'subtitle' => 'We believe hospitality goes beyond food. It’s about consistency, experience, and long-term value — delivered through thoughtful management and refined execution.',
                                'quote' => 'Great hospitality is built on consistency, strong systems, and a clear long-term vision. Our focus is on creating brands that perform sustainably while delivering memorable guest experiences.',
                                'author' => 'Platinum Hospitality Management Leadership',
                            ],
                        ],
                        [
                            'section_type' => 'plat_hours_booking',
                            'sort_order' => 6,
                            'data' => [
                                'badge' => 'Hospitality Hours & Reservations',
                                'title' => 'Booking Table In Online',
                                'subtitle' => 'Reserve your table across any of our signature venues in Dubai and Abu Dhabi.',
                                'phone' => '+971 4 360 8888',
                                'email' => 'info@platinumhospitality.ae',
                                'location' => 'United Arab Emirates',
                            ],
                        ],
                        [
                            'section_type' => 'plat_testimonials',
                            'sort_order' => 7,
                            'data' => [
                                'badge' => 'Guest & Partner Trust',
                                'title' => 'Our Clients Say',
                                'subtitle' => 'Testimonials from discerning diners, investors, and long-term hospitality partners.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_partner_cta',
                            'sort_order' => 8,
                            'data' => [
                                'badge' => 'Strategic Collaboration',
                                'title' => 'Partner With Platinum Hospitality Management',
                                'subtitle' => 'Building Strong Hospitality Brands Together',
                                'description' => 'Platinum Hospitality Management collaborates with investors, property owners, and hospitality entrepreneurs to develop, manage, and scale successful food and beverage concepts with long-term value.',
                                'footer_quote' => 'Driving Growth Through Strategic Hospitality Management. Built on experience. Driven by performance.',
                                'cta_text' => 'Start A Conversation',
                                'cta_link' => '/contact',
                                'bg_image' => 'images/platinum/hero/platinum-partner-collaboration.jpg',
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'About Us',
                    'slug' => 'about',
                    'template' => 'about',
                    'status' => 'published',
                    'is_system' => true,
                    'sort_order' => 2,
                    'sections' => [
                        [
                            'section_type' => 'plat_about_hero',
                            'sort_order' => 1,
                            'data' => [
                                'badge' => 'Our Identity & Purpose',
                                'title' => 'About Platinum Hospitality Management',
                                'subtitle' => 'A premier UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_story_ceo',
                            'sort_order' => 2,
                            'data' => [
                                'title' => 'Platinum Hospitality Management',
                                'description' => "Platinum Hospitality Management is a UAE-based food and beverage management company dedicated to creating, operating, and elevating exceptional dining concepts. As a trusted partner in the hospitality industry, we specialize in delivering refined culinary experiences supported by strong operational expertise and sustainable growth strategies.",
                                'ceo_badge' => 'CEO & Founder PLATINUM HOSPITALITY',
                                'image' => 'images/platinum/dishes/vegetarian-sandwich-panini-with-spinach-leaves-tomatoes-and-cheese.jpg',
                            ],
                        ],
                        [
                            'section_type' => 'plat_excellence_metrics',
                            'sort_order' => 3,
                            'data' => [
                                'badge' => 'Decades of Hospitality Management Excellence',
                                'title' => 'Strategic Expertise. Operational Precision.',
                                'description' => 'With decades of combined industry experience, Platinum Hospitality Management specializes in building, managing, and scaling high-performing food and beverage brands. From concept development to daily operations, our team ensures consistency, efficiency, and long-term profitability across every hospitality venture we lead.',
                                'metrics' => [
                                    ['label' => 'Quality Food', 'value' => '89%'],
                                    ['label' => 'Professional Chef', 'value' => '93%'],
                                    ['label' => 'Trusted Consument', 'value' => '98%'],
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_milestones',
                            'sort_order' => 4,
                            'data' => [
                                'badge' => 'Our Historical Trajectory',
                                'title' => 'Milestones That Define Us',
                                'subtitle' => 'From artisanal beginnings to regional multi-brand hospitality leadership.',
                                'timeline' => [
                                    [
                                        'year' => '1989',
                                        'title' => 'Foundation of Hospitality Vision',
                                        'desc' => 'The roots of our hospitality journey began with a passion for culinary excellence and guest experience, laying the groundwork for future brand development.',
                                    ],
                                    [
                                        'year' => '1998',
                                        'title' => 'Expansion into Multi-Concept Dining',
                                        'desc' => 'We expanded operations by introducing diverse restaurant concepts, strengthening operational systems and brand positioning.',
                                    ],
                                    [
                                        'year' => '2007',
                                        'title' => 'Operational Excellence & Brand Recognition',
                                        'desc' => 'Our management frameworks matured, earning recognition for quality standards, operational consistency, and hospitality innovation.',
                                    ],
                                    [
                                        'year' => '2017',
                                        'title' => 'Portfolio Growth & Regional Expansion',
                                        'desc' => 'We scaled our brand portfolio, managing multiple hospitality ventures and expanding our presence across key markets.',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_branches_showcase',
                            'sort_order' => 5,
                            'data' => [
                                'badge' => 'Multi-Concept Footprint',
                                'title' => 'OUR BRANCHES',
                                'subtitle' => 'Discover our restaurant locations across the region, each offering the same signature experience.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_strategic_pillars',
                            'sort_order' => 6,
                            'data' => [
                                'badge' => 'Strategic Pillars',
                                'title' => 'Building Exceptional Hospitality Brands',
                                'subtitle' => 'Where Hospitality Meets Strategic Excellence',
                                'pillars' => [
                                    [
                                        'title' => 'Operational Excellence',
                                        'desc' => 'Structured systems and proven processes that ensure consistency, efficiency, and service quality across every hospitality operation we manage.',
                                        'icon' => 'settings',
                                    ],
                                    [
                                        'title' => 'Brand Development',
                                        'desc' => 'We build strong hospitality identities through concept creation, positioning, and long-term brand growth strategies.',
                                        'icon' => 'sparkles',
                                    ],
                                    [
                                        'title' => 'Strategic Partnerships',
                                        'desc' => 'Collaborating with investors and property owners to create scalable, profitable hospitality ventures.',
                                        'icon' => 'users',
                                    ],
                                    [
                                        'title' => 'Sustainable Growth',
                                        'desc' => 'Focused on resource optimization, operational longevity, and environmentally responsible hospitality practices.',
                                        'icon' => 'leaf',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_founders_team',
                            'sort_order' => 7,
                            'data' => [
                                'badge' => 'Leadership & Culinary Masters',
                                'title' => 'Meet Our Founders',
                                'subtitle' => 'PLATINUM HOSPITALITY',
                                'members' => [
                                    [
                                        'name' => 'Aroldo De Marco',
                                        'role' => 'Founder & Chef',
                                        'image' => 'images/platinum/team/aroldo-de-marco.jpg',
                                    ],
                                    [
                                        'name' => 'Quetzalli Antonio',
                                        'role' => 'Co - Founder & Chef',
                                        'image' => 'images/platinum/team/quetzalli-antonio.jpg',
                                    ],
                                    [
                                        'name' => 'Jovanni Scutari',
                                        'role' => 'Head Chef',
                                        'image' => 'images/platinum/team/jovanni-scutari.jpg',
                                    ],
                                    [
                                        'name' => 'Edda Rivera',
                                        'role' => 'HR Manager',
                                        'image' => 'images/platinum/team/edda-rivera.jpg',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Brands',
                    'slug' => 'brands',
                    'template' => 'brands',
                    'status' => 'published',
                    'is_system' => true,
                    'sort_order' => 3,
                    'sections' => [
                        [
                            'section_type' => 'plat_brands_hero',
                            'sort_order' => 1,
                            'data' => [
                                'badge' => 'Dining Concepts',
                                'title' => 'Our Portfolio Brands',
                                'subtitle' => 'Distinctive gastronomic concepts unified by uncompromising standards of service and culinary innovation.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_branches_showcase',
                            'sort_order' => 2,
                            'data' => [
                                'badge' => 'Flagship Destinations',
                                'title' => 'OUR BRANCHES',
                                'subtitle' => 'Discover our restaurant locations across the region, each offering the same signature experience.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_philosophy',
                            'sort_order' => 3,
                            'data' => [
                                'badge' => 'Shared Vision',
                                'title' => 'Crafting Enduring Dining Legacies',
                                'quote' => 'Great hospitality is built on consistency, strong systems, and a clear long-term vision. Our focus is on creating brands that perform sustainably while delivering memorable guest experiences.',
                                'author' => 'Platinum Hospitality Management',
                            ],
                        ],
                        [
                            'section_type' => 'plat_testimonials',
                            'sort_order' => 4,
                            'data' => [
                                'badge' => 'Testimonial',
                                'title' => 'Our Clients Say',
                                'subtitle' => 'Hear from regular diners, guests, and community patrons.',
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Franchise',
                    'slug' => 'franchise',
                    'template' => 'franchise',
                    'status' => 'published',
                    'is_system' => true,
                    'sort_order' => 4,
                    'sections' => [
                        [
                            'section_type' => 'plat_franchise_hero',
                            'sort_order' => 1,
                            'data' => [
                                'badge' => 'Grow With Platinum Hospitality',
                                'title' => 'Franchise & Partnership Enquiry',
                                'subtitle' => 'Join hands with Platinum Hospitality Management to build and grow successful hospitality brands.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_franchise_form',
                            'sort_order' => 2,
                            'data' => [
                                'title' => 'Submit Franchise Application',
                                'subtitle' => 'Our franchise development team will review your application and schedule a private discovery call.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_franchise_support',
                            'sort_order' => 3,
                            'data' => [
                                'badge' => 'Partnership Ecosystem',
                                'title' => 'Your Franchise Journey Starts Here',
                                'subtitle' => 'Comprehensive Support. Proven Systems.',
                                'description' => 'Platinum Hospitality Management provides end-to-end franchise support — from concept setup and operational training to marketing strategy and long-term business growth.',
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Contact Us',
                    'slug' => 'contact',
                    'template' => 'contact',
                    'status' => 'published',
                    'is_system' => true,
                    'sort_order' => 5,
                    'sections' => [
                        [
                            'section_type' => 'plat_contact_hero',
                            'sort_order' => 1,
                            'data' => [
                                'badge' => 'Connect With Platinum',
                                'title' => 'Get In Touch',
                                'subtitle' => 'Business & Partnership Enquiries',
                            ],
                        ],
                        [
                            'section_type' => 'plat_contact_split',
                            'sort_order' => 2,
                            'data' => [
                                'description' => 'Connect with Platinum Hospitality Management for franchise opportunities, brand partnerships, and hospitality management solutions. Our team is ready to assist you with strategic guidance and collaboration discussions.',
                                'location' => 'United Arab Emirates',
                                'phone' => '+971 4 360 8888',
                                'email' => 'info@platinumhospitality.ae',
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Shakespeare Middle East',
                    'slug' => 'shakespeare-middle-east',
                    'template' => 'brand',
                    'status' => 'published',
                    'is_system' => false,
                    'sort_order' => 6,
                    'sections' => [
                        [
                            'section_type' => 'plat_brand_hero',
                            'sort_order' => 1,
                            'data' => [
                                'brand_name' => 'Shakespeare Middle East',
                                'tagline' => 'A Timeless Dining Experience, Reimagined for Modern Hospitality',
                                'badge' => 'Portfolio Brand',
                                'bg_image' => 'images/platinum/brands/shakespeare.jpg',
                            ],
                        ],
                        [
                            'section_type' => 'plat_brand_story',
                            'sort_order' => 2,
                            'data' => [
                                'heading' => 'Our Special Menu',
                                'subheading' => 'A Timeless Dining Experience, Reimagined for Modern Hospitality',
                                'description' => 'Shakespeare Middle East reimagines the legacy of its classic predecessor, offering a refined retreat where literature and leisure intertwine. Located in the vibrant Bawabat Al Sharq, it’s a haven for those who appreciate the aroma of freshly brewed coffee, inspired cuisine, and delectable French pastries. The ambiance is a blend of old-world charm and contemporary comfort, invites guests to linger over meals, conversations. Here, every visit feels like stepping into a story where culture, taste, and timeless elegance converge.',
                                'management_statement' => 'Shakespeare Middle East is a premium dining concept known for its sophisticated ambiance, diverse menu offerings, and exceptional guest experiences. Managed under Platinum Hospitality Management, the brand reflects operational excellence, culinary consistency, and scalable growth potential across the region.',
                                'image' => 'images/platinum/brands/shakespeare.jpg',
                                'location' => 'Bawabat Al Sharq, Abu Dhabi & UAE',
                                'features' => [
                                    'Freshly Brewed Artisan Specialty Coffee',
                                    'Delectable Daily French Pastries & Patisserie',
                                    'Old-World Victorian Charm with Modern Comfort',
                                    'Supervised by Platinum Hospitality Management',
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_brand_experience',
                            'sort_order' => 3,
                            'data' => [
                                'badge' => 'Sensory Journey',
                                'title' => 'Experience the World of Shakespeare Middle East',
                                'subtitle' => 'A Celebration of Heritage, Flavor, and Ambiance',
                                'cards' => [
                                    [
                                        'title' => 'Artisanal Patisserie',
                                        'desc' => 'Delectable French pastries baked fresh daily with refined European techniques and exquisite presentations.',
                                        'image' => 'images/platinum/brands/shakespeare.jpg',
                                        'tag' => 'French Patisserie',
                                        'icon' => 'coffee',
                                        'features' => ['Bespoke viennoiserie', 'Artisanal macarons', 'Classic afternoon tea'],
                                    ],
                                    [
                                        'title' => 'Literary Ambiance & Leisure',
                                        'desc' => 'Where literature and leisure intertwine in a cozy Victorian aesthetic, inviting guests to linger over meals and conversation.',
                                        'image' => 'images/platinum/dishes/strawberry-tartlet.jpg',
                                        'tag' => 'Bawabat Al Sharq',
                                        'icon' => 'book-open',
                                        'features' => ['Bawabat Al Sharq destination', 'Intimate seating corners', 'Warm nostalgic decor'],
                                    ],
                                    [
                                        'title' => 'Platinum Management Standards',
                                        'desc' => 'Managed under Platinum Hospitality Management, ensuring operational consistency, premium sourcing, and sustainable expansion.',
                                        'image' => 'images/platinum/dishes/croque-monsieur.jpg',
                                        'tag' => 'Operational Quality',
                                        'icon' => 'shield-check',
                                        'features' => ['Rigorous quality controls', 'Consistent hospitality standards', 'Scalable growth framework'],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_philosophy',
                            'sort_order' => 4,
                            'data' => [
                                'badge' => 'Management Philosophy',
                                'title' => 'Where Hospitality Meets Culinary Heritage',
                                'subtitle' => 'We believe hospitality goes beyond food. It’s about consistency, experience, and long-term value — delivered through thoughtful management and refined execution.',
                                'quote' => 'Great hospitality is built on consistency, strong systems, and a clear long-term vision. Our focus is on creating brands that perform sustainably while delivering memorable guest experiences.',
                                'author' => 'Platinum Hospitality Management',
                            ],
                        ],
                        [
                            'section_type' => 'plat_testimonials',
                            'sort_order' => 5,
                            'data' => [
                                'badge' => 'Guest & Partner Trust',
                                'title' => 'Our Clients Say',
                                'subtitle' => 'Discover how diners and partners experience the Platinum standard at Shakespeare Middle East.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_hours_booking',
                            'sort_order' => 6,
                            'data' => [
                                'badge' => 'Reservations',
                                'title' => 'Booking Table In Online',
                                'subtitle' => 'Reserve your table at Shakespeare Middle East in Bawabat Al Sharq.',
                                'phone' => '+971 4 360 8888',
                                'email' => 'info@platinumhospitality.ae',
                                'location' => 'Bawabat Al Sharq, United Arab Emirates',
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Otantik Café & Restaurant',
                    'slug' => 'otantik-cafe-restaurant',
                    'template' => 'brand',
                    'status' => 'published',
                    'is_system' => false,
                    'sort_order' => 7,
                    'sections' => [
                        [
                            'section_type' => 'plat_brand_hero',
                            'sort_order' => 1,
                            'data' => [
                                'brand_name' => 'Otantik Café & Restaurant',
                                'tagline' => 'Authentic Turkish Flavors. Timeless Hospitality.',
                                'badge' => 'Portfolio Brand',
                                'bg_image' => 'images/platinum/brands/otantik.jpg',
                            ],
                        ],
                        [
                            'section_type' => 'plat_brand_story',
                            'sort_order' => 2,
                            'data' => [
                                'heading' => 'Otantik Café',
                                'subheading' => 'Authentic Turkish Flavors. Timeless Hospitality.',
                                'description' => 'Otantik Café & Restaurant brings the essence of traditional Turkish dining to the Middle East. Known for its warm hospitality, artisanal recipes, and culturally inspired interiors, the brand delivers an immersive culinary experience rooted in authenticity and quality.',
                                'management_statement' => 'Managed under Platinum Hospitality Management, Otantik reflects operational excellence and scalable brand growth.',
                                'image' => 'images/platinum/brands/otantik.jpg',
                                'location' => 'United Arab Emirates',
                                'features' => [
                                    'Traditional Turkish Dining & Handcrafted Mezzes',
                                    'Warm Culturally Inspired Ottoman Interiors',
                                    'Charcoal Grilled Kebabs & Artisanal Pide',
                                    'Managed Under Platinum Hospitality Governance',
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_brand_experience',
                            'sort_order' => 3,
                            'data' => [
                                'badge' => 'Heritage Experience',
                                'title' => 'Authentic Turkish Flavors. Timeless Hospitality.',
                                'subtitle' => 'Where rich Turkish culinary heritage meets warm, culturally inspired dining experiences.',
                                'cards' => [
                                    [
                                        'title' => 'Artisanal Turkish Grills',
                                        'desc' => 'Succulent lumpwood charcoal-grilled meats, tender lamb kebabs, and rich regional marinades perfected over generations.',
                                        'image' => 'images/platinum/brands/otantik.jpg',
                                        'tag' => 'Live Grills',
                                        'icon' => 'flame',
                                        'features' => ['Lumpwood charcoal flavor', 'Freshly baked Turkish bread', 'Signature mezze platters'],
                                    ],
                                    [
                                        'title' => 'Ottoman Lounge & Shisha',
                                        'desc' => 'Warm, ambient lighting, hand-woven textiles, and premium shisha terrace designed for shared gatherings with family and friends.',
                                        'image' => 'images/platinum/dishes/mixed-grill.jpg',
                                        'tag' => 'Hospitality Lounge',
                                        'icon' => 'sparkles',
                                        'features' => ['Traditional tea & coffee rituals', 'Al-fresco shisha terrace', 'Warm Middle Eastern welcome'],
                                    ],
                                    [
                                        'title' => 'Platinum Operational Standard',
                                        'desc' => 'Structured operational systems that guarantee consistent food taste, stringent kitchen hygiene, and high culinary excellence.',
                                        'image' => 'images/platinum/dishes/mezze-selection.jpg',
                                        'tag' => 'Quality Standard',
                                        'icon' => 'shield-check',
                                        'features' => ['Strict ingredient traceability', 'Professional kitchen leadership', 'Sustainable franchise model'],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_philosophy',
                            'sort_order' => 4,
                            'data' => [
                                'badge' => 'Management Philosophy',
                                'title' => 'Where Hospitality Meets Culinary Heritage',
                                'subtitle' => 'We believe hospitality goes beyond food. It’s about consistency, experience, and long-term value — delivered through thoughtful management and refined execution.',
                                'quote' => 'Great hospitality is built on consistency, strong systems, and a clear long-term vision. Our focus is on creating brands that perform sustainably while delivering memorable guest experiences.',
                                'author' => 'Platinum Hospitality Management',
                            ],
                        ],
                        [
                            'section_type' => 'plat_testimonials',
                            'sort_order' => 5,
                            'data' => [
                                'badge' => 'Guest & Partner Trust',
                                'title' => 'Our Clients Say',
                                'subtitle' => 'Hear why guests and business collaborators admire Otantik Café & Restaurant.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_hours_booking',
                            'sort_order' => 6,
                            'data' => [
                                'badge' => 'Reservations',
                                'title' => 'Booking Table In Online',
                                'subtitle' => 'Reserve your table at Otantik Café & Restaurant.',
                                'phone' => '+971 4 360 8888',
                                'email' => 'info@platinumhospitality.ae',
                                'location' => 'United Arab Emirates',
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Chinese Connection',
                    'slug' => 'chinese-connection',
                    'template' => 'brand',
                    'status' => 'published',
                    'is_system' => false,
                    'sort_order' => 8,
                    'sections' => [
                        [
                            'section_type' => 'plat_brand_hero',
                            'sort_order' => 1,
                            'data' => [
                                'brand_name' => 'Chinese Connection',
                                'tagline' => 'Bold Asian Flavors. Modern Dining Energy.',
                                'badge' => 'Portfolio Brand',
                                'bg_image' => 'images/platinum/brands/chinese-connection.jpg',
                            ],
                        ],
                        [
                            'section_type' => 'plat_brand_story',
                            'sort_order' => 2,
                            'data' => [
                                'heading' => 'Chinese Connection',
                                'subheading' => 'Bold Asian Flavors. Modern Dining Energy.',
                                'description' => 'Chinese Connection is a contemporary Asian dining concept that brings together authentic Chinese flavors and modern lifestyle hospitality. Designed to cater to today’s urban diners, the brand blends vibrant interiors, fast-casual service, and a diverse menu inspired by traditional Chinese cuisine.',
                                'management_statement' => 'Managed under Platinum Hospitality Management, Chinese Connection operates on standardized systems, ensuring consistent food quality, operational efficiency, and scalable growth potential across locations. The concept appeals to families, young professionals, and casual dining audiences seeking flavorful experiences in a dynamic setting.',
                                'image' => 'images/platinum/brands/chinese-connection.jpg',
                                'location' => 'United Arab Emirates',
                                'features' => [
                                    'Steamed Bamboo Dim Sum & Handmade Dumplings',
                                    'Sizzling High-Flame Wok Specialties & Noodles',
                                    'Vibrant Contemporary Pan-Asian Ambience',
                                    'Scalable Operations Managed by Platinum Hospitality',
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_brand_experience',
                            'sort_order' => 3,
                            'data' => [
                                'badge' => 'Asian Gastronomy',
                                'title' => 'Bold Asian Flavors. Modern Dining Energy.',
                                'subtitle' => 'Where authentic Chinese cuisine meets contemporary lifestyle dining experiences.',
                                'cards' => [
                                    [
                                        'title' => 'Artisanal Dim Sum & Wok Art',
                                        'desc' => 'Steaming handcrafted dim sum baskets, delicate soup dumplings, and fiery wok-hei stir-fries made with master culinary precision.',
                                        'image' => 'images/platinum/brands/chinese-connection.jpg',
                                        'tag' => 'Dim Sum & Wok',
                                        'icon' => 'utensils',
                                        'features' => ['Hand-folded crystal dim sum', 'Authentic wok-hei smokiness', 'Signature Peking duck'],
                                    ],
                                    [
                                        'title' => 'Modern Lifestyle Dining',
                                        'desc' => 'Vibrant contemporary design, ambient mood lighting, and energetic dining flow perfectly suited for urban diners and families.',
                                        'image' => 'images/platinum/dishes/dim-sum.jpg',
                                        'tag' => 'Dining Energy',
                                        'icon' => 'sparkles',
                                        'features' => ['Dynamic urban atmosphere', 'Open kitchen spectacle', 'Fast-casual hospitality'],
                                    ],
                                    [
                                        'title' => 'Scalable Growth Potential',
                                        'desc' => 'Engineered for seamless mall and flagship expansion, supported by Platinum standardized systems and cost optimization.',
                                        'image' => 'images/platinum/dishes/wok-beef.jpg',
                                        'tag' => 'Scalable Framework',
                                        'icon' => 'trending-up',
                                        'features' => ['Standardized culinary SOPs', 'High kitchen turnaround', 'Proven regional profitability'],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'section_type' => 'plat_philosophy',
                            'sort_order' => 4,
                            'data' => [
                                'badge' => 'Management Philosophy',
                                'title' => 'Where Hospitality Meets Culinary Heritage',
                                'subtitle' => 'We believe hospitality goes beyond food. It’s about consistency, experience, and long-term value — delivered through thoughtful management and refined execution.',
                                'quote' => 'Great hospitality is built on consistency, strong systems, and a clear long-term vision. Our focus is on creating brands that perform sustainably while delivering memorable guest experiences.',
                                'author' => 'Platinum Hospitality Management',
                            ],
                        ],
                        [
                            'section_type' => 'plat_testimonials',
                            'sort_order' => 5,
                            'data' => [
                                'badge' => 'Guest & Partner Trust',
                                'title' => 'Our Clients Say',
                                'subtitle' => 'Valued feedback from guests across all Chinese Connection dining rooms.',
                            ],
                        ],
                        [
                            'section_type' => 'plat_hours_booking',
                            'sort_order' => 6,
                            'data' => [
                                'badge' => 'Reservations',
                                'title' => 'Booking Table In Online',
                                'subtitle' => 'Reserve your table at Chinese Connection.',
                                'phone' => '+971 4 360 8888',
                                'email' => 'info@platinumhospitality.ae',
                                'location' => 'United Arab Emirates',
                            ],
                        ],
                    ],
                ],
            ];

            foreach ($pagesConfig as $p) {
                $page = Page::create([
                    'title' => $p['title'],
                    'slug' => $p['slug'],
                    'template' => $p['template'],
                    'status' => $p['status'],
                    'is_system' => $p['is_system'],
                    'sort_order' => $p['sort_order'],
                    'published_at' => now(),
                ]);

                foreach ($p['sections'] as $sec) {
                    PageSection::create([
                        'page_id' => $page->id,
                        'section_type' => $sec['section_type'],
                        'sort_order' => $sec['sort_order'],
                        'is_active' => true,
                        'data' => $sec['data'],
                    ]);
                }
            }

            // 6. Navigation
            NavigationItem::truncate();
            foreach ($data['navigation_items'] as $nav) {
                $item = NavigationItem::create([
                    'location' => $nav['location'],
                    'title' => $nav['title'],
                    'url' => $nav['url'],
                    'url_type' => $nav['url_type'] ?? 'internal',
                    'target' => $nav['target'] ?? '_self',
                    'sort_order' => $nav['sort_order'] ?? 0,
                    'is_active' => $nav['is_active'] ?? true,
                ]);

                if (!empty($nav['children'])) {
                    foreach ($nav['children'] as $idx => $child) {
                        NavigationItem::create([
                            'parent_id' => $item->id,
                            'location' => $nav['location'],
                            'title' => $child['title'],
                            'url' => $child['url'],
                            'url_type' => 'internal',
                            'target' => '_self',
                            'sort_order' => $idx + 1,
                            'is_active' => true,
                        ]);
                    }
                }
            }

            // 7. Testimonials
            Testimonial::truncate();
            foreach ($data['testimonials'] as $t) {
                Testimonial::create([
                    'customer_name' => $t['customer_name'],
                    'customer_role' => $t['customer_role'] ?? null,
                    'content' => $t['content'],
                    'rating' => $t['rating'] ?? 5,
                    'avatar' => $t['avatar'] ?? null,
                    'status' => 'published',
                    'is_featured' => true,
                    'sort_order' => $t['sort_order'] ?? 0,
                ]);
            }

            // 8. FAQs
            Faq::truncate();
            foreach ($data['faqs'] as $faq) {
                Faq::create([
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'category' => $faq['category'] ?? 'general',
                    'status' => 'published',
                    'sort_order' => $faq['sort_order'] ?? 0,
                ]);
            }

            // 9. Offers
            Offer::truncate();
            foreach ($data['offers'] as $offer) {
                Offer::create([
                    'title' => $offer['title'],
                    'slug' => $offer['slug'] ?? \Illuminate\Support\Str::slug($offer['title']),
                    'subtitle' => $offer['subtitle'] ?? null,
                    'description' => $offer['description'] ?? null,
                    'badge' => $offer['badge'] ?? null,
                    'promo_code' => $offer['promo_code'] ?? null,
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => $offer['sort_order'] ?? 0,
                ]);
            }
        });
    }
}
