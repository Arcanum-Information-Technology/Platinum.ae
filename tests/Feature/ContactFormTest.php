<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
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

    public function test_guest_can_submit_contact_form(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Sophia Loren',
            'email' => 'sophia@example.com',
            'phone' => '+1 (555) 789-0123',
            'subject' => 'Private Dining Inquiry for 12 Guests',
            'message' => 'We are interested in booking the private wine vault for an anniversary dinner next month.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Sophia Loren',
            'email' => 'sophia@example.com',
            'subject' => 'Private Dining Inquiry for 12 Guests',
            'is_read' => false,
        ]);
    }

    public function test_spam_bot_filling_honeypot_is_silently_discarded(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Spam Bot',
            'email' => 'bot@spammer.com',
            'message' => 'Buy cheap links now!',
            'website_hp' => 'http://spam-site.com', // Honeypot trap
        ]);

        $response->assertRedirect();
        // Database should NOT contain this spam message
        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'bot@spammer.com',
        ]);
    }

    public function test_admin_can_view_and_manage_messages(): void
    {
        $msg = ContactMessage::create([
            'name' => 'Lord Mountbatten',
            'email' => 'lord@palace.uk',
            'subject' => 'State Dinner Catering',
            'message' => 'Please contact my private secretary regarding gala arrangements.',
        ]);

        $indexResponse = $this->actingAs($this->admin)->get(route('admin.messages.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Lord Mountbatten');

        // View single message (marks as read)
        $showResponse = $this->actingAs($this->admin)->get(route('admin.messages.show', $msg->id));
        $showResponse->assertStatus(200);

        $msg->refresh();
        $this->assertTrue($msg->is_read);

        // Add internal note
        $noteResponse = $this->actingAs($this->admin)->post(route('admin.messages.notes', $msg->id), [
            'notes' => 'Spoke to private secretary on phone. Banquet menu sent via email.',
        ]);
        $noteResponse->assertRedirect();

        $msg->refresh();
        $this->assertEquals('Spoke to private secretary on phone. Banquet menu sent via email.', $msg->notes);
    }
}
