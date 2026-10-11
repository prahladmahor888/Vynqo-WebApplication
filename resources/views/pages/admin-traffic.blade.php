@extends('layouts.admin')

@section('title', 'Visitor Traffic & Bot Shield Analytics — Sangfy Admin')
@section('page_title', 'Traffic & Bot Shield Defense')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ activeView: '{{ (request('active_tab') === 'shield' || request()->has('bot_page') || request()->filled('bot_search') || (request()->filled('bot_category') && request('bot_category') !== 'all')) ? 'shield' : 'traffic' }}' }">
    
    <!-- Top Header Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Real-Time Visitor Tracking Active</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                    <span>Anti-Bot Shield Armed</span>
                </div>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Traffic &amp; Bot Defense Hub
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Real-time monitoring of <strong>Legitimate Visitors</strong> and <strong>Neutralized Malicious Bot Threats</strong>.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.settings.index') }}#shield" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5 shadow-2xs">
                <i class="fa-solid fa-shield-halved text-rose-500"></i>
                <span>Bot Shield Rules</span>
            </a>

            <!-- View Mode Switcher -->
            <div class="bg-slate-100 p-1 rounded-xl border border-slate-200 flex items-center gap-1 text-xs font-bold">
                <button type="button" @click="activeView = 'traffic'" :class="activeView === 'traffic' ? 'bg-white text-brand-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fa-solid fa-users"></i>
                    <span>Human Traffic</span>
                </button>
                <button type="button" @click="activeView = 'shield'" :class="activeView === 'shield' ? 'bg-white text-rose-700 shadow-xs' : 'text-slate-600 hover:text-slate-900'" class="px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-virus"></i>
                    <span>Blocked Bots</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-rose-100 text-rose-800 text-[10px] font-mono">{{ number_format($shieldStats['totalBlocked']) }}</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 shrink-0 text-base"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- VIEW 1: REGULAR VISITOR TRAFFIC -->
    <!-- ========================================================================= -->
    <div x-show="activeView === 'traffic'" class="space-y-6">
        
        <!-- Key Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            
            <!-- Total Page Views -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-2">
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
                    <span>Total Page Views</span>
                    <span class="p-2 rounded-lg bg-purple-50 text-brand-600"><i class="fa-solid fa-chart-column"></i></span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono">
                    {{ number_format($stats['totalViews']) }}
                </div>
                <div class="text-[11px] text-slate-500 flex items-center gap-1 font-medium">
                    <span class="text-emerald-600 font-bold">+{{ number_format($stats['todayViews']) }}</span> today
                </div>
            </div>

            <!-- Unique Visitors -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-2">
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
                    <span>Unique Visitors</span>
                    <span class="p-2 rounded-lg bg-pink-50 text-pink-600"><i class="fa-solid fa-users"></i></span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono">
                    {{ number_format($stats['uniqueVisitors']) }}
                </div>
                <div class="text-[11px] text-slate-500 flex items-center gap-1 font-medium">
                    <span class="text-pink-600 font-bold">+{{ number_format($stats['todayUnique']) }}</span> unique today
                </div>
            </div>

            <!-- This Week Views -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-2">
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
                    <span>This Week</span>
                    <span class="p-2 rounded-lg bg-blue-50 text-blue-600"><i class="fa-solid fa-calendar-week"></i></span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono">
                    {{ number_format($stats['weekViews']) }}
                </div>
                <div class="text-[11px] text-slate-500 font-medium">
                    Last 7 calendar days
                </div>
            </div>

            <!-- This Month Views -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-2">
                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
                    <span>This Month</span>
                    <span class="p-2 rounded-lg bg-emerald-50 text-emerald-600"><i class="fa-solid fa-arrow-trend-up"></i></span>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono">
                    {{ number_format($stats['monthViews']) }}
                </div>
                <div class="text-[11px] text-slate-500 font-medium">
                    Current billing month
                </div>
            </div>

        </div>

        <!-- 7-Day Trend Chart -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">7-Day Human Visitor Activity Trend</h3>
                    <p class="text-xs text-slate-400">Clean user traffic excluding filtered bot probes</p>
                </div>
                <span class="px-2.5 py-1 rounded-md bg-purple-50 text-brand-700 text-xs font-bold">Weekly Chart</span>
            </div>

            @php
                $maxCount = max(array_column($stats['dailyTrend'], 'count')) ?: 1;
            @endphp

            <div class="h-44 flex items-end justify-between gap-2 pt-4 px-2">
                @foreach($stats['dailyTrend'] as $item)
                    @php
                        $heightPercent = max(8, round(($item['count'] / $maxCount) * 100));
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 group h-full justify-end">
                        <div class="text-[10px] font-mono font-bold text-slate-500 group-hover:text-brand-600 transition">
                            {{ $item['count'] }}
                        </div>
                        <div class="w-full max-w-[40px] rounded-t-lg bg-gradient-to-t from-purple-600 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-400 transition-all shadow-xs" style="height: {{ $heightPercent }}%;"></div>
                        <div class="text-[11px] font-semibold text-slate-600 mt-1">
                            {{ $item['short_day'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Analytics Breakdown: Geolocation Places & Devices -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Geographic Traffic by Place / Country -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-brand-600"></i>
                            <span>Visitor Locations &amp; Places</span>
                        </h3>
                        <p class="text-xs text-slate-400">Detected visitor countries and regional places</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                        Live Places
                    </span>
                </div>

                <div class="space-y-3.5">
                    @forelse($stats['countries'] as $country)
                        @php
                            $totalV = $stats['totalViews'] ?: 1;
                            $countryPercent = round(($country->total / $totalV) * 100, 1);
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs font-bold mb-1">
                                <span class="flex items-center gap-2 text-slate-800">
                                    <span class="text-base leading-none">{{ $country->flag }}</span>
                                    <span>{{ $country->country }}</span>
                                    @if($country->country_code && $country->country_code !== 'UN' && $country->country_code !== 'DEV')
                                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-mono">{{ $country->country_code }}</span>
                                    @endif
                                </span>
                                <span class="text-slate-900 font-mono">{{ number_format($country->total) }} <span class="text-slate-400 font-normal">({{ $countryPercent }}%)</span></span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: {{ $countryPercent }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-6">No visitor location data logged yet.</p>
                    @endforelse
                </div>

                <!-- Top Cities Badges -->
                @if(isset($stats['cities']) && $stats['cities']->isNotEmpty())
                    <div class="pt-3 border-t border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Top Visitor Cities &amp; Regions:</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($stats['cities'] as $ct)
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50/60 text-emerald-900 text-[11px] font-semibold border border-emerald-200/80 flex items-center gap-1 shadow-2xs">
                                    <i class="fa-solid fa-location-dot text-emerald-600 text-[10px]"></i>
                                    <span>{{ $ct->city }}</span>
                                    <span class="text-emerald-700 font-mono font-bold">({{ $ct->total }})</span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Devices & OS Breakdown -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-mobile-screen text-purple-600"></i>
                            <span>Device &amp; Hardware Distribution</span>
                        </h3>
                        <p class="text-xs text-slate-400">Traffic split by hardware platform</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-md bg-purple-50 text-brand-700 text-xs font-bold">Devices</span>
                </div>

                <div class="space-y-3.5">
                    @forelse($stats['devices'] as $dev)
                        @php
                            $totalDev = $stats['totalViews'] ?: 1;
                            $devPercent = round(($dev->total / $totalDev) * 100, 1);
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs font-bold mb-1">
                                <span class="flex items-center gap-1.5 text-slate-700">
                                    @if($dev->device_type === 'Mobile') <i class="fa-solid fa-mobile-screen text-purple-600"></i> @elseif($dev->device_type === 'Tablet') <i class="fa-solid fa-tablet-screen-button text-blue-600"></i> @elseif($dev->device_type === 'Bot') <i class="fa-solid fa-robot text-rose-600"></i> @else <i class="fa-solid fa-laptop text-slate-600"></i> @endif
                                    {{ $dev->device_type }}
                                </span>
                                <span class="text-slate-900 font-mono">{{ $dev->total }} <span class="text-slate-400 font-normal">({{ $devPercent }}%)</span></span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full" style="width: {{ $devPercent }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-6">No device data logged yet.</p>
                    @endforelse
                </div>

                <!-- Top Platforms List -->
                @if($stats['platforms']->isNotEmpty())
                    <div class="pt-3 border-t border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Operating Systems:</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($stats['platforms'] as $plat)
                                <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-[11px] font-medium border border-slate-200">
                                    {{ $plat->platform }}: <strong>{{ $plat->total }}</strong>
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <!-- Top Visited Routes / Pages Grid -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-link text-brand-600"></i>
                        <span>Top Visited Routes &amp; Landing Pages</span>
                    </h3>
                    <p class="text-xs text-slate-400">Most requested route paths across your application</p>
                </div>
                <span class="text-xs text-slate-500 font-medium">Ranked by hit frequency</span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($stats['topPages'] as $page)
                    @php
                        $pagePercent = round(($page->total_views / ($stats['totalViews'] ?: 1)) * 100, 1);
                    @endphp
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-bold text-slate-800 truncate px-2 py-0.5 rounded bg-slate-100 border border-slate-200">{{ $page->path }}</span>
                                <a href="{{ url($page->path) }}" target="_blank" class="text-slate-400 hover:text-brand-600 text-xs flex items-center gap-0.5">
                                    <span>Open</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-slate-100 mt-2 overflow-hidden max-w-md">
                                <div class="h-full bg-purple-600 rounded-full" style="width: {{ $pagePercent }}%;"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-mono text-xs font-bold text-slate-900">{{ number_format($page->total_views) }}</span>
                            <span class="block text-[10px] text-slate-400 font-medium">{{ $pagePercent }}% of total</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">No route hit data recorded yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Live Real-Time Human Visitor Stream -->
        <div id="humanTrafficSection" class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden relative">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-tower-broadcast text-brand-600"></i>
                        <span>Live Human Visitor Stream</span>
                    </h3>
                    <p class="text-xs text-slate-400">Detailed breakdown showing IP Address, Place Location, Browser, Device &amp; Route</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="refreshTrafficAjax('human')" title="Refresh current page data" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-lg transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-arrows-rotate text-brand-600"></i>
                        <span>Refresh</span>
                    </button>
                    <form action="{{ route('admin.traffic.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all recorded visitor traffic logs?');">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg transition flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>Clear Human Logs</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Container for AJAX Swap of both Filter Toolbar & Table -->
            <div id="humanTrafficContainer">
                <!-- 🔍 Multi-Criteria Filter & Search Toolbar -->
                <div class="p-4 sm:p-5 bg-slate-50/80 border-b border-slate-200">
                    <form id="humanTrafficFilterForm" onsubmit="handleTrafficFilterSubmit(event, 'human')" class="space-y-3">
                        <!-- Row 1: Search Input & Action Buttons -->
                        <div class="flex flex-col md:flex-row items-stretch md:items-center gap-2.5">
                            <!-- Main Search Bar -->
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Filter by IP, City, State, Country, Route, Browser, OS..." 
                                       class="w-full pl-9 pr-8 py-2 text-xs rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 shadow-2xs">
                                @if(request('search'))
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 text-xs" title="Clear Search">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                @endif
                            </div>

                            <!-- Filter Submit Button -->
                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white btn-sangfy rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-filter text-xs"></i>
                                <span>Apply Filter</span>
                            </button>

                            <!-- Clear All Filters Button (Visible when any filter is active) -->
                            @if(($activeFiltersCount ?? 0) > 0)
                                <a href="{{ route('admin.traffic') }}" class="px-3.5 py-2 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition flex items-center justify-center gap-1.5" title="Reset all active filters">
                                    <i class="fa-solid fa-rotate-left text-xs"></i>
                                    <span>Reset ({{ $activeFiltersCount }})</span>
                                </a>
                            @endif
                        </div>

                        <!-- Row 2: Dropdown Selects Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 pt-1 text-xs">
                            <!-- 1. Time Period -->
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Time Period</label>
                                <select name="period" onchange="handleTrafficFilterSubmit(event, 'human')" class="w-full py-1.5 px-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 font-medium focus:ring-1 focus:ring-brand-500 text-xs cursor-pointer">
                                    <option value="all" {{ request('period') === 'all' || !request('period') ? 'selected' : '' }}>All Time</option>
                                    <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Today</option>
                                    <option value="yesterday" {{ request('period') === 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                    <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Last 7 Days</option>
                                    <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>This Month</option>
                                </select>
                            </div>

                            <!-- 2. Device Type -->
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Device Type</label>
                                <select name="device" onchange="handleTrafficFilterSubmit(event, 'human')" class="w-full py-1.5 px-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 font-medium focus:ring-1 focus:ring-brand-500 text-xs cursor-pointer">
                                    <option value="all" {{ !request('device') || request('device') === 'all' ? 'selected' : '' }}>All Devices</option>
                                    @foreach($availableDevices ?? [] as $dev)
                                        <option value="{{ $dev }}" {{ request('device') === $dev ? 'selected' : '' }}>{{ $dev }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 3. IP Protocol (IPv6 vs IPv4) -->
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">IP Protocol</label>
                                <select name="ip_type" onchange="handleTrafficFilterSubmit(event, 'human')" class="w-full py-1.5 px-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 font-medium focus:ring-1 focus:ring-brand-500 text-xs cursor-pointer">
                                    <option value="all" {{ !request('ip_type') || request('ip_type') === 'all' ? 'selected' : '' }}>All IPs (v4 &amp; v6)</option>
                                    <option value="ipv6" {{ request('ip_type') === 'ipv6' ? 'selected' : '' }}>IPv6 Only 🟣</option>
                                    <option value="ipv4" {{ request('ip_type') === 'ipv4' ? 'selected' : '' }}>IPv4 Only ⚪</option>
                                </select>
                            </div>

                            <!-- 4. Route / Page -->
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Route / Page</label>
                                <select name="route" onchange="handleTrafficFilterSubmit(event, 'human')" class="w-full py-1.5 px-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 font-medium focus:ring-1 focus:ring-brand-500 text-xs cursor-pointer">
                                    <option value="all" {{ !request('route') || request('route') === 'all' ? 'selected' : '' }}>All Routes</option>
                                    <option value="home" {{ request('route') === 'home' ? 'selected' : '' }}>Home (/)</option>
                                    <option value="download" {{ request('route') === 'download' ? 'selected' : '' }}>Download (/download)</option>
                                    <option value="features" {{ request('route') === 'features' ? 'selected' : '' }}>Features (/features)</option>
                                    <option value="contact" {{ request('route') === 'contact' ? 'selected' : '' }}>Contact (/contact)</option>
                                    <option value="legal" {{ request('route') === 'legal' ? 'selected' : '' }}>Legal Policies</option>
                                </select>
                            </div>

                            <!-- 5. Country / Place -->
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Location / Country</label>
                                <select name="country" onchange="handleTrafficFilterSubmit(event, 'human')" class="w-full py-1.5 px-2.5 rounded-lg border border-slate-200 bg-white text-slate-700 font-medium focus:ring-1 focus:ring-brand-500 text-xs cursor-pointer">
                                    <option value="all" {{ !request('country') || request('country') === 'all' ? 'selected' : '' }}>All Countries</option>
                                    @foreach($availableCountries ?? [] as $c)
                                        <option value="{{ $c }}" {{ request('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    <!-- Row 3: Active Filters Summary Pills -->
                    @if(($activeFiltersCount ?? 0) > 0)
                        <div class="flex flex-wrap items-center gap-1.5 pt-2 border-t border-slate-200/80 text-[11px]">
                            <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px]">Active Filters:</span>
                            @if(request('search'))
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-100 text-purple-800 font-medium">
                                    <span>Search: "{{ request('search') }}"</span>
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-purple-600 hover:text-purple-900"><i class="fa-solid fa-xmark"></i></a>
                                </span>
                            @endif
                            @if(request('period') && request('period') !== 'all')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-100 text-purple-800 font-medium">
                                    <span>Period: {{ ucfirst(request('period')) }}</span>
                                    <a href="{{ request()->fullUrlWithQuery(['period' => null]) }}" class="text-purple-600 hover:text-purple-900"><i class="fa-solid fa-xmark"></i></a>
                                </span>
                            @endif
                            @if(request('device') && request('device') !== 'all')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-100 text-purple-800 font-medium">
                                    <span>Device: {{ request('device') }}</span>
                                    <a href="{{ request()->fullUrlWithQuery(['device' => null]) }}" class="text-purple-600 hover:text-purple-900"><i class="fa-solid fa-xmark"></i></a>
                                </span>
                            @endif
                            @if(request('ip_type') && request('ip_type') !== 'all')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-100 text-purple-800 font-medium">
                                    <span>IP: {{ strtoupper(request('ip_type')) }}</span>
                                    <a href="{{ request()->fullUrlWithQuery(['ip_type' => null]) }}" class="text-purple-600 hover:text-purple-900"><i class="fa-solid fa-xmark"></i></a>
                                </span>
                            @endif
                            @if(request('route') && request('route') !== 'all')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-100 text-purple-800 font-medium">
                                    <span>Route: {{ ucfirst(request('route')) }}</span>
                                    <a href="{{ request()->fullUrlWithQuery(['route' => null]) }}" class="text-purple-600 hover:text-purple-900"><i class="fa-solid fa-xmark"></i></a>
                                </span>
                            @endif
                            @if(request('country') && request('country') !== 'all')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-100 text-purple-800 font-medium">
                                    <span>Country: {{ request('country') }}</span>
                                    <a href="{{ request()->fullUrlWithQuery(['country' => null]) }}" class="text-purple-600 hover:text-purple-900"><i class="fa-solid fa-xmark"></i></a>
                                </span>
                            @endif
                            <span class="text-slate-500 font-mono text-[10px] ml-auto">
                                Showing <strong>{{ number_format($paginatedLogs->total()) }}</strong> filtered visits
                            </span>
                        </div>
                    @endif
                </form>
            </div>

            <div id="humanTrafficTableWrapper" class="relative transition-opacity duration-200">
            @if($paginatedLogs->isEmpty())
                <div class="p-12 text-center space-y-2">
                    <i class="fa-solid fa-filter-circle-xmark text-3xl text-slate-300 block mb-2"></i>
                    <p class="text-sm font-bold text-slate-700">No Visits Matching Filters</p>
                    <p class="text-xs text-slate-400">No visitor records match your selected filter criteria. Try clearing search or changing the time period.</p>
                    @if(($activeFiltersCount ?? 0) > 0)
                        <div class="pt-2">
                            <a href="{{ route('admin.traffic') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-brand-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg transition">
                                <i class="fa-solid fa-rotate-left"></i>
                                <span>Reset All Filters</span>
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5 whitespace-nowrap">Time</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">IP Address</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Location (Place Name)</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Route (Page)</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Device &amp; OS</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Browser</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Referrer</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($paginatedLogs as $log)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-400 font-mono text-[11px]" title="{{ $log->created_at->format('Y-m-d H:i:s') }}">
                                        {{ $log->created_at->diffForHumans() }}
                                    </td>
                                    
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1.5">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 font-mono text-[11px] font-bold border border-slate-200">
                                                <span>{{ $log->ip_address ?? '127.0.0.1' }}</span>
                                            </span>
                                            @if(str_contains($log->ip_address ?? '', ':'))
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-purple-100 text-purple-700 border border-purple-200 tracking-wider">IPv6</span>
                                            @else
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-slate-100 text-slate-600 border border-slate-200 tracking-wider">IPv4</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-5 py-3.5">
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-purple-50/50 border border-purple-200/70 shadow-2xs">
                                            <span class="text-base leading-none shrink-0">{{ $log->country_flag }}</span>
                                            <div class="font-bold text-slate-900 text-xs whitespace-nowrap">
                                                {{ $log->location_display }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-3.5">
                                        <a href="{{ url($log->path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-purple-100 text-slate-800 hover:text-brand-700 font-mono text-xs font-bold border border-slate-200 hover:border-purple-300 transition group">
                                            <span class="truncate max-w-[160px]">{{ $log->path }}</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400 group-hover:text-brand-600"></i>
                                        </a>
                                    </td>

                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-200/80 text-xs">
                                            @if($log->device_type === 'Mobile') <i class="fa-solid fa-mobile-screen text-purple-600"></i> @elseif($log->device_type === 'Tablet') <i class="fa-solid fa-tablet-screen-button text-blue-600"></i> @elseif($log->device_type === 'Bot') <i class="fa-solid fa-robot text-rose-600"></i> @else <i class="fa-solid fa-laptop text-slate-600"></i> @endif
                                            <span>{{ $log->device_type }}</span>
                                            <span class="text-slate-300">&bull;</span>
                                            <span class="text-slate-600">{{ $log->platform ?? 'Unknown' }}</span>
                                        </span>
                                    </td>

                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-50 text-slate-700 font-medium border border-slate-200/80 text-xs">
                                            <i class="fa-regular fa-window-maximize text-slate-400"></i>
                                            <span>{{ $log->browser ?? 'Browser' }}</span>
                                        </span>
                                    </td>

                                    <td class="px-5 py-3.5 text-slate-400 truncate max-w-[150px] whitespace-nowrap" title="{{ $log->referer }}">
                                        {{ $log->referer ? parse_url($log->referer, PHP_URL_HOST) ?: $log->referer : 'Direct' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100 pagination-container">
                    {{ $paginatedLogs->links() }}
                </div>
            @endif
            </div>
        </div>
    </div>

</div>

    <!-- ========================================================================= -->
    <!-- VIEW 2: BOT SHIELD & DEFENSE LOGS -->
    <!-- ========================================================================= -->
    <div x-show="activeView === 'shield'" class="space-y-6" style="display:none;">
        
        <!-- Shield Security Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
            
            <!-- Total Blocked Bots -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-rose-200/90 shadow-xs space-y-1.5">
                <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-rose-500">
                    <span>Total Blocked</span>
                    <span class="p-1.5 rounded-lg bg-rose-50 text-rose-600"><i class="fa-solid fa-shield-halved"></i></span>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 font-mono">
                    {{ number_format($shieldStats['totalBlocked']) }}
                </div>
                <div class="text-[10px] text-slate-500 flex items-center gap-1 font-medium">
                    <span class="text-rose-600 font-bold">+{{ number_format($shieldStats['todayBlocked']) }}</span> today
                </div>
            </div>

            <!-- Exploit Probes Blocked -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs space-y-1.5">
                <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <span>Exploit Probes</span>
                    <span class="p-1.5 rounded-lg bg-amber-50 text-amber-600"><i class="fa-solid fa-ban"></i></span>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 font-mono">
                    {{ number_format($shieldStats['exploitProbesBlocked']) }}
                </div>
                <div class="text-[10px] text-slate-500 font-medium">
                    /.env, wp, shells
                </div>
            </div>

            <!-- SQLi & XSS Blocked -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-red-200/90 shadow-xs space-y-1.5">
                <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-red-500">
                    <span>SQLi &amp; XSS</span>
                    <span class="p-1.5 rounded-lg bg-red-50 text-red-600"><i class="fa-solid fa-syringe"></i></span>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 font-mono">
                    {{ number_format(($shieldStats['sqlInjectionBlocked'] ?? 0) + ($shieldStats['xssBlocked'] ?? 0)) }}
                </div>
                <div class="text-[10px] text-slate-500 font-medium">
                    Script &amp; SQL injection
                </div>
            </div>

            <!-- Scrapers Blocked -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs space-y-1.5">
                <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <span>Scrapers</span>
                    <span class="p-1.5 rounded-lg bg-purple-50 text-purple-600"><i class="fa-solid fa-robot"></i></span>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 font-mono">
                    {{ number_format($shieldStats['scrapersBlocked']) }}
                </div>
                <div class="text-[10px] text-slate-500 font-medium">
                    Python, Scrapy, tools
                </div>
            </div>

            <!-- Honeypot Trapped -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs space-y-1.5">
                <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <span>Spam Traps</span>
                    <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600"><i class="fa-solid fa-filter"></i></span>
                </div>
                <div class="text-2xl font-extrabold text-slate-900 font-mono">
                    {{ number_format($shieldStats['honeypotTrapped']) }}
                </div>
                <div class="text-[10px] text-slate-500 font-medium">
                    Form bots caught
                </div>
            </div>

        </div>

        <!-- Shield Health & Status Card -->
        <div class="p-6 rounded-2xl bg-gradient-to-r from-slate-900 via-purple-950 to-slate-900 text-white shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Active Multi-Layer Firewall Active</span>
                </div>
                <h3 class="text-xl font-bold tracking-tight">Your website is fully protected against automated bot traffic</h3>
                <p class="text-xs text-slate-300 max-w-2xl leading-relaxed">
                    All incoming requests pass through multi-point heuristic inspection: Exploit scanning interception, automated scraper blocking, empty header drops, Honeypot spam filtering, and burst rate-limiting.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('admin.settings.index') }}#shield" class="px-4 py-2.5 text-xs font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl transition flex items-center gap-1.5 shadow-xs">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Configure Firewall Rules</span>
                </a>
                <form action="{{ route('admin.traffic.clear-bots') }}" method="POST" onsubmit="return confirm('Clear all blocked bot security logs?');">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 text-xs font-bold text-rose-300 bg-rose-500/20 hover:bg-rose-500/30 border border-rose-500/30 rounded-xl transition flex items-center gap-1.5">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Clear Bot Threat Logs</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Live Blocked Bots & Threat Stream Table -->
        <div id="botTrafficSection" class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden relative">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-shield-virus text-rose-600"></i>
                        <span>Neutralized Bot Threat Stream</span>
                    </h3>
                    <p class="text-xs text-slate-400">Live feed of malicious automated scrapers and exploit probes blocked by the firewall</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="refreshTrafficAjax('bot')" title="Refresh current page data" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-lg transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-arrows-rotate text-rose-600"></i>
                        <span>Refresh</span>
                    </button>
                    <form action="{{ route('admin.traffic.clear-bots') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all blocked bot & threat security logs?');">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg transition flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>Clear Threat Logs</span>
                        </button>
                    </form>
                    <span class="hidden sm:flex px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-bold border border-rose-200 items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                        <span>Real-Time Defense Stream</span>
                    </span>
                </div>
            </div>

            <!-- Container for AJAX Swap of both Bot Filter Toolbar & Table -->
            <div id="botTrafficContainer">
                <!-- 🛡️ Bot Threat Search & Filter Toolbar -->
                <div class="p-3.5 sm:p-4 bg-slate-50/80 border-b border-slate-200">
                    <form id="botTrafficFilterForm" onsubmit="handleTrafficFilterSubmit(event, 'bot')" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        <input type="hidden" name="active_tab" value="shield">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" 
                                   name="bot_search" 
                                   value="{{ request('bot_search') }}" 
                                   placeholder="Search blocked bots by IP, probe path, or reason..." 
                                   class="w-full pl-8 pr-7 py-1.5 text-xs rounded-xl border border-slate-200 bg-white text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-1 focus:ring-rose-500 shadow-2xs">
                            @if(request('bot_search'))
                                <a href="{{ request()->fullUrlWithQuery(['bot_search' => null]) }}" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-700 text-xs" title="Clear search">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                        </div>
                        <select name="bot_category" onchange="handleTrafficFilterSubmit(event, 'bot')" class="py-1.5 px-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-xs font-medium focus:ring-1 focus:ring-rose-500 cursor-pointer">
                            <option value="all" {{ !request('bot_category') || request('bot_category') === 'all' ? 'selected' : '' }}>All Attack Categories</option>
                            <option value="sql_injection" {{ request('bot_category') === 'sql_injection' ? 'selected' : '' }}>SQL Injection</option>
                            <option value="xss_attack" {{ request('bot_category') === 'xss_attack' ? 'selected' : '' }}>XSS Attack</option>
                            <option value="exploit_probe" {{ request('bot_category') === 'exploit_probe' ? 'selected' : '' }}>Exploit Probes (/.env, wp)</option>
                            <option value="honeypot" {{ request('bot_category') === 'honeypot' ? 'selected' : '' }}>Honeypot Trap</option>
                            <option value="rate_limit" {{ request('bot_category') === 'rate_limit' ? 'selected' : '' }}>Rate Limit Exceeded</option>
                        </select>
                        <button type="submit" class="px-3.5 py-1.5 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl transition flex items-center justify-center gap-1 cursor-pointer shadow-2xs">
                            <i class="fa-solid fa-filter text-xs"></i>
                            <span>Filter</span>
                        </button>
                        @if(request('bot_search') || (request('bot_category') && request('bot_category') !== 'all'))
                            <a href="{{ route('admin.traffic', ['active_tab' => 'shield']) }}" class="px-3 py-1.5 text-xs font-bold text-slate-600 bg-slate-200 hover:bg-slate-300 rounded-xl transition flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div id="botTrafficTableWrapper" class="relative transition-opacity duration-200">
            @if($paginatedBotLogs->isEmpty())
                <div class="p-12 text-center space-y-2">
                    <i class="fa-solid fa-shield-halved text-3xl text-slate-300 block mb-2"></i>
                    <p class="text-sm font-bold text-slate-700">No Blocked Threats Found</p>
                    <p class="text-xs text-slate-400">No recorded malicious attempts match your filter criteria.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5 whitespace-nowrap">Time Blocked</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Attacker IP</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Reason &amp; Category</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">Target Route</th>
                                <th class="px-5 py-3.5 whitespace-nowrap">User-Agent Signature</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($paginatedBotLogs as $bot)
                                <tr class="hover:bg-rose-50/40 transition">
                                    <!-- Timestamp -->
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-400 font-mono text-[11px]" title="{{ $bot->created_at->format('Y-m-d H:i:s') }}">
                                        {{ $bot->created_at->diffForHumans() }}
                                    </td>

                                    <!-- IP Address -->
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <div class="inline-flex items-center gap-1.5">
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 font-mono text-[11px] font-bold border border-slate-200">
                                                <span>{{ $bot->country_flag }}</span>
                                                <span>{{ $bot->ip_address ?? 'Unknown' }}</span>
                                            </div>
                                            @if(str_contains($bot->ip_address ?? '', ':'))
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-purple-100 text-purple-700 border border-purple-200 tracking-wider">IPv6</span>
                                            @else
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-slate-100 text-slate-600 border border-slate-200 tracking-wider">IPv4</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Block Reason & Category Badge -->
                                    <td class="px-5 py-3.5">
                                        <div class="space-y-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                                @if($bot->category === 'sql_injection') bg-rose-600 text-white shadow-2xs
                                                @elseif($bot->category === 'xss_attack') bg-red-600 text-white shadow-2xs
                                                @elseif($bot->category === 'exploit_probe') bg-rose-100 text-rose-800 border border-rose-200
                                                @elseif($bot->category === 'honeypot') bg-amber-100 text-amber-800 border border-amber-200
                                                @elseif($bot->category === 'rate_limit') bg-orange-100 text-orange-800 border border-orange-200
                                                @else bg-purple-100 text-purple-800 border border-purple-200 @endif">
                                                {{ str_replace('_', ' ', $bot->category) }}
                                            </span>
                                            <div class="font-semibold text-slate-800 text-xs">
                                                {{ $bot->block_reason }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Target Path -->
                                    <td class="px-5 py-3.5">
                                        <span class="font-mono text-xs text-rose-700 bg-rose-50 px-2 py-0.5 rounded border border-rose-200 font-bold truncate max-w-[200px] block">
                                            {{ $bot->method }} {{ $bot->path }}
                                        </span>
                                    </td>

                                    <!-- User Agent -->
                                    <td class="px-5 py-3.5 font-mono text-[11px] text-slate-500 max-w-[250px] truncate" title="{{ $bot->user_agent }}">
                                        {{ $bot->user_agent ?: 'None (Empty User-Agent)' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100 pagination-container">
                    {{ $paginatedBotLogs->links() }}
                </div>
            @endif
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
(function() {
    // 1. Submit Handler for Filter Forms (Human & Bot)
    window.handleTrafficFilterSubmit = function(e, type) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        var isHuman = (type === 'human');
        var formId = isHuman ? 'humanTrafficFilterForm' : 'botTrafficFilterForm';
        var containerId = isHuman ? 'humanTrafficContainer' : 'botTrafficContainer';
        var sectionId = isHuman ? 'humanTrafficSection' : 'botTrafficSection';
        var form = document.getElementById(formId);

        if (!form) return;

        var formData = new FormData(form);
        var currentUrl = new URL(window.location.href);
        var params = currentUrl.searchParams;

        if (isHuman) {
            // Reset human-specific filter and pagination params
            params.delete('page');
            params.delete('search');
            params.delete('period');
            params.delete('device');
            params.delete('ip_type');
            params.delete('route');
            params.delete('country');
            params.set('active_tab', 'traffic');

            formData.forEach(function(val, key) {
                val = (typeof val === 'string') ? val.trim() : val;
                if (val && val !== 'all') {
                    params.set(key, val);
                }
            });
        } else {
            // Reset bot-specific filter and pagination params
            params.delete('bot_page');
            params.delete('bot_search');
            params.delete('bot_category');
            params.set('active_tab', 'shield');

            formData.forEach(function(val, key) {
                val = (typeof val === 'string') ? val.trim() : val;
                if (val && val !== 'all') {
                    params.set(key, val);
                }
            });
        }

        var queryString = params.toString();
        var targetUrl = currentUrl.pathname + (queryString ? '?' + queryString : '');

        loadTrafficContainer(targetUrl, containerId, sectionId, true);
    };

    // 2. Click Interceptor for Filter Pills [x], Reset buttons, and Pagination Links
    document.addEventListener('click', function(e) {
        var link = e.target.closest('#humanTrafficContainer a, #botTrafficContainer a');
        if (!link || !link.href) return;

        // Skip non-GET / external / hash links
        if (link.getAttribute('target') === '_blank') return;
        if (link.getAttribute('aria-disabled') === 'true') {
            e.preventDefault();
            return;
        }
        var href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

        e.preventDefault();
        e.stopPropagation();

        var isHuman = Boolean(link.closest('#humanTrafficContainer'));
        var containerId = isHuman ? 'humanTrafficContainer' : 'botTrafficContainer';
        var sectionId = isHuman ? 'humanTrafficSection' : 'botTrafficSection';

        loadTrafficContainer(link.href, containerId, sectionId, true);
    });

    // 3. Manual Refresh Button Trigger
    window.refreshTrafficAjax = function(type) {
        var isHuman = (type === 'human');
        var containerId = isHuman ? 'humanTrafficContainer' : 'botTrafficContainer';
        var sectionId = isHuman ? 'humanTrafficSection' : 'botTrafficSection';
        loadTrafficContainer(window.location.href, containerId, sectionId, false);
    };

    // 4. Core AJAX Loader Function using DOMParser
    function loadTrafficContainer(url, containerId, sectionId, updateHistory) {
        var container = document.getElementById(containerId);
        var section = document.getElementById(sectionId);
        if (!container) {
            window.location.href = url;
            return;
        }

        // Add subtle loading state
        container.classList.add('opacity-40', 'pointer-events-none', 'transition-opacity');

        var toastId = 'traffic_filter_toast';
        var existingToast = document.getElementById(toastId);
        if (!existingToast) {
            var toast = document.createElement('div');
            toast.id = toastId;
            toast.className = 'fixed bottom-6 right-6 z-50 flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-2xl backdrop-blur-md border border-slate-700 transition-all';
            toast.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-brand-400 text-sm"></i><span>Updating traffic data...</span>';
            document.body.appendChild(toast);
        }

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.text();
        })
        .then(function(html) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(html, 'text/html');
            var newContainer = doc.getElementById(containerId);

            // Remove loading toast
            var t = document.getElementById(toastId);
            if (t) t.remove();

            if (newContainer) {
                container.innerHTML = newContainer.innerHTML;
                container.classList.remove('opacity-40', 'pointer-events-none');

                if (updateHistory) {
                    window.history.pushState({ path: url, containerId: containerId, sectionId: sectionId }, '', url);
                }

                // If user has scrolled down past the section header, smoothly scroll to top of section
                if (section) {
                    var rect = section.getBoundingClientRect();
                    if (rect.top < 60) {
                        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            } else {
                window.location.href = url;
            }
        })
        .catch(function(err) {
            console.error('AJAX traffic filter error:', err);
            var t = document.getElementById(toastId);
            if (t) t.remove();
            window.location.href = url;
        });
    }

    // 5. Browser Back & Forward Navigation Synchronization
    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.containerId) {
            loadTrafficContainer(window.location.href, e.state.containerId, e.state.sectionId, false);
        } else {
            var params = new URLSearchParams(window.location.search);
            if (params.get('active_tab') === 'shield' || params.has('bot_page') || params.has('bot_search') || params.has('bot_category')) {
                loadTrafficContainer(window.location.href, 'botTrafficContainer', 'botTrafficSection', false);
            } else {
                loadTrafficContainer(window.location.href, 'humanTrafficContainer', 'humanTrafficSection', false);
            }
        }
    });
})();
</script>
@endpush
@endsection
