@extends('layouts.app')

@section('title', 'About Us — Why We Built Sangfy')
@section('meta_description', 'Learn why Sangfy was built: to give everyone a simple, private, and ad-free messaging app where your personal conversations stay truly yours.')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-indigo-50 border border-indigo-100 text-brand-700 text-xs font-semibold">
            <i class="fa-solid fa-star text-brand-600"></i>
            <span>Our Story</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            Your Private Conversations Belong Only to You
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            We built Sangfy because we believe staying in touch with friends and family should be simple, fast, and completely free from ads and surveillance.
        </p>
    </div>
</section>

<!-- Story Section -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-900">Why Another Messaging App?</h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Most modern chat apps have become cluttered with advertisements, news feeds, and promotional messages. Worse, many platforms track who you talk to and what you search for to show you targeted ads.
                </p>
                <p class="text-sm text-slate-600 leading-relaxed">
                    We wanted something cleaner and more honest. An app that simply does what it's supposed to do: deliver your messages instantly, connect your calls in crystal clear HD, and protect your privacy without compromise.
                </p>
            </div>
            
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-6 space-y-4 shadow-xs">
                <div class="text-xs text-brand-600 font-bold uppercase tracking-wider">Our Core Commitments</div>
                <ul class="space-y-3 text-xs text-slate-700">
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm mt-0.5"></i>
                        <span><strong>Zero Advertisements:</strong> We will never interrupt your conversations with ads, banners, or popups.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm mt-0.5"></i>
                        <span><strong>Total Privacy:</strong> Only you and your friends can read your messages. Even Sangfy cannot see them.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-sm mt-0.5"></i>
                        <span><strong>100% Free:</strong> Unlimited text, voice notes, photos, and HD voice/video calls without hidden fees.</span>
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
