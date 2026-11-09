<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageManagementTest extends TestCase
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

    public function test_admin_can_view_pages_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pages.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_a_page_with_slug_and_seo(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.pages.store'), [
            'title' => 'Chef Private Cellar Experience',
            'slug' => 'private-cellar',
            'template' => 'builder',
            'status' => 'published',
            'excerpt' => 'Exclusive private tasting table inside our 19th-century wine vault.',
            'meta_title' => 'Private Cellar Dining | Saffron & Thyme',
            'meta_description' => 'Exclusive wine vault dining experience.',
        ]);

        $this->assertDatabaseHas('pages', [
            'title' => 'Chef Private Cellar Experience',
            'slug' => 'private-cellar',
            'status' => 'published',
        ]);

        $page = Page::where('slug', 'private-cellar')->first();
        $this->assertNotNull($page);
        $this->assertNotNull($page->seo);
        $this->assertEquals('Private Cellar Dining | Saffron & Thyme', $page->seo->meta_title);

        $response->assertRedirect(route('admin.pages.sections', $page->id));
    }

    public function test_admin_can_duplicate_a_page(): void
    {
        $page = Page::create([
            'title' => 'Spring Equinox Gala',
            'slug' => 'spring-equinox-gala',
            'template' => 'builder',
            'status' => 'published',
            'created_by' => $this->admin->id,
            'updated_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.pages.duplicate', $page->id));

        $this->assertDatabaseHas('pages', [
            'title' => 'Spring Equinox Gala (Copy)',
            'status' => 'draft',
        ]);

        $response->assertStatus(302);
    }

    public function test_admin_can_add_sections_to_a_page(): void
    {
        $page = Page::create([
            'title' => 'Special Events',
            'slug' => 'special-events',
            'template' => 'builder',
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.pages.sections.store', $page->id), [
            'section_type' => 'hero',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('page_sections', [
            'page_id' => $page->id,
            'section_type' => 'hero',
            'is_active' => true,
        ]);
    }

    public function test_draft_page_cannot_be_viewed_by_public_but_can_be_previewed_by_admin(): void
    {
        $page = Page::create([
            'title' => 'Secret VIP Menu',
            'slug' => 'secret-vip-menu',
            'template' => 'builder',
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        // Public visitor gets 404
        $publicResponse = $this->get('/secret-vip-menu');
        $publicResponse->assertStatus(404);

        // Authenticated admin can view preview
        $previewResponse = $this->actingAs($this->admin)->get(route('page.preview', $page->id));
        $previewResponse->assertStatus(200);
        $previewResponse->assertSee('Secret VIP Menu');
    }

    public function test_admin_can_update_edit_and_remove_section_content_without_fallback_revival(): void
    {
        $page = Page::create([
            'title' => 'Home Test Page',
            'slug' => 'home-test',
            'template' => 'builder',
            'status' => 'published',
            'created_by' => $this->admin->id,
        ]);

        $section = \App\Models\PageSection::create([
            'page_id' => $page->id,
            'section_type' => 'sh_hero',
            'sort_order' => 1,
            'is_active' => true,
            'data' => [
                'title' => 'SUMMER MENU',
                'video' => 'home-page/08131.mp4',
                'poster' => 'home-page/poster.jpg',
            ],
        ]);

        // When public page renders with title set, it sees SUMMER MENU
        $response = $this->get('/home-test');
        $response->assertStatus(200);
        $response->assertSee('SUMMER MENU');

        // Admin updates section in modal, removing the title (empty string)
        $updateResponse = $this->actingAs($this->admin)->put(
            route('admin.pages.sections.update', ['page' => $page->id, 'section' => $section->id]),
            [
                'structured' => '1',
                'data' => [
                    'title' => '',
                    'video' => 'home-page/08131.mp4',
                    'poster' => 'home-page/poster.jpg',
                ],
            ]
        );

        $updateResponse->assertRedirect();
        $section->refresh();

        // The title in DB is now null (or empty)
        $this->assertTrue(empty($section->data['title']));

        // Public page must NOT display "SUMMER MENU" fallback anymore
        $publicResponse = $this->get('/home-test');
        $publicResponse->assertStatus(200);
        $publicResponse->assertDontSee('SUMMER MENU');

        // Admin updates section with new title
        $this->actingAs($this->admin)->put(
            route('admin.pages.sections.update', ['page' => $page->id, 'section' => $section->id]),
            [
                'structured' => '1',
                'data' => [
                    'title' => 'AUTUMN COLLECTION',
                    'video' => 'home-page/08131.mp4',
                    'poster' => 'home-page/poster.jpg',
                ],
            ]
        );

        $publicResponse2 = $this->get('/home-test');
        $publicResponse2->assertStatus(200);
        $publicResponse2->assertSee('AUTUMN COLLECTION');

        // Admin deletes the section
        $deleteResponse = $this->actingAs($this->admin)->delete(
            route('admin.pages.sections.destroy', ['page' => $page->id, 'section' => $section->id])
        );

        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('page_sections', ['id' => $section->id]);
    }
}
