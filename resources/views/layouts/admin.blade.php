<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 text-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>@yield('title', 'Admin Console — Sangfy')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $siteFavicon ?? asset('assets/images/favicon.png') }}">

    <!-- Google Fonts: Poppins & JetBrains Mono -->
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
    <style>
        [x-cloak] { display: none !important; }

        /* Sleek Modern Scrollbar for White Theme Sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.3);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(124, 58, 237, 0.6);
        }
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.3) transparent;
        }
    </style>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @stack('head')
</head>
<body class="h-full flex flex-col font-sans antialiased bg-slate-50 text-slate-900">

    <div class="flex h-screen overflow-hidden bg-slate-100">
        
        <!-- Mobile Sidebar Backdrop -->
        <div id="mobileSidebarBackdrop" 
             class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-xs lg:hidden hidden transition-opacity duration-200"
             onclick="toggleMobileSidebar(false)"></div>

        <!-- Sidebar Navigation (Pure White Theme) -->
        <aside id="adminSidebar" 
               class="fixed inset-y-0 left-0 z-50 w-72 h-screen bg-white text-slate-700 flex flex-col transition-transform duration-300 transform -translate-x-full lg:static lg:translate-x-0 border-r border-slate-200 shadow-xl lg:shadow-none overflow-hidden shrink-0">
            
            <!-- Top Brand Header (Fixed Top) -->
            <div class="h-18 px-6 flex items-center justify-between border-b border-slate-100 bg-white shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="{{ $siteName ?? 'Sangfy' }} Logo" class="h-8 w-8 object-contain">
                    <div>
                        <span class="font-extrabold text-base tracking-tight text-slate-900 block leading-none">{{ $siteName ?? 'Sangfy' }} Admin</span>
                        <span class="text-[10px] text-brand-600 font-mono font-semibold">Control Console</span>
                    </div>
                </a>

                <!-- Close button on mobile -->
                <button type="button" 
                        class="lg:hidden p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition cursor-pointer"
                        onclick="toggleMobileSidebar(false)"
                        aria-label="Close sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation Links List (Flex-1 Smooth Scrollable) -->
            <div class="flex-1 min-h-0 overflow-y-auto px-4 py-5 space-y-1 custom-scrollbar">
                <div class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 font-mono">
                    Main Management
                </div>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard Overview</span>
                </a>

                <!-- Site Branding & Dynamic Logo Settings -->
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.settings*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Site Settings &amp; Logo</span>
                </a>

                <!-- APK & Release Manager -->
                <a href="{{ route('admin.release') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.release*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>APK & Release Manager</span>
                </a>

                <!-- Android App Device Permissions -->
                <a href="{{ route('admin.permissions.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.permissions*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>App Permissions</span>
                </a>

                <!-- Legal Documents & Policies -->
                <a href="{{ route('admin.legal.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.legal*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Legal & Guidelines</span>
                </a>

                <!-- User Messages -->
                <a href="{{ route('admin.messages') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.messages*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>User Inquiries</span>
                </a>

                <!-- Traffic & Visitor Analytics -->
                <a href="{{ route('admin.traffic') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.traffic*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Traffic &amp; Analytics</span>
                    </span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </a>

                <div class="pt-5 px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 font-mono">
                    Live Preview & Links
                </div>

                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-purple-50/70 hover:text-brand-700 transition">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Open Public Website</span>
                    </span>
                    <span class="text-[10px] text-slate-400">&nearr;</span>
                </a>
            </div>

            <!-- Bottom User & App Status Card (Fixed Bottom) -->
            <div class="p-4 border-t border-slate-100 space-y-3 bg-slate-50/70 shrink-0">
                <div class="p-3 rounded-xl bg-white border border-slate-200 text-xs space-y-1 shadow-2xs">
                    <div class="flex items-center justify-between text-slate-500 text-[11px]">
                        <span>Active Release:</span>
                        <span class="font-bold text-emerald-600 font-mono">{{ $latestRelease->version_name ?? 'v1.0.0' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-500 text-[11px]">
                        <span>Package Size:</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                    </div>
                </div>

                <!-- Admin User Info & Logout Form -->
                <div class="flex items-center justify-between pt-1">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-bold text-slate-900 leading-tight truncate max-w-[110px]">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="text-[10px] text-slate-500 truncate max-w-[110px]">{{ Auth::user()->email ?? 'Active Admin' }}</div>
                        </div>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Logout" class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Admin Bar -->
            <header class="h-16 bg-white border-b border-slate-200/90 px-4 sm:px-6 lg:px-8 flex items-center justify-between z-10 shrink-0">
                <div class="flex items-center gap-3">
                    <button type="button" 
                            id="mobileSidebarOpenBtn"
                            class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition focus:outline-none cursor-pointer"
                            onclick="toggleMobileSidebar(true)"
                            aria-label="Open sidebar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="text-slate-900 font-bold hidden sm:inline">Sangfy Control Hub</span>
                        <span class="hidden sm:inline">/</span>
                        <span class="text-brand-700 font-semibold">@yield('page_title', 'Dashboard')</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Database Live</span>
                    </div>

                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:text-brand-600 hover:bg-slate-50 border border-slate-200 rounded-lg transition">
                        <span>View Live</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </header>

            <!-- Scrollable Content Viewport -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-50">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- Global Mobile Sidebar Toggle Script -->
    <script>
    function toggleMobileSidebar(open) {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('mobileSidebarBackdrop');
        if (!sidebar || !backdrop) return;
        
        if (open) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            backdrop.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            toggleMobileSidebar(false);
        }
    });
    </script>

    @stack('scripts')
</body>
</html>
