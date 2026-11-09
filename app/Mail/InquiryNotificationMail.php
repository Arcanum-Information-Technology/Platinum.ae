<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $inquiry)
    {
    }

    public function envelope(): Envelope
    {
        $prefix = match ($this->inquiry->type) {
            'booking' => 'Table Reservation Request',
            'franchise' => 'Franchise & Partnership Inquiry',
            default => 'Guest Contact Message',
        };

        return new Envelope(
            subject: "[Platinum Hospitality] {$prefix} from {$this->inquiry->name}",
            replyTo: [$this->inquiry->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

