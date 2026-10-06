@extends('layouts.app')

@section('title', 'Download Sangfy for Android — Free, Simple & Private Messaging')
@section('meta_description', 'Download the official Sangfy app for Android. 100% free, private messaging, HD voice & video calls, and zero advertisements.')

@section('content')
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Official Safe Download</span>
        </div>

        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            Get Sangfy for Android
        </h1>
        
        <p class="mt-4 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">
            Stay close with the people who matter most. Unlimited free messaging, crystal-clear voice and video calls, with zero ads.
        </p>

        <!-- Main Download Highlight Card -->
        <div class="mt-10 bg-white border border-slate-200 rounded-lg p-6 sm:p-10 shadow-lg text-left" x-data="{ showAdvanced: false, copied: false }">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-8 border-b border-slate-200">
                <div class="flex items-center space-x-4">
                    <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo.png') }}';" alt="{{ $siteName ?? 'Sangfy' }} Official Logo" class="w-16 h-16 rounded-xl object-contain p-1">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-2xl font-bold text-slate-900">{{ $siteName ?? 'Sangfy' }} App</h2>
                            <span class="bg-purple-50 border border-purple-200 text-brand-700 text-xs px-2.5 py-0.5 rounded font-bold">{{ $latestRelease->version_name ?? 'v1.0.0' }}</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Package: <code class="font-mono text-slate-700">{{ $siteSettings['android_package_name'] ?? 'com.prahlix.sangfy' }}</code> • Updated {{ $latestRelease->updated_at ? $latestRelease->updated_at->diffForHumans() : 'Recently' }}</p>
                    </div>
                </div>

                <!-- Dual Download CTAs: Direct APK & Play Store -->
                <div class="w-full md:w-auto flex flex-col sm:flex-row md:flex-col gap-3">
                    @if(($siteSettings['direct_apk_enabled'] ?? '1') === '1')
                    <a href="{{ route('download.apk') }}" class="inline-flex items-center justify-center gap-3 px-7 py-3.5 text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Direct Download APK ({{ $latestRelease->file_size ?? '30 MB' }})</span>
                    </a>
                    @endif

                    @if(($siteSettings['play_store_enabled'] ?? '1') === '1')
                    <a href="{{ $siteSettings['play_store_url'] ?? 'https://play.google.com/store/apps/details?id=' . ($siteSettings['android_package_name'] ?? 'com.prahlix.sangfy') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2.5 px-6 py-3 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl border border-slate-700 transition shadow-xs">
                        <svg class="w-4 h-4" viewBox="0 0 512 512">
                            <path fill="#4caf50" d="M363.8 238.1l-246.5-142.3c-10.2-5.9-22.9-5.9-33.1 0-10.2 5.9-16.5 16.8-16.5 28.6v284.6c0 11.8 6.3 22.7 16.5 28.6 5.1 2.9 10.8 4.4 16.5 4.4s11.5-1.5 16.5-4.4l246.6-142.3c10.2-5.9 16.5-16.8 16.5-28.6s-6.4-22.7-16.5-28.6z"/>
                            <path fill="#00bcd4" d="M67.7 124.4c-1.5 2.6-2.3 5.5-2.3 8.6v245.9c0 3.1.8 6 2.3 8.6l143.5-131.6-143.5-131.5z"/>
                            <path fill="#ffb300" d="M380.3 227.2l-52.6-30.4-44.5 40.8 44.5 40.8 52.6-30.4c6.7-3.9 10.8-11 10.8-18.8s-4.1-14.9-10.8-22z"/>
                            <path fill="#e91e63" d="M211.2 247.6l72 66-72 66 148.6-85.8-148.6-46.2z"/>
                        </svg>
                        <span>Get on Google Play Store</span>
                    </a>
                    @endif

                    <div class="text-[11px] text-slate-500 text-center flex items-center justify-center gap-1.5 font-medium">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>{{ number_format($latestRelease->download_count ?? 1250) }} Verified Downloads</span>
                    </div>
                </div>
            </div>

            <!-- Everyday User Specs Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-6 border-b border-slate-200 text-xs">
                <div>
                    <span class="text-slate-400 block mb-1">Works on</span>
                    <span class="font-bold text-slate-800">{{ $latestRelease->min_android_version ?? 'Android 8.0 & newer' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1">File Size</span>
                    <span class="font-bold text-slate-800 font-mono text-brand-600">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1">Privacy</span>
                    <span class="font-bold text-emerald-600">100% Private & Locked</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1">Price & Ads</span>
                    <span class="font-bold text-slate-800">100% Free • No Ads</span>
                </div>
            </div>

            <!-- Optional Advanced Security Accordion for Developers / Technical Users -->
            <div class="pt-4">
                <button @click="showAdvanced = !showAdvanced" type="button" class="text-xs font-semibold text-slate-500 hover:text-brand-600 flex items-center gap-1">
                    <span x-text="showAdvanced ? '− Hide Technical Details' : '+ Show Security Checksum (For Advanced Users)'"></span>
                </button>

                <div x-show="showAdvanced" x-transition class="mt-3 p-4 bg-slate-50 border border-slate-200 rounded-md space-y-3 text-xs" style="display:none;">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-slate-700 pb-2 border-b border-slate-200">
                        <div><strong>Package Name:</strong> <code class="font-mono text-brand-600">{{ $siteSettings['android_package_name'] ?? 'com.prahlix.sangfy' }}</code></div>
                        <div><strong>Target Platform:</strong> Android 8.0 to Android 15 (API 26–35)</div>
                        <div><strong>Native Architectures:</strong> arm64-v8a, armeabi-v7a, x86_64</div>
                        <div><strong>Realtime Engine:</strong> Agora RTC Embedded Voice/Video</div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold text-slate-700">SHA-256 Package Checksum:</span>
                            <button @click="navigator.clipboard.writeText('{{ $latestRelease->sha256_checksum ?? 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' }}'); copied = true; setTimeout(() => copied = false, 2500)" class="text-xs font-semibold text-brand-600 hover:underline">
                                <span x-text="copied ? '✓ Copied!' : 'Copy'"></span>
                            </button>
                        </div>
                        <div class="bg-slate-900 text-emerald-400 p-2.5 rounded font-mono text-[11px] break-all">
                            {{ $latestRelease->sha256_checksum ?? 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- 3-Step Simple Installation Guide -->
<section class="py-16 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12 space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-widest text-brand-600">Quick Setup</h2>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">How to Install in 3 Easy Steps</h3>
            <p class="text-slate-600 text-sm">Getting started takes less than a minute.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="sangfy-card p-6 space-y-4">
                <div class="w-10 h-10 rounded-md bg-brand-50 border border-brand-100 flex items-center justify-center font-extrabold text-brand-600 text-lg">
                    1
                </div>
                <h4 class="font-bold text-slate-900 text-base">Download the App</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Tap the <strong>Download Free App</strong> button above on your Android phone to download the installation file.
                </p>
            </div>

            <div class="sangfy-card p-6 space-y-4">
                <div class="w-10 h-10 rounded-md bg-brand-50 border border-brand-100 flex items-center justify-center font-extrabold text-brand-600 text-lg">
                    2
                </div>
                <h4 class="font-bold text-slate-900 text-base">Tap to Open & Install</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Open your downloaded file. If your phone asks for permission to install, simply tap <strong>Allow</strong>.
                </p>
            </div>

            <div class="sangfy-card p-6 space-y-4">
                <div class="w-10 h-10 rounded-md bg-brand-50 border border-brand-100 flex items-center justify-center font-extrabold text-brand-600 text-lg">
                    3
                </div>
                <h4 class="font-bold text-slate-900 text-base">Enjoy Private Chats</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Open Sangfy, choose your display name, and start chatting with friends with crystal-clear calls and complete privacy!
                </p>
            </div>

        </div>

    </div>
</section>

<!-- What's New & Updates -->
<section class="py-16 bg-white border-b border-slate-200" id="changelog">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12 space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-widest text-brand-600">App Updates</h2>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">What's New in This Version</h3>
        </div>

        <div class="space-y-6">
            <!-- Latest Version Card -->
            <div class="bg-white border-2 border-brand-200 rounded-lg p-6 sm:p-8 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <span class="text-xl font-bold text-slate-900 font-mono">{{ $latestRelease->version_name ?? 'v1.0.0' }}</span>
                        <span class="px-2.5 py-0.5 rounded bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold uppercase">Latest Version</span>
                    </div>
                    <span class="text-xs text-slate-400">{{ $latestRelease->created_at ? $latestRelease->created_at->format('M d, Y') : 'Recent' }}</span>
                </div>
                <div class="pt-4 text-sm text-slate-700 leading-relaxed space-y-2 font-sans">
                    {!! nl2br(e($latestRelease->changelog ?? "• Official Launch of Sangfy Android App\n• Image & Video Feed Posts\n• 24-Hour Stories (Moments)\n• Find Nearby People discovery radar\n• End-to-End Encrypted messaging & HD calling")) !!}
                </div>
            </div>

            <!-- Past Releases -->
            @foreach($pastReleases as $past)
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-6">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-800 text-base">{{ $past->version_name }}</span>
                            <span class="text-xs text-slate-500">({{ $past->file_size }})</span>
                        </div>
                        <span class="text-xs text-slate-400">{{ $past->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="pt-3 text-xs text-slate-600 leading-relaxed space-y-1">
                        {!! nl2br(e($past->changelog)) !!}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endsection
