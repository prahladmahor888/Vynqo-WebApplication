<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 text-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>@yield('title', 'Admin Console — Sangfy')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $siteFavicon ?? asset('assets/images/favicon.png') }}">

    <!-- Font Awesome 6.6.0 Pro/Free Icon Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
<body class="h-full flex flex-col font-sans antialiased bg-slate-50 text-slate-900 overflow-x-hidden">

    <div class="flex h-screen h-[100dvh] max-h-[100dvh] overflow-hidden bg-slate-100" style="height: 100vh; height: 100dvh;">
        
        <!-- Mobile Sidebar Backdrop -->
        <div id="mobileSidebarBackdrop" 
             class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs lg:hidden hidden transition-opacity duration-200"
             onclick="toggleMobileSidebar(false)"></div>

        <!-- Sidebar Navigation (Pure White Theme) -->
        <aside id="adminSidebar" 
               class="fixed inset-y-0 left-0 z-50 w-72 sm:w-80 h-full max-h-[100dvh] bg-white text-slate-700 flex flex-col transition-transform duration-300 transform -translate-x-full lg:static lg:translate-x-0 border-r border-slate-200 shadow-2xl lg:shadow-none overflow-hidden shrink-0"
               style="height: 100vh; height: 100dvh; max-height: 100dvh; max-height: -webkit-fill-available;">
            
            <!-- Top Brand Header (Fixed Top) -->
            <div class="h-16 sm:h-18 px-5 sm:px-6 flex items-center justify-between border-b border-slate-100 bg-white shrink-0">
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
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links List (Flex-1 Smooth Scrollable) -->
            <div class="flex-1 min-h-0 overflow-y-auto px-3.5 sm:px-4 py-4 space-y-1 custom-scrollbar" style="-webkit-overflow-scrolling: touch;">
                <div class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 font-mono">
                    Main Management
                </div>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <i class="fa-solid fa-table-columns w-4 text-center shrink-0 text-sm"></i>
                    <span>Dashboard Overview</span>
                </a>

                <!-- Site Branding & Dynamic Logo Settings -->
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.settings*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <i class="fa-solid fa-sliders w-4 text-center shrink-0 text-sm"></i>
                    <span>Site Settings &amp; Logo</span>
                </a>

                <!-- APK & Release Manager -->
                <a href="{{ route('admin.release') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.release*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <i class="fa-brands fa-android w-4 text-center shrink-0 text-sm"></i>
                    <span>APK & Release Manager</span>
                </a>

                <!-- Android App Device Permissions -->
                <a href="{{ route('admin.permissions.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.permissions*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <i class="fa-solid fa-shield-halved w-4 text-center shrink-0 text-sm"></i>
                    <span>App Permissions</span>
                </a>

                <!-- Legal Documents & Policies -->
                <a href="{{ route('admin.legal.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.legal*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <i class="fa-solid fa-scale-balanced w-4 text-center shrink-0 text-sm"></i>
                    <span>Legal & Guidelines</span>
                </a>

                <!-- User Messages -->
                <a href="{{ route('admin.messages') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.messages*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <i class="fa-solid fa-envelope-open-text w-4 text-center shrink-0 text-sm"></i>
                    <span>User Inquiries</span>
                </a>

                <!-- Traffic & Visitor Analytics -->
                <a href="{{ route('admin.traffic') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.traffic*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-xs' : 'text-slate-600 hover:bg-purple-50/70 hover:text-brand-700' }}">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-chart-line w-4 text-center shrink-0 text-sm"></i>
                        <span>Traffic &amp; Analytics</span>
                    </span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </a>

                <div class="pt-4 px-3 pb-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 font-mono">
                    Live Preview & Links
                </div>

                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-purple-50/70 hover:text-brand-700 transition">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-globe w-4 text-center shrink-0 text-sm"></i>
                        <span>Open Public Website</span>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                </a>
            </div>

            <!-- Bottom User & App Status Card (Fixed Bottom with Safe-Area Inset) -->
            <div class="p-3.5 sm:p-4 border-t border-slate-100 space-y-2.5 bg-slate-50/95 shrink-0" style="padding-bottom: max(1rem, env(safe-area-inset-bottom, 1rem));">
                
                <!-- Active Release Compact Box -->
                <div class="p-2.5 rounded-xl bg-white border border-slate-200 text-xs space-y-1 shadow-2xs">
                    <div class="flex items-center justify-between text-slate-500 text-[11px]">
                        <span>Active Release:</span>
                        <span class="font-bold text-emerald-600 font-mono">{{ $latestRelease->version_name ?? 'v1.0.0' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-500 text-[11px]">
                        <span>Package Size:</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                    </div>
                </div>

                <!-- Admin Profile Info Row -->
                <div class="flex items-center justify-between bg-white p-2 sm:p-2.5 rounded-xl border border-slate-200 shadow-2xs">
                    <div class="flex items-center gap-2 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand-600 to-pink-600 text-white flex items-center justify-center font-bold text-xs shadow-xs shrink-0">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="text-left min-w-0">
                            <div class="text-xs font-bold text-slate-900 leading-tight truncate">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="text-[10px] text-slate-500 truncate">{{ Auth::user()->email ?? 'Active Admin' }}</div>
                        </div>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST" class="inline shrink-0">
                        @csrf
                        <button type="submit" title="Logout of Admin" class="p-2 rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition cursor-pointer flex items-center justify-center shadow-2xs" aria-label="Logout">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- Prominent Full-Width Logout Action Button (Guaranteed Visible on All Phone Screen Sizes) -->
                <form action="{{ route('admin.logout') }}" method="POST" class="w-full pt-0.5">
                    @csrf
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-700 hover:to-red-700 active:scale-[0.98] text-white font-bold text-xs shadow-xs hover:shadow-md transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout of Admin</span>
                    </button>
                </form>

            </div>

        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Admin Bar -->
            <header class="h-16 bg-white border-b border-slate-200/90 px-3.5 sm:px-6 lg:px-8 flex items-center justify-between z-10 shrink-0">
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <!-- Mobile Hamburger Button with Badge Effect -->
                    <button type="button" 
                            id="mobileSidebarOpenBtn"
                            class="lg:hidden p-2 rounded-xl text-slate-700 bg-slate-50 hover:bg-purple-50 hover:text-brand-700 border border-slate-200 transition focus:outline-none cursor-pointer flex items-center justify-center shrink-0 shadow-2xs"
                            onclick="toggleMobileSidebar(true)"
                            aria-label="Open sidebar navigation menu">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>

                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500 truncate">
                        <span class="text-slate-900 font-bold hidden sm:inline">Sangfy Control Hub</span>
                        <span class="hidden sm:inline">/</span>
                        <span class="text-brand-700 font-semibold truncate">@yield('page_title', 'Dashboard')</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <div class="hidden md:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Live</span>
                    </div>

                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 text-xs font-semibold text-slate-700 hover:text-brand-600 hover:bg-slate-50 border border-slate-200 rounded-lg transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-slate-400 text-xs"></i>
                        <span class="hidden xs:inline">View Site</span>
                    </a>

                    <!-- Top Header Quick Logout (1-tap Logout for Phone View) -->
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Logout" class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 active:bg-rose-200 border border-rose-200 rounded-lg transition cursor-pointer shadow-2xs">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Scrollable Content Viewport -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-50" style="-webkit-overflow-scrolling: touch;">
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
