<?php

namespace App\Providers;

use App\Models\AppRelease;
use App\Models\SiteSetting;
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
        // Share latest release data, grand total downloads, and dynamic site branding settings globally across all Blade views
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('app_releases')) {
                    $latestRelease = AppRelease::getLatestRelease();
                    $totalPublicDownloads = AppRelease::sum('download_count') ?: ($latestRelease->download_count ?? 1250);
                    $allReleases = AppRelease::latest('id')->get();
                } else {
                    $latestRelease = new AppRelease([
                        'version_name' => 'v1.0.0',
                        'version_code' => 100,
                        'apk_file_path' => 'downloads/sangfy-release.apk',
                        'file_size' => '30 MB',
                        'min_android_version' => 'Android 8.0 (Oreo)+',
                        'download_count' => 1250,
                        'is_latest' => true,
                    ]);
                    $totalPublicDownloads = 1250;
                    $allReleases = collect([$latestRelease]);
                }
            } catch (\Exception $e) {
                $latestRelease = new AppRelease([
                    'version_name' => 'v1.0.0',
                    'version_code' => 100,
                    'apk_file_path' => 'downloads/sangfy-release.apk',
                    'file_size' => '30 MB',
                    'min_android_version' => 'Android 8.0 (Oreo)+',
                    'download_count' => 1250,
                    'is_latest' => true,
                ]);
                $totalPublicDownloads = 1250;
                $allReleases = collect([$latestRelease]);
            }

            $siteSettings = SiteSetting::getAll();
            $siteLogo = SiteSetting::getLogoUrl();
            $siteFavicon = SiteSetting::getFaviconUrl();
            $siteName = $siteSettings['site_name'] ?? 'Sangfy';

            $view->with([
                'latestRelease' => $latestRelease,
                'totalDownloads' => $totalPublicDownloads,
                'totalPublicDownloads' => $totalPublicDownloads,
                'allReleases' => $allReleases,
                'siteSettings' => $siteSettings,
                'siteLogo' => $siteLogo,
                'siteFavicon' => $siteFavicon,
                'siteName' => $siteName,
            ]);
        });
    }
}
