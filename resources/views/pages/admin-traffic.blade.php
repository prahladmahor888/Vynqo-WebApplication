@extends('layouts.admin')

@section('title', 'Visitor Traffic & Real-Time Analytics — Sangfy Admin')
@section('page_title', 'Traffic & Visitor Analytics')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Top Header Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>Real-Time Visitor Tracking Active</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Traffic &amp; Visitor Analytics Hub
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Monitor live page hits, unique visitors, device types, top landing pages, and traffic trends.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.settings.index') }}#seo" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5 shadow-2xs">
                <span>Configure Google Analytics</span>
            </a>
            <form action="{{ route('admin.traffic.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all recorded traffic logs?');">
                @csrf
                <button type="submit" class="px-4 py-2 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Clear Logs</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Key Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Total Page Views -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
                <span>Total Page Views</span>
                <span class="p-2 rounded-lg bg-purple-50 text-brand-600">📊</span>
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
                <span class="p-2 rounded-lg bg-pink-50 text-pink-600">👥</span>
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
                <span class="p-2 rounded-lg bg-blue-50 text-blue-600">📅</span>
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
                <span class="p-2 rounded-lg bg-emerald-50 text-emerald-600">📈</span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono">
                {{ number_format($stats['monthViews']) }}
            </div>
            <div class="text-[11px] text-slate-500 font-medium">
                Current billing month
            </div>
        </div>

    </div>

    <!-- 7-Day Trend Chart & Device Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- 7-Day Activity Chart Card -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">7-Day Visitor Activity Trend</h3>
                    <p class="text-xs text-slate-400">Daily page hit volume over the past week</p>
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

        <!-- Devices & OS Breakdown -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
            <div class="pb-3 border-b border-slate-100">
                <h3 class="font-extrabold text-sm text-slate-900">Device Distribution</h3>
                <p class="text-xs text-slate-400">Traffic split by hardware type</p>
            </div>

            <div class="space-y-3">
                @forelse($stats['devices'] as $dev)
                    @php
                        $totalDev = $stats['totalViews'] ?: 1;
                        $devPercent = round(($dev->total / $totalDev) * 100, 1);
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold mb-1">
                            <span class="flex items-center gap-1.5 text-slate-700">
                                @if($dev->device_type === 'Mobile') 📱 @elseif($dev->device_type === 'Tablet') 📟 @elseif($dev->device_type === 'Bot') 🤖 @else 💻 @endif
                                {{ $dev->device_type }}
                            </span>
                            <span class="text-slate-900 font-mono">{{ $dev->total }} ({{ $devPercent }}%)</span>
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
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-slate-700 text-[11px] font-medium border border-slate-200">
                                {{ $plat->platform }}: <strong>{{ $plat->total }}</strong>
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Top Visited Pages Grid -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="font-extrabold text-sm text-slate-900">Most Visited Landing Pages</h3>
                <p class="text-xs text-slate-400">Top destinations across your application</p>
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
                            <span class="font-mono text-xs font-bold text-slate-800 truncate">{{ $page->path }}</span>
                            <a href="{{ url($page->path) }}" target="_blank" class="text-slate-400 hover:text-brand-600 text-xs">&nearr;</a>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-slate-100 mt-1.5 overflow-hidden max-w-md">
                            <div class="h-full bg-purple-600 rounded-full" style="width: {{ $pagePercent }}%;"></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="font-mono text-xs font-bold text-slate-900">{{ number_format($page->total_views) }}</span>
                        <span class="block text-[10px] text-slate-400 font-medium">{{ $pagePercent }}% of total</span>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 text-center py-6">No page hit data recorded yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Live Real-Time Visitor Activity Stream -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-base text-slate-900">Live Visitor Activity Log</h3>
                <p class="text-xs text-slate-400">Chronological stream of incoming page views</p>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">Live Feed</span>
        </div>

        @if($paginatedLogs->isEmpty())
            <div class="p-12 text-center space-y-2">
                <span class="text-3xl">🌐</span>
                <p class="text-sm font-bold text-slate-700">No Visitor Logs Yet</p>
                <p class="text-xs text-slate-400">As people browse your site, their page visits will stream here in real time.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">Timestamp</th>
                            <th class="px-6 py-3.5">Page Path</th>
                            <th class="px-6 py-3.5">Device &amp; OS</th>
                            <th class="px-6 py-3.5">Browser</th>
                            <th class="px-6 py-3.5">IP Address</th>
                            <th class="px-6 py-3.5">Referrer</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($paginatedLogs as $log)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-3.5 whitespace-nowrap text-slate-400 font-mono text-[11px]">
                                    {{ $log->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-3.5 font-mono font-bold text-slate-900">
                                    {{ $log->path }}
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="inline-flex items-center gap-1 font-semibold text-slate-700">
                                        @if($log->device_type === 'Mobile') 📱 @elseif($log->device_type === 'Tablet') 📟 @else 💻 @endif
                                        {{ $log->device_type }} &bull; {{ $log->platform ?? 'Unknown' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-slate-600">
                                    {{ $log->browser ?? 'Browser' }}
                                </td>
                                <td class="px-6 py-3.5 font-mono text-[11px] text-slate-500">
                                    {{ $log->ip_address ?? '127.0.0.1' }}
                                </td>
                                <td class="px-6 py-3.5 text-slate-400 truncate max-w-[180px]" title="{{ $log->referer }}">
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
@endsection
