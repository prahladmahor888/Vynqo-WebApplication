@extends('layouts.app')

@section('title', 'About Sangfy — India\'s Premier Social Media & Dating Platform | Our Story')
@section('meta_description', 'Discover the story behind Sangfy: India\'s homegrown social media, Indian Instagram alternative & free dating app. Built with pride for 1.4 billion Indians to share, connect, and date safely without ads.')
@section('meta_keywords', 'About Sangfy, indian social media, indian instagram, dating app, indian dating app, made in india social network, sangfy story, desi social app')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-200/80 text-brand-700 text-xs font-semibold">
            <i class="fa-solid fa-flag text-brand-600"></i>
            <span>Proudly Made in India 🇮🇳</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            India's Own Platform for Sharing Moments, Dating &amp; Real Connection
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            We built Sangfy to give India an authentic social media experience and a genuine nearby dating app — free from commercial advertisements, fake profiles, and corporate data tracking.
        </p>
    </div>
</section>

<!-- Story Section -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">Why We Built Sangfy for India</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Over the last decade, global social media and foreign dating platforms have lost their soul. Feeds are saturated with sponsored ads, creators are suppressed by opaque commercial algorithms, and popular dating apps demand expensive weekly subscription paywalls just to say hello to someone nearby.
                </p>
                <p class="text-sm text-slate-600 leading-relaxed">
                    We envisioned something better: an <strong>Indian social media</strong> app and <strong>Indian Instagram alternative</strong> where sharing moments is joyful and organic, meeting new friends and dating matches nearby is completely free and safe, and your conversations are protected with military-grade 256-bit End-to-End Encryption.
                </p>
            </div>
            
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 space-y-4 shadow-xs">
                <div class="text-xs text-brand-600 font-bold uppercase tracking-wider">The Sangfy Difference</div>
                <ul class="space-y-3 text-xs text-slate-700">
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm mt-0.5"></i>
                        <span><strong>Zero Advertisements:</strong> We will never interrupt your feed, stories, or chats with sponsored popups or banner ads.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm mt-0.5"></i>
                        <span><strong>Free Nearby Dating Match Radar:</strong> Find real singles and friends within 1 km to 50 km in your Indian city without paying a single rupee.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm mt-0.5"></i>
                        <span><strong>Total Privacy &amp; Ghost Mode:</strong> Exact GPS coordinates are never revealed. Encrypted chats stay locked on your device.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm mt-0.5"></i>
                        <span><strong>Homegrown Indian Innovation:</strong> Built with pride for 1.4 billion Indian hearts.</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</section>

<!-- 4 Core Pillars -->
<section class="py-16 bg-slate-50 border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12 space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-widest text-brand-600">What We Stand For</h2>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Four Principles That Guide Us</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="sangfy-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-md bg-indigo-50 border border-indigo-100 flex items-center justify-center text-brand-600 font-bold text-lg">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base">Real Privacy</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    You shouldn't have to be a tech expert to be safe. Your chats are automatically locked the moment you type them.
                </p>
            </div>

            <div class="sangfy-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-md bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-lg">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base">Fast & Lightweight</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Under 45 MB in size. Opens instantly, uses very little battery, and works smoothly even on slow mobile internet.
                </p>
            </div>

            <div class="sangfy-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-md bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 font-bold text-lg">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base">You Own Your Identity</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Join interest clubs and public groups without having to share your personal phone number with strangers.
                </p>
            </div>

            <div class="sangfy-card p-6 space-y-3">
                <div class="w-10 h-10 rounded-md bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 font-bold text-lg">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-base">Made for Everyone</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Clean, simple, and friendly interface designed for people of all ages to connect effortlessly.
                </p>
            </div>

        </div>

    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
        <h3 class="text-2xl sm:text-3xl font-bold text-slate-900">Join thousands of happy users</h3>
        <p class="text-sm text-slate-600 max-w-lg mx-auto">Download Sangfy today and enjoy a clean, fast, and private messaging experience.</p>
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('download.apk') }}" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg">
                <i class="fa-solid fa-download"></i>
                <span>Download Free App for Android</span>
            </a>
            <a href="{{ route('features') }}" class="inline-flex items-center justify-center px-6 py-3.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-md transition">
                Explore Features
            </a>
        </div>
    </div>
</section>
@endsection
