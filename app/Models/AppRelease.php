<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppRelease extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_name',
        'version_code',
        'apk_file_path',
        'file_size',
        'sha256_checksum',
        'changelog',
        'min_android_version',
        'download_count',
        'is_latest',
    ];

    protected $casts = [
        'version_code' => 'integer',
        'download_count' => 'integer',
        'is_latest' => 'boolean',
    ];

    /**
     * Scope to get the latest active release directly from database.
     */
    public static function getLatestRelease()
    {
        return self::where('is_latest', true)->latest('id')->first()
            ?? self::latest('id')->first()
            ?? new self([
                'version_name' => 'v0',
                'version_code' => 0,
                'apk_file_path' => 'downloads/sangfy-release.apk',
                'file_size' => '30 MB',
                'sha256_checksum' => 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855',
                'changelog' => "• Image & Video Feed post sharing with captions, likes and comments\n• 24-Hour disappearing Stories\n• 'Find Nearby People' radar with distance & interest filters\n• High-definition 1080p voice and video calling via Agora RTC\n• End-to-End Encrypted 1-on-1 private messaging and view-once media\n• Location privacy controls & Ghost Mode",
                'min_android_version' => 'Android 8.0 (Oreo)+',
                'download_count' => 1250,
                'is_latest' => true,
            ]);
    }
}
