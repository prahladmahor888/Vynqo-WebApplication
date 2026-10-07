<?php

namespace App\Http\Controllers;

use App\Models\AppRelease;
use App\Models\LegalDocument;
use App\Models\ContactMessage;
use App\Models\VisitorTraffic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminDashboardController extends Controller
{
    /**
     * Display unified Admin Dashboard with all metrics and management hubs.
     */
    public function index()
    {
        $latestRelease = AppRelease::getLatestRelease();
        $totalReleases = AppRelease::count();
        $totalDownloads = AppRelease::getTotalDownloads();
        $legalDocs = LegalDocument::all();
        if ($legalDocs->isEmpty()) {
            $legalDocs = collect(LegalDocument::getDefaultsArray())->map(fn($d) => new LegalDocument($d));
        }
        $legalCount = $legalDocs->count();

        $totalMessages = ContactMessage::count();
        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentReleases = AppRelease::latest()->take(5)->get();

        $apkExists = File::exists(public_path($latestRelease->apk_file_path ?? 'downloads/sangfy-release.apk'));

        // Traffic overview summary
        $trafficStats = VisitorTraffic::getStats();
        $shieldStats = \App\Models\BlockedBotLog::getShieldStats();

        // Queue & Background Worker Telemetry (jobs, job_batches, failed_jobs)
        $queueStats = [
            'pending_jobs' => 0,
            'job_batches' => 0,
            'failed_jobs' => 0,
        ];

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('jobs')) {
                $queueStats['pending_jobs'] = \Illuminate\Support\Facades\DB::table('jobs')->count();
            }
            if (\Illuminate\Support\Facades\Schema::hasTable('job_batches')) {
                $queueStats['job_batches'] = \Illuminate\Support\Facades\DB::table('job_batches')->count();
            }
            if (\Illuminate\Support\Facades\Schema::hasTable('failed_jobs')) {
                $queueStats['failed_jobs'] = \Illuminate\Support\Facades\DB::table('failed_jobs')->count();
            }
        } catch (\Throwable $e) {
            // Graceful fallback
        }

        return view('pages.admin-dashboard', compact(
            'latestRelease',
            'totalReleases',
            'totalDownloads',
            'legalDocs',
            'legalCount',
            'totalMessages',
            'recentMessages',
            'recentReleases',
            'apkExists',
            'trafficStats',
            'shieldStats',
            'queueStats'
        ));
    }

    /**
     * Display comprehensive Real-Time Traffic & Visitor Analytics Hub with Bot Shield Defense.
     */
    public function traffic()
    {
        $stats = VisitorTraffic::getStats();
        $paginatedLogs = VisitorTraffic::latest()->paginate(25);
        $shieldStats = \App\Models\BlockedBotLog::getShieldStats();
        $paginatedBotLogs = \App\Models\BlockedBotLog::latest()->paginate(25, ['*'], 'bot_page');

        return view('pages.admin-traffic', compact('stats', 'paginatedLogs', 'shieldStats', 'paginatedBotLogs'));
    }

    /**
     * Clear all traffic analytics logs.
     */
    public function clearTraffic()
    {
        VisitorTraffic::truncate();
        return redirect()->route('admin.traffic')->with('success', 'All traffic logs cleared successfully.');
    }

    /**
     * Clear all blocked bot & exploit probe security logs.
     */
    public function clearBotLogs()
    {
        \App\Models\BlockedBotLog::truncate();
        return redirect()->route('admin.traffic')->with('success', 'All blocked bot security logs cleared successfully.');
    }

    /**
     * View contact & support inquiries.
     */
    public function messages()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('pages.admin-messages', compact('messages'));
    }

    /**
     * Mark message as resolved or toggle status.
     */
    public function toggleMessage(ContactMessage $message)
    {
        $message->update(['is_resolved' => !$message->is_resolved]);
        return back()->with('success', 'Message status updated.');
    }

    /**
     * Delete contact message.
     */
    public function deleteMessage(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted successfully.');
    }
}
