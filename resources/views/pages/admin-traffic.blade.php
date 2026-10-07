@extends('layouts.admin')

@section('title', 'Visitor Traffic & Bot Shield Analytics — Sangfy Admin')
@section('page_title', 'Traffic & Bot Shield Defense')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ activeView: 'traffic' }">
    
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
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-tower-broadcast text-brand-600"></i>
                        <span>Live Human Visitor Stream</span>
                    </h3>
                    <p class="text-xs text-slate-400">Detailed breakdown showing IP Address, Place Location, Browser, Device &amp; Route</p>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('admin.traffic.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all recorded visitor traffic logs?');">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg transition flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>Clear Human Logs</span>
                        </button>
                    </form>
                </div>
            </div>

            @if($paginatedLogs->isEmpty())
                <div class="p-12 text-center space-y-2">
                    <i class="fa-solid fa-globe text-3xl text-slate-300 block mb-2"></i>
                    <p class="text-sm font-bold text-slate-700">No Visitor Logs Yet</p>
                    <p class="text-xs text-slate-400">As people browse your site, their IP, place location, browser, device, and visited route will stream here in real time.</p>
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
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 font-mono text-[11px] font-bold border border-slate-200">
                                            <span>{{ $log->ip_address ?? '127.0.0.1' }}</span>
                                        </span>
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

                <div class="p-4 border-t border-slate-100">
                    {{ $paginatedLogs->links() }}
                </div>
            @endif
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
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-base text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-shield-virus text-rose-600"></i>
                        <span>Neutralized Bot Threat Stream</span>
                    </h3>
                    <p class="text-xs text-slate-400">Live feed of malicious automated scrapers and exploit probes blocked by the firewall</p>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-bold border border-rose-200 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                    <span>Real-Time Defense Stream</span>
                </span>
            </div>

            @if($paginatedBotLogs->isEmpty())
                <div class="p-12 text-center space-y-2">
                    <i class="fa-solid fa-shield-halved text-3xl text-slate-300 block mb-2"></i>
                    <p class="text-sm font-bold text-slate-700">No Blocked Bot Threats Recorded Yet</p>
                    <p class="text-xs text-slate-400">When automated scrapers, exploit scanners, or spam bots attempt to access your website, they are instantly dropped and logged here.</p>
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
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 font-mono text-[11px] font-bold border border-slate-200">
                                            <span>{{ $bot->country_flag }}</span>
                                            <span>{{ $bot->ip_address ?? 'Unknown' }}</span>
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

                <div class="p-4 border-t border-slate-100">
                    {{ $paginatedBotLogs->links() }}
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
