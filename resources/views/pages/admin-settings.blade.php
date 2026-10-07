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
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                <span>View Live Site</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 shrink-0 text-base"></i>
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
                    <i class="fa-solid fa-rotate-left"></i>
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
                <i class="fa-solid fa-image text-brand-600"></i> <span>Logo &amp; Brand</span>
            </button>
            <button type="button" @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-rocket text-purple-600"></i> <span>Hero Section &amp; Banner</span>
            </button>
            <button type="button" @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-phone text-blue-600"></i> <span>Contact &amp; Support</span>
            </button>
            <button type="button" @click="activeTab = 'social'" :class="activeTab === 'social' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-globe text-emerald-600"></i> <span>Social Media Links</span>
            </button>
            <button type="button" @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-chart-line text-indigo-600"></i> <span>SEO &amp; Analytics</span>
            </button>
            <button type="button" @click="activeTab = 'footer'" :class="activeTab === 'footer' ? 'bg-white text-brand-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-file-lines text-amber-600"></i> <span>Footer &amp; Store Channels</span>
            </button>
            <button type="button" @click="activeTab = 'shield'" :class="activeTab === 'shield' ? 'bg-white text-rose-700 shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-shield-halved text-rose-600"></i> <span>Bot Protection &amp; Shield</span>
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
                                            <i class="fa-solid fa-cloud-arrow-up text-brand-600"></i>
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
                                            <i class="fa-solid fa-wand-magic-sparkles text-pink-600"></i>
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

                <!-- Top Announcement Banner Toggle, Icon & Text -->
                <div class="p-5 rounded-2xl bg-purple-50/70 border border-purple-200 space-y-4" x-data="{ 
                    bannerIconClass: '{{ old('top_banner_icon_class', $settings['top_banner_icon_class'] ?? 'fa-solid fa-bullhorn') }}',
                    setIcon(cls) { this.bannerIconClass = cls; }
                }">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block flex items-center gap-1.5">
                                <i class="fa-solid fa-bell text-brand-600"></i>
                                <span>Top Announcement Notice Banner</span>
                            </span>
                            <span class="text-[11px] text-slate-500">Displays an announcement alert with customizable icon across the top of all public pages</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="top_banner_enabled" value="1" {{ ($settings['top_banner_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <!-- Notification Icon Selector (Font Awesome vs Custom Uploaded Image) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-purple-200/80">
                        <!-- Option A: Font Awesome Icon Class -->
                        <div class="bg-white p-3.5 rounded-xl border border-purple-200/80 space-y-2.5">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold uppercase text-slate-700 tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-icons text-brand-600"></i>
                                    <span>Font Awesome Icon</span>
                                </label>
                                <span class="w-7 h-7 rounded-lg bg-purple-50 text-brand-600 flex items-center justify-center border border-purple-100 shadow-2xs">
                                    <i :class="bannerIconClass ? bannerIconClass : 'fa-solid fa-bell'" class="text-xs"></i>
                                </span>
                            </div>

                            <input type="text" name="top_banner_icon_class" x-model="bannerIconClass" placeholder="fa-solid fa-bullhorn" class="w-full text-xs font-mono px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 bg-slate-50 focus:bg-white">

                            <!-- Popular Preset Icons -->
                            <div>
                                <span class="text-[10px] font-semibold text-slate-500 block mb-1.5">Quick Presets:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <button type="button" @click="setIcon('fa-solid fa-bullhorn')" class="px-2 py-1 bg-slate-100 hover:bg-purple-100 rounded text-[10px] text-slate-700 flex items-center gap-1 border border-slate-200"><i class="fa-solid fa-bullhorn text-brand-600"></i> Bullhorn</button>
                                    <button type="button" @click="setIcon('fa-solid fa-bell')" class="px-2 py-1 bg-slate-100 hover:bg-purple-100 rounded text-[10px] text-slate-700 flex items-center gap-1 border border-slate-200"><i class="fa-solid fa-bell text-brand-600"></i> Bell</button>
                                    <button type="button" @click="setIcon('fa-solid fa-circle-exclamation')" class="px-2 py-1 bg-slate-100 hover:bg-purple-100 rounded text-[10px] text-slate-700 flex items-center gap-1 border border-slate-200"><i class="fa-solid fa-circle-exclamation text-brand-600"></i> Alert</button>
                                    <button type="button" @click="setIcon('fa-solid fa-bolt')" class="px-2 py-1 bg-slate-100 hover:bg-purple-100 rounded text-[10px] text-slate-700 flex items-center gap-1 border border-slate-200"><i class="fa-solid fa-bolt text-brand-600"></i> Bolt</button>
                                    <button type="button" @click="setIcon('fa-solid fa-star')" class="px-2 py-1 bg-slate-100 hover:bg-purple-100 rounded text-[10px] text-slate-700 flex items-center gap-1 border border-slate-200"><i class="fa-solid fa-star text-brand-600"></i> Star</button>
                                    <button type="button" @click="setIcon('fa-solid fa-shield-halved')" class="px-2 py-1 bg-slate-100 hover:bg-purple-100 rounded text-[10px] text-slate-700 flex items-center gap-1 border border-slate-200"><i class="fa-solid fa-shield-halved text-brand-600"></i> Shield</button>
                                    <button type="button" @click="setIcon('fa-solid fa-mobile-screen')" class="px-2 py-1 bg-slate-100 hover:bg-purple-100 rounded text-[10px] text-slate-700 flex items-center gap-1 border border-slate-200"><i class="fa-solid fa-mobile-screen text-brand-600"></i> App</button>
                                </div>
                            </div>
                        </div>

                        <!-- Option B: Custom Image Upload -->
                        <div class="bg-white p-3.5 rounded-xl border border-purple-200/80 space-y-2.5">
                            <label class="text-xs font-bold uppercase text-slate-700 tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-image text-brand-600"></i>
                                <span>Upload Custom Icon Image</span>
                            </label>

                            @if(!empty($settings['top_banner_icon_image']))
                                <div class="flex items-center justify-between p-2 bg-purple-50/70 border border-purple-100 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset($settings['top_banner_icon_image']) }}" alt="Current Custom Icon" class="w-6 h-6 object-contain rounded bg-white p-0.5 border border-slate-200">
                                        <span class="text-[11px] font-medium text-slate-700">Active Custom Image</span>
                                    </div>
                                    <label class="flex items-center gap-1 text-[11px] text-rose-600 cursor-pointer font-semibold">
                                        <input type="checkbox" name="remove_banner_icon_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                        <span>Remove</span>
                                    </label>
                                </div>
                            @endif

                            <input type="file" name="top_banner_icon_file" accept=".png,.jpg,.jpeg,.svg,.webp,.ico,.gif" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-brand-700 hover:file:bg-purple-100 cursor-pointer">
                            <p class="text-[10px] text-slate-400">PNG, SVG, WEBP, or ICO (Max 2MB). If uploaded, this image overrides the Font Awesome icon.</p>
                        </div>
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
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'support@prahlix.com') }}" placeholder="e.g. support@prahlix.com" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
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
                        <input type="text" name="company_address" value="{{ old('company_address', $settings['company_address'] ?? 'Prahlix Technologies, Global') }}" placeholder="e.g. Prahlix Technologies" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Privacy &amp; Security Desk Email
                        </label>
                        <input type="email" name="privacy_email" value="{{ old('privacy_email', $settings['privacy_email'] ?? 'support@prahlix.com') }}" placeholder="e.g. support@prahlix.com" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Content Safety &amp; Appeals Email
                        </label>
                        <input type="email" name="safety_email" value="{{ old('safety_email', $settings['safety_email'] ?? 'support@prahlix.com') }}" placeholder="e.g. support@prahlix.com" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div class="sm:col-span-2 p-4 bg-purple-50/60 rounded-xl border border-purple-200 space-y-1">
                        <label class="block text-xs font-bold uppercase text-brand-700 tracking-wider mb-1">
                            <i class="fa-solid fa-envelope text-brand-700 mr-1"></i> Admin Notification Receiver Email (Where user messages will be emailed)
                        </label>
                        <input type="email" name="support_receiver_email" value="{{ old('support_receiver_email', $settings['support_receiver_email'] ?? 'support@prahlix.com') }}" placeholder="e.g. support@prahlix.com" class="w-full text-sm px-4 py-2.5 rounded-xl border border-purple-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 bg-white">
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
                            <i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram URL
                        </label>
                        <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? 'https://instagram.com/sangfyapp') }}" placeholder="https://instagram.com/yourusername" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-brands fa-x-twitter text-slate-800 mr-1"></i> X (Twitter) URL
                        </label>
                        <input type="url" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? 'https://x.com/sangfyapp') }}" placeholder="https://x.com/yourusername" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-brands fa-telegram text-sky-500 mr-1"></i> Telegram Channel URL
                        </label>
                        <input type="url" name="social_telegram" value="{{ old('social_telegram', $settings['social_telegram'] ?? 'https://t.me/sangfyapp') }}" placeholder="https://t.me/yourchannel" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-brands fa-youtube text-red-600 mr-1"></i> YouTube Channel URL
                        </label>
                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? 'https://youtube.com/@sangfyapp') }}" placeholder="https://youtube.com/@yourchannel" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-brands fa-discord text-indigo-600 mr-1"></i> Discord Community URL
                        </label>
                        <input type="url" name="social_discord" value="{{ old('social_discord', $settings['social_discord'] ?? 'https://discord.gg/sangfy') }}" placeholder="https://discord.gg/invitecode" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook Page URL
                        </label>
                        <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? 'https://facebook.com/sangfyapp') }}" placeholder="https://facebook.com/yourpage" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-brands fa-linkedin text-blue-700 mr-1"></i> LinkedIn Page URL
                        </label>
                        <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? 'https://linkedin.com/company/sangfy') }}" placeholder="https://linkedin.com/company/yourbrand" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 flex items-center gap-1.5">
                            <i class="fa-brands fa-github text-slate-800 mr-1"></i> GitHub / Developer Repository URL
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

            <!-- ============================================================= -->
            <!-- TAB 7: BOT PROTECTION, FIREWALL & SECURITY SHIELD -->
            <!-- ============================================================= -->
            <div x-show="activeTab === 'shield'" class="space-y-6" style="display:none;">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-rose-600"></i>
                            <span>Bot Protection, Anti-Scraping &amp; Firewall Shield</span>
                        </h2>
                        <p class="text-xs text-slate-500">Protect your website from automated bots, content scrapers, exploit scanners, and form spam.</p>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Shield Active</span>
                    </div>
                </div>

                <!-- Master Switch -->
                <div class="p-5 rounded-2xl bg-gradient-to-r from-rose-50 to-orange-50 border border-rose-200 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900 block">Master Bot Protection Shield</span>
                        <span class="text-[11px] text-slate-600">Enforces request filtering, threat neutralization, and bot throttling across all routes</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="bot_protection_enabled" value="1" {{ ($settings['bot_protection_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-600"></div>
                    </label>
                </div>

                <!-- Defense Modules Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- 1. Block Malicious Exploit Scanners & Probes -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Block Exploit Probes &amp; Vulnerability Scanners</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Instantly drops bots probing <code class="text-rose-600 font-mono">/.env</code>, <code class="text-rose-600 font-mono">/.git</code>, <code class="text-rose-600 font-mono">/wp-login.php</code>, <code class="text-rose-600 font-mono">/phpmyadmin</code>, shell scripts, etc.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="block_exploit_probes" value="1" {{ ($settings['block_exploit_probes'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <!-- 2. Block Known Automated Scrapers & Attack Tools -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Block Automated Scrapers &amp; Tools</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Blocks Python-requests, Scrapy, Sqlmap, Nikto, HeadlessChrome, Curl/Wget bots and aggressive scrapers.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="block_known_scrapers" value="1" {{ ($settings['block_known_scrapers'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <!-- 3. Form Honeypot & Anti-Spam -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Form Honeypot &amp; Sub-second Anti-Spam</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Traps automated form-filling bots with invisible honey tokens &amp; minimum human completion time analysis.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="honeypot_enabled" value="1" {{ ($settings['honeypot_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <!-- 4. Cross-Site Scripting (XSS) & Script Injection Defense -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Cross-Site Scripting (XSS) &amp; Script Injection Shield</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Scans URIs, query strings, and payloads for <code class="text-rose-600 font-mono">&lt;script&gt;</code>, event handlers (<code class="text-rose-600 font-mono">onerror=</code>), and javascript protocols.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="xss_protection_enabled" value="1" {{ ($settings['xss_protection_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <!-- 5. SQL Injection & Malicious Payload Filter -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">SQL Injection (SQLi) Deep Heuristics</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Intercepts malicious query patterns (<code class="text-rose-600 font-mono">UNION SELECT</code>, <code class="text-rose-600 font-mono">SLEEP()</code>, <code class="text-rose-600 font-mono">OR 1=1</code>) across all endpoints.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="sqli_protection_enabled" value="1" {{ ($settings['sqli_protection_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <!-- 6. Block Empty / Missing User-Agents -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Block Empty / Missing User-Agents</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Denies anonymous automated scripts and low-reputation crawlers that hide browser headers.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="block_empty_user_agents" value="1" {{ ($settings['block_empty_user_agents'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <!-- 5. Allow Verified Search Engines (Google, Bing for SEO) -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start justify-between gap-3 md:col-span-2">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">Allow Verified Search Engine Indexers (Google, Bing, DuckDuckGo)</span>
                            <span class="text-[11px] text-slate-500 block mt-0.5">Ensures Googlebot and search indexers can crawl public showcase pages for top SEO ranking while preserving security.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" name="allow_search_engines" value="1" {{ ($settings['allow_search_engines'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                </div>

                <!-- Rate Limit & IP Access Rules -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            Max Requests Per Minute <span class="text-slate-400 font-normal">(Anti-Hammering)</span>
                        </label>
                        <input type="number" name="max_requests_per_minute" min="5" max="1000" value="{{ old('max_requests_per_minute', $settings['max_requests_per_minute'] ?? 60) }}" class="w-full text-sm font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900">
                        <p class="text-[10px] text-slate-400 mt-1">Limits requests from a single IP. Default: 60/min.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            IP Whitelist <span class="text-slate-400 font-normal">(1 IP per line)</span>
                        </label>
                        <textarea name="ip_whitelist" rows="3" placeholder="e.g.&#10;192.168.1.1&#10;203.0.113.50" class="w-full text-xs font-mono px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 leading-tight">{{ old('ip_whitelist', $settings['ip_whitelist'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                            IP Blacklist / Ban List <span class="text-slate-400 font-normal">(1 IP per line)</span>
                        </label>
                        <textarea name="ip_blacklist" rows="3" placeholder="e.g.&#10;45.33.32.156&#10;198.51.100.22" class="w-full text-xs font-mono px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-slate-900 leading-tight">{{ old('ip_blacklist', $settings['ip_blacklist'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-purple-50 border border-purple-200 text-xs text-brand-800 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-brand-700"></i>
                        <span>Want to view live blocked bot logs and attack stream?</span>
                    </div>
                    <a href="{{ route('admin.traffic') }}" class="font-bold underline hover:text-brand-900 flex items-center gap-1">
                        <span>Open Bot Shield Analytics</span>
                        <i class="fa-solid fa-arrow-right text-[11px]"></i>
                    </a>
                </div>

            </div>

            <!-- Submit Button Bar -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs text-slate-500">
                    Changes take effect immediately across all website views and download endpoints.
                </div>
                <button type="submit" class="px-8 py-3 text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
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
