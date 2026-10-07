<?php

namespace App\Jobs;

use App\Models\BlockedBotLog;
use App\Models\VisitorTraffic;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class PruneOldVisitorTrafficJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $daysToKeep;

    /**
     * Create a new job instance.
     */
    public function __construct(int $daysToKeep = 90)
    {
        $this->daysToKeep = $daysToKeep;
    }

    /**
     * Execute the job to prune old logs and telemetry from database.
     */
    public function handle(): void
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        $cutoffDate = Carbon::now()->subDays($this->daysToKeep);

        $prunedTraffic = VisitorTraffic::where('visited_at', '<', $cutoffDate)->delete();
        $prunedBots = BlockedBotLog::where('created_at', '<', $cutoffDate)->delete();

        Log::info("PruneOldVisitorTrafficJob: Successfully pruned {$prunedTraffic} visitor rows and {$prunedBots} bot log rows older than {$this->daysToKeep} days.");
    }

    /**
     * Handle job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::error("PruneOldVisitorTrafficJob failed: " . ($exception ? $exception->getMessage() : 'Unknown error'));
    }
}
