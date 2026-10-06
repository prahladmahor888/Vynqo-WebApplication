@extends('layouts.admin')

@section('title', 'Site Branding & Settings — Sangfy Admin')
@section('page_title', 'Site Branding & Settings')

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="siteSettingsManager()">
    
    <!-- Header Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-200 text-brand-700 text-xs font-semibold mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Dynamic Site Configuration Suite</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Master Site Settings &amp; Branding
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Customize every aspect of your site: logos, hero copy, social links, contact info, SEO metadata, and store links.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5 shadow-2xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>View Live Site</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Live Logo Preview & Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Main Logo Preview Card (Pure White Theme) -->
        <div class="md:col-span-2 bg-white text-slate-900 p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 text-xs">
                <span class="text-brand-700 font-bold uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                    Live Header Preview
                </span>
                <span class="text-slate-500 font-mono text-[11px] truncate max-w-[200px]" title="{{ $settings['site_logo'] ?? 'assets/images/logo.png' }}">
                    Logo: {{ $settings['site_logo'] ?? 'assets/images/logo.png' }}
                </span>
            </div>

            <!-- Simulated Header Bar -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between text-slate-900 shadow-2xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white p-1.5 flex items-center justify-center border border-slate-200 shadow-xs">
                        <img src="{{ $logoUrl }}" :src="logoPreviewUrl || '{{ $logoUrl }}'" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="Logo Preview" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span class="font-extrabold text-lg tracking-tight gradient-text" x-text="siteName || '{{ $settings['site_name'] ?? 'Sangfy' }}'">{{ $settings['site_name'] ?? 'Sangfy' }}</span>
                        <span class="block text-[10px] text-slate-400 -mt-1" x-text="siteTagline || '{{ $settings['site_tagline'] ?? 'Connect from the Heart' }}'">{{ $settings['site_tagline'] ?? 'Connect from the Heart' }}</span>
                    </div>
                </div>
                <div class="hidden sm:flex items-center gap-3 text-xs font-semibold text-slate-600">
                    <span class="text-brand-600">Features</span>
                    <span>Download</span>
                    <span>Support</span>
                    <span class="btn-sangfy px-3 py-1 rounded-lg text-white text-[11px]">Get App</span>
                </div>
            </div>

            <!-- Multi-surface background test -->
            <div class="pt-2">
                <span class="text-xs text-slate-500 block mb-2 font-medium">Logo Contrast Check across Different Surfaces:</span>
                <div class="grid grid-cols-3 gap-3 text-center text-xs">
                    <!-- Light Background -->
                    <div class="p-4 bg-white rounded-xl border border-slate-200 flex flex-col items-center justify-center gap-2 shadow-2xs">
                        <img src="{{ $logoUrl }}" :src="logoPreviewUrl || '{{ $logoUrl }}'" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="Logo on Light" class="h-10 w-10 object-contain">
                        <span class="text-[10px] font-bold text-slate-700">Light BG</span>
                    </div>
                    <!-- Dark Background -->
                    <div class="p-4 bg-slate-900 rounded-xl border border-slate-800 flex flex-col items-center justify-center gap-2">
                        <img src="{{ $logoUrl }}" :src="logoPreviewUrl || '{{ $logoUrl }}'" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="Logo on Dark" class="h-10 w-10 object-contain">
                        <span class="text-[10px] font-bold text-slate-300">Dark BG</span>
                    </div>
                    <!-- Gradient Brand Background -->
                    <div class="p-4 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex flex-col items-center justify-center gap-2 shadow-2xs">
                        <img src="{{ $logoUrl }}" :src="logoPreviewUrl || '{{ $logoUrl }}'" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="Logo on Gradient" class="h-10 w-10 object-contain drop-shadow-xs">
                        <span class="text-[10px] font-bold text-white">Brand Gradient</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Favicon & Quick Actions Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm flex flex-col justify-between space-y-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-3">
                    Browser Tab &amp; Favicon
                </span>
                
                <!-- Simulated Browser Tab -->
                <div class="bg-slate-100 p-2.5 rounded-t-xl border border-slate-300 flex items-center gap-2 shadow-2xs">
                    <img src="{{ $faviconUrl }}" :src="faviconPreviewUrl || '{{ $faviconUrl }}'" onerror="this.onerror=null;this.src='{{ asset('assets/images/favicon.png') }}';" alt="Favicon" class="w-4 h-4 object-contain rounded-xs">
                    <span class="text-xs font-semibold text-slate-800 truncate" x-text="(siteName || '{{ $settings['site_name'] ?? 'Sangfy' }}') + ' — ' + (siteTagline || 'Connect from the Heart')">{{ ($settings['site_name'] ?? 'Sangfy') . ' — ' . ($settings['site_tagline'] ?? 'Connect from the Heart') }}</span>
                </div>
                <div class="p-3 bg-slate-50 border-x border-b border-slate-300 rounded-b-xl text-[11px] text-slate-500 space-y-1">
                    <p>Tab icon shown on browser tabs, bookmarks, and mobile home-screen web clips.</p>
                </div>
            </div>

            <!-- Reset to Defaults Form -->
            <form action="{{ route('admin.settings.reset-logo') }}" method="POST" onsubmit="return confirm('Reset site logo and favicon to default?');">
                @csrf
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 border border-slate-200 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Reset Logo to Default</span>
                </button>
            </form>
        </div>

    </div>

    <!-- Main Settings Form Container with Category Navigation -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        
        <!-- Category Navigation Tabs -->
        <div class="flex items-center gap-2 p-3 bg-slate-50 border-b border-slate-200 overflow-x-auto text-xs font-bold">
            <button type="button" @click="activeTab = 'branding'" :class="activeTab === 'branding' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <span>🖼️</span> <span>Logo &amp; Brand</span>
            </button>
            <button type="button" @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <span>🚀</span> <span>Hero Section &amp; Banner</span>
            </button>
            <button type="button" @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <span>📞</span> <span>Contact &amp; Support</span>
            </button>
            <button type="button" @click="activeTab = 'social'" :class="activeTab === 'social' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <span>🌐</span> <span>Social Media Links</span>
            </button>
            <button type="button" @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <span>📈</span> <span>SEO &amp; Analytics</span>
            </button>
            <button type="button" @click="activeTab = 'footer'" :class="activeTab === 'footer' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <span>📄</span> <span>Footer &amp; Store Channels</span>
            </button>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- ============================================================= -->
            <!-- TAB 1: BRANDING, LOGO & FAVICON -->
            <!-- ============================================================= -->
            <div x-show="activeTab === 'branding'" class="space-y-6">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Brand Identity, Logo &amp; Favicon</h2>
                    <p class="text-xs text-slate-500">Configure your brand names, package identity, and image assets.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Upload Site Logo -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider">
                                Site Logo <span class="text-slate-400 font-normal">(PNG, SVG, JPG, WebP)</span>
                            </label>
                            <span class="text-[11px] font-mono text-purple-600 bg-purple-50 px-2 py-0.5 rounded border border-purple-200 truncate max-w-[200px]" title="{{ $settings['site_logo'] ?? 'assets/images/logo.png' }}">
                                {{ basename($settings['site_logo'] ?? 'logo.png') }}
                            </span>
                        </div>

                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col sm:flex-row items-center gap-4">
                            <!-- Current / Selected Logo Image Display -->
                            <div class="w-20 h-20 shrink-0 rounded-xl bg-white border border-slate-200 p-2 flex items-center justify-center shadow-xs">
                                <img src="{{ $logoUrl }}" :src="logoPreviewUrl || '{{ $logoUrl }}'" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="Site Logo" class="w-full h-full object-contain">
                            </div>

                            <!-- Upload Action Area -->
                            <div class="flex-1 w-full">
                                <label class="flex flex-col items-center justify-center w-full min-h-[90px] border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-white hover:bg-purple-50/50 hover:border-purple-300 transition p-3 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-1">
                                        <div class="flex items-center gap-1.5 text-xs text-slate-700 font-bold">
                                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span x-text="logoFileName ? 'Selected: ' + logoFileName : 'Choose New Logo File'">Choose New Logo File</span>
                                        </div>
                                        <p class="text-[10px] text-slate-400">PNG, SVG, JPG (Max 5MB)</p>
                                    </div>
                                    <input type="file" name="site_logo_file" accept="image/*,.svg,.ico" class="hidden" @change="handleLogoSelect($event)">
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Favicon -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider">
                                Site Favicon <span class="text-slate-400 font-normal">(ICO, PNG, SVG)</span>
                            </label>
                            <span class="text-[11px] font-mono text-pink-600 bg-pink-50 px-2 py-0.5 rounded border border-pink-200 truncate max-w-[200px]" title="{{ $settings['site_favicon'] ?? 'assets/images/favicon.png' }}">
                                {{ basename($settings['site_favicon'] ?? 'favicon.png') }}
                            </span>
                        </div>

                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col sm:flex-row items-center gap-4">
                            <!-- Current / Selected Favicon Image Display -->
                            <div class="w-20 h-20 shrink-0 rounded-xl bg-white border border-slate-200 p-2 flex items-center justify-center shadow-xs">
                                <img src="{{ $faviconUrl }}" :src="faviconPreviewUrl || '{{ $faviconUrl }}'" onerror="this.onerror=null;this.src='{{ asset('assets/images/favicon.png') }}';" alt="Favicon" class="w-10 h-10 object-contain">
                            </div>

                            <!-- Upload Action Area -->
                            <div class="flex-1 w-full">
                                <label class="flex flex-col items-center justify-center w-full min-h-[90px] border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-white hover:bg-pink-50/50 hover:border-pink-300 transition p-3 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-1">
                                        <div class="flex items-center gap-1.5 text-xs text-slate-700 font-bold">
                                            <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                            <span x-text="faviconFileName ? 'Selected: ' + faviconFileName : 'Choose New Favicon File'"></span>
                                        </div>
                                        <p class="text-[10px] text-slate-400">ICO, PNG (32x32 or 64x64)</p>
                                    </div>
                                    <input type="file" name="site_favicon_file" accept="image/*,.ico,.svg" class="hidden" @change="handleFaviconSelect($event)">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Logo URL fallback -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1">
                        Or Custom Logo URL / Asset Path <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="text" name="site_logo_url" value="{{ old('site_logo_url', $settings['site_logo'] ?? '') }}" placeholder="e.g. assets/images/logo.png or https://cdn.prahlix.com/logo.png" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900">
                </div>

                <!-- Site Name & Tagline -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Website / App Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="site_name" x-model="siteName" required value="{{ old('site_name', $settings['site_name'] ?? 'Sangfy') }}" placeholder="e.g. Sangfy" class="w-full text-sm font-bold px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Brand Tagline
                        </label>
                        <input type="text" name="site_tagline" x-model="siteTagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Connect from the Heart') }}" placeholder="e.g. Connect from the Heart" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Android Package Name
                        </label>
                        <input type="text" name="android_package_name" value="{{ old('android_package_name', $settings['android_package_name'] ?? 'com.prahlix.sangfy') }}" placeholder="e.g. com.prahlix.sangfy" class="w-full text-sm font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900">
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 2: HERO SECTION & BANNER -->
            <!-- ============================================================= -->
            <div x-show="activeTab === 'hero'" class="space-y-6" style="display:none;">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Hero Showcase &amp; Top Notification Bar</h2>
                    <p class="text-xs text-slate-500">Edit the hero headline, subtitle, badge, and global top announcement banner.</p>
                </div>

                <!-- Top Announcement Banner Toggle & Text -->
                <div class="p-5 rounded-2xl bg-purple-50/70 border border-purple-200 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Top Announcement Notice Banner</span>
                            <span class="text-[11px] text-slate-500">Displays a dismissable alert across the top of all public pages</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="top_banner_enabled" value="1" {{ ($settings['top_banner_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Banner Alert Text</label>
                        <input type="text" name="top_banner_text" value="{{ old('top_banner_text', $settings['top_banner_text'] ?? 'Official Android Release: Sangfy App (com.prahlix.sangfy) for Android 8.0 to Android 15.') }}" class="w-full text-xs px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 bg-white">
                    </div>
                </div>

                <!-- Hero Badge Text -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Hero Floating Status Badge Text
                    </label>
                    <input type="text" name="hero_badge_text" value="{{ old('hero_badge_text', $settings['hero_badge_text'] ?? 'The Social App Built for Real Connection') }}" placeholder="e.g. The Social App Built for Real Connection" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                </div>

                <!-- Hero Main Headline -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Hero Main Headline
                    </label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? 'Share Moments. Discover Nearby & Chat Privately.') }}" placeholder="e.g. Share Moments. Discover Nearby & Chat Privately." class="w-full text-sm font-bold px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                </div>

                <!-- Hero Subtitle Paragraph -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Hero Subtitle Paragraph
                    </label>
                    <textarea name="hero_subtitle" rows="3" class="w-full text-xs px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 leading-relaxed">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? 'Post photos & videos, share 24-hour stories, find genuine people nearby on your own terms, and enjoy end-to-end encrypted chats & free HD video calls.') }}</textarea>
                </div>

                <!-- Hero CTA Button Text -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Primary CTA Button Text
                    </label>
                    <input type="text" name="hero_cta_text" value="{{ old('hero_cta_text', $settings['hero_cta_text'] ?? 'Download Free for Android') }}" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 3: CONTACT & SUPPORT PAGE -->
            <!-- ============================================================= -->
            <div x-show="activeTab === 'contact'" class="space-y-6" style="display:none;">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Support Page &amp; Contact Channel Suite</h2>
                    <p class="text-xs text-slate-500">Configure the /contact page hero banner, help channels, form headlines, and response details.</p>
                </div>

                <!-- Support Page Hero & Headline Controls -->
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-700 block">
                        Support Page Hero Banner
                    </span>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                                Support Hero Badge Text
                            </label>
                            <input type="text" name="support_badge_text" value="{{ old('support_badge_text', $settings['support_badge_text'] ?? 'Official Android App Support') }}" class="w-full text-xs px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 bg-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                                Support Hero Main Title
                            </label>
                            <input type="text" name="support_title" value="{{ old('support_title', $settings['support_title'] ?? 'How Can We Help You?') }}" class="w-full text-xs font-bold px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 bg-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Support Hero Subtitle / Explainer
                        </label>
                        <textarea name="support_subtitle" rows="2" class="w-full text-xs px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 leading-relaxed bg-white">{{ old('support_subtitle', $settings['support_subtitle'] ?? 'Need help with your Sangfy Android App, have feedback, or want to report an issue? Our team is here to assist.') }}</textarea>
                    </div>
                </div>

                <!-- Contact Channels Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Customer &amp; Technical Support Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'support@sangfy.prahlix.com') }}" placeholder="e.g. support@sangfy.prahlix.com" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Support Telephone / Hotline
                        </label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+1 (555) 019-2834') }}" placeholder="e.g. +1 (555) 019-2834" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Support Desk Operating Hours
                        </label>
                        <input type="text" name="support_hours" value="{{ old('support_hours', $settings['support_hours'] ?? '24/7 Response Desk (within 24 hours)') }}" placeholder="e.g. 24/7 Response Desk" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Company / Headquarters Address
                        </label>
                        <input type="text" name="company_address" value="{{ old('company_address', $settings['company_address'] ?? 'Prahlix Technologies, Silicon Valley & Global') }}" placeholder="e.g. Prahlix Technologies, Silicon Valley" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Privacy &amp; Security Desk Email
                        </label>
                        <input type="email" name="privacy_email" value="{{ old('privacy_email', $settings['privacy_email'] ?? 'privacy@sangfy.prahlix.com') }}" placeholder="e.g. privacy@sangfy.prahlix.com" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Content Safety &amp; Appeals Email
                        </label>
                        <input type="email" name="safety_email" value="{{ old('safety_email', $settings['safety_email'] ?? 'safety@sangfy.prahlix.com') }}" placeholder="e.g. safety@sangfy.prahlix.com" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div class="sm:col-span-2 p-4 bg-purple-50/60 rounded-xl border border-purple-200 space-y-1">
                        <label class="block text-xs font-bold uppercase text-brand-700 tracking-wider mb-1">
                            📩 Admin Notification Receiver Email (Where user messages will be emailed)
                        </label>
                        <input type="email" name="support_receiver_email" value="{{ old('support_receiver_email', $settings['support_receiver_email'] ?? 'sangfy@prahlix.com') }}" placeholder="e.g. sangfy@prahlix.com" class="w-full text-sm px-4 py-2.5 rounded-xl border border-purple-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 bg-white">
                        <p class="text-[11px] text-slate-500">Every time a visitor submits the contact form, an instant notification with their name, email, and message will be sent to this email address.</p>
                    </div>
                </div>

                <!-- Support Form Title & Subtitle -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Message Form Title
                        </label>
                        <input type="text" name="contact_form_title" value="{{ old('contact_form_title', $settings['contact_form_title'] ?? 'Send us a message') }}" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Message Form Subtitle / SLA
                        </label>
                        <input type="text" name="contact_form_subtitle" value="{{ old('contact_form_subtitle', $settings['contact_form_subtitle'] ?? 'Our Android support engineering team responds within 24 business hours.') }}" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 4: SOCIAL MEDIA LINKS -->
            <!-- ============================================================= -->
            <div x-show="activeTab === 'social'" class="space-y-6" style="display:none;">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Official Social Media &amp; Community Channels</h2>
                    <p class="text-xs text-slate-500">Provide direct URLs to your social channels rendered across footer and contact pages.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <span>📸</span> Instagram URL
                        </label>
                        <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? 'https://instagram.com/sangfyapp') }}" placeholder="https://instagram.com/yourusername" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <span>🐦</span> X (Twitter) URL
                        </label>
                        <input type="url" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? 'https://x.com/sangfyapp') }}" placeholder="https://x.com/yourusername" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <span>✈️</span> Telegram Channel URL
                        </label>
                        <input type="url" name="social_telegram" value="{{ old('social_telegram', $settings['social_telegram'] ?? 'https://t.me/sangfyapp') }}" placeholder="https://t.me/yourchannel" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <span>▶️</span> YouTube Channel URL
                        </label>
                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? 'https://youtube.com/@sangfyapp') }}" placeholder="https://youtube.com/@yourchannel" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <span>👾</span> Discord Community URL
                        </label>
                        <input type="url" name="social_discord" value="{{ old('social_discord', $settings['social_discord'] ?? 'https://discord.gg/sangfy') }}" placeholder="https://discord.gg/invitecode" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <span>📘</span> Facebook Page URL
                        </label>
                        <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? 'https://facebook.com/sangfyapp') }}" placeholder="https://facebook.com/yourpage" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <span>💼</span> LinkedIn Page URL
                        </label>
                        <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? 'https://linkedin.com/company/sangfy') }}" placeholder="https://linkedin.com/company/yourbrand" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <span>🐙</span> GitHub / Developer Repository URL
                        </label>
                        <input type="url" name="social_github" value="{{ old('social_github', $settings['social_github'] ?? 'https://github.com/prahlix/sangfy') }}" placeholder="https://github.com/organization/repo" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 5: SEO, ANALYTICS & CUSTOM CODE -->
            <!-- ============================================================= -->
            <div x-show="activeTab === 'seo'" class="space-y-6" style="display:none;">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Search Engine Optimization &amp; Custom Scripts</h2>
                    <p class="text-xs text-slate-500">Configure global meta tags, OpenGraph sharing info, and tracking code.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Default Meta Title
                    </label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? 'Sangfy — Social Media, Stories, Nearby People & Private HD Calling') }}" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        SEO Meta Description
                    </label>
                    <textarea name="meta_description" rows="3" class="w-full text-xs px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 leading-relaxed">{{ old('meta_description', $settings['meta_description'] ?? 'Official Sangfy Android App (com.prahlix.sangfy). Share image/video posts, post 24h stories, discover nearby people with custom filters, and enjoy end-to-end encrypted messaging and HD calls with zero ads.') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Meta Keywords <span class="text-slate-400 font-normal">(Comma separated)</span>
                    </label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? 'Sangfy, Sangfy Android App, com.prahlix.sangfy, private messaging, heart to heart, HD calling, Agora RTC, zero ads') }}" class="w-full text-xs px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Google Analytics Measurement ID
                        </label>
                        <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="e.g. G-XXXXXXXXXX" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                        <p class="text-[11px] text-slate-400 mt-1">Google Analytics 4 Measurement ID</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Custom Head Code / Verification Tag
                        </label>
                        <textarea name="custom_head_code" rows="2" placeholder="<!-- Optional <meta> or script tags in <head> -->" class="w-full text-xs font-mono px-4 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 leading-tight">{{ old('custom_head_code', $settings['custom_head_code'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 6: FOOTER & STORE CHANNELS -->
            <!-- ============================================================= -->
            <div x-show="activeTab === 'footer'" class="space-y-6" style="display:none;">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Footer Blurb &amp; Store Channels</h2>
                    <p class="text-xs text-slate-500">Manage Google Play links, direct APK downloads, and footer copyright.</p>
                </div>

                <!-- Google Play Store Config -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Google Play Store Card</span>
                            <span class="text-[11px] text-slate-500">Show/hide Google Play download option</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="play_store_enabled" value="1" {{ ($settings['play_store_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Google Play Store URL</label>
                        <input type="url" name="play_store_url" value="{{ old('play_store_url', $settings['play_store_url'] ?? 'https://play.google.com/store/apps/details?id=com.prahlix.sangfy') }}" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 bg-white">
                    </div>
                </div>

                <!-- Direct APK Download Toggle -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900 block">Direct APK Download Channel</span>
                        <span class="text-[11px] text-slate-500">Allow users to download APK file directly from your website</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="direct_apk_enabled" value="1" {{ ($settings['direct_apk_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                    </label>
                </div>

                <!-- Footer About Blurb -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Footer Description Text
                    </label>
                    <textarea name="footer_about_text" rows="3" class="w-full text-xs px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 leading-relaxed">{{ old('footer_about_text', $settings['footer_about_text'] ?? 'The official communication platform for the Sangfy Android App (com.prahlix.sangfy). Built for photo/video posts, 24h stories, nearby people discovery, and end-to-end encrypted messaging.') }}</textarea>
                </div>

                <!-- Footer Copyright -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Footer Copyright Notice
                    </label>
                    <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '© ' . date('Y') . ' Sangfy App (com.prahlix.sangfy). All rights reserved.') }}" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs text-slate-500">
                    Changes take effect immediately across all website views and download endpoints.
                </div>
                <button type="submit" class="px-8 py-3 text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save All Settings</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
function siteSettingsManager() {
    return {
        activeTab: 'branding',
        siteName: '{{ $settings['site_name'] ?? 'Sangfy' }}',
        siteTagline: '{{ $settings['site_tagline'] ?? 'Connect from the Heart' }}',
        logoFileName: '',
        faviconFileName: '',
        logoPreviewUrl: null,
        faviconPreviewUrl: null,

        handleLogoSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.logoFileName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.logoPreviewUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        handleFaviconSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.faviconFileName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.faviconPreviewUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>
@endpush
@endsection
