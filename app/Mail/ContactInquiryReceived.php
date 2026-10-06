<?php

namespace App\Mail;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $contactMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $siteName = SiteSetting::get('site_name', 'Sangfy');
        return new Envelope(
            subject: "[{$siteName} Support] New Inquiry: " . $this->contactMessage->subject,
            replyTo: [
                new Address($this->contactMessage->email, $this->contactMessage->name),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-inquiry',
            with: [
                'msg' => $this->contactMessage,
                'siteName' => SiteSetting::get('site_name', 'Sangfy'),
                'siteLogo' => SiteSetting::getLogoUrl(),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
