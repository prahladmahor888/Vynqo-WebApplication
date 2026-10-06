<?php

namespace Database\Seeders;

use App\Models\AppRelease;
use Illuminate\Database\Seeder;

class AppReleaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppRelease::truncate();

        // Initial Public Release v1.0.0 from real Android Project
        AppRelease::create([
            'version_name' => 'v1.0.0',
            'version_code' => 1,
            'apk_file_path' => 'downloads/sangfy-release.apk',
            'file_size' => '29.65 MB',
            'sha256_checksum' => '2ebcddf151a6ae5535b3306f1e1c1d61ffba666663607d188a5fbafe8fd50a4e',
            'changelog' => "• Official Public Launch of Sangfy Android App (com.prahlix.sangfy)\n• Image & Video Feed Posts with likes, comments, and captions\n• 24-Hour disappearing Stories (Moments)\n• 'Find Nearby People' discovery radar with distance & interest filters\n• High-definition 1080p voice and video calls powered by Agora RTC\n• End-to-End Encrypted private chats & view-once media\n• Location privacy controls & Ghost Mode",
            'min_android_version' => 'Android 10.0 (API 29)+',
            'download_count' => 0,
            'is_latest' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
