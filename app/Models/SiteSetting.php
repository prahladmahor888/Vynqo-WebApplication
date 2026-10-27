<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Default settings dictionary with all customizable platform features.
     */
    public static function defaults(): array
    {
        return [
            // 1. Core Brand Identity
            'site_name' => 'Sangfy',
            'site_tagline' => 'India\'s #1 Social Media & Dating App',
            'site_logo' => 'assets/images/logo.png',
            'site_favicon' => 'assets/images/favicon.png',
            'android_package_name' => 'com.prahlix.sangfy',

            // 2. Hero Section
            'hero_badge_text' => 'India\'s #1 Social Media & Dating Platform 🇮🇳',
            'hero_title' => "India's Own Social Media & Dating App.\nIndian Instagram & Nearby Connections.",
            'hero_subtitle' => 'Share photo & video feeds, post 24h stories, discover genuine singles & friends nearby with custom radar, and enjoy 100% private encrypted chats & free HD video calls. Zero ads, zero tracking.',
            'hero_cta_text' => 'Download Free for Android',

            // 3. Top Banner & Alert
            'top_banner_enabled' => '1',
            'top_banner_text' => 'Official Android Release: Sangfy App (com.prahlix.sangfy) — India\'s Premier Social Media & Dating App for Android 8.0 to Android 15.',

            // 4. Contact & Support Page
            'support_badge_text' => 'Official Android App Support',
            'support_title' => 'How Can We Help You?',
            'support_subtitle' => 'Need help with your Sangfy Android App, have feedback, or want to report an issue? Our team is here to assist.',
            'contact_email' => 'support@prahlix.com',
            'contact_phone' => '',
            'support_hours' => '',
            'company_address' => '',
            'privacy_email' => 'support@prahlix.com',
            'safety_email' => 'support@prahlix.com',
            'support_receiver_email' => 'support@prahlix.com',
            'contact_form_title' => 'Send us a message',
            'contact_form_subtitle' => 'Our Android support engineering team responds within 24 business hours.',

            // 5. External Download Links
            'play_store_url' => 'https://play.google.com/store/apps/details?id=com.prahlix.sangfy',
            'play_store_enabled' => '1',
            'direct_apk_enabled' => '1',

            // 6. Social Media & Community Links (Empty by default - only active configured icons display)
            'social_instagram' => '',
            'social_twitter' => '',
            'social_telegram' => '',
            'social_youtube' => '',
            'social_github' => '',
            'social_discord' => '',
            'social_facebook' => '',
            'social_linkedin' => '',
            'social_whatsapp' => '',

            // 7. SEO & Analytics (Targeting: Sangfy, Indian social media, Indian instagram, Dating app)
            'meta_title' => 'Sangfy — India\'s #1 Social Media & Dating App | Indian Instagram & Nearby Friends',
            'meta_description' => 'Sangfy is India\'s fast-growing social media platform, Indian Instagram alternative & free dating app. Share photos & 24h stories, find nearby singles & friends, and enjoy private encrypted HD calls with zero ads. Download free Android APK.',
            'meta_keywords' => 'Sangfy, Sangfy App, indian social media, indian instagram, datting app, dating app, indian dating app, best dating app in india, free dating app without payment, indian social network, made in india social media, desi social app, meet nearby people, find singles india, indian photo sharing app, indian reels app, private messaging app india, sangfy apk download, free video call app, india ka apna social media, ladki se baat karne wala app, bharat social media, safe dating app for indian women',
            'google_analytics_id' => '',
            'custom_head_code' => '',

            // 8. Bot Protection & Shield Firewall
            'bot_protection_enabled' => '1',
            'block_known_scrapers' => '1',
            'block_exploit_probes' => '1',
            'block_empty_user_agents' => '1',
            'honeypot_enabled' => '1',
            'allow_search_engines' => '1',
            'max_requests_per_minute' => '60',
            'ip_whitelist' => '',
            'ip_blacklist' => '',

            // 9. Footer Content
            'footer_about_text' => 'Sangfy is India\'s official social media, Indian Instagram alternative, and nearby dating & messaging platform (com.prahlix.sangfy). Share moments, meet singles nearby, and enjoy private encrypted calls with zero ads.',
            'footer_copyright' => '© ' . date('Y') . ' Sangfy App (com.prahlix.sangfy). Made with ❤️ in India. All rights reserved.',
        ];
    }

    /**
     * Retrieve a setting by key, with default fallback and ultra-fast Cache.
     */
    public static function get(string $key, $default = null)
    {
        $all = self::getAll();
        return $all[$key] ?? $default;
    }

    /**
     * Set a setting value by key and invalidate memory cache.
     */
    public static function set(string $key, ?string $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        \Illuminate\Support\Facades\Cache::forget('site_settings_all');
    }

    /**
     * Get all settings as a key => value array with High-Performance Cache (zero DB queries on repeated hits).
     */
    public static function getAll(): array
    {
        $defaults = self::defaults();

        return \Illuminate\Support\Facades\Cache::remember('site_settings_all', 86400, function () use ($defaults) {
            try {
                if (Schema::hasTable('site_settings')) {
                    // Ensure every default key exists in the database table
                    $existingKeys = self::pluck('key')->toArray();
                    foreach ($defaults as $k => $v) {
                        if (!in_array($k, $existingKeys, true)) {
                            self::create(['key' => $k, 'value' => $v]);
                        }
                    }

                    // Auto-cleanup legacy fake/hardcoded social and contact details from database
                    $legacyHardcoded = [
                        'social_instagram' => 'https://instagram.com/sangfyapp',
                        'social_twitter' => 'https://x.com/sangfyapp',
                        'social_telegram' => 'https://t.me/sangfyapp',
                        'social_youtube' => 'https://youtube.com/@sangfyapp',
                        'social_github' => 'https://github.com/prahlix/sangfy',
                        'social_discord' => 'https://discord.gg/sangfy',
                        'social_facebook' => 'https://facebook.com/sangfyapp',
                        'social_linkedin' => 'https://linkedin.com/company/sangfy',
                        'contact_phone' => '+1 (555) 019-2834',
                        'company_address' => 'Prahlix Technologies, Global',
                        'support_hours' => '24/7 Response Desk (within 24 hours)',
                    ];
                    foreach ($legacyHardcoded as $lKey => $lVal) {
                        self::where('key', $lKey)->where('value', $lVal)->update(['value' => '']);
                    }

                    // Auto-migrate legacy emails in database to support@prahlix.com
                    $legacyEmails = ['support@sangfy.prahlix.com', 'privacy@sangfy.prahlix.com', 'safety@sangfy.prahlix.com', 'sangfy@prahlix.com'];
                    foreach (['contact_email', 'privacy_email', 'safety_email', 'support_receiver_email'] as $eKey) {
                        $currentVal = self::where('key', $eKey)->value('value');
                        if (in_array($currentVal, $legacyEmails, true) || empty($currentVal)) {
                            self::updateOrCreate(['key' => $eKey], ['value' => 'support@prahlix.com']);
                        }
                    }

                    // Auto-update legacy generic SEO meta tags to high-ranking target keywords
                    $legacyTitles = [
                        'Sangfy — Social Media, Stories, Nearby People & Private HD Calling',
                        'Sangfy — Private Messaging & HD Calls',
                    ];
                    $currentTitle = self::where('key', 'meta_title')->value('value');
                    if (in_array($currentTitle, $legacyTitles, true) || empty($currentTitle)) {
                        self::updateOrCreate(['key' => 'meta_title'], ['value' => $defaults['meta_title']]);
                    }

                    $legacyKeywords = [
                        'Sangfy, Sangfy Android App, com.prahlix.sangfy, private messaging, heart to heart, HD calling, Agora RTC, zero ads',
                        'Sangfy, Sangfy App, indian social media, indian instagram, datting app, dating app, indian dating app, indian social network, made in india social media, desi social app, meet nearby people, find singles india, indian photo sharing app, indian reels, private messaging app india, sangfy apk download, free dating app india',
                    ];
                    $currentKeywords = self::where('key', 'meta_keywords')->value('value');
                    if (in_array($currentKeywords, $legacyKeywords, true) || empty($currentKeywords)) {
                        self::updateOrCreate(['key' => 'meta_keywords'], ['value' => $defaults['meta_keywords']]);
                    }

                    $legacyDescriptions = [
                        'Official Sangfy Android App (com.prahlix.sangfy). Share image/video posts, post 24h stories, discover nearby people with custom filters, and enjoy end-to-end encrypted messaging and HD calls with zero ads.',
                        'Official Sangfy Android App (com.prahlix.sangfy). Private conversations from the heart, crystal-clear HD voice & video calls, disappearing media, and zero ads.',
                    ];
                    $currentDesc = self::where('key', 'meta_description')->value('value');
                    if (in_array($currentDesc, $legacyDescriptions, true) || empty($currentDesc)) {
                        self::updateOrCreate(['key' => 'meta_description'], ['value' => $defaults['meta_description']]);
                    }

                    $dbSettings = self::pluck('value', 'key')->toArray();
                    // Merge DB settings over defaults so that saved settings (including empty values) take precedence
                    return array_merge($defaults, $dbSettings);
                }
            } catch (\Throwable $e) {
                // Fallback gracefully
            }

            return $defaults;
        });
    }

    /**
     * Get full public URL for the site logo.
     */
    public static function getLogoUrl(): string
    {
        $logo = self::get('site_logo');
        if (empty($logo)) {
            $logo = 'assets/images/logo.png';
        }
        if (str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://') || str_starts_with($logo, '//')) {
            return $logo;
        }
        return asset(ltrim($logo, '/'));
    }

    /**
     * Get full public URL for the site favicon.
     */
    public static function getFaviconUrl(): string
    {
        $favicon = self::get('site_favicon');
        if (empty($favicon)) {
            $favicon = 'assets/images/favicon.png';
        }
        if (str_starts_with($favicon, 'http://') || str_starts_with($favicon, 'https://') || str_starts_with($favicon, '//')) {
            return $favicon;
        }
        return asset(ltrim($favicon, '/'));
    }
}
