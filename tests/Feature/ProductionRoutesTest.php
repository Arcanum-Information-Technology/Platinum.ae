<?php

namespace Tests\Feature;

use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\ShakespeareWebsiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(AdminUserSeeder::class);
        $this->seed(ShakespeareWebsiteSeeder::class);
    }

    public function test_home_route_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login_route_redirects_to_admin_login(): void
    {
        $response = $this->get('/login');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_login_route_renders_successfully(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_contact_route_renders_successfully(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    public function test_menu_route_renders_successfully(): void
    {
        $response = $this->get('/menu');
        $response->assertStatus(200);
    }

    public function test_offers_route_renders_successfully(): void
    {
        $response = $this->get('/offers');
        $response->assertStatus(200);
    }

    public function test_production_manifest_assets_exist_and_readable(): void
    {
        $manifestPath = public_path('build/manifest.json');
        $this->assertFileExists($manifestPath, 'public/build/manifest.json must exist in repository.');

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $this->assertIsArray($manifest);
        $this->assertArrayHasKey('resources/css/app.css', $manifest);
        $this->assertArrayHasKey('resources/js/app.js', $manifest);

        $cssFile = public_path('build/' . $manifest['resources/css/app.css']['file']);
        $jsFile = public_path('build/' . $manifest['resources/js/app.js']['file']);

        $this->assertFileExists($cssFile, "Compiled CSS asset {$cssFile} must exist.");
        $this->assertFileExists($jsFile, "Compiled JS asset {$jsFile} must exist.");
    }
}
