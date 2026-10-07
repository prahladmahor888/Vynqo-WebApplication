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
                <span>Welcome, {{ Auth::user()->name ?? 'Admin' }}</span>
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
                    <span class="text-emerald-600 font-bold">All {{ $totalReleases }} Releases</span>
                    <span>•</span>
                    <span>{{ number_format($latestRelease->download_count ?? 1250) }} on Active</span>
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
                        <span class="font-bold text-brand-700 font-mono">{{ Auth::user()->email ?? 'Active Admin' }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
