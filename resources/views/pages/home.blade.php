@extends('layouts.app')

@section('title', 'Sangfy — Social Media, Stories, Nearby People & Private HD Calling')
@section('meta_description', 'Official Sangfy Android App. Share image/video posts, post 24h stories, discover nearby people with custom filters, and enjoy end-to-end encrypted messaging and HD calls with zero ads.')

@section('content')
<!-- Hero Section -->
<section class="relative pt-12 pb-16 lg:pt-18 lg:pb-24 overflow-hidden hero-glow-bg border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Left Hero Text & CTAs -->
            <div class="lg:col-span-7 text-center lg:text-left space-y-6">
                
                <!-- Status Badge with Heart Logo & Live Download Counter -->
                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-purple-50 border border-purple-200/80 text-brand-700 text-xs font-semibold shadow-xs">
                    <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" alt="{{ $siteName ?? 'Sangfy' }} Icon" class="w-4 h-4 object-contain">
                    <span>{{ $siteSettings['hero_badge_text'] ?? 'The Social App Built for Real Connection' }}</span>
                    <span class="text-purple-300">•</span>
                    <span>{{ $latestRelease->version_name ?? 'v1.0.0' }}</span>
                    <span class="text-purple-300">•</span>
                    <span class="text-emerald-700 font-bold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ number_format($totalPublicDownloads ?? $latestRelease->download_count ?? 1250) }} Downloads
                    </span>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.15]">
                    @if(!empty($siteSettings['hero_title']))
                        {!! nl2br(e($siteSettings['hero_title'])) !!}
                    @else
                        Share Moments.<br>
                        <span class="gradient-text">Discover Nearby & Chat Privately.</span>
                    @endif
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    {{ $siteSettings['hero_subtitle'] ?? 'Post photos & videos, share 24-hour stories, find genuine people nearby on your own terms, and enjoy end-to-end encrypted chats & free HD video calls.' }}
                </p>

                <!-- Action CTAs -->
                <div class="space-y-3">
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        @if(($siteSettings['direct_apk_enabled'] ?? '1') == '1')
                            <a href="{{ route('download.apk') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-7 py-4 text-base font-bold text-white btn-sangfy rounded-md shadow-md transition hover:shadow-lg group">
                                <i class="fa-solid fa-download text-lg group-hover:-translate-y-0.5 transition"></i>
                                <span>{{ $siteSettings['hero_cta_text'] ?? 'Download Free for Android' }}</span>
                                <span class="text-xs bg-white/20 px-2 py-0.5 rounded font-normal text-white">{{ $latestRelease->file_size ?? '30 MB' }}</span>
                            </a>
                        @else
                            <a href="{{ route('download.page') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-7 py-4 text-base font-bold text-white btn-sangfy rounded-md shadow-md transition hover:shadow-lg group">
                                <i class="fa-solid fa-download text-lg"></i>
                                <span>Get {{ $siteName ?? 'Sangfy' }} App</span>
                            </a>
                        @endif
                        
                        <a href="{{ route('features') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-4 text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-md transition hover:border-slate-400">
                            <span>Explore All Features</span>
                            <i class="fa-solid fa-arrow-right text-slate-400 text-xs"></i>
                        </a>
                    </div>
                    
                    <!-- Verified Social Proof Stats -->
                    <div class="flex items-center justify-center lg:justify-start gap-3 text-xs text-slate-500 font-medium">
                        <span class="flex items-center gap-1.5 font-bold text-slate-800">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            {{ number_format($totalPublicDownloads ?? $latestRelease->download_count ?? 1250) }}+ Verified Downloads
                        </span>
                        <span>•</span>
                        <span>Android 8.0 to 15 Ready</span>
                    </div>
                </div>

                <!-- Feature Highlights Badges -->
                <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs font-semibold text-slate-600">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-camera-retro text-pink-500"></i> Posts & 24h Stories
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-emerald-500"></i> Find Nearby People
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-purple-500"></i> End-to-End Encrypted
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-phone-volume text-indigo-500"></i> Free HD Calls
                    </span>
                </div>
            </div>

            <!-- Right Interactive Phone Mockup with Social Tabs -->
            <div class="lg:col-span-5 flex justify-center" x-data="{ tab: 'feed' }">
                <div class="w-full max-w-[340px] space-y-3">
                    
                    <!-- Tab Selector Switcher -->
                    <div class="flex items-center justify-center p-1 bg-slate-100 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600">
                        <button @click="tab = 'feed'" :class="tab === 'feed' ? 'bg-white text-brand-700 shadow-xs' : 'hover:text-slate-900'" class="flex-1 py-1.5 rounded-md transition text-center flex items-center justify-center gap-1">
                            <i class="fa-solid fa-images text-xs"></i>
                            <span>Feed</span>
                        </button>
                        <button @click="tab = 'nearby'" :class="tab === 'nearby' ? 'bg-white text-brand-700 shadow-xs' : 'hover:text-slate-900'" class="flex-1 py-1.5 rounded-md transition text-center flex items-center justify-center gap-1">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                            <span>Nearby</span>
                        </button>
                        <button @click="tab = 'chat'" :class="tab === 'chat' ? 'bg-white text-brand-700 shadow-xs' : 'hover:text-slate-900'" class="flex-1 py-1.5 rounded-md transition text-center flex items-center justify-center gap-1">
                            <i class="fa-solid fa-comments text-xs"></i>
                            <span>Chat</span>
                        </button>
                        <button @click="tab = 'call'" :class="tab === 'call' ? 'bg-white text-brand-700 shadow-xs' : 'hover:text-slate-900'" class="flex-1 py-1.5 rounded-md transition text-center flex items-center justify-center gap-1">
                            <i class="fa-solid fa-phone text-xs"></i>
                            <span>Call</span>
                        </button>
                    </div>

                    <!-- Phone Frame -->
                    <div class="mockup-device bg-slate-950 p-2 shadow-2xl">
                        <div class="mockup-camera-notch"></div>
                        
                        <!-- Phone Screen -->
                        <div class="bg-slate-900 rounded-[28px] h-[520px] overflow-hidden flex flex-col text-slate-100 relative">
                            
                            <!-- Phone Top Status Bar -->
                            <div class="pt-3 px-5 pb-2 flex justify-between items-center text-[11px] text-slate-400 font-medium z-20">
                                <span>09:41</span>
                                <div class="flex items-center gap-1.5">
                                    <span>5G</span>
                                    <span class="flex items-center gap-1"><i class="fa-solid fa-location-dot text-emerald-400"></i> Nearby ON</span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                                </div>
                            </div>

                            <!-- TAB 1: SOCIAL FEED & STORIES VIEW -->
                            <div x-show="tab === 'feed'" class="flex-1 flex flex-col justify-between p-3 space-y-2 overflow-y-auto">
                                <!-- Top Bar with Logo -->
                                <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                                    <div class="flex items-center gap-1.5">
                                        <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" alt="{{ $siteName ?? 'Sangfy' }}" class="w-6 h-6 object-contain">
                                        <span class="font-extrabold text-sm text-white">{{ $siteName ?? 'Sangfy' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-slate-300">
                                        <button class="hover:text-pink-400 p-1"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        <button class="hover:text-pink-400 p-1"><i class="fa-solid fa-bell"></i></button>
                                    </div>
                                </div>

                                <!-- Stories Bar -->
                                <div class="flex items-center gap-2.5 pb-2 overflow-x-auto border-b border-slate-800/80">
                                    <div class="flex flex-col items-center gap-1 text-[10px] text-slate-300">
                                        <div class="w-11 h-11 rounded-full bg-slate-800 border-2 border-dashed border-pink-500 flex items-center justify-center text-sm font-bold text-pink-400">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                        </div>
                                        <span>Your Story</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1 text-[10px] text-slate-300">
                                        <div class="w-11 h-11 rounded-full p-0.5 bg-gradient-to-tr from-purple-600 to-pink-500">
                                            <div class="w-full h-full rounded-full bg-slate-800 flex items-center justify-center font-bold text-xs">
                                                RS
                                            </div>
                                        </div>
                                        <span>Riya</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1 text-[10px] text-slate-300">
                                        <div class="w-11 h-11 rounded-full p-0.5 bg-gradient-to-tr from-purple-600 to-pink-500">
                                            <div class="w-full h-full rounded-full bg-slate-800 flex items-center justify-center font-bold text-xs">
                                                AK
                                            </div>
                                        </div>
                                        <span>Aman</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1 text-[10px] text-slate-300">
                                        <div class="w-11 h-11 rounded-full p-0.5 bg-gradient-to-tr from-purple-600 to-pink-500">
                                            <div class="w-full h-full rounded-full bg-slate-800 flex items-center justify-center font-bold text-xs">
                                                SJ
                                            </div>
                                        </div>
                                        <span>Sarah</span>
                                    </div>
                                </div>

                                <!-- Feed Post Card -->
                                <div class="bg-slate-800/80 rounded-xl p-3 space-y-2.5 border border-slate-700/50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-purple-600 to-pink-500 flex items-center justify-center font-bold text-[10px] text-white">
                                                RS
                                            </div>
                                            <div>
                                                <div class="font-bold text-xs text-white">Riya Sharma</div>
                                                <div class="text-[9px] text-slate-400">2 hours ago • Mumbai</div>
                                            </div>
                                        </div>
                                        <button class="text-xs text-slate-400"><i class="fa-solid fa-ellipsis"></i></button>
                                    </div>

                                    <!-- Post Image Graphic Mockup -->
                                    <div class="rounded-lg h-36 bg-gradient-to-br from-purple-900/60 via-pink-900/40 to-slate-900 flex flex-col items-center justify-center text-center p-3 border border-purple-500/20">
                                        <div class="flex items-center gap-2 text-2xl mb-1 text-pink-400">
                                            <i class="fa-solid fa-mountain-sun"></i>
                                            <i class="fa-solid fa-camera"></i>
                                        </div>
                                        <span class="text-[11px] font-semibold text-purple-200">Weekend Sunset & Nature Hike</span>
                                        <span class="text-[9px] text-pink-300">High-Resolution Media Post</span>
                                    </div>

                                    <!-- Post Actions -->
                                    <div class="flex items-center justify-between pt-1 text-xs">
                                        <div class="flex items-center gap-3">
                                            <span class="flex items-center gap-1.5 text-pink-400 font-semibold cursor-pointer"><i class="fa-solid fa-heart"></i> 1.4k</span>
                                            <span class="flex items-center gap-1.5 text-slate-300 cursor-pointer"><i class="fa-solid fa-comment"></i> 128</span>
                                            <span class="text-slate-300 cursor-pointer"><i class="fa-solid fa-share-nodes"></i></span>
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-mono">#photography #nature</span>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: FIND NEARBY PEOPLE VIEW -->
                            <div x-show="tab === 'nearby'" style="display:none;" class="flex-1 flex flex-col justify-between p-3 space-y-2 overflow-y-auto">
                                <div class="pb-2 border-b border-slate-800 flex justify-between items-center">
                                    <div>
                                        <span class="font-bold text-xs text-white flex items-center gap-1"><i class="fa-solid fa-location-dot text-pink-500"></i> People Nearby</span>
                                        <span class="text-[10px] text-emerald-400 block">Radius: Within 5 km</span>
                                    </div>
                                    <span class="text-[10px] bg-purple-900/60 border border-purple-500/40 text-purple-300 px-2 py-0.5 rounded-full">Radar Active</span>
                                </div>

                                <div class="space-y-2 text-xs">
                                    <!-- Nearby User 1 -->
                                    <div class="bg-slate-800/80 p-2.5 rounded-lg border border-slate-700/50 flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-purple-600 to-pink-500 flex items-center justify-center font-bold text-xs text-white">
                                                RS
                                            </div>
                                            <div>
                                                <div class="font-bold text-xs text-white flex items-center gap-1">
                                                    Riya, 24
                                                    <span class="text-[9px] bg-emerald-950 text-emerald-400 px-1.5 py-0.2 rounded">1.2 km</span>
                                                </div>
                                                <div class="text-[10px] text-slate-400 flex items-center gap-1.5">
                                                    <span><i class="fa-solid fa-camera text-pink-400 text-[9px]"></i> Photography</span>
                                                    <span>•</span>
                                                    <span><i class="fa-solid fa-mug-saucer text-amber-400 text-[9px]"></i> Coffee</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="px-2.5 py-1 rounded bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold text-[11px]">Chat</button>
                                    </div>

                                    <!-- Nearby User 2 -->
                                    <div class="bg-slate-800/80 p-2.5 rounded-lg border border-slate-700/50 flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-500 flex items-center justify-center font-bold text-xs text-white">
                                                AV
                                            </div>
                                            <div>
                                                <div class="font-bold text-xs text-white flex items-center gap-1">
                                                    Aman, 26
                                                    <span class="text-[9px] bg-emerald-950 text-emerald-400 px-1.5 py-0.2 rounded">2.4 km</span>
                                                </div>
                                                <div class="text-[10px] text-slate-400 flex items-center gap-1.5">
                                                    <span><i class="fa-solid fa-laptop-code text-cyan-400 text-[9px]"></i> Tech</span>
                                                    <span>•</span>
                                                    <span><i class="fa-solid fa-gamepad text-purple-400 text-[9px]"></i> Gaming</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="px-2.5 py-1 rounded bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold text-[11px]">Chat</button>
                                    </div>

                                    <!-- Nearby User 3 -->
                                    <div class="bg-slate-800/80 p-2.5 rounded-lg border border-slate-700/50 flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-pink-600 to-rose-500 flex items-center justify-center font-bold text-xs text-white">
                                                PP
                                            </div>
                                            <div>
                                                <div class="font-bold text-xs text-white flex items-center gap-1">
                                                    Pooja, 23
                                                    <span class="text-[9px] bg-emerald-950 text-emerald-400 px-1.5 py-0.2 rounded">3.1 km</span>
                                                </div>
                                                <div class="text-[10px] text-slate-400 flex items-center gap-1.5">
                                                    <span><i class="fa-solid fa-plane text-sky-400 text-[9px]"></i> Travel</span>
                                                    <span>•</span>
                                                    <span><i class="fa-solid fa-headphones text-indigo-400 text-[9px]"></i> Music</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="px-2.5 py-1 rounded bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold text-[11px]">Chat</button>
                                    </div>
                                </div>

                                <div class="bg-slate-800 rounded-lg p-2 text-[10px] text-center text-slate-400 border border-slate-700 flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                                    <span>Approximate distance only — Exact GPS is never shared</span>
                                </div>
                            </div>

                            <!-- TAB 3: E2EE CHAT VIEW -->
                            <div x-show="tab === 'chat'" style="display:none;" class="flex-1 flex flex-col justify-between p-3 space-y-3">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-purple-600 to-pink-500 flex items-center justify-center font-bold text-white text-xs">
                                            RS
                                        </div>
                                        <div>
                                            <div class="font-bold text-xs text-white flex items-center gap-1">
                                                Riya Sharma
                                                <i class="fa-solid fa-heart text-purple-400 text-[10px]"></i>
                                            </div>
                                            <div class="text-[10px] text-emerald-400 flex items-center gap-1"><i class="fa-solid fa-lock text-[9px]"></i> E2EE Locked</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-300">
                                        <button class="p-1 hover:text-white" title="Voice Call"><i class="fa-solid fa-phone text-xs"></i></button>
                                        <button class="p-1 hover:text-white" title="Video Call"><i class="fa-solid fa-video text-xs"></i></button>
                                    </div>
                                </div>

                                <div class="flex-1 space-y-2 text-xs overflow-y-auto pr-1">
                                    <div class="chat-bubble-in max-w-[85%] p-2.5 text-slate-900 bg-slate-100">
                                        <p>Hey! Saw your post on the feed. Loved the sunset picture! <i class="fa-solid fa-mountain-sun text-amber-500"></i></p>
                                        <span class="text-[9px] text-slate-500 block text-right mt-1">09:38 AM</span>
                                    </div>

                                    <div class="chat-bubble-out max-w-[85%] ml-auto p-2.5 bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                                        <p>Thank you! Took it yesterday during the hike.</p>
                                        <span class="text-[9px] text-purple-200 block text-right mt-1">09:39 AM <i class="fa-solid fa-check-double text-[9px]"></i></span>
                                    </div>

                                    <div class="chat-bubble-out max-w-[85%] ml-auto p-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white flex items-center gap-2">
                                        <i class="fa-solid fa-eye-slash text-base text-pink-300"></i>
                                        <div class="text-left">
                                            <div class="font-bold text-[11px]">Photo (View Once)</div>
                                            <div class="text-[9px] text-purple-200">Disappears after viewing</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-slate-800 rounded-lg p-1.5 flex items-center gap-2 text-xs">
                                    <i class="fa-regular fa-face-smile text-slate-400 pl-1 text-sm"></i>
                                    <span class="flex-1 text-slate-400 text-[11px]">Encrypted message...</span>
                                    <button class="w-6 h-6 rounded-md bg-gradient-to-r from-purple-600 to-pink-500 flex items-center justify-center text-white text-xs"><i class="fa-solid fa-paper-plane text-[10px]"></i></button>
                                </div>
                            </div>

                            <!-- TAB 4: HD CALL VIEW -->
                            <div x-show="tab === 'call'" style="display:none;" class="flex-1 flex flex-col justify-between p-4 bg-slate-900 text-center">
                                <div class="pt-6 space-y-2">
                                    <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-purple-600 to-pink-500 border-2 border-purple-400 mx-auto flex items-center justify-center text-3xl shadow-lg text-white">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <h3 class="font-bold text-white text-base">Riya Sharma</h3>
                                    <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-emerald-950/80 border border-emerald-500/40 text-emerald-400 text-[11px] font-medium">
                                        <span>● Agora RTC 1080p HD Call</span>
                                    </div>
                                    <p class="text-xs text-slate-300 font-mono">03:42</p>
                                </div>

                                <div class="bg-slate-800/90 rounded-lg p-3 text-left space-y-1.5 border border-slate-700/50">
                                    <div class="flex justify-between text-xs text-slate-300">
                                        <span>Call Quality</span>
                                        <span class="text-emerald-400 font-semibold">Crystal Clear 1080p</span>
                                    </div>
                                    <div class="flex justify-between text-xs text-slate-300">
                                        <span>Encryption</span>
                                        <span class="text-pink-300 font-semibold">End-to-End SRTP</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-center gap-5 pb-4">
                                    <button class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-200 text-sm hover:bg-slate-700"><i class="fa-solid fa-microphone-slash"></i></button>
                                    <button class="w-12 h-12 rounded-full bg-rose-600 flex items-center justify-center text-white text-base font-bold shadow-lg hover:bg-rose-500"><i class="fa-solid fa-phone-slash"></i></button>
                                    <button class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-200 text-sm hover:bg-slate-700"><i class="fa-solid fa-volume-high"></i></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Simple Key Specs Bar -->
<section class="py-8 bg-slate-50 border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="space-y-1">
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">Posts & Stories</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Images, Videos & 24h Moments</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">Find Nearby</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Custom Distance Discovery</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">100% E2EE Chats</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Locked Direct Messaging</div>
            </div>
            <div class="space-y-1">
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">Free HD Calling</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Voice & 1080p Video</div>
            </div>
        </div>
    </div>
</section>

<!-- Core App Features Grid (Strictly Sangfy Social Media + Messaging) -->
<section class="py-20 bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <h2 class="text-xs font-bold uppercase tracking-widest text-brand-600">All-in-One Social & Chat</h2>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Everything You Can Do in Sangfy</h3>
            <p class="text-slate-600 text-base">From sharing daily moments to meeting people nearby and private video calling.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($features as $feature)
                <div class="sangfy-card p-6 flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-md bg-purple-50 border border-purple-100 flex items-center justify-center text-brand-600 font-bold group-hover:scale-105 transition">
                                @if($feature['icon'] === 'camera')
                                    <i class="fa-solid fa-camera text-base"></i>
                                @elseif($feature['icon'] === 'clock')
                                    <i class="fa-solid fa-hourglass-half text-base"></i>
                                @elseif($feature['icon'] === 'map-pin')
                                    <i class="fa-solid fa-location-dot text-base"></i>
                                @elseif($feature['icon'] === 'lock')
                                    <i class="fa-solid fa-lock text-base"></i>
                                @elseif($feature['icon'] === 'video')
                                    <i class="fa-solid fa-video text-base"></i>
                                @else
                                    <i class="fa-solid fa-shield-halved text-base"></i>
                                @endif
                            </div>
                            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded bg-purple-50 text-brand-700 border border-purple-200/60">
                                {{ $feature['badge'] }}
                            </span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">{{ $feature['title'] }}</h4>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $feature['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('features') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 transition">
                <span>See in-depth feature details</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>

<!-- Direct Download Box -->
<section class="py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-purple-200/80 rounded-lg p-8 sm:p-12 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                
                <div class="md:col-span-8 space-y-3 text-left">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-purple-50 text-brand-700 text-xs font-bold uppercase tracking-wide border border-purple-200">
                        Official Android App (com.prahlix.sangfy)
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Install Sangfy on Your Android Phone</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Get the latest release <strong>{{ $latestRelease->version_name ?? 'v1.0.0' }}</strong> ({{ $latestRelease->file_size ?? '30 MB' }}). Join <strong>{{ number_format($totalPublicDownloads ?? $latestRelease->download_count ?? 1250) }}+ users</strong> sharing photos, 24h stories, and enjoying free private HD calls.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-4 text-xs text-slate-600 font-medium">
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i> Works on Android 8.0 to Android 15</span>
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i> 100% Free • No Ads</span>
                        <span class="text-emerald-700 font-bold flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i> {{ number_format($totalPublicDownloads ?? $latestRelease->download_count ?? 1250) }} Verified Installs</span>
                    </div>
                </div>

                <div class="md:col-span-4 flex flex-col items-stretch sm:items-end justify-center space-y-3">
                    <a href="{{ route('download.apk') }}" class="w-full inline-flex items-center justify-center gap-2.5 px-6 py-4 text-base font-bold text-white btn-sangfy rounded-md shadow-md transition hover:shadow-lg">
                        <i class="fa-solid fa-download text-lg"></i>
                        <span>Download Free APK</span>
                    </a>
                    <a href="{{ route('download.page') }}" class="text-xs font-semibold text-slate-600 hover:text-brand-600 text-center w-full transition inline-flex items-center justify-center gap-1">
                        <span>Installation Guide & Notes</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Frequently Asked Questions Section -->
<section class="py-20 bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-14 space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-widest text-brand-600">Common Questions</h2>
            <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Frequently Asked Questions</h3>
            <p class="text-slate-600 text-sm">Everything you need to know about using Sangfy.</p>
        </div>

        <div class="space-y-4" x-data="{ activeAccordion: 0 }">
            @foreach($faqs as $index => $faq)
                <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                    <button @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}" class="w-full px-6 py-4 text-left flex items-center justify-between font-semibold text-slate-900 hover:text-brand-600 transition">
                        <span class="text-base">{{ $faq['question'] }}</span>
                        <i :class="activeAccordion === {{ $index }} ? 'rotate-180 text-brand-600' : 'text-slate-400'" class="fa-solid fa-chevron-down transform transition-transform duration-200 flex-shrink-0 text-sm"></i>
                    </button>
                    <div x-show="activeAccordion === {{ $index }}" x-transition class="px-6 pb-4 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        {{ $faq['answer'] }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10 text-center text-xs text-slate-500">
            Have questions or suggestions? <a href="{{ route('contact') }}" class="font-semibold text-brand-600 hover:underline">Contact our Support Team</a>.
        </div>

    </div>
</section>
@endsection
