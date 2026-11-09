<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_deploy_setup_requires_valid_token(): void
    {
        $response = $this->get('/deploy-setup');
        $response->assertStatus(403);

        $response = $this->get('/deploy-setup?token=setup-restaurant-2026');
        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');
    }
}
