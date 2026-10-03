<?php

namespace App\Providers;

use App\Models\AppRelease;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share latest release data globally across all Blade views
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('app_releases')) {
                    $latestRelease = AppRelease::getLatestRelease();
                } else {
                    $latestRelease = new AppRelease([
                        'version_name' => 'v1.0.0',
                        'version_code' => 100,
                        'apk_file_path' => 'downloads/vynqo-release.apk',
                        'file_size' => '30 MB',
                        'min_android_version' => 'Android 8.0 (Oreo)+',
                        'download_count' => 1050,
                        'is_latest' => true,
                    ]);
                }
            } catch (\Exception $e) {
                $latestRelease = new AppRelease([
                    'version_name' => 'v1.0.0',
                    'version_code' => 100,
                    'apk_file_path' => 'downloads/vynqo-release.apk',
                    'file_size' => '30 MB',
                    'min_android_version' => 'Android 8.0 (Oreo)+',
                    'download_count' => 1050,
                    'is_latest' => true,
                ]);
            }

            $view->with('latestRelease', $latestRelease);
        });
    }
}
