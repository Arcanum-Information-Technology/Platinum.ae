<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ContactFormRequest;
use App\Mail\InquiryNotificationMail;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $page = Page::published()->where('slug', 'contact')->first();

        if ($page) {
            return view('website.page', compact('page'));
        }

        return view('website.contact');
    }

    public function submit(ContactFormRequest $request): RedirectResponse
    {
        // Anti-spam honeypot verification
        if ($request->filled('website_hp')) {
            // Silently discard spam bots
            return back()->with('success', 'Thank you! Your reservation inquiry has been received.');
        }

        // Rate limiting: max 10 messages per hour per IP
        $key = 'contact_submissions:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many submissions. Please wait {$seconds} seconds before trying again.")->withInput();
        }

        RateLimiter::hit($key, 3600);

        $subjectInput = $request->input('subject', '');
        $body = $request->input('message');
        $brand = $request->input('brand') ?: $request->input('territory');

        // Determine inquiry category
        $type = 'contact';
        $defaultSubject = 'General Website Inquiry';

        if (stripos($subjectInput, 'Reservation') !== false || stripos($subjectInput, 'Booking') !== false || stripos($subjectInput, 'Table') !== false) {
            $type = 'booking';
            $defaultSubject = 'Online Table Reservation';
        } elseif (stripos($subjectInput, 'Franchise') !== false || $request->filled('territory')) {
            $type = 'franchise';
            $defaultSubject = 'Franchise & Partnership Enquiry';
        }

        $subject = !empty($subjectInput) ? $subjectInput : $defaultSubject;

        // If brand was chosen, append or contextualize
        if ($brand && !empty($brand)) {
            $subject = "[{$brand}] {$subject}";
        }

        $message = ContactMessage::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'subject' => $subject,
            'type' => $type,
            'brand' => $brand,
            'status' => 'new',
            'message' => $body,
            'ip_address' => $request->ip(),
        ]);

        ActivityLog::log(
            action: 'inquiry_submitted',
            description: "New {$type} inquiry from {$message->name} ({$message->email})",
            entity: $message
        );

        // Send email alert to the configured receiver email
        try {
            $recipientEmail = Setting::get('inquiry_notification_email')
                ?: env('INQUIRY_NOTIFICATION_EMAIL', Setting::get('restaurant_email', 'info@platinumhospitality.ae'));

            if (!empty($recipientEmail)) {
                Mail::to($recipientEmail)->send(new InquiryNotificationMail($message));
            }
        } catch (\Throwable $e) {
            Log::warning("Failed sending inquiry notification email: " . $e->getMessage(), [
                'inquiry_id' => $message->id,
            ]);
        }

        $successText = match ($type) {
            'booking' => 'Thank you! Your table reservation request has been submitted. Our concierge team will contact you shortly.',
            'franchise' => 'Thank you for your franchise application. Our corporate development team will review your proposal promptly.',
            default => 'Thank you for reaching out. Your message has been received and our team will get in touch soon.',
        };

        return back()->with('success', $successText);
    }
}
