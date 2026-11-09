<?php

namespace App\Mail;

use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminLoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $adminName;
    public string $ipAddress;

    /**
     * Create a new message instance.
     */
    public function __construct(string $otp, string $adminName = 'Administrator', string $ipAddress = 'Unknown')
    {
        $this->otp = $otp;
        $this->adminName = $adminName;
        $this->ipAddress = $ipAddress;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $siteName = SiteSetting::get('site_name', 'Sangfy');
        return new Envelope(
            subject: "[{$siteName} Admin Security] Your 2-Step Verification Code: {$this->otp}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-login-otp',
            with: [
                'otp' => $this->otp,
                'adminName' => $this->adminName,
                'ipAddress' => $this->ipAddress,
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

