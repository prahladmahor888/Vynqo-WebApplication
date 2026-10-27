<!DOCTYPE html>
<html lang="en" class="h-full bg-white text-slate-900 scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteSettings['meta_title'] ?? 'Sangfy — India\'s #1 Social Media & Dating App | Indian Instagram & Nearby Friends')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Sangfy is India\'s fast-growing social media platform, Indian Instagram alternative & free dating app. Share photos & 24h stories, find nearby singles & friends, and enjoy private encrypted HD calls with zero ads. Download free Android APK.')">
    <meta name="keywords" content="@yield('meta_keywords', $siteSettings['meta_keywords'] ?? 'Sangfy, Sangfy App, indian social media, indian instagram, datting app, dating app, indian dating app, best dating app in india, free dating app without payment, indian social network, made in india social media, desi social app, meet nearby people, find singles india, indian photo sharing app, indian reels app, private messaging app india, sangfy apk download, free video call app, india ka apna social media, ladki se baat karne wala app, bharat social media, safe dating app for indian women')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="Sangfy">
    <meta name="publisher" content="Sangfy">
    <meta name="application-name" content="Sangfy">
    <meta name="apple-mobile-web-app-title" content="Sangfy">
    <meta name="color-scheme" content="light">
    
    <!-- Geo Targeting for India -->
    <meta name="geo.region" content="IN">
    <meta name="geo.placename" content="India">
    <meta name="language" content="English, Hindi">

    <!-- OpenGraph & Facebook / WhatsApp Rich Cards -->
    <meta property="og:site_name" content="{{ $siteName ?? 'Sangfy' }}">
    <meta property="og:locale" content="en_IN">
    <meta property="og:title" content="@yield('title', $siteSettings['meta_title'] ?? 'Sangfy — India\'s #1 Social Media & Dating App')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Share photos & 24h stories, meet nearby singles & friends, and enjoy private encrypted HD calls with zero ads.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $siteLogo ?? asset('assets/images/logo.png') }}">
    <meta property="og:image:alt" content="{{ $siteName ?? 'Sangfy' }} — Indian Social Media & Dating App">

    <!-- Twitter / X Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $siteSettings['meta_title'] ?? 'Sangfy — India\'s #1 Social Media & Dating App')">
    <meta name="twitter:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'India\'s own social media & dating app. Share feed posts, 24h stories, and meet verified people nearby.')">
    <meta name="twitter:image" content="{{ $siteLogo ?? asset('assets/images/logo.png') }}">
    
    <!-- Favicon using official Logo -->
    <link rel="icon" type="image/png" href="{{ $siteFavicon ?? asset('assets/images/favicon.png') }}">

    <!-- Structured Data JSON-LD Schemas (Google Rich Snippets & Search Graph) -->
    <script type="application/ld+json">
    {!! json_encode([
      '@' . 'context' => 'https://schema.org',
      '@' . 'graph' => [
        [
          '@' . 'type' => 'WebSite',
          '@' . 'id' => url('/') . '/#website',
          'url' => url('/'),
          'name' => $siteName ?? 'Sangfy',
          'description' => "India's premier social media, Indian Instagram alternative, and nearby dating app.",
          'inLanguage' => 'en-IN',
          'potentialAction' => [
            '@' . 'type' => 'SearchAction',
            'target' => url('/') . '/?s={search_term_string}',
            'query-input' => 'required name=search_term_string'
          ]
        ],
        [
          '@' . 'type' => 'Organization',
          '@' . 'id' => url('/') . '/#organization',
          'name' => $siteName ?? 'Sangfy',
          'url' => url('/'),
          'logo' => [
            '@' . 'type' => 'ImageObject',
            'url' => asset('assets/images/logo.png')
          ],
          'foundingLocation' => [
            '@' . 'type' => 'Country',
            'name' => 'India'
          ],
          'contactPoint' => [
            '@' . 'type' => 'ContactPoint',
            'email' => 'support@prahlix.com',
            'contactType' => 'customer support'
          ]
        ],
        [
          '@' . 'type' => 'SoftwareApplication',
          '@' . 'id' => url('/') . '/#app',
          'name' => 'Sangfy',
          'operatingSystem' => 'Android 8.0 and higher',
          'applicationCategory' => 'SocialNetworkingApplication',
          'downloadUrl' => route('download.apk'),
          'description' => 'Indian social media, Instagram alternative, and nearby dating & private HD calling application.',
          'offers' => [
            '@' . 'type' => 'Offer',
            'price' => '0',
            'priceCurrency' => 'INR'
          ],
          'aggregateRating' => [
            '@' . 'type' => 'AggregateRating',
            'ratingValue' => '4.8',
            'ratingCount' => '2850',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ]
      ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
    @stack('schema')

    <!-- Font Awesome 6.6.0 Pro/Free Icon Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                    @if(!empty($siteSettings['top_banner_icon_image']))
                        <img src="{{ asset($siteSettings['top_banner_icon_image']) }}" alt="Notice Icon" class="w-4 h-4 object-contain rounded-xs">
                    @elseif(!empty($siteSettings['top_banner_icon_class']))
                        <i class="{{ $siteSettings['top_banner_icon_class'] }} text-emerald-400 text-xs"></i>
                    @else
                        <i class="fa-solid fa-bullhorn text-emerald-400 text-xs"></i>
                    @endif
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-medium text-slate-200">Notice:</span>
                    <span class="hidden sm:inline text-slate-300">{{ $siteSettings['top_banner_text'] ?? ('Official Android Release: ' . ($siteName ?? 'Sangfy') . ' App (com.prahlix.sangfy) for Android 8.0 to Android 15.') }}</span>
                    <span class="sm:hidden text-slate-300 truncate max-w-[200px]">{{ $siteSettings['top_banner_text'] ?? (($siteName ?? 'Sangfy') . ' Official Release') }}</span>
                </div>
                <div class="flex items-center gap-4 text-slate-400">
                    <a href="{{ route('legal.privacy') }}" class="hover:text-white transition flex items-center gap-1.5 text-[11px]">
                        <i class="fa-solid fa-shield-halved text-pink-400"></i>
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
                <a href="{{ route('about') }}" class="transition hover:text-brand-600 {{ request()->routeIs('about') ? 'text-brand-600' : '' }}">About Us</a>
                <a href="{{ route('download.page') }}" class="transition hover:text-brand-600 {{ request()->routeIs('download.page') ? 'text-brand-600' : '' }}">Download App</a>
                <a href="{{ route('legal.guidelines') }}" class="transition hover:text-brand-600 {{ request()->routeIs('legal.guidelines') ? 'text-brand-600' : '' }}">Guidelines</a>
                <a href="{{ route('legal.privacy') }}" class="transition hover:text-brand-600 {{ request()->routeIs('legal.privacy') ? 'text-brand-600' : '' }}">Privacy Policy</a>
                <a href="{{ route('contact') }}" class="transition hover:text-brand-600 {{ request()->routeIs('contact') ? 'text-brand-600' : '' }}">Support</a>
            </nav>

            <!-- Action CTA Button -->
            <div class="hidden sm:flex items-center space-x-3">
                <a href="{{ route('download.page') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-bold text-white btn-sangfy rounded-md shadow-sm transition">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Download APK</span>
                </a>
            </div>

            <!-- Mobile Hamburger Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden p-2 rounded-md text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none" aria-label="Toggle navigation menu">
                <i x-show="!mobileMenuOpen" class="fa-solid fa-bars text-lg"></i>
                <i x-show="mobileMenuOpen" style="display:none;" class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-b border-slate-200 bg-white px-4 pt-2 pb-6 space-y-2 shadow-lg" style="display:none;">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Home</a>
            <a href="{{ route('features') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('features') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Features</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">About Us</a>
            <a href="{{ route('download.page') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('download.page') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Download APK</a>
            <a href="{{ route('legal.guidelines') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('legal.guidelines') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Community Guidelines</a>
            <a href="{{ route('legal.privacy') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('legal.privacy') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Privacy Policy</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'bg-purple-50 text-brand-600' : 'text-slate-700 hover:bg-slate-50' }}">Support & Help</a>
            <div class="pt-3">
                <a href="{{ route('download.page') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white btn-sangfy rounded-md shadow-sm">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Download App ({{ $latestRelease->version_name ?? 'v1.0.0' }})</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Global Alert / Flash Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
            <div class="max-w-6xl mx-auto flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600 flex-shrink-0 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('ios_error'))
        <div class="bg-amber-50 border-b border-amber-200 text-amber-900 px-4 py-3 text-sm">
            <div class="max-w-6xl mx-auto flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-amber-100 flex items-center justify-center text-amber-700 text-xs shrink-0 font-bold">
                        <i class="fa-brands fa-apple"></i>
                    </span>
                    <span class="font-bold">{{ session('ios_error') }}</span>
                </div>
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
                    
                    <!-- Dynamic Brand Social Media Icons (Only Active / Configured Icons Displayed) -->
                    @php
                        $activeSocials = array_filter([
                            'instagram' => $siteSettings['social_instagram'] ?? null,
                            'twitter'   => $siteSettings['social_twitter'] ?? null,
                            'telegram'  => $siteSettings['social_telegram'] ?? null,
                            'youtube'   => $siteSettings['social_youtube'] ?? null,
                            'whatsapp'  => $siteSettings['social_whatsapp'] ?? null,
                            'discord'   => $siteSettings['social_discord'] ?? null,
                            'facebook'  => $siteSettings['social_facebook'] ?? null,
                            'linkedin'  => $siteSettings['social_linkedin'] ?? null,
                            'github'    => $siteSettings['social_github'] ?? null,
                        ]);
                    @endphp
                    @if(!empty($activeSocials))
                        <div class="flex flex-wrap items-center gap-2 pt-2">
                            <!-- Instagram -->
                            @if(!empty($siteSettings['social_instagram']))
                                <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" title="Follow on Instagram" class="social-icon-btn btn-instagram group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-pink-600">
                                    <i class="fa-brands fa-instagram text-base"></i>
                                </a>
                            @endif

                            <!-- X (Twitter) -->
                            @if(!empty($siteSettings['social_twitter']))
                                <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" title="Follow on X (Twitter)" class="social-icon-btn btn-x group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-black">
                                    <i class="fa-brands fa-x-twitter text-base"></i>
                                </a>
                            @endif

                            <!-- Telegram -->
                            @if(!empty($siteSettings['social_telegram']))
                                <a href="{{ $siteSettings['social_telegram'] }}" target="_blank" rel="noopener noreferrer" title="Join Telegram Channel" class="social-icon-btn btn-telegram group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-sky-500">
                                    <i class="fa-brands fa-telegram text-base"></i>
                                </a>
                            @endif

                            <!-- YouTube -->
                            @if(!empty($siteSettings['social_youtube']))
                                <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" title="Watch on YouTube" class="social-icon-btn btn-youtube group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-rose-600">
                                    <i class="fa-brands fa-youtube text-base"></i>
                                </a>
                            @endif

                            <!-- WhatsApp -->
                            @if(!empty($siteSettings['social_whatsapp']))
                                <a href="{{ $siteSettings['social_whatsapp'] }}" target="_blank" rel="noopener noreferrer" title="Connect on WhatsApp" class="social-icon-btn btn-whatsapp group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-emerald-600">
                                    <i class="fa-brands fa-whatsapp text-base"></i>
                                </a>
                            @endif

                            <!-- Discord -->
                            @if(!empty($siteSettings['social_discord']))
                                <a href="{{ $siteSettings['social_discord'] }}" target="_blank" rel="noopener noreferrer" title="Join Discord Community" class="social-icon-btn btn-discord group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-indigo-600">
                                    <i class="fa-brands fa-discord text-base"></i>
                                </a>
                            @endif

                            <!-- Facebook -->
                            @if(!empty($siteSettings['social_facebook']))
                                <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" title="Follow on Facebook" class="social-icon-btn btn-facebook group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-blue-600">
                                    <i class="fa-brands fa-facebook text-base"></i>
                                </a>
                            @endif

                            <!-- LinkedIn -->
                            @if(!empty($siteSettings['social_linkedin']))
                                <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener noreferrer" title="Follow on LinkedIn" class="social-icon-btn btn-linkedin group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-blue-700">
                                    <i class="fa-brands fa-linkedin text-base"></i>
                                </a>
                            @endif

                            <!-- GitHub -->
                            @if(!empty($siteSettings['social_github']))
                                <a href="{{ $siteSettings['social_github'] }}" target="_blank" rel="noopener noreferrer" title="View Source on GitHub" class="social-icon-btn btn-github group w-9 h-9 rounded-xl shadow-2xs flex items-center justify-center text-slate-600 hover:text-slate-900">
                                    <i class="fa-brands fa-github text-base"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Product Links (2 cols) -->
                <div class="lg:col-span-2 space-y-2.5 text-xs">
                    <h4 class="font-bold uppercase tracking-wider text-slate-900">App & Features</h4>
                    <ul class="space-y-2 text-slate-600">
                        <li><a href="{{ route('home') }}" class="hover:text-brand-600 transition">Home Overview</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-brand-600 transition">All Features</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-brand-600 transition">About Sangfy</a></li>
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
                                        <i class="fa-solid fa-download text-sm"></i>
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
                                        <!-- Google Play Official Font Awesome Brand Icon -->
                                        <i class="fa-brands fa-google-play text-emerald-600 text-lg"></i>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-[10px] text-slate-500 font-medium">Get it on Store</div>
                                        <div class="text-xs font-bold text-slate-900 group-hover:text-emerald-700">Google Play Store</div>
                                    </div>
                                </div>
                                <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1">
                                    <span>Verified</span>
                                    <i class="fa-solid fa-check text-[10px]"></i>
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

    <!-- iOS Device Not Supported Alert Modal -->
    <div id="ios-block-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity" style="display: none;">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 text-center shadow-2xl border border-slate-200 relative animate-in fade-in zoom-in-95 duration-150">
            <button type="button" onclick="closeIosModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center text-sm transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center text-xl">
                    <i class="fa-brands fa-apple"></i>
                </div>
                <div class="w-6 h-6 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-xs font-black">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fa-brands fa-android"></i>
                </div>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                <span>Notice for Apple iOS Users</span>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 mb-2">This app is only for Android users</h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                You cannot download it on an iOS device. Sangfy is exclusively compiled as a native Android (.apk) package and cannot be installed on iPhone or iPad.
            </p>
            <div class="flex flex-col sm:flex-row gap-2.5">
                <button type="button" onclick="closeIosModal()" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                    Got it
                </button>
                <a href="{{ route('features') }}" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-white btn-sangfy flex items-center justify-center gap-1.5 shadow-sm">
                    <span>Explore Features</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        // High-precision client-side protection for APK download triggers
        (function() {
            function isIosUser() {
                var ua = navigator.userAgent || '';
                return /iPad|iPhone|iPod/.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
            }

            window.closeIosModal = function() {
                var modal = document.getElementById('ios-block-modal');
                if (modal) modal.style.display = 'none';
            };

            function openIosModal() {
                var modal = document.getElementById('ios-block-modal');
                if (modal) {
                    modal.style.display = 'flex';
                } else {
                    alert("This app is only for Android users. You cannot download it on iOS devices.");
                }
            }

            function generateDownloadToken() {
                return Date.now().toString(36) + '-' + Math.random().toString(36).substring(2, 9);
            }

            document.addEventListener('click', function (e) {
                var btn = e.target.closest('a[href*="/download/apk"], a[href$="/download/apk"]');
                if (!btn) return;

                // 1. Immediately block iOS devices with interactive modal notice
                if (isIosUser()) {
                    e.preventDefault();
                    e.stopPropagation();
                    openIosModal();
                    return false;
                }

                var now = Date.now();

                // 2. Block rapid repeated taps on mobile across all download buttons (4-second throttle)
                if (btn.dataset.isDownloading === '1' || (window.__lastApkDownloadClick && (now - window.__lastApkDownloadClick < 4000))) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }

                window.__lastApkDownloadClick = now;
                btn.dataset.isDownloading = '1';

                // 3. Attach unique one-time dl_token to download URL so server deduplicates
                // multiple internal requests from mobile Chrome & Android Download Manager
                try {
                    var currentUrl = new URL(btn.href, window.location.origin);
                    if (!currentUrl.searchParams.has('dl_token')) {
                        currentUrl.searchParams.set('dl_token', generateDownloadToken());
                        btn.href = currentUrl.toString();
                    }
                } catch (err) {
                    if (btn.href.indexOf('dl_token=') === -1) {
                        var sep = btn.href.indexOf('?') === -1 ? '?' : '&';
                        btn.href += sep + 'dl_token=' + generateDownloadToken();
                    }
                }

                // 4. Mobile UI feedback: show loading spinner and prevent duplicate taps
                var icon = btn.querySelector('i');
                var originalIconClass = icon ? icon.className : null;

                if (icon) {
                    icon.className = 'fa-solid fa-circle-notch fa-spin text-lg';
                }
                btn.style.opacity = '0.85';
                btn.style.pointerEvents = 'none';

                // 5. Re-enable button after 5 seconds
                setTimeout(function () {
                    delete btn.dataset.isDownloading;
                    btn.style.opacity = '';
                    btn.style.pointerEvents = '';
                    if (icon && originalIconClass) {
                        icon.className = originalIconClass;
                    }
                    // Reset token for next genuine user-initiated download attempt
                    try {
                        var resetUrl = new URL(btn.href, window.location.origin);
                        resetUrl.searchParams.delete('dl_token');
                        btn.href = resetUrl.toString();
                    } catch (err) {}
                }, 5000);
            }, true);
        })();
    </script>

    @stack('scripts')
</body>
</html>
