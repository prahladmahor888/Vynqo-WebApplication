<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiteSettingController extends Controller
{
    /**
     * Display the Site Branding & Settings Manager with tabbed categorized controls.
     */
    public function index()
    {
        $settings = SiteSetting::getAll();
        $logoUrl = SiteSetting::getLogoUrl();
        $faviconUrl = SiteSetting::getFaviconUrl();

        return view('pages.admin-settings', compact('settings', 'logoUrl', 'faviconUrl'));
    }

    /**
     * Update Site Branding, Logo, Content, Social Links & Configuration.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // 1. Branding
            'site_name' => 'required|string|max:100',
            'site_tagline' => 'nullable|string|max:255',
            'android_package_name' => 'nullable|string|max:100',
            'site_logo_file' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp,ico|max:5120',
            'site_favicon_file' => 'nullable|file|mimes:png,ico,svg,jpg,jpeg,webp|max:2048',
            'site_logo_url' => 'nullable|string|max:500',

            // 2. Hero & Banner
            'hero_badge_text' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:1000',
            'hero_cta_text' => 'nullable|string|max:100',
            'top_banner_enabled' => 'nullable|string|in:0,1',
            'top_banner_text' => 'nullable|string|max:500',
            'top_banner_icon_class' => 'nullable|string|max:100',
            'top_banner_icon_file' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp,ico,gif|max:2048',
            'remove_banner_icon_image' => 'nullable|string|in:0,1',

            // 3. Contact & Support Page
            'support_badge_text' => 'nullable|string|max:255',
            'support_title' => 'nullable|string|max:255',
            'support_subtitle' => 'nullable|string|max:1000',
            'contact_email' => 'nullable|email|max:150',
            'contact_phone' => 'nullable|string|max:50',
            'support_hours' => 'nullable|string|max:150',
            'company_address' => 'nullable|string|max:255',
            'privacy_email' => 'nullable|email|max:150',
            'safety_email' => 'nullable|email|max:150',
            'support_receiver_email' => 'nullable|email|max:150',
            'contact_form_title' => 'nullable|string|max:255',
            'contact_form_subtitle' => 'nullable|string|max:500',

            // 4. Download Channels
            'play_store_url' => 'nullable|string|max:500',
            'play_store_enabled' => 'nullable|string|in:0,1',
            'direct_apk_enabled' => 'nullable|string|in:0,1',

            // 5. Social Links
            'social_instagram' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'social_telegram' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'social_github' => 'nullable|string|max:255',

            // 6. SEO & Scripts
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
            'google_analytics_id' => 'nullable|string|max:50',
            'custom_head_code' => 'nullable|string|max:5000',

            // 7. Bot Protection & Firewall
            'max_requests_per_minute' => 'nullable|integer|min:5|max:1000',
            'ip_whitelist' => 'nullable|string|max:5000',
            'ip_blacklist' => 'nullable|string|max:5000',

            // 8. Footer
            'footer_about_text' => 'nullable|string|max:1000',
            'footer_copyright' => 'nullable|string|max:255',
        ]);

        $textKeys = [
            'site_name',
            'site_tagline',
            'android_package_name',
            'hero_badge_text',
            'hero_title',
            'hero_subtitle',
            'hero_cta_text',
            'top_banner_text',
            'top_banner_icon_class',
            'support_badge_text',
            'support_title',
            'support_subtitle',
            'contact_email',
            'contact_phone',
            'support_hours',
            'company_address',
            'privacy_email',
            'safety_email',
            'support_receiver_email',
            'contact_form_title',
            'contact_form_subtitle',
            'play_store_url',
            'social_instagram',
            'social_twitter',
            'social_telegram',
            'social_youtube',
            'social_github',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'google_analytics_id',
            'custom_head_code',
            'max_requests_per_minute',
            'ip_whitelist',
            'ip_blacklist',
            'footer_about_text',
            'footer_copyright',
        ];

        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                SiteSetting::set($key, trim((string) $request->input($key)));
            }
        }

        // Handle checkboxes/boolean switches
        SiteSetting::set('top_banner_enabled', $request->has('top_banner_enabled') ? '1' : '0');
        SiteSetting::set('play_store_enabled', $request->has('play_store_enabled') ? '1' : '0');
        SiteSetting::set('direct_apk_enabled', $request->has('direct_apk_enabled') ? '1' : '0');
        SiteSetting::set('bot_protection_enabled', $request->has('bot_protection_enabled') ? '1' : '0');
        SiteSetting::set('block_known_scrapers', $request->has('block_known_scrapers') ? '1' : '0');
        SiteSetting::set('block_exploit_probes', $request->has('block_exploit_probes') ? '1' : '0');
        SiteSetting::set('block_empty_user_agents', $request->has('block_empty_user_agents') ? '1' : '0');
        SiteSetting::set('honeypot_enabled', $request->has('honeypot_enabled') ? '1' : '0');
        SiteSetting::set('allow_search_engines', $request->has('allow_search_engines') ? '1' : '0');
        SiteSetting::set('xss_protection_enabled', $request->has('xss_protection_enabled') ? '1' : '0');
        SiteSetting::set('sqli_protection_enabled', $request->has('sqli_protection_enabled') ? '1' : '0');

        $uploadDir = public_path('uploads/settings');
        File::ensureDirectoryExists($uploadDir);

        // Process Logo File Upload
        if ($request->hasFile('site_logo_file')) {
            $logoFile = $request->file('site_logo_file');
            $extension = $logoFile->getClientOriginalExtension() ?: 'png';
            $logoFilename = 'site-logo-' . time() . '.' . $extension;
            
            $logoFile->move($uploadDir, $logoFilename);
            SiteSetting::set('site_logo', 'uploads/settings/' . $logoFilename);
        } elseif (!empty($validated['site_logo_url'])) {
            SiteSetting::set('site_logo', trim($validated['site_logo_url']));
        }

        // Process Favicon File Upload
        if ($request->hasFile('site_favicon_file')) {
            $favFile = $request->file('site_favicon_file');
            $extension = $favFile->getClientOriginalExtension() ?: 'png';
            $favFilename = 'site-favicon-' . time() . '.' . $extension;
            
            $favFile->move($uploadDir, $favFilename);
            SiteSetting::set('site_favicon', 'uploads/settings/' . $favFilename);
        }

        // Process Top Banner Notification Icon Upload & Removal
        if ($request->input('remove_banner_icon_image') == '1') {
            SiteSetting::set('top_banner_icon_image', '');
        } elseif ($request->hasFile('top_banner_icon_file')) {
            $bannerIconFile = $request->file('top_banner_icon_file');
            $extension = $bannerIconFile->getClientOriginalExtension() ?: 'png';
            $bannerIconFilename = 'banner-icon-' . time() . '.' . $extension;
            
            $bannerIconFile->move($uploadDir, $bannerIconFilename);
            SiteSetting::set('top_banner_icon_image', 'uploads/settings/' . $bannerIconFilename);
        }

        return redirect()->route('admin.settings.index')->with('success', 'All site settings, branding, hero copy, social links, and SEO configuration updated successfully!');
    }

    /**
     * Reset branding & copy to original defaults.
     */
    public function resetLogo()
    {
        SiteSetting::set('site_logo', 'assets/images/logo.png');
        SiteSetting::set('site_favicon', 'assets/images/favicon.png');

        return redirect()->route('admin.settings.index')->with('success', 'Logo & Favicon reset to default branding successfully.');
    }
}
