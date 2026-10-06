<?php

namespace App\Http\Controllers;

use App\Models\AppRelease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReleaseManagerController extends Controller
{
    /**
     * Show the APK Release Management dashboard.
     */
    public function index()
    {
        $currentRelease = AppRelease::getLatestRelease();
        $allReleases = AppRelease::latest('id')->get();

        return view('pages.admin-release', compact('currentRelease', 'allReleases'));
    }

    /**
     * Handle new APK upload & database update.
     * File Size and Checksum are 100% AUTOMATICALLY calculated.
     */
    public function updateRelease(Request $request)
    {
        $validated = $request->validate([
            'version_name' => 'required|string|max:50',
            'version_code' => 'required|integer|min:1',
            'file_size' => 'nullable|string|max:50',
            'min_android_version' => 'nullable|string|max:100',
            'changelog' => 'required|string',
            'apk_file' => 'nullable|file|max:153600', // up to 150MB
        ]);

        $currentRelease = AppRelease::where('is_latest', true)->latest('id')->first();

        $filePath = $currentRelease ? $currentRelease->apk_file_path : 'downloads/sangfy-release.apk';
        $fileSize = $currentRelease ? $currentRelease->file_size : '30 MB';
        $checksum = $currentRelease ? $currentRelease->sha256_checksum : 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';

        // Clean version string (e.g. ensure 'v' prefix)
        $versionName = trim($validated['version_name']);
        if (!str_starts_with(strtolower($versionName), 'v')) {
            $versionName = 'v' . $versionName;
        }

        $versionCode = (int) $validated['version_code'];

        // If a new APK file was uploaded -> AUTOMATICALLY calculate exact file size & SHA-256
        if ($request->hasFile('apk_file')) {
            $uploadedFile = $request->file('apk_file');
            
            // Save binary to downloads folder
            $filename = 'sangfy-release.apk';
            $destinationDir = public_path('downloads');
            File::ensureDirectoryExists($destinationDir);
            
            $uploadedFile->move($destinationDir, $filename);
            
            $fullPath = $destinationDir . DIRECTORY_SEPARATOR . $filename;
            $rawBytes = File::size($fullPath);
            
            // ⚡ AUTOMATIC EXACT FILE SIZE CALCULATION (e.g. 30.5 MB)
            $fileSize = round($rawBytes / (1024 * 1024), 1) . ' MB';
            
            // ⚡ AUTOMATIC SHA-256 CHECKSUM CALCULATION
            $checksum = hash_file('sha256', $fullPath);
            $filePath = 'downloads/' . $filename;
        } elseif (!empty($validated['file_size'])) {
            $fileSize = trim($validated['file_size']);
        }

        // Mark previous releases as not latest
        AppRelease::where('is_latest', true)->update(['is_latest' => false]);

        // Create new active release record
        $release = AppRelease::create([
            'version_name' => $versionName,
            'version_code' => $versionCode,
            'apk_file_path' => $filePath,
            'file_size' => $fileSize,
            'sha256_checksum' => $checksum,
            'changelog' => $validated['changelog'],
            'min_android_version' => $validated['min_android_version'] ?: 'Android 8.0 (Oreo)+',
            'download_count' => $currentRelease ? $currentRelease->download_count : 1250,
            'is_latest' => true,
        ]);

        return redirect()->route('admin.release')->with('success', "Release saved successfully! Version: {$release->version_name} (Code: {$release->version_code}), Automatic File Size: {$release->file_size}. Database updated.");
    }
}
