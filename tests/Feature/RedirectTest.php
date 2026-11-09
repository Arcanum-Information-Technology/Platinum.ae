<?php

namespace Tests\Feature;

use App\Models\Redirect;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectTest extends TestCase
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

    public function test_active_redirect_forwards_guest_to_target_destination(): void
    {
        Redirect::create([
            'source_url' => '/old-wine-cellar',
            'destination_url' => '/menu',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $response = $this->get('/old-wine-cellar');
        $response->assertStatus(301);
        $response->assertRedirect('/menu');
    }

    public function test_admin_can_create_redirect(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.redirects.store'), [
            'source_url' => '/chef-table',
            'destination_url' => '/contact',
            'status_code' => 302,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('redirects', [
            'source_url' => '/chef-table',
            'destination_url' => '/contact',
            'status_code' => 302,
            'is_active' => true,
        ]);
    }

    public function test_circular_redirect_is_prevented(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.redirects.store'), [
            'source_url' => '/same-path',
            'destination_url' => '/same-path',
            'status_code' => 301,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('destination_url');
    }
}
