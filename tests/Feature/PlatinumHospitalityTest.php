<?php

namespace Tests\Feature;

use App\Mail\InquiryNotificationMail;
use App\Models\ContactMessage;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\PlatinumWebsiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PlatinumHospitalityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PlatinumWebsiteSeeder::class);
    }

    public function test_home_page_renders_with_platinum_branding_and_content(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Platinum Hospitality Management');
        $response->assertSee('Shakespeare Middle East');
        $response->assertSee('Otantik');
        $response->assertSee('Chinese Connection');
        $response->assertSee('vegetarian-sandwich-panini-with-spinach-leaves-tomatoes-and-cheese.jpg');
        $response->assertSee('Sophie Laurent');
        $response->assertSee('Eveline Gagneux');
        $response->assertSee('Ahmed Al Mansoori');
        $response->assertSee('09:00 AM');
        $response->assertSee('Booking Table In Online');

        // Footer assertions: has facebook/instagram svg, and NO staff login
        $response->assertSee('aria-label="Facebook"', false);
        $response->assertSee('aria-label="Instagram"', false);
        $response->assertDontSee('Staff Login');
    }

    public function test_about_page_renders_with_milestones_and_founders(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Platinum Hospitality Management');
        $response->assertSee('Decades of Hospitality Management Excellence');
        $response->assertSee('1989');
        $response->assertSee('1998');
        $response->assertSee('2007');
        $response->assertSee('2017');
        $response->assertSee('Aroldo De Marco');
        $response->assertSee('Quetzalli Antonio');
        $response->assertSee('Jovanni Scutari');
        $response->assertSee('Edda Rivera');
        $response->assertSee('Quality Food');
        $response->assertSee('Professional Chef');
    }

    public function test_brands_page_renders_all_three_sub_brands(): void
    {
        $response = $this->get('/brands');

        $response->assertStatus(200);
        $response->assertSee('Shakespeare Middle East');
        $response->assertSee('Otantik');
        $response->assertSee('Chinese Connection');
        $response->assertSee('id="shakespeare"', false);
        $response->assertSee('id="otantik"', false);
        $response->assertSee('id="chinese-connection"', false);
    }

    public function test_franchise_page_renders_inquiry_form_and_support_pillars(): void
    {
        $response = $this->get('/franchise');

        $response->assertStatus(200);
        $response->assertSee('Franchise &amp; Partnership Enquiry', false);
        $response->assertSee('Your Franchise Journey Starts Here');
        $response->assertSee('Comprehensive Support. Proven Systems.');
        $response->assertSee('Select Brand');
    }

    public function test_table_booking_submission_saves_and_sends_email_notification(): void
    {
        Mail::fake();
        Setting::set('inquiry_notification_email', 'admin@platinumhospitality.ae');

        $response = $this->post('/contact', [
            'name' => 'Bhairav Patel',
            'email' => 'bhairav@example.com',
            'phone' => '+971 50 123 4567',
            'subject' => 'Online Table Reservation',
            'territory' => 'Shakespeare Middle East',
            'message' => 'Table reservation for 4 guests this Saturday at 7:30 PM.',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Bhairav Patel',
            'email' => 'bhairav@example.com',
            'type' => 'booking',
            'brand' => 'Shakespeare Middle East',
        ]);

        Mail::assertSent(InquiryNotificationMail::class, function ($mail) {
            return $mail->hasTo('admin@platinumhospitality.ae')
                && $mail->inquiry->type === 'booking';
        });
    }

    public function test_franchise_inquiry_submission_saves_and_sends_email_notification(): void
    {
        Mail::fake();
        Setting::set('inquiry_notification_email', 'director@platinumhospitality.ae');

        $response = $this->post('/contact', [
            'name' => 'Rashid Al Maktoum',
            'email' => 'rashid@investmentuae.com',
            'phone' => '+971 50 999 8888',
            'subject' => 'Franchise & Partnership Enquiry',
            'territory' => 'Otantik Cafe & Restaurant',
            'message' => 'We are interested in franchising Otantik in Dubai Creek Harbour.',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Rashid Al Maktoum',
            'email' => 'rashid@investmentuae.com',
            'type' => 'franchise',
            'brand' => 'Otantik Cafe & Restaurant',
        ]);

        Mail::assertSent(InquiryNotificationMail::class, function ($mail) {
            return $mail->hasTo('director@platinumhospitality.ae')
                && $mail->inquiry->type === 'franchise';
        });
    }

    public function test_contact_page_renders_and_accepts_submission(): void
    {
        Mail::fake();

        $postResponse = $this->post('/contact', [
            'name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'phone' => '+971 50 123 4567',
            'subject' => 'Media & PR Collaboration',
            'message' => 'We would love to feature Platinum Hospitality in our luxury magazine.',
        ]);

        $postResponse->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'type' => 'contact',
        ]);

        Mail::assertSent(InquiryNotificationMail::class);
    }

    public function test_admin_inquiry_pages_render_successfully_for_staff(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['email' => 'admin@test.com', 'is_active' => true]);
        } else {
            $admin->update(['is_active' => true]);
        }

        // Create 3 sample records
        ContactMessage::create([
            'name' => 'Guest 1',
            'email' => 'g1@test.com',
            'type' => 'booking',
            'brand' => 'Shakespeare Middle East',
            'subject' => 'Online Table Reservation',
            'message' => 'Table request',
        ]);

        ContactMessage::create([
            'name' => 'Lead 2',
            'email' => 'lead@test.com',
            'type' => 'franchise',
            'brand' => 'Chinese Connection',
            'subject' => 'Franchise Enquiry',
            'message' => 'Franchise request',
        ]);

        ContactMessage::create([
            'name' => 'General 3',
            'email' => 'gen@test.com',
            'type' => 'contact',
            'subject' => 'General question',
            'message' => 'Hello team',
        ]);

        // 1. Table Bookings Page
        $res1 = $this->actingAs($admin)->get(route('admin.inquiries.bookings'));
        $res1->assertStatus(200);
        $res1->assertSee('Table Reservations');
        $res1->assertSee('Guest 1');

        // 2. Franchise Page
        $res2 = $this->actingAs($admin)->get(route('admin.inquiries.franchise'));
        $res2->assertStatus(200);
        $res2->assertSee('Franchise');
        $res2->assertSee('Lead 2');

        // 3. Contact Messages Page
        $res3 = $this->actingAs($admin)->get(route('admin.inquiries.contact'));
        $res3->assertStatus(200);
        $res3->assertSee('Contact Us Messages');
        $res3->assertSee('General 3');
    }

    public function test_shakespeare_brand_subpage_renders_with_provided_content(): void
    {
        $response = $this->get('/brands/shakespeare-middle-east');
        $response->assertStatus(200);
        $response->assertSee('Shakespeare Middle East');
        $response->assertSee('Our Special Menu');
        $response->assertSee('Bawabat Al Sharq');
        $response->assertSee('A Timeless Dining Experience, Reimagined for Modern Hospitality');
        $response->assertSee('Experience the World of Shakespeare Middle East');
    }

    public function test_otantik_brand_subpage_renders_with_provided_content(): void
    {
        $response = $this->get('/brands/otantik-cafe-restaurant');
        $response->assertStatus(200);
        $response->assertSee('Otantik Café &amp; Restaurant', false);
        $response->assertSee('Authentic Turkish Flavors. Timeless Hospitality.');
        $response->assertSee('Otantik Café');
        $response->assertSee('traditional Turkish dining');
    }

    public function test_chinese_connection_brand_subpage_renders_with_provided_content(): void
    {
        $response = $this->get('/brands/chinese-connection');
        $response->assertStatus(200);
        $response->assertSee('Chinese Connection');
        $response->assertSee('Bold Asian Flavors. Modern Dining Energy.');
        $response->assertSee('contemporary Asian dining');
        $response->assertSee('traditional Chinese cuisine');
    }
}
