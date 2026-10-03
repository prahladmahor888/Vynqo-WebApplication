<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 text-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Console — Vynqo')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                        sans: ['"Plus Jakarta Sans"', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    @stack('head')
</head>
<body class="h-full flex flex-col font-sans antialiased" x-data="{ mobileSidebarOpen: false }">

    <div class="flex h-screen overflow-hidden bg-slate-100">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="mobileSidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
             @click="mobileSidebarOpen = false"
             style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 flex flex-col justify-between transition-transform duration-300 transform lg:static lg:translate-x-0 border-r border-slate-800"
               :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Top Brand Header -->
            <div>
                <div class="h-18 px-6 flex items-center justify-between border-b border-slate-800/80 bg-slate-950/40">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Vynqo Logo" class="h-8 w-8 object-contain">
                        <div>
                            <span class="font-extrabold text-base tracking-tight text-white block leading-none">Vynqo Admin</span>
                            <span class="text-[10px] text-purple-400 font-mono font-medium">Control Console</span>
                        </div>
                    </a>

                    <!-- Close button on mobile -->
                    <button class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800"
                            @click="mobileSidebarOpen = false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Navigation Links List -->
                <div class="px-4 py-6 space-y-1">
                    <div class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 font-mono">
                        Main Management
                    </div>

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard Overview</span>
                    </a>

                    <!-- APK & Release Manager -->
                    <a href="{{ route('admin.release') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.release*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>APK & Release Manager</span>
                    </a>

                    <!-- Android App Device Permissions -->
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.permissions*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>App Permissions</span>
                    </a>

                    <!-- Legal Documents & Policies -->
                    <a href="{{ route('admin.legal.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.legal*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Legal & Guidelines</span>
                    </a>

                    <!-- User Messages -->
                    <a href="{{ route('admin.messages') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.messages*') ? 'bg-gradient-to-r from-brand-600 to-pink-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        <span>User Inquiries</span>
                    </a>

                    <div class="pt-6 px-3 pb-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 font-mono">
                        Live Preview & Links
                    </div>

                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:bg-slate-800/80 hover:text-slate-200 transition">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Open Public Website</span>
                        </span>
                        <span class="text-[10px] text-slate-500">&nearr;</span>
                    </a>
                </div>
            </div>

            <!-- Bottom User & App Status Card -->
            <div class="p-4 border-t border-slate-800/80 space-y-3 bg-slate-950/40">
                <div class="p-3 rounded-xl bg-slate-800/60 border border-slate-700/60 text-xs space-y-1">
                    <div class="flex items-center justify-between text-slate-400 text-[11px]">
                        <span>Active Release:</span>
                        <span class="font-bold text-emerald-400 font-mono">{{ $latestRelease->version_name ?? 'v1.0.0' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-400 text-[11px]">
                        <span>Package Size:</span>
                        <span class="font-semibold text-slate-200 font-mono">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                    </div>
                </div>

                <!-- Admin User Info & Logout Form -->
                <div class="flex items-center justify-between pt-1">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-bold text-white leading-tight truncate max-w-[110px]">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="text-[10px] text-slate-400 truncate max-w-[110px]">{{ Auth::user()->email ?? 'Active Admin' }}</div>
                        </div>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Logout" class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Admin Bar -->
            <header class="h-16 bg-white border-b border-slate-200/90 px-4 sm:px-6 lg:px-8 flex items-center justify-between z-10">
                <div class="flex items-center gap-3">
                    <button class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none"
                            @click="mobileSidebarOpen = true">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="text-slate-900 font-bold">Vynqo Control Hub</span>
                        <span>/</span>
                        <span class="text-brand-700 font-semibold">@yield('page_title', 'Dashboard')</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Database Live</span>
                    </div>

                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:text-brand-600 hover:bg-slate-50 border border-slate-200 rounded-lg transition">
                        <span>View Live App Site</span>
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

    @stack('scripts')
</body>
</html>
