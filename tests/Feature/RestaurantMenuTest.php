<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Subcategory;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantMenuTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        $this->seed(AdminUserSeeder::class);
        $this->admin = User::where('email', 'admin@restaurant.com')->first();
    }

    public function test_admin_can_create_category_and_subcategory(): void
    {
        $catResponse = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Persian & Levantine',
            'slug' => 'persian-levantine',
            'description' => 'Aromatic rice, wood-roasted meats, and cold-pressed olive oils.',
            'status' => 'published',
            'sort_order' => 1,
        ]);
        $catResponse->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Persian & Levantine',
            'slug' => 'persian-levantine',
        ]);

        $category = Category::where('slug', 'persian-levantine')->first();

        $subResponse = $this->actingAs($this->admin)->post(route('admin.subcategories.store'), [
            'category_id' => $category->id,
            'name' => 'Charcoal Skewers',
            'slug' => 'charcoal-skewers',
            'description' => 'Marinated in saffron, sumac, and wild barberries.',
            'status' => 'published',
            'sort_order' => 1,
        ]);
        $subResponse->assertRedirect(route('admin.subcategories.index'));

        $this->assertDatabaseHas('subcategories', [
            'name' => 'Charcoal Skewers',
            'category_id' => $category->id,
        ]);
    }

    public function test_admin_can_create_menu_item_with_full_attributes(): void
    {
        $category = Category::create([
            'name' => 'Mediterranean Coast',
            'slug' => 'mediterranean-coast',
            'status' => 'published',
        ]);

        $subcategory = Subcategory::create([
            'category_id' => $category->id,
            'name' => 'Fresh Catch',
            'slug' => 'fresh-catch',
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.menu-items.store'), [
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'name' => 'Wild Branzino Al Sale',
            'slug' => 'wild-branzino-al-sale',
            'short_description' => 'Whole Mediterranean sea bass baked in grey salt crust with lemon thyme.',
            'full_description' => 'Delivered fresh daily, served table-side with confit cherry tomatoes.',
            'price' => 38.00,
            'discounted_price' => 32.00,
            'calories' => 520,
            'preparation_time' => '25 mins',
            'is_vegetarian' => false,
            'is_vegan' => false,
            'is_spicy' => false,
            'is_featured' => true,
            'is_available' => true,
            'ingredients' => 'Wild Branzino, Sicilian Sea Salt, Fresh Thyme, Cold-Pressed Olive Oil',
            'allergens' => 'Fish',
            'tags' => 'Gluten-Free, Chef Pick',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.menu-items.index'));

        $this->assertDatabaseHas('menu_items', [
            'name' => 'Wild Branzino Al Sale',
            'price' => 38.00,
            'discounted_price' => 32.00,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'is_featured' => true,
        ]);

        $item = MenuItem::where('slug', 'wild-branzino-al-sale')->first();
        $this->assertTrue($item->has_discount);
        $this->assertEquals(32.00, $item->effective_price);
        $this->assertContains('Fish', $item->allergens);
    }

    public function test_public_menu_and_item_details_render_successfully(): void
    {
        $category = Category::create([
            'name' => 'Italian Hearth',
            'slug' => 'italian-hearth',
            'status' => 'published',
        ]);

        $item = MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Handmade Cacio e Pepe',
            'slug' => 'handmade-cacio-e-pepe',
            'short_description' => 'Pecorino Romano DOP and toasted Tellicherry black peppercorns.',
            'price' => 24.00,
            'is_available' => true,
            'status' => 'published',
        ]);

        // Public menu index displays categories (Image 2 layout)
        $menuResponse = $this->get(route('menu.index'));
        $menuResponse->assertStatus(200);
        $menuResponse->assertSee('ITALIAN HEARTH');

        // Public category page displays its menu items
        $catResponse = $this->get(route('menu.category', $category->slug));
        $catResponse->assertStatus(200);
        $catResponse->assertSee('Handmade Cacio e Pepe');

        // Public food detail
        $detailResponse = $this->get($item->url);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Handmade Cacio e Pepe');
        $detailResponse->assertSee('Pecorino Romano DOP');
    }

    public function test_subcategory_page_renders_without_route_exceptions(): void
    {
        $category = Category::create([
            'name' => 'Starters & Small Plates',
            'slug' => 'starters-small-plates',
            'status' => 'published',
        ]);

        $sub = Subcategory::create([
            'category_id' => $category->id,
            'name' => 'Vegetarian Appetizers',
            'slug' => 'vegetarian-appetizers',
            'status' => 'published',
        ]);

        $item = MenuItem::create([
            'category_id' => $category->id,
            'subcategory_id' => $sub->id,
            'name' => 'Truffle Arancini',
            'slug' => 'truffle-arancini',
            'price' => 15.00,
            'is_available' => true,
            'status' => 'published',
        ]);

        // Category page with subcategories rendered (must not throw UrlGenerationException)
        $catResponse = $this->get(route('menu.category', $category->slug));
        $catResponse->assertStatus(200);
        $catResponse->assertSee('Vegetarian Appetizers');
        $catResponse->assertSee('Truffle Arancini');

        // Subcategory direct page
        $subResponse = $this->get(route('menu.subcategory', ['categorySlug' => $category->slug, 'subcategorySlug' => $sub->slug]));
        $subResponse->assertStatus(200);
        $subResponse->assertSee('Truffle Arancini');
    }

    public function test_admin_menu_items_index_renders_safely_when_category_or_subcategory_is_deleted(): void
    {
        $category = Category::create([
            'name' => 'Pastry Corner',
            'slug' => 'pastry-corner',
            'status' => 'published',
        ]);

        $sub = Subcategory::create([
            'category_id' => $category->id,
            'name' => 'Croissants & Bakes',
            'slug' => 'croissants-bakes',
            'status' => 'published',
        ]);

        $item = MenuItem::create([
            'category_id' => $category->id,
            'subcategory_id' => $sub->id,
            'name' => 'Almond Croissant',
            'slug' => 'almond-croissant',
            'price' => 8.50,
            'is_available' => true,
            'status' => 'published',
        ]);

        // Delete subcategory then category (exact user scenario)
        $sub->delete();
        $category->delete();

        // Admin menu items listing must render 200 without null property exceptions
        $response = $this->actingAs($this->admin)->get(route('admin.menu-items.index'));
        $response->assertStatus(200);
        $response->assertSee('Almond Croissant');
        $response->assertSee('Pastry Corner');
        $response->assertSee('(Deleted)');

        // Admin subcategories listing must render 200 without null property exceptions
        $subIndexResponse = $this->actingAs($this->admin)->get(route('admin.subcategories.index'));
        $subIndexResponse->assertStatus(200);

        // Admin menu item edit page must render 200 with reassign warning
        $editResponse = $this->actingAs($this->admin)->get(route('admin.menu-items.edit', $item->id));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Pastry Corner');

        // Public menu and sitemap must render cleanly without errors
        $publicMenuResponse = $this->get(route('menu.index'));
        $publicMenuResponse->assertStatus(200);

        $sitemapResponse = $this->get(route('sitemap'));
        $sitemapResponse->assertStatus(200);
    }
}
