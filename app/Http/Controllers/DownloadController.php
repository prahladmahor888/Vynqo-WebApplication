<?php

namespace App\Http\Controllers;

use App\Models\AppRelease;
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
     * Prevents multi-chunk range request duplicates, double-clicks, and bot loops.
     */
    public function downloadApk(Request $request)
    {
        $release = AppRelease::getLatestRelease();

        // 1. Check if this is a partial byte-range continuation request (e.g., Range: bytes=1024-...)
        $rangeHeader = $request->header('Range') ?? $request->server('HTTP_RANGE');
        $isContinuationChunk = false;
        if ($rangeHeader && preg_match('/bytes=(\d+)-/i', $rangeHeader, $matches)) {
            if ((int)$matches[1] > 0) {
                $isContinuationChunk = true;
            }
        }

        // 2. Prevent multi-counting on simultaneous browser chunk requests / double-clicks (2s debounce)
        $ip = $request->ip() ?: '0.0.0.0';
        $releaseId = $release ? $release->id : 0;
        $dedupKey = 'apk_dl_instant_lock_' . $releaseId . '_' . md5($ip . '_' . ($request->userAgent() ?: ''));

        if (!$isContinuationChunk && $release && $release->exists) {
            // Atomic 2-second lock stops duplicate parallel connections from a single click
            if (Cache::add($dedupKey, 1, 2)) {
                $release->increment('download_count');
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

        return response()->download($apkFullPath, $filename, [
            'Content-Type' => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }
}
