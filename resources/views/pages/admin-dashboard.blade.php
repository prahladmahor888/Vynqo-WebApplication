@extends('layouts.admin')

@section('title', 'Admin Dashboard Overview — Sangfy')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Welcome Banner Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="space-y-1.5">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-200 text-brand-700 text-xs font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>Admin Operations Center</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span>Welcome, {{ Auth::user()?->name ?? 'Admin' }}</span>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-purple-100 text-brand-800 font-mono">Super Admin</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Real-time management for Sangfy Android App (<code class="font-mono text-slate-700 font-bold">com.prahlix.sangfy</code>), live release binaries, compliance policies, and user inquiries.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.release') }}" class="px-4 py-2.5 text-xs font-bold text-white btn-sangfy rounded-xl shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Upload New Build</span>
            </a>
            <a href="{{ route('admin.legal.index') }}" class="px-4 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5">
                <i class="fa-solid fa-file-contract"></i>
                <span>Edit Policies</span>
            </a>
        </div>
    </div>

    <!-- Global Flash Alerts -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 shrink-0 text-base"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- 4 Key Metrics Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Metric 1: Current Release -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-500 tracking-wider">Active APK Build</span>
                <span class="w-8 h-8 rounded-xl bg-purple-50 text-brand-600 flex items-center justify-center text-sm font-bold"><i class="fa-solid fa-rocket"></i></span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-slate-900 font-mono">{{ $latestRelease->version_name ?? 'v1.0.0' }}</div>
                <div class="text-xs text-slate-500 mt-1 flex items-center gap-1.5 font-medium">
                    <span class="text-emerald-600 font-bold">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                    <span>•</span>
                    <span>Build Code #{{ $latestRelease->version_code ?? 100 }}</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('admin.release') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center justify-between">
                    <span>Manage Release</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        <!-- Metric 2: Total Downloads -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-500 tracking-wider">All-Time Downloads</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold"><i class="fa-solid fa-download"></i></span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-slate-900 font-mono">{{ number_format($totalDownloads) }}</div>
                <div class="text-xs text-slate-500 mt-1 font-medium flex items-center gap-1">
                    <span class="text-emerald-600 font-bold">+{{ number_format($apkStats['today_counted'] ?? 0) }} verified today</span>
                    <span>•</span>
                    <span>{{ number_format($apkStats['total_counted'] ?? 0) }} in logs</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.release') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                    <span>Version Breakdown</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
                <a href="{{ route('download.page') }}" target="_blank" class="text-xs font-semibold text-slate-400 hover:text-emerald-600 flex items-center gap-1" title="Open Public Download Page">
                    <span>Public</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Metric 3: Legal & Policies -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-500 tracking-wider">Legal Policies in DB</span>
                <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold"><i class="fa-solid fa-file-contract"></i></span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-slate-900 font-mono">{{ $legalCount }} Active</div>
                <div class="text-xs text-slate-500 mt-1 font-medium">
                    Privacy, Guidelines, Terms, Security
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('admin.legal.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center justify-between">
                    <span>Edit Policies</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        <!-- Metric 4: Support Inquiries -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-500 tracking-wider">User Inquiries</span>
                <span class="w-8 h-8 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-sm font-bold"><i class="fa-solid fa-comments"></i></span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-slate-900 font-mono">{{ $totalMessages }} Messages</div>
                <div class="text-xs text-slate-500 mt-1 font-medium">
                    Support & Privacy Desk
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('admin.messages') }}" class="text-xs font-bold text-pink-600 hover:text-pink-700 flex items-center justify-between">
                    <span>View Inquiries</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- FULL-WIDTH SECTION: REAL-TIME APK DOWNLOAD INTELLIGENCE & AUDIT HUB -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        
        <!-- Header -->
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <h2 class="text-lg font-extrabold text-slate-900 flex items-center gap-2.5">
                        <i class="fa-solid fa-download text-emerald-600"></i>
                        <span>APK Download Analytics &amp; Verified Installs Hub</span>
                    </h2>
                </div>
                <p class="text-xs text-slate-400">
                    Real-time telemetry tracking client Android installs, geo-location places, IP protocols, deduplication locks, and iOS threat defense.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/80 flex items-center gap-1.5 shadow-2xs">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>{{ number_format($apkStats['total_counted'] ?? 0) }} Verified Installs</span>
                </span>
                <a href="{{ route('download.apk') }}" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5" title="Test Live Download Endpoint">
                    <i class="fa-solid fa-play text-slate-500"></i>
                    <span>Test Download</span>
                </a>
                <a href="{{ route('admin.release') }}" class="px-3.5 py-1.5 text-xs font-bold text-white btn-sangfy rounded-xl shadow-2xs transition flex items-center gap-1.5">
                    <i class="fa-brands fa-android"></i>
                    <span>Release Manager</span>
                </a>
            </div>
        </div>

        <!-- Analytics Grid: 4 Metric Badges (Left) + 7-Day Download Trend Chart (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 border-b border-slate-100 divide-y lg:divide-y-0 lg:divide-x divide-slate-100">
            
            <!-- Left Side: Metrics & Geolocation summary (5 Cols) -->
            <div class="lg:col-span-5 p-6 space-y-5 bg-slate-50/40">
                <!-- 4 Metrics Grid -->
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs space-y-1">
                        <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <span>Today's Installs</span>
                            <i class="fa-solid fa-calendar-day text-emerald-500"></i>
                        </div>
                        <div class="text-2xl font-black text-slate-900 font-mono">
                            +{{ number_format($apkStats['today_counted'] ?? 0) }}
                        </div>
                        <div class="text-[10px] text-emerald-600 font-medium">
                            100% Verified (+1)
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs space-y-1">
                        <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <span>Unique IPs</span>
                            <i class="fa-solid fa-network-wired text-blue-500"></i>
                        </div>
                        <div class="text-2xl font-black text-slate-900 font-mono">
                            {{ number_format($apkStats['unique_ips'] ?? 0) }}
                        </div>
                        <div class="text-[10px] text-blue-600 font-medium">
                            Distinct Visitor IPs
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs space-y-1">
                        <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <span>Blocked iOS</span>
                            <i class="fa-brands fa-apple text-rose-500"></i>
                        </div>
                        <div class="text-2xl font-black text-rose-600 font-mono">
                            {{ number_format($apkStats['blocked_ios'] ?? 0) }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            Apple Devices Dropped
                        </div>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs space-y-1">
                        <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <span>Duplicates Saved</span>
                            <i class="fa-solid fa-shield-halved text-amber-500"></i>
                        </div>
                        <div class="text-2xl font-black text-amber-600 font-mono">
                            {{ number_format($apkStats['duplicates_prevented'] ?? 0) }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            Debounce &amp; Lock Trapped
                        </div>
                    </div>
                </div>

                <!-- Top Geographic Breakdown -->
                @if(!empty($apkStats['top_countries']) && $apkStats['top_countries']->isNotEmpty())
                    <div class="space-y-2 pt-1">
                        <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <span>Top Download Locations</span>
                            <span>Share</span>
                        </div>
                        <div class="space-y-2">
                            @foreach($apkStats['top_countries'] as $c)
                                @php
                                    $percent = ($apkStats['total_counted'] ?? 0) > 0 ? round(($c->total / $apkStats['total_counted']) * 100, 1) : 0;
                                @endphp
                                <div class="bg-white p-2.5 rounded-xl border border-slate-200 shadow-2xs">
                                    <div class="flex items-center justify-between text-xs mb-1 font-semibold text-slate-800">
                                        <span class="flex items-center gap-1.5">
                                            <span class="text-sm">{{ \App\Services\GeoLocationService::getCountryFlag($c->country_code) }}</span>
                                            <span>{{ $c->country }}</span>
                                        </span>
                                        <span class="font-mono text-slate-900 font-bold">
                                            {{ number_format($c->total) }} <span class="text-slate-400 font-normal">({{ $percent }}%)</span>
                                        </span>
                                    </div>
                                    <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full" style="width: {{ $percent }}%;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Side: APK Downloads Pie / Donut Chart (7 Cols) -->
            <div class="lg:col-span-7 p-6 space-y-5 flex flex-col justify-between">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2 border-b border-slate-100">
                    <div>
                        <h3 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-emerald-600"></i>
                            <span>APK Downloads Telemetry &amp; Verification Ratio</span>
                        </h3>
                        <p class="text-xs text-slate-400">Interactive distribution of client installs, blocked iOS probes, and debounces</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/80 shadow-2xs flex items-center gap-1.5">
                        <i class="fa-solid fa-chart-pie text-emerald-600"></i>
                        <span>Pie Chart View</span>
                    </span>
                </div>

                @php
                    $dlCounted = ($apkStats['total_counted'] ?? 0) > 0 ? $apkStats['total_counted'] : max(1, $totalDownloads ?? 0);
                    $dlBlocked = $apkStats['blocked_ios'] ?? 0;
                    $dlDuplicates = $apkStats['duplicates_prevented'] ?? 0;
                    $dlTotalAudited = $dlCounted + $dlBlocked + $dlDuplicates;

                    $pctCounted = $dlTotalAudited > 0 ? round(($dlCounted / $dlTotalAudited) * 100, 1) : 100;
                    $pctBlocked = $dlTotalAudited > 0 ? round(($dlBlocked / $dlTotalAudited) * 100, 1) : 0;
                    $pctDuplicates = $dlTotalAudited > 0 ? round(($dlDuplicates / $dlTotalAudited) * 100, 1) : 0;
                @endphp

                <!-- Donut / Pie Chart & Interactive Breakdown Layout -->
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-6 items-center py-1">
                    
                    <!-- Left: Interactive Canvas Donut Chart with Center Metric (5 Cols) -->
                    <div class="sm:col-span-5 flex flex-col items-center justify-center relative">
                        <div class="relative w-44 h-44 sm:w-48 sm:h-48 flex items-center justify-center">
                            <canvas id="apkDownloadPieChart" data-counted="{{ $dlCounted }}" data-blocked="{{ $dlBlocked }}" data-duplicates="{{ $dlDuplicates }}" class="relative z-10 w-full h-full"></canvas>
                            
                            <!-- Donut Inner Center Counter Badge -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none z-0">
                                <span class="text-2xl sm:text-3xl font-black text-slate-900 font-mono tracking-tight leading-none">
                                    {{ number_format($dlCounted) }}
                                </span>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-600 mt-1">
                                    Verified
                                </span>
                                <span class="text-[9px] text-slate-400 font-medium">
                                    of {{ number_format($dlTotalAudited) }} audits
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Detailed Category Legend & Percentage Metrics (7 Cols) -->
                    <div class="sm:col-span-7 space-y-2.5">
                        <!-- Slices Legend Breakdown -->
                        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100 hover:border-emerald-300 transition flex items-center justify-between group shadow-2xs">
                            <div class="flex items-center gap-2.5">
                                <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100 shrink-0"></span>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>Verified Installs</span>
                                        <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-emerald-100 text-emerald-800 font-mono">Counted +1</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500">Official Android downloads logged</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-base font-black text-emerald-700 font-mono block leading-none">{{ number_format($dlCounted) }}</span>
                                <span class="text-[10px] font-bold text-slate-400 font-mono">{{ $pctCounted }}%</span>
                            </div>
                        </div>

                        <div class="bg-rose-50/70 p-3 rounded-xl border border-rose-100 hover:border-rose-300 transition flex items-center justify-between group shadow-2xs">
                            <div class="flex items-center gap-2.5">
                                <span class="w-3.5 h-3.5 rounded-full bg-rose-500 ring-4 ring-rose-100 shrink-0"></span>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>Blocked iOS Traffic</span>
                                        <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-rose-100 text-rose-800 font-mono">Apple Dropped</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500">Safari/iOS non-Android intercepts</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-base font-black text-rose-600 font-mono block leading-none">{{ number_format($dlBlocked) }}</span>
                                <span class="text-[10px] font-bold text-slate-400 font-mono">{{ $pctBlocked }}%</span>
                            </div>
                        </div>

                        <div class="bg-amber-50/70 p-3 rounded-xl border border-amber-100 hover:border-amber-300 transition flex items-center justify-between group shadow-2xs">
                            <div class="flex items-center gap-2.5">
                                <span class="w-3.5 h-3.5 rounded-full bg-amber-500 ring-4 ring-amber-100 shrink-0"></span>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        <span>Duplicates Prevented</span>
                                        <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-amber-100 text-amber-800 font-mono">Locks Trapped</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500">Atomic cache &amp; rapid click debounces</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-base font-black text-amber-600 font-mono block leading-none">{{ number_format($dlDuplicates) }}</span>
                                <span class="text-[10px] font-bold text-slate-400 font-mono">{{ $pctDuplicates }}%</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer Security Strip -->
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-600">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                        <span>Zero-Leak Telemetry: Atomic cache locks prevent race conditions &amp; double-counts.</span>
                    </span>
                    <span class="font-bold text-emerald-700 font-mono bg-emerald-50 px-2.5 py-0.5 rounded-lg border border-emerald-200">
                        100% Reliable
                    </span>
                </div>
            </div>

        </div>

        <!-- Full-Width Live Download Stream Table -->
        <div class="p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-brand-600"></i>
                        <span>Recent APK Download Audit Logs</span>
                    </h3>
                    <p class="text-xs text-slate-400">Detailed stream of verified download events and security interception</p>
                </div>

                <div class="flex items-center gap-2 text-xs">
                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-semibold border border-slate-200">
                        Latest {{ $recentApkDownloads->count() }} Events
                    </span>
                    <a href="{{ route('admin.release') }}" class="font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                        <span>Release Center &rarr;</span>
                    </a>
                </div>
            </div>

            @if($recentApkDownloads->isEmpty())
                <div class="p-12 text-center space-y-3 bg-slate-50/60 rounded-xl border border-slate-200/80">
                    <div class="w-14 h-14 rounded-2xl bg-white text-slate-400 border border-slate-200 shadow-2xs flex items-center justify-center mx-auto text-2xl">
                        <i class="fa-solid fa-cloud-arrow-down text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">No APK Downloads Recorded Yet</p>
                        <p class="text-xs text-slate-400 max-w-md mx-auto mt-0.5">
                            When users tap download on the official portal, their verified download event, device platform, exact IP, and geo-location will be logged here.
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('download.apk') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white btn-sangfy rounded-xl shadow-xs">
                            <i class="fa-solid fa-play"></i>
                            <span>Test Live Download Endpoint</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-2xs">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5 whitespace-nowrap">Timestamp</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">User Location &amp; IP</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Hardware &amp; Client</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Target Build</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Audit Result</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($recentApkDownloads as $dl)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <!-- Time -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="space-y-0.5">
                                            <span class="font-bold text-slate-800 block text-xs" title="{{ $dl->created_at->format('Y-m-d H:i:s') }}">
                                                {{ $dl->created_at->diffForHumans() }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-mono block">
                                                {{ $dl->created_at->format('M d, H:i') }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- User Location & IP -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2 font-bold text-slate-900 text-xs">
                                                <span class="text-base leading-none">{{ $dl->country_flag }}</span>
                                                <span>{{ $dl->location_display }}</span>
                                            </div>
                                            <div class="inline-flex items-center gap-1.5">
                                                <span class="font-mono text-[11px] text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-lg border border-slate-200">
                                                    {{ $dl->ip_address }}
                                                </span>
                                                @if(str_contains($dl->ip_address ?? '', ':'))
                                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-purple-100 text-purple-700 border border-purple-200">IPv6</span>
                                                @else
                                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-slate-100 text-slate-600 border border-slate-200">IPv4</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Hardware & Client -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="space-y-1">
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 font-semibold text-xs text-slate-800">
                                                @if($dl->platform === 'iOS')
                                                    <i class="fa-brands fa-apple text-slate-700 text-sm"></i>
                                                @elseif($dl->platform === 'Android')
                                                    <i class="fa-brands fa-android text-emerald-600 text-sm"></i>
                                                @else
                                                    <i class="fa-solid fa-laptop text-slate-500 text-sm"></i>
                                                @endif
                                                <span>{{ $dl->platform ?? 'Android' }}</span>
                                                <span class="text-slate-300">&bull;</span>
                                                <span class="text-slate-600 font-normal">{{ $dl->browser ?? 'Browser' }}</span>
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-mono truncate max-w-[220px]" title="{{ $dl->user_agent }}">
                                                {{ $dl->user_agent ?: 'Android Client' }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Build Version -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-purple-50 text-brand-700 font-bold border border-purple-200 font-mono text-xs">
                                                <i class="fa-solid fa-cube text-[10px]"></i>
                                                <span>{{ $dl->release->version_name ?? ('Build #' . ($dl->release_id ?: '1')) }}</span>
                                            </span>
                                            <span class="text-[10px] text-slate-400 block font-mono">
                                                Code #{{ $dl->release->version_code ?? 100 }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Audit Result Status -->
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($dl->status === 'counted')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                                <span>Counted (+1)</span>
                                            </span>
                                        @elseif($dl->status === 'blocked_ios')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200 shadow-2xs">
                                                <i class="fa-solid fa-ban text-rose-500"></i>
                                                <span>Blocked iOS</span>
                                            </span>
                                        @elseif($dl->status === 'duplicate_token')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 shadow-2xs">
                                                <i class="fa-solid fa-shield-halved text-amber-500"></i>
                                                <span>Duplicate Token</span>
                                            </span>
                                        @elseif($dl->status === 'duplicate_session')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 shadow-2xs">
                                                <i class="fa-solid fa-clock-rotate-left text-amber-500"></i>
                                                <span>Session Cooldown</span>
                                            </span>
                                        @elseif($dl->status === 'duplicate_ip_window')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-orange-50 text-orange-700 border border-orange-200 shadow-2xs">
                                                <i class="fa-solid fa-hourglass-half text-orange-500"></i>
                                                <span>IP Debounced</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold uppercase bg-slate-100 text-slate-600">
                                                {{ $dl->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <!-- Two Column Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Active Release Box & Legal Table (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Live Active Release Hero Card (Pure White Theme) -->
            <div class="bg-white text-slate-900 rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-80 h-80 bg-purple-50 rounded-full blur-3xl pointer-events-none -z-0"></div>
                
                <div class="relative z-10 space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Live Active Release in Database</span>
                        </div>
                        <span class="text-xs font-mono text-slate-500">App ID: com.prahlix.sangfy</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                        <div>
                            <span class="text-xs text-slate-500 block">Version &amp; Code</span>
                            <span class="text-xl font-bold text-slate-900 font-mono">{{ $latestRelease->version_name ?? 'v1.0.0' }}</span>
                            <span class="text-xs text-brand-600 font-mono block">Build Code #{{ $latestRelease->version_code ?? 100 }}</span>
                        </div>

                        <div>
                            <span class="text-xs text-slate-500 block">Package Size</span>
                            <span class="text-xl font-bold text-emerald-600 font-mono">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                            <span class="text-xs text-slate-500 block">Universal APK Binary</span>
                        </div>

                        <div>
                            <span class="text-xs text-slate-500 block">Target OS</span>
                            <span class="text-base font-bold text-slate-800">Android 8.0 - 15</span>
                            <span class="text-xs text-slate-500 block">API 26 to API 35</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <span class="text-xs text-slate-600 block mb-1 font-semibold">Active Changelog &amp; Features:</span>
                        <div class="text-xs text-slate-700 bg-slate-50 p-3.5 rounded-xl font-mono whitespace-pre-line border border-slate-200 leading-relaxed max-h-52 overflow-y-auto custom-scrollbar">
{{ $latestRelease->changelog ?? '• Image & Video Feed Posts\n• 24h Stories\n• Nearby Radar\n• Free HD Calls' }}
                        </div>
                    </div>

                    <div class="pt-3 flex flex-wrap items-center justify-between gap-4 border-t border-slate-100">
                        <div class="text-xs text-slate-500 font-mono">
                            SHA256: <code class="text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200 font-mono">{{ substr($latestRelease->sha256_checksum ?? 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 0, 24) }}...</code>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.release') }}" class="px-4 py-2 text-xs font-bold text-white btn-sangfy rounded-lg shadow-xs">
                                Edit Release &amp; Upload APK
                            </a>
                            <a href="{{ route('download.apk') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg border border-slate-200 transition">
                                Test Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Legal Documents Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Managed Legal Documents in Database</h2>
                        <p class="text-xs text-slate-500">Edit privacy policy, community guidelines, and terms dynamically.</p>
                    </div>
                    <a href="{{ route('admin.legal.index') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        Manage All &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3">Document Title</th>
                                <th class="py-2.5 px-3">Slug</th>
                                <th class="py-2.5 px-3">Version</th>
                                <th class="py-2.5 px-3">Effective Date</th>
                                <th class="py-2.5 px-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($legalDocs as $doc)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-3 font-semibold text-slate-900">
                                        {{ $doc->title }}
                                    </td>
                                    <td class="py-3 px-3 font-mono text-slate-500">
                                        /{{ $doc->slug }}
                                    </td>
                                    <td class="py-3 px-3">
                                        <span class="px-2 py-0.5 rounded bg-purple-50 text-brand-700 font-bold font-mono">
                                            v{{ $doc->version ?? '1.0.0' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-slate-500">
                                        {{ $doc->effective_date ?? 'October 2026' }}
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <a href="{{ route('admin.legal.edit', $doc->slug) }}" class="inline-flex items-center px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700 font-bold hover:bg-brand-100 transition">
                                            Edit in DB
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Column: Shortcuts & System Status (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Real-Time Traffic & Analytics Widget -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <h3 class="text-xs font-bold uppercase text-slate-900 tracking-wider">Live Traffic &amp; Shield</h3>
                    </div>
                    <a href="{{ route('admin.traffic') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        Analytics Hub &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div class="p-2.5 bg-purple-50/60 rounded-xl border border-purple-100 text-center">
                        <span class="text-[9px] font-bold uppercase text-brand-700 block">Today Views</span>
                        <span class="text-lg font-black text-slate-900 font-mono">{{ number_format($trafficStats['todayViews'] ?? 0) }}</span>
                    </div>
                    <div class="p-2.5 bg-pink-50/60 rounded-xl border border-pink-100 text-center">
                        <span class="text-[9px] font-bold uppercase text-pink-700 block">Unique</span>
                        <span class="text-lg font-black text-slate-900 font-mono">{{ number_format($trafficStats['uniqueVisitors'] ?? 0) }}</span>
                    </div>
                    <div class="p-2.5 bg-rose-50/60 rounded-xl border border-rose-100 text-center">
                        <span class="text-[9px] font-bold uppercase text-rose-700 block">Bots Blocked</span>
                        <span class="text-lg font-black text-rose-700 font-mono">{{ number_format($shieldStats['totalBlocked'] ?? 0) }}</span>
                    </div>
                </div>

                <!-- 7-Day Human Visitor Activity Trend Bar Chart (Traffic Bar Chart) -->
                @php
                    $trafficDailyTrend = $trafficStats['dailyTrend'] ?? [];
                    $trafficMax = $trafficStats['trend_max'] ?? (max(array_column($trafficDailyTrend, 'count')) ?: 1);
                @endphp
                <div class="pt-2 pb-1 space-y-2 border-t border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-extrabold text-xs text-slate-900 flex items-center gap-1.5">
                                <i class="fa-solid fa-chart-simple text-brand-600"></i>
                                <span>7-Day Visitor Traffic Activity</span>
                            </h4>
                            <p class="text-[10px] text-slate-400">Human traffic excluding bot probes</p>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-purple-50 text-brand-700 border border-purple-200 font-mono">
                            7 Days
                        </span>
                    </div>

                    <!-- Gradient Bars Track -->
                    <div class="h-36 flex items-end justify-between gap-1.5 pt-3 px-1">
                        @foreach($trafficDailyTrend as $item)
                            @php
                                $heightPercent = max(10, round(($item['count'] / $trafficMax) * 100));
                                $hasViews = ($item['count'] > 0);
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-1.5 group h-full justify-end">
                                <!-- Tooltip count preview on top of bar -->
                                <div class="text-[10px] font-mono font-bold transition text-center {{ $hasViews ? 'text-brand-700' : 'text-slate-300' }}">
                                    {{ $item['count'] }}
                                </div>

                                <!-- Bar Graphic with Purple-Pink Gradient -->
                                <div class="w-full max-w-[32px] rounded-t-lg bg-gradient-to-t from-purple-600 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-400 transition-all shadow-xs" style="height: {{ $heightPercent }}%;" title="{{ $item['count'] }} Views on {{ $item['day'] ?? $item['short_day'] }}"></div>

                                <!-- Day of week label -->
                                <div class="text-center mt-0.5">
                                    <span class="block text-[11px] font-bold text-slate-700 group-hover:text-brand-600 transition">{{ $item['short_day'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if(!empty($trafficStats['countries']) && $trafficStats['countries']->isNotEmpty())
                    <div class="pt-1">
                        <div class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-1.5 flex items-center justify-between">
                            <span>Top Locations</span>
                            <span>Hits</span>
                        </div>
                        <div class="space-y-1">
                            @foreach($trafficStats['countries']->take(3) as $c)
                                <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-50 border border-slate-100">
                                    <span class="flex items-center gap-1.5 font-medium text-slate-700 truncate">
                                        <span>{{ $c->flag }}</span>
                                        <span class="truncate">{{ $c->country }}</span>
                                    </span>
                                    <span class="font-mono font-bold text-slate-900 text-[11px]">{{ number_format($c->total) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="pt-1">
                    <a href="{{ route('admin.traffic') }}" class="w-full py-2 px-3 text-xs font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
                        <i class="fa-solid fa-chart-line text-brand-600"></i>
                        <span>Open Full Traffic Report</span>
                    </a>
                </div>
            </div>

            <!-- Queue & Background Jobs Telemetry Card (jobs, job_batches, failed_jobs) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-brand-600 text-sm"></i>
                        <h3 class="text-xs font-bold uppercase text-slate-900 tracking-wider">Queue &amp; Background Jobs</h3>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-purple-50 text-brand-700 border border-purple-200 font-mono">
                        {{ config('queue.default') ?? 'database' }}
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-center">
                        <span class="text-[9px] font-bold uppercase text-slate-500 block">Pending Jobs</span>
                        <span class="text-lg font-black text-slate-900 font-mono">{{ number_format($queueStats['pending_jobs'] ?? 0) }}</span>
                        <span class="text-[9px] text-slate-400 block font-mono">jobs</span>
                    </div>
                    <div class="p-2.5 bg-purple-50/70 rounded-xl border border-purple-200 text-center">
                        <span class="text-[9px] font-bold uppercase text-brand-700 block">Batches</span>
                        <span class="text-lg font-black text-brand-800 font-mono">{{ number_format($queueStats['job_batches'] ?? 0) }}</span>
                        <span class="text-[9px] text-brand-500 block font-mono">job_batches</span>
                    </div>
                    <div class="p-2.5 bg-rose-50/70 rounded-xl border border-rose-200 text-center">
                        <span class="text-[9px] font-bold uppercase text-rose-700 block">Failed</span>
                        <span class="text-lg font-black text-rose-700 font-mono">{{ number_format($queueStats['failed_jobs'] ?? 0) }}</span>
                        <span class="text-[9px] text-rose-500 block font-mono">failed_jobs</span>
                    </div>
                </div>

                <div class="pt-1 flex flex-col sm:flex-row gap-2">
                    <form action="{{ route('admin.queue.dispatch-batch') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2 px-3 text-xs font-bold text-white btn-sangfy rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-bolt"></i>
                            <span>Dispatch Batch</span>
                        </button>
                    </form>
                    <form action="{{ route('admin.queue.run-work') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2 px-3 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-play"></i>
                            <span>Run Worker</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Hub Navigation -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-3">
                <h3 class="text-xs font-bold uppercase text-slate-900 tracking-wider">Quick Actions Hub</h3>
                
                <div class="space-y-2 text-xs">
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 transition group">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-sliders text-brand-600 text-sm"></i>
                            <span class="font-bold text-slate-800 group-hover:text-brand-700">Site Settings &amp; Logo</span>
                        </div>
                        <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-600"></i>
                    </a>

                    <a href="{{ route('admin.release') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 transition group">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-brands fa-android text-emerald-600 text-sm"></i>
                            <span class="font-bold text-slate-800 group-hover:text-brand-700">Upload New APK Binary</span>
                        </div>
                        <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-600"></i>
                    </a>

                    <a href="{{ route('admin.legal.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 transition group">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-file-lines text-blue-600 text-sm"></i>
                            <span class="font-bold text-slate-800 group-hover:text-brand-700">Edit Privacy & Guidelines</span>
                        </div>
                        <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-600"></i>
                    </a>

                    <a href="{{ route('admin.messages') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 transition group">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope-open-text text-pink-600 text-sm"></i>
                            <span class="font-bold text-slate-800 group-hover:text-brand-700">Manage User Inquiries</span>
                        </div>
                        <i class="fa-solid fa-arrow-right text-[11px] text-slate-400 group-hover:text-brand-600"></i>
                    </a>
                </div>
            </div>

            <!-- System & Security Status Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-xs font-bold uppercase text-slate-900 tracking-wider">Architecture & Status</h3>
                
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Framework</span>
                        <span class="font-bold text-slate-800 font-mono">Laravel 11.x / PHP 8.2+</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Database Engine</span>
                        <span class="font-bold text-emerald-600 font-mono">SQLite (Active)</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Voice & Video Calls</span>
                        <span class="font-bold text-purple-600">Agora RTC (SRTP E2EE)</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Social Features</span>
                        <span class="font-bold text-slate-800">Posts, Stories & Radar</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Ad Monetization</span>
                        <span class="font-bold text-emerald-600">0 Ads (100% Privacy)</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-slate-500">Logged-In Admin</span>
                        <span class="font-bold text-brand-700 font-mono">{{ Auth::user()?->email ?? 'Active Admin' }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('apkDownloadPieChart');
    if (!canvas) return;

    let retries = 0;
    function initPieChart() {
        if (typeof Chart === 'undefined') {
            if (retries++ < 30) {
                setTimeout(initPieChart, 150);
            }
            return;
        }

        const ctx = canvas.getContext('2d');
        const dlCounted = parseInt(canvas.dataset.counted, 10) || 0;
        const dlBlocked = parseInt(canvas.dataset.blocked, 10) || 0;
        const dlDuplicates = parseInt(canvas.dataset.duplicates, 10) || 0;
        const total = dlCounted + dlBlocked + dlDuplicates;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Verified Installs', 'Blocked iOS', 'Duplicates Filtered'],
                datasets: [{
                    data: [dlCounted, dlBlocked, dlDuplicates],
                    backgroundColor: [
                        '#10B981', // emerald-500
                        '#F43F5E', // rose-500
                        '#F59E0B'  // amber-500
                    ],
                    hoverBackgroundColor: [
                        '#059669',
                        '#E11D48',
                        '#D97706'
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        titleColor: '#F8FAFC',
                        bodyColor: '#F1F5F9',
                        borderColor: '#334155',
                        borderWidth: 1,
                        titleFont: { family: 'Poppins', size: 12, weight: 'bold' },
                        bodyFont: { family: 'Poppins', size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        boxPadding: 6,
                        callbacks: {
                            label: function(context) {
                                const val = context.parsed || 0;
                                const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                return ' ' + context.label + ': ' + Number(val).toLocaleString() + ' (' + pct + '%)';
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 900
                }
            }
        });
    }

    initPieChart();
});
</script>
@endpush
