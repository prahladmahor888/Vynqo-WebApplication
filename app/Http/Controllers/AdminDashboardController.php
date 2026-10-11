<?php

namespace App\Http\Controllers;

use App\Models\AppRelease;
use App\Models\ApkDownloadLog;
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
        $trafficStats['trend_max'] = max(array_column($trafficStats['dailyTrend'] ?? [], 'count')) ?: 1;
        $shieldStats = \App\Models\BlockedBotLog::getShieldStats();

        // APK Download Telemetry & Activity Logs
        ApkDownloadLog::ensureTableExists();

        // 7-Day Daily APK Downloads Trend for Chart
        $dailyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Illuminate\Support\Carbon::today()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $counted = ApkDownloadLog::where('status', 'counted')
                ->whereDate('created_at', $dateStr)
                ->count();
            $blockedIos = ApkDownloadLog::where('status', 'blocked_ios')
                ->whereDate('created_at', $dateStr)
                ->count();
            $dailyTrend[] = [
                'date' => $dateStr,
                'short_day' => $date->format('D'),
                'full_date' => $date->format('M d, Y'),
                'counted' => $counted,
                'blocked_ios' => $blockedIos,
                'total' => $counted + $blockedIos,
            ];
        }

        $apkStats = [
            'total_counted' => ApkDownloadLog::where('status', 'counted')->count(),
            'today_counted' => ApkDownloadLog::where('status', 'counted')->where('created_at', '>=', \Illuminate\Support\Carbon::today())->count(),
            'unique_ips' => ApkDownloadLog::where('status', 'counted')->distinct('ip_address')->count('ip_address'),
            'blocked_ios' => ApkDownloadLog::where('status', 'blocked_ios')->count(),
            'duplicates_prevented' => ApkDownloadLog::whereIn('status', ['duplicate_token', 'duplicate_session', 'duplicate_ip_window'])->count(),
            'daily_trend' => $dailyTrend,
            'trend_max' => max(array_column($dailyTrend, 'total')) ?: 1,
            'top_countries' => ApkDownloadLog::where('status', 'counted')
                ->whereNotNull('country')
                ->whereNotIn('country', ['Unknown', ''])
                ->selectRaw('country, country_code, count(*) as total')
                ->groupBy('country', 'country_code')
                ->orderByDesc('total')
                ->take(4)
                ->get(),
        ];
        $recentApkDownloads = ApkDownloadLog::with('release')->latest('id')->take(15)->get();

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
            'queueStats',
            'apkStats',
            'recentApkDownloads'
        ));
    }

    /**
     * Display comprehensive Real-Time Traffic & Visitor Analytics Hub with Multi-Criteria Filtering and Bot Shield Defense.
     */
    public function traffic(Request $request)
    {
        $stats = VisitorTraffic::getStats();
        
        $query = VisitorTraffic::latest();

        // 1. Text Search (IP address, city, region, country, path, browser, platform, referer)
        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('path', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('platform', 'like', "%{$search}%")
                  ->orWhere('referer', 'like', "%{$search}%");
            });
        }

        // 2. Date Period Filter (today, yesterday, week, month)
        if ($request->filled('period') && $request->input('period') !== 'all') {
            $period = $request->input('period');
            if ($period === 'today') {
                $query->where('created_at', '>=', \Illuminate\Support\Carbon::today());
            } elseif ($period === 'yesterday') {
                $query->whereBetween('created_at', [
                    \Illuminate\Support\Carbon::yesterday()->startOfDay(),
                    \Illuminate\Support\Carbon::yesterday()->endOfDay(),
                ]);
            } elseif ($period === 'week') {
                $query->where('created_at', '>=', \Illuminate\Support\Carbon::now()->subDays(7));
            } elseif ($period === 'month') {
                $query->where('created_at', '>=', \Illuminate\Support\Carbon::now()->startOfMonth());
            }
        }

        // 3. Device Filter (Mobile, Desktop, Tablet, Bot)
        if ($request->filled('device') && $request->input('device') !== 'all') {
            $query->where('device_type', $request->input('device'));
        }

        // 4. IP Type Protocol Filter (ipv6, ipv4)
        if ($request->filled('ip_type') && $request->input('ip_type') !== 'all') {
            $ipType = $request->input('ip_type');
            if ($ipType === 'ipv6') {
                $query->where('ip_address', 'like', '%:%');
            } elseif ($ipType === 'ipv4') {
                $query->where('ip_address', 'not like', '%:%');
            }
        }

        // 5. Route Path Filter
        if ($request->filled('route') && $request->input('route') !== 'all') {
            $r = $request->input('route');
            if ($r === 'home') {
                $query->where('path', '/');
            } elseif ($r === 'download') {
                $query->where('path', 'like', '%download%');
            } elseif ($r === 'features') {
                $query->where('path', 'like', '%features%');
            } elseif ($r === 'contact') {
                $query->where('path', 'like', '%contact%');
            } elseif ($r === 'legal') {
                $query->where(function ($q) {
                    $q->where('path', 'like', '%privacy%')
                      ->orWhere('path', 'like', '%terms%')
                      ->orWhere('path', 'like', '%guidelines%')
                      ->orWhere('path', 'like', '%security%');
                });
            } else {
                $query->where('path', 'like', "%{$r}%");
            }
        }

        // 6. Country Filter
        if ($request->filled('country') && $request->input('country') !== 'all') {
            $query->where('country', $request->input('country'));
        }

        $paginatedLogs = $query->paginate(25)->withQueryString();

        // Bot threats query with optional search & category filter
        $botQuery = \App\Models\BlockedBotLog::latest();
        if ($request->filled('bot_search')) {
            $bs = trim((string) $request->input('bot_search'));
            $botQuery->where(function ($q) use ($bs) {
                $q->where('ip_address', 'like', "%{$bs}%")
                  ->orWhere('block_reason', 'like', "%{$bs}%")
                  ->orWhere('category', 'like', "%{$bs}%")
                  ->orWhere('target_path', 'like', "%{$bs}%");
            });
        }
        if ($request->filled('bot_category') && $request->input('bot_category') !== 'all') {
            $botQuery->where('category', $request->input('bot_category'));
        }

        $shieldStats = \App\Models\BlockedBotLog::getShieldStats();
        $paginatedBotLogs = $botQuery->paginate(25, ['*'], 'bot_page')->withQueryString();

        // Count active human filters
        $activeFiltersCount = 0;
        foreach (['search', 'period', 'device', 'ip_type', 'route', 'country'] as $param) {
            if ($request->filled($param) && $request->input($param) !== 'all') {
                $activeFiltersCount++;
            }
        }

        // Available dynamic country options
        $availableCountries = VisitorTraffic::select('country')
            ->whereNotNull('country')
            ->whereNotIn('country', ['', 'Unknown'])
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        // Available dynamic device options
        $availableDevices = VisitorTraffic::select('device_type')
            ->whereNotNull('device_type')
            ->where('device_type', '!=', '')
            ->distinct()
            ->pluck('device_type');

        return view('pages.admin-traffic', compact(
            'stats',
            'paginatedLogs',
            'shieldStats',
            'paginatedBotLogs',
            'activeFiltersCount',
            'availableCountries',
            'availableDevices'
        ));
    }

    /**
     * Clear all traffic analytics logs.
     */
    public function clearTraffic()
    {
        $lock = \Illuminate\Support\Facades\Cache::lock('admin_clear_traffic_lock', 10);
        $lock->get(function () {
            VisitorTraffic::truncate();
        });
        return redirect()->route('admin.traffic')->with('success', 'All traffic logs cleared successfully.');
    }

    /**
     * Clear all blocked bot & exploit probe security logs.
     */
    public function clearBotLogs()
    {
        $lock = \Illuminate\Support\Facades\Cache::lock('admin_clear_bot_logs_lock', 10);
        $lock->get(function () {
            \App\Models\BlockedBotLog::truncate();
        });
        return redirect()->route('admin.traffic')->with('success', 'All blocked bot security logs cleared successfully.');
    }

    /**
     * View contact & support inquiries.
     */
    public function messages()
    {
        $messages = ContactMessage::latest()->paginate(15)->withQueryString();
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

    /**
     * Clear all application, views, routes, and config caches.
     */
    public function clearCache(Request $request)
    {
        try {
            $lock = \Illuminate\Support\Facades\Cache::lock('admin_clear_cache_lock', 15);
            $lock->get(function () {
                \Illuminate\Support\Facades\Cache::flush();
                \Illuminate\Support\Facades\Artisan::call('cache:clear');
                \Illuminate\Support\Facades\Artisan::call('view:clear');
                \Illuminate\Support\Facades\Artisan::call('route:clear');
                \Illuminate\Support\Facades\Artisan::call('config:clear');
            });

            $message = 'Application cache, compiled views, routes, and config successfully cleared!';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                ]);
            }

            return back()->with('success', $message);
        } catch (\Throwable $e) {
            $errorMsg = 'Error clearing cache: ' . $e->getMessage();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMsg,
                ], 500);
            }
            return back()->with('error', $errorMsg);
        }
    }
}
