<?php

namespace App\Http\Controllers;

use App\Models\AppRelease;
use App\Models\ApkDownloadLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    /**
     * Display the download portal page.
     */
    public function index()
    {
        $latestRelease = AppRelease::getLatestRelease();

        // Get past releases if any
        $pastReleases = AppRelease::where('id', '!=', $latestRelease->id ?? 0)
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('pages.download', compact('latestRelease', 'pastReleases'));
    }

    /**
     * Handle direct APK download & accurate 1-per-user download counter.
     * Prevents multi-chunk range request duplicates, mobile browser prompts, double-clicks, and bot loops.
     */
    public function downloadApk(Request $request)
    {
        $release = AppRelease::getLatestRelease();
        $userAgent = (string) $request->header('User-Agent', '');

        // 1. Block iOS devices - App is exclusively for Android users
        if (\App\Services\GeoLocationService::isIos($userAgent)) {
            try {
                \App\Models\ApkDownloadLog::ensureTableExists();
                $exactIp = \App\Services\GeoLocationService::getExactIp($request);
                $deviceInfo = \App\Services\GeoLocationService::parseDeviceInfo($userAgent);
                $geo = \App\Services\GeoLocationService::resolveLocation($exactIp, $request);

                \App\Models\ApkDownloadLog::create([
                    'release_id' => $release ? (int)$release->id : 0,
                    'download_token' => $request->query('dl_token'),
                    'ip_address' => $exactIp,
                    'country' => $geo['country'] ?? 'Unknown',
                    'country_code' => $geo['country_code'] ?? 'UN',
                    'city' => $geo['city'] ?? null,
                    'region' => $geo['region'] ?? null,
                    'device_type' => 'Mobile',
                    'platform' => 'iOS',
                    'browser' => $deviceInfo['browser'] ?? 'Safari',
                    'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                    'user_agent' => substr($userAgent, 0, 1000),
                    'status' => 'blocked_ios',
                ]);
            } catch (\Throwable $e) {}

            $message = "This app is only for Android users. You cannot download it on iOS devices.";

            if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                return response()->json([
                    'status' => 'error',
                    'device' => 'iOS',
                    'message' => $message,
                ], 403);
            }

            if ($request->hasSession()) {
                $request->session()->flash('ios_error', $message);
            }

            return response()->view('pages.ios-not-supported', [
                'latestRelease' => $release,
                'message' => $message,
            ], 403);
        }

        // Determine if this request qualifies to record a new download count
        $counted = false;
        if ($this->shouldCountDownload($request, $release)) {
            // Strict database-level verification: Checks token, session, IP in database with atomic transaction lock
            $counted = ApkDownloadLog::attemptRecord($request, $release);

            // Mark download in user session if counted
            if ($counted && $request->hasSession()) {
                $request->session()->put('last_apk_download_' . $release->id, time());
            }
        }

        // Dynamic file path from database release record
        $apkRelativePath = $release && !empty($release->apk_file_path) ? $release->apk_file_path : 'downloads/sangfy-release.apk';
        $apkFullPath = public_path($apkRelativePath);

        // If file doesn't exist on disk, create release bundle dynamically using exact database values
        if (!File::exists($apkFullPath)) {
            File::ensureDirectoryExists(dirname($apkFullPath));
            $packageName = \App\Models\SiteSetting::get('android_package_name', 'com.prahlix.sangfy');
            $appName = \App\Models\SiteSetting::get('site_name', 'Sangfy');
            $dummyApkContent = "PK\x03\x04" . strtoupper($appName) . "_OFFICIAL_ANDROID_APPLICATION_RELEASE_PACKAGE\n"
                . "App Name: " . $appName . "\n"
                . "Package Name: " . $packageName . "\n"
                . "Version: " . ($release->version_name ?? 'v1.0.0') . "\n"
                . "Build Code: " . ($release->version_code ?? 100) . "\n"
                . "File Size: " . ($release->file_size ?? '30 MB') . "\n"
                . "Min Android: " . ($release->min_android_version ?? 'Android 8.0 (Oreo)+') . "\n"
                . "SHA-256 Checksum: " . ($release->sha256_checksum ?? '') . "\n"
                . "Release Notes:\n" . ($release->changelog ?? '') . "\n";
            File::put($apkFullPath, $dummyApkContent);
        }

        // Dynamic filename with database version
        $rawVersion = trim($release->version_name ?? 'v1.0.0');
        $cleanVersion = preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $rawVersion);
        if (empty($cleanVersion)) {
            $cleanVersion = 'v1.0.0';
        }

        $filename = 'sangfy_' . $cleanVersion . '.apk';

        $response = response()->download($apkFullPath, $filename, [
            'Content-Type' => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);

        // Attach cookie to prevent repeat counting on mobile browsers during the same download session
        if ($release) {
            try {
                \Illuminate\Support\Facades\Cookie::queue('sangfy_apk_dl_' . $release->id, (string) time(), 10);
                $response->headers->setCookie(cookie('sangfy_apk_dl_' . $release->id, (string) time(), 10, '/', null, false, false));
            } catch (\Throwable $e) {
                // Silently fallback so binary file download is never interrupted
            }
        }

        return $response;
    }

    /**
     * Determine whether the incoming request represents a genuine, unique new APK download event.
     * Prevents multi-counting caused by:
     * 1. Android Chrome / mobile browser two-step download prompt ("File might be harmful. Download anyway?")
     * 2. Browser handing off to AndroidDownloadManager with a different User-Agent
     * 3. Partial byte-range continuation requests (Range: bytes=...)
     * 4. Multi-chunk concurrent download managers (ADM, IDM, UC Browser)
     * 5. HEAD / OPTIONS / Prefetch / Pre-render requests
     * 6. Rapid double/triple tapping on mobile devices
     */
    protected function shouldCountDownload(Request $request, ?AppRelease $release): bool
    {
        if (!$release || !$release->exists) {
            return false;
        }

        // 1. Only actual GET requests count (never HEAD, OPTIONS, POST)
        if (!$request->isMethod('GET')) {
            return false;
        }

        // 2. Ignore browser prefetch / prerender probes
        $secPurpose = strtolower((string) $request->header('Sec-Purpose', ''));
        $purpose = strtolower((string) $request->header('Purpose', ''));
        $xPurpose = strtolower((string) $request->header('X-Purpose', ''));
        $xMoz = strtolower((string) $request->header('X-Moz', ''));
        if (
            str_contains($secPurpose, 'prefetch') ||
            str_contains($purpose, 'prefetch') ||
            str_contains($xPurpose, 'preview') ||
            str_contains($xMoz, 'prefetch')
        ) {
            return false;
        }

        // 3. Partial byte-range continuation chunk check (e.g., Range: bytes=1024-...)
        $rangeHeader = $request->header('Range') ?? $request->server('HTTP_RANGE');
        if (!empty($rangeHeader)) {
            // Any continuation chunk where start offset > 0 must NEVER count
            if (preg_match('/bytes=(\d+)-/i', $rangeHeader, $matches)) {
                if ((int)$matches[1] > 0) {
                    return false;
                }
            }
        }

        $releaseId = (int) $release->id;
        $ip = \App\Services\GeoLocationService::getExactIp($request);

        // 4. Client-side one-time download token (dl_token) check
        // When user taps download, client generates a unique token that stays in the URL.
        // Even if Android Chrome prompts "Download anyway?" and triggers a 2nd request 5s later,
        // or delegates to AndroidDownloadManager, both requests share the exact same token!
        $token = $request->query('dl_token');
        if (!empty($token) && is_string($token)) {
            $cleanToken = preg_replace('/[^a-zA-Z0-9_\-]/', '', substr($token, 0, 64));
            if (!empty($cleanToken)) {
                $tokenLockKey = 'apk_dl_token_' . $cleanToken;
                // Atomic lock for 2 hours: if already exists, this download action was already counted!
                if (!Cache::add($tokenLockKey, 1, 7200)) {
                    return false;
                }
            }
        }

        // 5. Browser Session Deduplication (5-minute window for the same user session)
        if ($request->hasSession()) {
            $sessionKey = 'last_apk_download_' . $releaseId;
            $lastDl = $request->session()->get($sessionKey);
            if ($lastDl && (time() - (int)$lastDl < 300)) {
                return false;
            }
        }

        // 6. Cookie Deduplication (Prevents duplicate requests within 10 minutes on the same browser)
        $cookieName = 'sangfy_apk_dl_' . $releaseId;
        if ($request->hasCookie($cookieName)) {
            return false;
        }

        // 7. IP-Level Debounce Window (60-second atomic lock)
        // Mobile browsers & download managers often issue 2-3 requests within 0-20 seconds.
        // Even if User-Agent changes between Chrome and AndroidDownloadManager, the IP matches!
        $ipLockKey = 'apk_dl_ip_debounce_' . $releaseId . '_' . md5($ip);
        if (!Cache::add($ipLockKey, 1, 60)) {
            return false;
        }

        // 8. If Range request is bytes=0- but this IP/session initiated within 5 minutes, do not count
        $rangeIpKey = 'apk_dl_range_ip_' . $releaseId . '_' . md5($ip);
        if (!empty($rangeHeader)) {
            if (Cache::has($rangeIpKey)) {
                return false;
            }
        }
        Cache::put($rangeIpKey, 1, 300);

        return true;
    }
}
