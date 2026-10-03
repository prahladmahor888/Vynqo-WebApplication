@extends('layouts.admin')

@section('title', 'Admin Dashboard Overview — Vynqo')
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
                Real-time management for Vynqo Android App (<code class="font-mono text-slate-700 font-bold">com.vynqo.app</code>), live release binaries, compliance policies, and user inquiries.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.release') }}" class="px-4 py-2.5 text-xs font-bold text-white btn-vynqo rounded-xl shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Upload New Build</span>
            </a>
            <a href="{{ route('admin.legal.index') }}" class="px-4 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition">
                <span>Edit Policies</span>
            </a>
        </div>
    </div>

    <!-- Global Flash Alerts -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- 4 Key Metrics Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Metric 1: Current Release -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-500 tracking-wider">Active APK Build</span>
                <span class="w-8 h-8 rounded-xl bg-purple-50 text-brand-600 flex items-center justify-center text-base font-bold">🚀</span>
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
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Metric 2: Total Downloads -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-500 tracking-wider">APK Downloads</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base font-bold">📥</span>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-slate-900 font-mono">{{ number_format($totalDownloads) }}</div>
                <div class="text-xs text-slate-500 mt-1 font-medium">
                    Tracked Android Downloads
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('download.page') }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center justify-between">
                    <span>Public Download Page</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Metric 3: Legal & Policies -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-500 tracking-wider">Legal Policies in DB</span>
                <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base font-bold">📜</span>
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
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Metric 4: Support Inquiries -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:border-purple-300 transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-500 tracking-wider">User Inquiries</span>
                <span class="w-8 h-8 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-base font-bold">💬</span>
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
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Two Column Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Active Release Box & Legal Table (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Live Active Release Hero Card -->
            <div class="bg-slate-900 text-white rounded-2xl p-6 sm:p-7 border border-slate-800 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10 space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Live Active Release in Database</span>
                        </div>
                        <span class="text-xs font-mono text-slate-400">App ID: com.vynqo.app</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                        <div>
                            <span class="text-xs text-slate-400 block">Version & Code</span>
                            <span class="text-xl font-bold text-white font-mono">{{ $latestRelease->version_name ?? 'v1.0.0' }}</span>
                            <span class="text-xs text-purple-300 font-mono block">Build Code #{{ $latestRelease->version_code ?? 100 }}</span>
                        </div>

                        <div>
                            <span class="text-xs text-slate-400 block">Package Size</span>
                            <span class="text-xl font-bold text-emerald-400 font-mono">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                            <span class="text-xs text-slate-400 block">Universal APK Binary</span>
                        </div>

                        <div>
                            <span class="text-xs text-slate-400 block">Target OS</span>
                            <span class="text-base font-bold text-slate-200">Android 8.0 - 15</span>
                            <span class="text-xs text-slate-400 block">API 26 to API 35</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <span class="text-xs text-slate-400 block mb-1 font-semibold">Active Changelog & Features:</span>
                        <div class="text-xs text-slate-300 bg-slate-800/80 p-3.5 rounded-xl font-mono whitespace-pre-line border border-slate-700/60 leading-relaxed max-h-36 overflow-y-auto">
{{ $latestRelease->changelog ?? '• Image & Video Feed Posts\n• 24h Stories\n• Nearby Radar\n• Free HD Calls' }}
                        </div>
                    </div>

                    <div class="pt-3 flex flex-wrap items-center justify-between gap-4 border-t border-slate-800">
                        <div class="text-xs text-slate-400 font-mono">
                            SHA256: <code class="text-slate-300 font-mono">{{ substr($latestRelease->sha256_checksum ?? 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 0, 24) }}...</code>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.release') }}" class="px-4 py-2 text-xs font-bold text-white btn-vynqo rounded-lg shadow-xs">
                                Edit Release & Upload APK
                            </a>
                            <a href="{{ route('download.apk') }}" class="px-4 py-2 text-xs font-bold text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg border border-slate-700 transition">
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
            
            <!-- Quick Hub Navigation -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-3">
                <h3 class="text-xs font-bold uppercase text-slate-900 tracking-wider">Quick Actions Hub</h3>
                
                <div class="space-y-2 text-xs">
                    <a href="{{ route('admin.release') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 transition group">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">📦</span>
                            <span class="font-bold text-slate-800 group-hover:text-brand-700">Upload New APK Binary</span>
                        </div>
                        <span class="text-slate-400 group-hover:text-brand-600">&rarr;</span>
                    </a>

                    <a href="{{ route('admin.legal.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 transition group">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">📜</span>
                            <span class="font-bold text-slate-800 group-hover:text-brand-700">Edit Privacy & Guidelines</span>
                        </div>
                        <span class="text-slate-400 group-hover:text-brand-600">&rarr;</span>
                    </a>

                    <a href="{{ route('admin.messages') }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 transition group">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">💬</span>
                            <span class="font-bold text-slate-800 group-hover:text-brand-700">Manage User Inquiries</span>
                        </div>
                        <span class="text-slate-400 group-hover:text-brand-600">&rarr;</span>
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
