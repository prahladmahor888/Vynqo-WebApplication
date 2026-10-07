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
            'site_tagline' => 'Connect from the Heart',
            'site_logo' => 'assets/images/logo.png',
            'site_favicon' => 'assets/images/favicon.png',
            'android_package_name' => 'com.prahlix.sangfy',

            // 2. Hero Section
            'hero_badge_text' => 'The Social App Built for Real Connection',
            'hero_title' => 'Share Moments. Discover Nearby & Chat Privately.',
            'hero_subtitle' => 'Post photos & videos, share 24-hour stories, find genuine people nearby on your own terms, and enjoy end-to-end encrypted chats & free HD video calls.',
            'hero_cta_text' => 'Download Free for Android',

            // 3. Top Banner & Alert
            'top_banner_enabled' => '1',
            'top_banner_text' => 'Official Android Release: Sangfy App (com.prahlix.sangfy) for Android 8.0 to Android 15.',

            // 4. Contact & Support Page
            'support_badge_text' => 'Official Android App Support',
            'support_title' => 'How Can We Help You?',
            'support_subtitle' => 'Need help with your Sangfy Android App, have feedback, or want to report an issue? Our team is here to assist.',
            'contact_email' => 'support@prahlix.com',
            'contact_phone' => '+1 (555) 019-2834',
            'support_hours' => '24/7 Response Desk (within 24 hours)',
            'company_address' => 'Prahlix Technologies, Global',
            'privacy_email' => 'support@prahlix.com',
            'safety_email' => 'support@prahlix.com',
            'support_receiver_email' => 'support@prahlix.com',
            'contact_form_title' => 'Send us a message',
            'contact_form_subtitle' => 'Our Android support engineering team responds within 24 business hours.',

            // 5. External Download Links
            'play_store_url' => 'https://play.google.com/store/apps/details?id=com.prahlix.sangfy',
            'play_store_enabled' => '1',
            'direct_apk_enabled' => '1',

            // 6. Social Media & Community Links
            'social_instagram' => 'https://instagram.com/sangfyapp',
            'social_twitter' => 'https://x.com/sangfyapp',
            'social_telegram' => 'https://t.me/sangfyapp',
            'social_youtube' => 'https://youtube.com/@sangfyapp',
            'social_github' => 'https://github.com/prahlix/sangfy',
            'social_discord' => 'https://discord.gg/sangfy',
            'social_facebook' => 'https://facebook.com/sangfyapp',
            'social_linkedin' => 'https://linkedin.com/company/sangfy',
            'social_whatsapp' => '',

            // 7. SEO & Analytics
            'meta_title' => 'Sangfy — Social Media, Stories, Nearby People & Private HD Calling',
            'meta_description' => 'Official Sangfy Android App (com.prahlix.sangfy). Share image/video posts, post 24h stories, discover nearby people with custom filters, and enjoy end-to-end encrypted messaging and HD calls with zero ads.',
            'meta_keywords' => 'Sangfy, Sangfy Android App, com.prahlix.sangfy, private messaging, heart to heart, HD calling, Agora RTC, zero ads',
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
            'footer_about_text' => 'The official communication platform for the Sangfy Android App (com.prahlix.sangfy). Built for photo/video posts, 24h stories, nearby people discovery, and end-to-end encrypted messaging.',
            'footer_copyright' => '© ' . date('Y') . ' Sangfy App (com.prahlix.sangfy). All rights reserved.',
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

                    // Auto-migrate legacy emails in database to support@prahlix.com
                    $legacyEmails = ['support@sangfy.prahlix.com', 'privacy@sangfy.prahlix.com', 'safety@sangfy.prahlix.com', 'sangfy@prahlix.com'];
                    foreach (['contact_email', 'privacy_email', 'safety_email', 'support_receiver_email'] as $eKey) {
                        $currentVal = self::where('key', $eKey)->value('value');
                        if (in_array($currentVal, $legacyEmails, true) || empty($currentVal)) {
                            self::updateOrCreate(['key' => $eKey], ['value' => 'support@prahlix.com']);
                        }
                    }

                    $dbSettings = self::pluck('value', 'key')->toArray();
                    return array_merge($defaults, array_filter($dbSettings, fn($v) => $v !== null && $v !== ''));
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
