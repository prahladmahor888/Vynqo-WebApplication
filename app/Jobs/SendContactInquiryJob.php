<?php

namespace App\Jobs;

use App\Mail\ContactInquiryReceived;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendContactInquiryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public array $backoff = [10, 30, 60];

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 3;

    /**
     * Delete the job if its models no longer exist.
     */
    public bool $deleteWhenMissingModels = true;

    public ContactMessage $contactMessage;
    public ?string $receiverEmail;

    /**
     * Create a new job instance.
     */
    public function __construct(ContactMessage $contactMessage, ?string $receiverEmail = null)
    {
        $this->contactMessage = $contactMessage;
        $this->receiverEmail = $receiverEmail;
    }

    /**
     * Execute the job to send the contact inquiry email in background.
     */
    public function handle(): void
    {
        $receiver = $this->receiverEmail ?: SiteSetting::get('support_receiver_email', 'support@prahlix.com');

        if (empty($receiver)) {
            Log::info("SendContactInquiryJob: No receiver email configured, skipping dispatch for message #{$this->contactMessage->id}");
            return;
        }

        Mail::to($receiver)->send(new ContactInquiryReceived($this->contactMessage));

        Log::info("SendContactInquiryJob: Support inquiry notification sent successfully to {$receiver} for message #{$this->contactMessage->id}");
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::error("SendContactInquiryJob FAILED permanently for message #{$this->contactMessage->id}: " . ($exception ? $exception->getMessage() : 'Unknown error'), [
            'message_id' => $this->contactMessage->id,
            'email' => $this->contactMessage->email,
        ]);
    }
}
