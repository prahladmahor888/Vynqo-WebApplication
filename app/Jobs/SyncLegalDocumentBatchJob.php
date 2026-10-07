<?php

namespace App\Jobs;

use App\Models\LegalDocument;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyncLegalDocumentBatchJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $slug;
    public array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(string $slug, array $data)
    {
        $this->slug = $slug;
        $this->data = $data;
    }

    /**
     * Execute the job to sync a specific legal document.
     */
    public function handle(): void
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        LegalDocument::updateOrCreate(
            ['slug' => $this->slug],
            $this->data
        );

        Log::info("SyncLegalDocumentBatchJob: Synced legal document '{$this->slug}' (v{$this->data['version']}) successfully.");
    }

    /**
     * Handle job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::error("SyncLegalDocumentBatchJob failed for '{$this->slug}': " . ($exception ? $exception->getMessage() : 'Unknown error'));
    }
}
