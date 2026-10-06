<!DOCTYPE html>
<html lang="en" class="h-full bg-white text-slate-900 scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteSettings['meta_title'] ?? (($siteName ?? 'Sangfy') . ' — Private Messaging & HD Calls'))</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Official Sangfy Android App (com.prahlix.sangfy). Private conversations from the heart, crystal-clear HD voice & video calls, disappearing media, and zero ads.')">
    <meta name="keywords" content="{{ $siteSettings['meta_keywords'] ?? 'Sangfy, Sangfy Android App, com.prahlix.sangfy, private messaging, heart to heart, HD calling, Agora RTC, zero ads' }}">
    <meta name="color-scheme" content="light">
    
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

    <!-- Tailwind CSS (Local with CDN fallback) -->
    <script src="{{ asset('assets/js/tailwind.js') }}"></script>
    <script>
        if (typeof tailwind === 'undefined') {
            document.write('<script src="https://cdn.tailwindcss.com"><\/script>');
        }
    </script>
    <script>
        window.tailwind = window.tailwind || {};
        tailwind.config = {
            darkMode: 'class',
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
        };
    </script>

    <!-- Custom CSS (Hosting & Cache-Busting Protected) -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}?v={{ @filemtime(public_path('assets/css/custom.css')) ?: time() }}">

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

    <!-- Floating Scroll-To-Download Bar (Static Dark Theme) -->
    <div x-show="showStickyBanner" x-transition class="fixed bottom-6 right-6 z-40" style="display:none;">
        <a href="{{ route('download.apk') }}" class="floating-download-btn flex items-center gap-3 bg-slate-900 text-white pl-4 pr-5 py-3 rounded-2xl shadow-2xl hover:bg-slate-800 border border-slate-700/80 transition group">
            <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="{{ $siteName ?? 'Sangfy' }}" class="w-8 h-8 object-contain">
            <div class="text-left">
                <div class="text-xs floating-subtitle font-medium">Download Android App</div>
                <div class="text-sm font-bold floating-title leading-tight group-hover:text-purple-300 transition">{{ $siteName ?? 'Sangfy' }} {{ $latestRelease->version_name ?? 'v1.0.0' }} <span class="text-xs font-normal floating-badge">({{ $latestRelease->file_size ?? '30 MB' }})</span></div>
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
                    
                    <!-- Dynamic High-Quality Brand Social Media Icons -->
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <!-- Instagram -->
                        @if(!empty($siteSettings['social_instagram']))
                            <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" title="Follow on Instagram" class="social-icon-btn btn-instagram group w-9 h-9 rounded-xl shadow-2xs">
                                <svg class="w-4 h-4 text-inherit" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        @endif

                        <!-- X (Twitter) -->
                        @if(!empty($siteSettings['social_twitter']))
                            <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" title="Follow on X (Twitter)" class="social-icon-btn btn-x group w-9 h-9 rounded-xl shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                        @endif

                        <!-- Telegram -->
                        @if(!empty($siteSettings['social_telegram']))
                            <a href="{{ $siteSettings['social_telegram'] }}" target="_blank" rel="noopener noreferrer" title="Join Telegram Channel" class="social-icon-btn btn-telegram group w-9 h-9 rounded-xl shadow-2xs">
                                <svg class="w-4 h-4 text-inherit" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                </svg>
                            </a>
                        @endif

                        <!-- YouTube -->
                        @if(!empty($siteSettings['social_youtube']))
                            <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" title="Watch on YouTube" class="social-icon-btn btn-youtube group w-9 h-9 rounded-xl shadow-2xs">
                                <svg class="w-4 h-4 text-inherit" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        @endif

                        <!-- GitHub -->
                        @if(!empty($siteSettings['social_github']))
                            <a href="{{ $siteSettings['social_github'] }}" target="_blank" rel="noopener noreferrer" title="View Source on GitHub" class="social-icon-btn btn-github group w-9 h-9 rounded-xl shadow-2xs">
                                <svg class="w-4 h-4 text-inherit" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                </svg>
                            </a>
                        @endif

                        <!-- Discord -->
                        @if(!empty($siteSettings['social_discord']))
                            <a href="{{ $siteSettings['social_discord'] }}" target="_blank" rel="noopener noreferrer" title="Join Discord Community" class="social-icon-btn btn-discord group w-9 h-9 rounded-xl shadow-2xs">
                                <svg class="w-4 h-4 text-inherit" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.894.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
                                </svg>
                            </a>
                        @endif

                        <!-- Facebook -->
                        @if(!empty($siteSettings['social_facebook']))
                            <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" title="Follow on Facebook" class="social-icon-btn btn-facebook group w-9 h-9 rounded-xl shadow-2xs">
                                <svg class="w-4 h-4 text-inherit" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        @endif

                        <!-- LinkedIn -->
                        @if(!empty($siteSettings['social_linkedin']))
                            <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener noreferrer" title="Follow on LinkedIn" class="social-icon-btn btn-linkedin group w-9 h-9 rounded-xl shadow-2xs">
                                <svg class="w-4 h-4 text-inherit" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </a>
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

                        <!-- Option 2: Get on Google Play Store (Clean White Theme) -->
                        @if(($siteSettings['play_store_enabled'] ?? '1') == '1' && !empty($siteSettings['play_store_url']))
                            <a href="{{ $siteSettings['play_store_url'] }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between p-3 rounded-xl bg-white hover:bg-emerald-50/40 border border-slate-200 hover:border-emerald-300 transition group shadow-2xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200/80 flex items-center justify-center flex-shrink-0 shadow-2xs group-hover:scale-105 transition-transform">
                                        <!-- Google Play Official Icon -->
                                        <svg class="w-5 h-5" viewBox="0 0 512 512">
                                            <path fill="#4caf50" d="M363.8 238.1l-246.5-142.3c-10.2-5.9-22.9-5.9-33.1 0-10.2 5.9-16.5 16.8-16.5 28.6v284.6c0 11.8 6.3 22.7 16.5 28.6 5.1 2.9 10.8 4.4 16.5 4.4s11.5-1.5 16.5-4.4l246.6-142.3c10.2-5.9 16.5-16.8 16.5-28.6s-6.4-22.7-16.5-28.6z"/>
                                            <path fill="#00bcd4" d="M67.7 124.4c-1.5 2.6-2.3 5.5-2.3 8.6v245.9c0 3.1.8 6 2.3 8.6l143.5-131.6-143.5-131.5z"/>
                                            <path fill="#ffb300" d="M380.3 227.2l-52.6-30.4-44.5 40.8 44.5 40.8 52.6-30.4c6.7-3.9 10.8-11 10.8-18.8s-4.1-14.9-10.8-22z"/>
                                            <path fill="#e91e63" d="M211.2 247.6l72 66-72 66 148.6-85.8-148.6-46.2z"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-[10px] text-slate-500 font-medium">Get it on Store</div>
                                        <div class="text-xs font-bold text-slate-900 group-hover:text-emerald-700">Google Play Store</div>
                                    </div>
                                </div>
                                <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1">
                                    <span>Verified</span>
                                    <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
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
