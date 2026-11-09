<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Services\SchemaService;
use App\Services\SeoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoAndStructuredDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_xml_generates_valid_xml(): void
    {
        Page::create([
            'title' => 'Wine Sourcing Philosophy',
            'slug' => 'wine-philosophy',
            'template' => 'builder',
            'status' => 'published',
        ]);

        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $response->assertSee('<urlset', false);
        $response->assertSee('wine-philosophy', false);
    }

    public function test_robots_txt_contains_crawler_rules_and_sitemap_link(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('User-agent: *');
        $response->assertSee('Disallow: /admin/');
        $response->assertSee('Sitemap:');
    }

    public function test_seo_and_json_ld_schema_service_outputs_restaurant_and_menu_item_schemas(): void
    {
        $schemaService = app(SchemaService::class);
        $restaurantSchema = $schemaService->getRestaurantSchema();

        $this->assertEquals('https://schema.org', $restaurantSchema['@context']);
        $this->assertEquals('Restaurant', $restaurantSchema['@type']);
        $this->assertArrayHasKey('openingHoursSpecification', $restaurantSchema);
        $this->assertArrayHasKey('address', $restaurantSchema);
        $this->assertArrayHasKey('geo', $restaurantSchema);

        $category = Category::create([
            'name' => 'Royal Kebabs',
            'slug' => 'royal-kebabs',
            'status' => 'published',
        ]);

        $item = MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Kakori Lamb Kebab',
            'slug' => 'kakori-lamb-kebab',
            'short_description' => 'Melt-in-mouth Awadhi spiced lamb skewers.',
            'price' => 29.50,
            'calories' => 480,
            'is_available' => true,
            'status' => 'published',
        ]);

        $itemSchema = $schemaService->getMenuItemSchema($item);
        $this->assertEquals('MenuItem', $itemSchema['@type']);
        $this->assertEquals('Kakori Lamb Kebab', $itemSchema['name']);
        $this->assertEquals('29.5', $itemSchema['offers']['price']);

        $seoService = app(SeoService::class);
        $metadata = $seoService->getMetadata($item);
        $this->assertStringContainsString('Kakori Lamb Kebab', $metadata['title']);
        $this->assertNotNull($metadata['schema_json_ld']);
    }
}
