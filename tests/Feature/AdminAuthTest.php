<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
        $this->seed(AdminUserSeeder::class);
    }

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }

    public function test_admin_user_can_authenticate(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@platinumhospitality.ae',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_user_cannot_authenticate_with_invalid_password(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@restaurant.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_admin_user_can_logout(): void
    {
        $user = User::where('email', 'admin@restaurant.com')->first();
        $this->actingAs($user);

        $response = $this->post(route('admin.logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_redirected_from_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }
}
