@extends('layouts.app')

@section('title', 'Vynqo App Features — Feed Posts, 24h Stories, Nearby Radar & HD Calling')
@section('meta_description', 'Explore Vynqo Android App features: Post photos and videos, share 24-hour stories, find nearby people with distance filters, end-to-end encrypted chats, and HD voice/video calls.')

@section('content')
<!-- Hero Section -->
<section class="py-14 sm:py-20 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-purple-50 border border-purple-200/80 text-brand-700 text-xs font-semibold">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Vynqo" class="w-4 h-4 object-contain">
            <span>Official Vynqo App Feature Guide</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            Connect, Share, and Call with Complete Freedom
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Everything you need in one modern Android app: social media feed posts, 24-hour stories, nearby people discovery, and end-to-end encrypted messaging & calls.
        </p>
    </div>
</section>

<!-- Detailed Feature Breakdown -->
<section class="py-20 bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">
        
        <!-- Feature 1: Feed Posts & 24h Stories -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 space-y-4">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded bg-purple-50 text-brand-700 text-xs font-bold uppercase tracking-wider">
                    📸 Social Feed & Stories
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Post Photos, Videos & 24h Stories</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Share your favorite moments with your friends and followers. Post high-resolution photos and video clips with rich captions, hashtags, likes, and real-time comments. Plus, share quick 24-hour stories that automatically disappear after a day.
                </p>
                <div class="space-y-2.5 pt-2">
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-pink-600 font-bold text-sm">✓</span>
                        <span>High-resolution image and video post sharing without compression loss</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-pink-600 font-bold text-sm">✓</span>
                        <span>24-Hour Stories that automatically vanish after 24 hours</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-pink-600 font-bold text-sm">✓</span>
                        <span>Real-time likes, emojis, comment threads, and profile galleries</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-6">
                <div class="vynqo-card p-6 bg-slate-50 border border-slate-200 rounded-lg space-y-3">
                    <div class="flex items-center justify-between text-xs text-slate-500 pb-2 border-b border-slate-200">
                        <span class="font-bold text-slate-900">📸 Moments & Feed</span>
                        <span class="bg-pink-50 text-pink-700 px-2 py-0.5 rounded font-bold">Social Suite</span>
                    </div>
                    <div class="p-3 bg-white rounded border border-slate-200 text-xs space-y-1">
                        <div class="font-bold text-slate-900">⏳ Ephemeral 24h Stories</div>
                        <p class="text-slate-600 text-[11px]">Post quick updates, daily snapshots, and short clips that keep your feed fresh and authentic.</p>
                    </div>
                    <div class="p-3 bg-white rounded border border-slate-200 text-xs space-y-1">
                        <div class="font-bold text-slate-900">🎨 Rich Media Feed</div>
                        <p class="text-slate-600 text-[11px]">Clean chronological feed with no sponsored advertisements or commercial algorithms.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature 2: Find Nearby People (Discovery Radar) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 lg:order-2 space-y-4">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider">
                    📍 Nearby Discovery
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Discover & Connect with People Nearby</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Looking to meet new people who share your hobbies nearby? Vynqo's Nearby People feature lets you find active users around your area based on customizable distance preferences (e.g. 1 km to 25 km) and interest tags.
                </p>
                <div class="space-y-2.5 pt-2">
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-emerald-600 font-bold text-sm">✓</span>
                        <span>Find genuine people nearby based on custom distance & hobby filters</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-emerald-600 font-bold text-sm">✓</span>
                        <span>Location Privacy: Exact GPS coordinates are never publicly shared</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-emerald-600 font-bold text-sm">✓</span>
                        <span>Ghost / Incognito Mode toggle to browse privately without appearing on radar</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-6 lg:order-1">
                <div class="vynqo-card p-6 bg-slate-50 border border-slate-200 rounded-lg space-y-4">
                    <div class="flex justify-between items-center text-xs font-bold text-slate-800 pb-3 border-b border-slate-200">
                        <span>Nearby Radar Controls</span>
                        <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Privacy First</span>
                    </div>
                    <div class="space-y-3 text-xs">
                        <div class="p-3 bg-white rounded border border-slate-200">
                            <div class="font-bold text-slate-900 mb-1">🎯 Custom Distance Radius</div>
                            <p class="text-slate-600 text-[11px]">Set your radar distance from 500 meters to 25 km to connect at your own comfort level.</p>
                        </div>
                        <div class="p-3 bg-white rounded border border-slate-200">
                            <div class="font-bold text-slate-900 mb-1">👻 Ghost Mode</div>
                            <p class="text-slate-600 text-[11px]">Turn off your location visibility with one tap in settings whenever you want total privacy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature 3: End-to-End Encrypted Private Chats -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 space-y-4">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded bg-indigo-50 text-brand-700 text-xs font-bold uppercase tracking-wider">
                    🔒 Private Chatting
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">End-to-End Encrypted Messaging</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Your 1-on-1 private messages are locked on your device before sending. Send text, high-quality audio notes, stickers, photos, videos, and documents up to 2 GB with complete peace of mind.
                </p>
                <div class="space-y-2.5 pt-2">
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-brand-600 font-bold text-sm">✓</span>
                        <span>Automatic End-to-End Encryption — no one in between can read your chats</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-brand-600 font-bold text-sm">✓</span>
                        <span>View-Once photos and videos that vanish immediately after being opened</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-brand-600 font-bold text-sm">✓</span>
                        <span>Voice message wave previews and instant delivery receipts</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-6">
                <div class="vynqo-card p-6 bg-white border border-slate-200 rounded-lg space-y-3 shadow-xs">
                    <div class="flex items-center justify-between text-xs text-slate-500 pb-2 border-b border-slate-100">
                        <span class="font-bold text-slate-900">🔐 Direct Chat Security</span>
                        <span class="bg-indigo-50 text-brand-700 px-2 py-0.5 rounded font-bold">E2EE Active</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded text-xs space-y-1 border border-slate-200">
                        <div class="font-bold text-slate-800">✨ Disappearing View-Once Media</div>
                        <p class="text-slate-600 text-[11px]">Send photos that can only be viewed once with screenshot prevention protection.</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded text-xs space-y-1 border border-slate-200">
                        <div class="font-bold text-slate-800">🎙️ Instant Audio Notes</div>
                        <p class="text-slate-600 text-[11px]">High-fidelity voice messages with noise suppression and wave playback.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature 4: HD Voice & Video Calling -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 lg:order-2 space-y-4">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider">
                    📞 HD Voice & Video
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Crystal Clear HD Voice & 1080p Video Calls</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Powered by an embedded Agora RTC engine, Vynqo delivers studio-grade voice calls and smooth 1080p 60fps video with sub-100ms latency. Calls connect instantly and stay stable even on low mobile internet.
                </p>
                <div class="space-y-2.5 pt-2">
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-blue-600 font-bold text-sm">✓</span>
                        <span>Free unlimited voice and video calls worldwide</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-blue-600 font-bold text-sm">✓</span>
                        <span>Smart background noise suppression for crisp audio</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">
                        <span class="text-blue-600 font-bold text-sm">✓</span>
                        <span>Adaptive bitrate to prevent dropped calls on 3G and 4G networks</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-6 lg:order-1">
                <div class="vynqo-card p-6 bg-slate-50 border border-slate-200 rounded-lg space-y-3">
                    <div class="flex items-center justify-between text-xs text-slate-500 pb-2 border-b border-slate-200">
                        <span class="font-bold text-slate-900">📞 Calling Specs</span>
                        <span class="bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded font-bold">1080p HD</span>
                    </div>
                    <div class="p-3 bg-white rounded border border-slate-200 text-xs space-y-1">
                        <div class="font-bold text-slate-900">⚡ Agora RTC Realtime Engine</div>
                        <p class="text-slate-600 text-[11px]">Sub-100ms ultra-low latency audio & video streaming.</p>
                    </div>
                    <div class="p-3 bg-white rounded border border-slate-200 text-xs space-y-1">
                        <div class="font-bold text-slate-900">🔒 Point-to-Point Encryption</div>
                        <p class="text-slate-600 text-[11px]">Encrypted media streams with zero server call recording.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Bottom CTA Banner -->
<section class="py-16 bg-slate-50 text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Ready to start sharing and connecting?</h3>
        <p class="text-sm text-slate-600 max-w-lg mx-auto">Download the Vynqo Android App for free and connect with people near you today.</p>
        <div>
            <a href="{{ route('download.apk') }}" class="inline-flex items-center gap-2 px-8 py-3.5 text-base font-bold text-white btn-vynqo rounded-md shadow-md transition hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Download Free APK for Android</span>
            </a>
        </div>
    </div>
</section>
@endsection
