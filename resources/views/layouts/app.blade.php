<!DOCTYPE html>
<html lang="en" class="h-full bg-white text-slate-900 scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteSettings['meta_title'] ?? (($siteName ?? 'Sangfy') . ' — Private Messaging & HD Calls'))</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Official Sangfy Android App (com.prahlix.sangfy). Private conversations from the heart, crystal-clear HD voice & video calls, disappearing media, and zero ads.')">
    <meta name="keywords" content="{{ $siteSettings['meta_keywords'] ?? 'Sangfy, Sangfy Android App, com.prahlix.sangfy, private messaging, heart to heart, HD calling, Agora RTC, zero ads' }}">
    
    <!-- OpenGraph & Twitter Cards -->
    <meta property="og:title" content="@yield('title', $siteSettings['meta_title'] ?? (($siteName ?? 'Sangfy') . ' — Private Messaging & HD Calls'))">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Private conversations from the heart, crystal-clear HD voice & video calls, and zero ads.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $siteLogo ?? asset('assets/images/logo.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Favicon using official Logo -->
    <link rel="icon" type="image/png" href="{{ $siteFavicon ?? asset('assets/images/favicon.png') }}">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Local) -->
    <script src="{{ asset('assets/js/tailwind.js') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#F5F3FF',
                            100: '#EDE9FE',
                            500: '#8B5CF6',
                            600: '#7C3AED',
                            700: '#6D28D9',
                            800: '#5B21B6',
                            900: '#4C1D95',
                            pink: '#EC4899',
                        }
                    },
                    fontFamily: {
                        sans: ['"Poppins"', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Google Analytics (Dynamic) -->
    @if(!empty($siteSettings['google_analytics_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['google_analytics_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $siteSettings['google_analytics_id'] }}');
        </script>
    @endif

    <!-- Custom Head Code Injection -->
    @if(!empty($siteSettings['custom_head_code']))
        {!! $siteSettings['custom_head_code'] !!}
    @endif

    @stack('head')
</head>
<body class="min-h-full flex flex-col font-sans bg-white text-slate-800 antialiased selection:bg-brand-600 selection:text-white" x-data="{ mobileMenuOpen: false, showStickyBanner: false }" @scroll.window="showStickyBanner = (window.pageYOffset > 450)">

    <!-- Top Notice Banner (Toggleable) -->
    @if(($siteSettings['top_banner_enabled'] ?? '1') == '1')
        <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
            <div class="max-w-6xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-medium text-slate-200">Notice:</span>
                    <span class="hidden sm:inline text-slate-300">{{ $siteSettings['top_banner_text'] ?? ('Official Android Release: ' . ($siteName ?? 'Sangfy') . ' App (com.prahlix.sangfy) for Android 8.0 to Android 15.') }}</span>
                    <span class="sm:hidden text-slate-300 truncate max-w-[200px]">{{ $siteSettings['top_banner_text'] ?? (($siteName ?? 'Sangfy') . ' Official Release') }}</span>
                </div>
                <div class="flex items-center gap-4 text-slate-400">
                    <a href="{{ route('legal.privacy') }}" class="hover:text-white transition flex items-center gap-1 text-[11px]">
                        <span class="text-pink-400">🛡️</span>
                        <span>Data Safety &amp; Privacy</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Clean White Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 transition-all">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Logo & Brand Name -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="{{ $siteName ?? 'Sangfy' }} Official Logo" class="h-10 w-10 object-contain group-hover:scale-105 transition">
                <div class="flex flex-col">
                    <span class="font-extrabold text-xl tracking-tight text-slate-900 leading-none">{{ $siteName ?? 'Sangfy' }}</span>
                    <span class="text-[10px] font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500 tracking-wider uppercase mt-0.5">{{ $siteSettings['site_tagline'] ?? 'Connect from the Heart' }}</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center space-x-7 text-sm font-semibold text-slate-600">
                <a href="{{ route('home') }}" class="transition hover:text-brand-600 {{ request()->routeIs('home') ? 'text-brand-600' : '' }}">Home</a>
                <a href="{{ route('features') }}" class="transition hover:text-brand-600 {{ request()->routeIs('features') ? 'text-brand-600' : '' }}">Features</a>
                <a href="{{ route('download.page') }}" class="transition hover:text-brand-600 {{ request()->routeIs('download.page') ? 'text-brand-600' : '' }}">Download App</a>
                <a href="{{ route('legal.guidelines') }}" class="transition hover:text-brand-600 {{ request()->routeIs('legal.guidelines') ? 'text-brand-600' : '' }}">Guidelines</a>
                <a href="{{ route('legal.privacy') }}" class="transition hover:text-brand-600 {{ request()->routeIs('legal.privacy') ? 'text-brand-600' : '' }}">Privacy Policy</a>
                <a href="{{ route('contact') }}" class="transition hover:text-brand-600 {{ request()->routeIs('contact') ? 'text-brand-600' : '' }}">Support</a>
            </nav>

            <!-- Action CTA Button -->
            <div class="hidden sm:flex items-center space-x-3">
                <a href="{{ route('download.page') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-bold text-white btn-sangfy rounded-md shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Download APK</span>
                </a>
            </div>

            <!-- Mobile Hamburger Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden p-2 rounded-md text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none" aria-label="Toggle navigation menu">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileMenuOpen" style="display:none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-b border-slate-200 bg-white px-4 pt-2 pb-6 space-y-2 shadow-lg" style="display:none;">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Home</a>
            <a href="{{ route('features') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('features') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Features</a>
            <a href="{{ route('download.page') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('download.page') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Download APK</a>
            <a href="{{ route('legal.guidelines') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('legal.guidelines') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Community Guidelines</a>
            <a href="{{ route('legal.privacy') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('legal.privacy') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Privacy Policy</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Support & Help</a>
            <div class="pt-3">
                <a href="{{ route('download.page') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white btn-sangfy rounded-md shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Download App ({{ $latestRelease->version_name ?? 'v1.0.0' }})</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Global Alert / Flash Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
            <div class="max-w-6xl mx-auto flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Floating Scroll-To-Download Bar -->
    <div x-show="showStickyBanner" x-transition class="fixed bottom-6 right-6 z-40" style="display:none;">
        <a href="{{ route('download.apk') }}" class="flex items-center gap-3 bg-slate-900 text-white pl-4 pr-5 py-3 rounded-lg shadow-2xl hover:bg-slate-800 border border-slate-700/60 transition group">
            <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="{{ $siteName ?? 'Sangfy' }}" class="w-8 h-8 object-contain">
            <div class="text-left">
                <div class="text-xs text-slate-400 font-medium">Download Android App</div>
                <div class="text-sm font-bold text-white leading-tight">{{ $siteName ?? 'Sangfy' }} {{ $latestRelease->version_name ?? 'v1.0.0' }} <span class="text-xs font-normal text-slate-300">({{ $latestRelease->file_size ?? '30 MB' }})</span></div>
            </div>
        </a>
    </div>

    <!-- Clean White Footer -->
    <footer class="bg-slate-50 border-t border-slate-200/90 pt-14 pb-10 text-sm text-slate-600">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 pb-12 border-b border-slate-200">
                
                <!-- Brand Column (4 cols) -->
                <div class="lg:col-span-4 space-y-3">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="{{ $siteName ?? 'Sangfy' }} Logo" class="h-9 w-9 object-contain">
                        <span class="font-extrabold text-xl tracking-tight text-slate-900">{{ $siteName ?? 'Sangfy' }}</span>
                    </div>
                    <p class="text-slate-500 text-xs max-w-sm leading-relaxed">
                        {{ $siteSettings['footer_about_text'] ?? ('The official communication platform for the ' . ($siteName ?? 'Sangfy') . ' Android App (' . ($siteSettings['android_package_name'] ?? 'com.prahlix.sangfy') . '). Built for photo/video posts, 24h stories, nearby people discovery, and end-to-end encrypted messaging.') }}
                    </p>
                    
                    <!-- Dynamic Social Media Icons -->
                    <div class="flex items-center gap-2 pt-2">
                        @if(!empty($siteSettings['social_instagram']))
                            <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" title="Instagram" class="w-8 h-8 rounded-lg bg-white hover:bg-purple-100 hover:text-brand-600 border border-slate-200 flex items-center justify-center transition text-sm shadow-2xs">📸</a>
                        @endif
                        @if(!empty($siteSettings['social_twitter']))
                            <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" title="X (Twitter)" class="w-8 h-8 rounded-lg bg-white hover:bg-purple-100 hover:text-brand-600 border border-slate-200 flex items-center justify-center transition text-sm shadow-2xs">🐦</a>
                        @endif
                        @if(!empty($siteSettings['social_telegram']))
                            <a href="{{ $siteSettings['social_telegram'] }}" target="_blank" rel="noopener noreferrer" title="Telegram" class="w-8 h-8 rounded-lg bg-white hover:bg-purple-100 hover:text-brand-600 border border-slate-200 flex items-center justify-center transition text-sm shadow-2xs">✈️</a>
                        @endif
                        @if(!empty($siteSettings['social_youtube']))
                            <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" title="YouTube" class="w-8 h-8 rounded-lg bg-white hover:bg-purple-100 hover:text-brand-600 border border-slate-200 flex items-center justify-center transition text-sm shadow-2xs">▶️</a>
                        @endif
                        @if(!empty($siteSettings['social_github']))
                            <a href="{{ $siteSettings['social_github'] }}" target="_blank" rel="noopener noreferrer" title="GitHub" class="w-8 h-8 rounded-lg bg-white hover:bg-purple-100 hover:text-brand-600 border border-slate-200 flex items-center justify-center transition text-sm shadow-2xs">🐙</a>
                        @endif
                    </div>
                </div>

                <!-- Product Links (2 cols) -->
                <div class="lg:col-span-2 space-y-2.5 text-xs">
                    <h4 class="font-bold uppercase tracking-wider text-slate-900">App & Features</h4>
                    <ul class="space-y-2 text-slate-600">
                        <li><a href="{{ route('home') }}" class="hover:text-brand-600 transition">Home Overview</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-brand-600 transition">All Features</a></li>
                        <li><a href="{{ route('download.page') }}" class="hover:text-brand-600 transition font-semibold text-brand-600">Download Page</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-brand-600 transition">App Support Desk</a></li>
                    </ul>
                </div>

                <!-- Legal & Compliance Links (2 cols) -->
                <div class="lg:col-span-2 space-y-2.5 text-xs">
                    <h4 class="font-bold uppercase tracking-wider text-slate-900">Safety & Legal</h4>
                    <ul class="space-y-2 text-slate-600">
                        <li><a href="{{ route('legal.privacy') }}" class="hover:text-brand-600 transition">Privacy Policy</a></li>
                        <li><a href="{{ route('legal.guidelines') }}" class="hover:text-brand-600 transition">Community Guidelines</a></li>
                        <li><a href="{{ route('legal.terms') }}" class="hover:text-brand-600 transition">Terms of Service</a></li>
                        <li><a href="{{ route('legal.security') }}" class="hover:text-brand-600 transition">Security Architecture</a></li>
                    </ul>
                </div>

                <!-- Download Options Column: Play Store & Site (4 cols) -->
                <div class="lg:col-span-4 space-y-3">
                    <h4 class="font-bold uppercase tracking-wider text-slate-900 text-xs">Get {{ $siteName ?? 'Sangfy' }} App</h4>
                    <p class="text-xs text-slate-500">Choose your preferred download method:</p>
                    
                    <div class="space-y-2.5 pt-1">
                        <!-- Option 1: Direct Download from Official Site -->
                        @if(($siteSettings['direct_apk_enabled'] ?? '1') == '1')
                            <a href="{{ route('download.apk') }}" class="flex items-center justify-between p-3 rounded-xl bg-white hover:bg-purple-50/60 border border-slate-200 hover:border-purple-300 transition group shadow-2xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-brand-600 to-pink-500 text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-[10px] text-slate-500 font-medium">Download from Site</div>
                                        <div class="text-xs font-bold text-slate-900 group-hover:text-brand-700">Official APK ({{ $latestRelease->version_name ?? 'v1.0.0' }})</div>
                                    </div>
                                </div>
                                <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-purple-50 text-brand-700 font-semibold border border-purple-100">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                            </a>
                        @endif

                        <!-- Option 2: Get on Google Play Store -->
                        @if(($siteSettings['play_store_enabled'] ?? '1') == '1' && !empty($siteSettings['play_store_url']))
                            <a href="{{ $siteSettings['play_store_url'] }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between p-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white border border-slate-800 transition group shadow-xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 flex items-center justify-center flex-shrink-0">
                                        <!-- Google Play Official Icon -->
                                        <svg class="w-6 h-6" viewBox="0 0 512 512">
                                            <path fill="#4caf50" d="M363.8 238.1l-246.5-142.3c-10.2-5.9-22.9-5.9-33.1 0-10.2 5.9-16.5 16.8-16.5 28.6v284.6c0 11.8 6.3 22.7 16.5 28.6 5.1 2.9 10.8 4.4 16.5 4.4s11.5-1.5 16.5-4.4l246.6-142.3c10.2-5.9 16.5-16.8 16.5-28.6s-6.4-22.7-16.5-28.6z"/>
                                            <path fill="#00bcd4" d="M67.7 124.4c-1.5 2.6-2.3 5.5-2.3 8.6v245.9c0 3.1.8 6 2.3 8.6l143.5-131.6-143.5-131.5z"/>
                                            <path fill="#ffb300" d="M380.3 227.2l-52.6-30.4-44.5 40.8 44.5 40.8 52.6-30.4c6.7-3.9 10.8-11 10.8-18.8s-4.1-14.9-10.8-22z"/>
                                            <path fill="#e91e63" d="M211.2 247.6l72 66-72 66 148.6-85.8-148.6-46.2z"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-[9px] text-slate-400 uppercase tracking-wider font-semibold">GET IT ON</div>
                                        <div class="text-xs font-bold text-white tracking-wide">Google Play Store</div>
                                    </div>
                                </div>
                                <span class="text-[10px] text-emerald-400 font-semibold flex items-center gap-1">
                                    <span>Verified</span>
                                    <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                </span>
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <p>{{ $siteSettings['footer_copyright'] ?? ('© ' . date('Y') . ' ' . ($siteName ?? 'Sangfy') . ' App (' . ($siteSettings['android_package_name'] ?? 'com.prahlix.sangfy') . '). All rights reserved.') }}</p>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('legal.privacy') }}" class="hover:text-slate-900 transition">Privacy</a>
                    <a href="{{ route('legal.guidelines') }}" class="hover:text-slate-900 transition">Guidelines</a>
                    <a href="{{ route('legal.terms') }}" class="hover:text-slate-900 transition">Terms</a>
                    <a href="{{ route('contact') }}" class="hover:text-slate-900 transition">Support</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
