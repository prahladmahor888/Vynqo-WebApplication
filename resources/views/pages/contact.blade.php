@extends('layouts.app')

@section('title', 'Contact & Android App Support — Sangfy')
@section('meta_description', 'Official support portal for the Sangfy Android App (com.prahlix.sangfy). Get help with app installation, camera/microphone permissions, notifications, or account support.')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-indigo-50 border border-indigo-100 text-brand-700 text-xs font-semibold">
            <i class="fa-solid fa-envelope"></i>
            <span>{{ $siteSettings['support_badge_text'] ?? 'Official Android App Support' }}</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            {{ $siteSettings['support_title'] ?? 'How Can We Help You?' }}
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            {{ $siteSettings['support_subtitle'] ?? ('Need help with your ' . ($siteName ?? 'Sangfy') . ' Android App (' . ($siteSettings['android_package_name'] ?? 'com.prahlix.sangfy') . '), have feedback, or want to report an issue? Our team is here to assist.') }}
        </p>
    </div>
</section>

<!-- Quick Android Troubleshooting Help -->
<section class="py-10 bg-slate-50 border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div class="p-4 bg-white rounded-lg border border-slate-200 space-y-1">
                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                    <i class="fa-solid fa-bell text-brand-600"></i>
                    <span>Notification Help</span>
                </div>
                <p class="text-slate-600">On Android 13+, ensure you have allowed notifications in <em>Settings &gt; Apps &gt; {{ $siteName ?? 'Sangfy' }} &gt; Notifications</em>.</p>
            </div>
            <div class="p-4 bg-white rounded-lg border border-slate-200 space-y-1">
                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                    <i class="fa-solid fa-microphone text-brand-600"></i>
                    <span>Call & Mic Access</span>
                </div>
                <p class="text-slate-600">For crystal-clear HD calling, enable Microphone & Camera permissions when prompted.</p>
            </div>
            <div class="p-4 bg-white rounded-lg border border-slate-200 space-y-1">
                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                    <i class="fa-solid fa-trash-can text-rose-500"></i>
                    <span>Account Deletion</span>
                </div>
                <p class="text-slate-600">Permanently delete your account inside the app via <em>Settings &gt; Privacy &gt; Delete My Account</em>.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Channel Grid -->
<section class="py-16 sm:py-20 bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left Contact Channels Info -->
            <div class="lg:col-span-5 space-y-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-200 text-brand-700 text-xs font-bold">
                        <i class="fa-solid fa-headset text-brand-600"></i>
                        <span>Support Channels</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Direct Assistance</h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Choose the most relevant channel for your inquiry to ensure the fastest response from our engineering team.
                    </p>
                </div>

                <div class="space-y-3.5">
                    <!-- Customer Support Card -->
                    <div class="p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 hover:border-purple-300 transition shadow-xs space-y-2 group">
                        <div class="flex items-center justify-between">
                            <div class="font-bold text-slate-900 text-sm flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-purple-50 text-brand-600 flex items-center justify-center text-xs font-bold shrink-0 border border-purple-100">
                                    <i class="fa-solid fa-comments"></i>
                                </span>
                                <span>Customer &amp; Technical Support</span>
                            </div>
                            <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Online</span>
                        </div>
                        <p class="text-xs text-slate-500 pl-10.5">For account recovery, APK installation bugs, or general app assistance.</p>
                        <div class="pl-10.5 pt-1">
                            <a href="mailto:{{ $siteSettings['contact_email'] ?? 'support@prahlix.com' }}" class="text-xs font-bold text-brand-600 hover:text-brand-800 underline inline-flex items-center gap-1.5">
                                <i class="fa-regular fa-envelope text-xs"></i>
                                <span>{{ $siteSettings['contact_email'] ?? 'support@prahlix.com' }}</span>
                            </a>
                            @if(!empty($siteSettings['support_hours']))
                                <div class="text-[11px] text-slate-400 mt-1 flex items-center gap-1.5">
                                    <i class="fa-regular fa-clock text-slate-400"></i>
                                    <span>{{ $siteSettings['support_hours'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(!empty($siteSettings['contact_phone']))
                    <!-- Phone Helpline Card -->
                    <div class="p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 hover:border-emerald-300 transition shadow-xs space-y-2 group">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0 border border-emerald-100">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <span>Direct Helpline</span>
                        </div>
                        <p class="text-xs text-slate-500 pl-10.5">Speak directly to our customer assistance and safety desk.</p>
                        <div class="pl-10.5 pt-1">
                            <a href="tel:{{ $siteSettings['contact_phone'] }}" class="text-xs font-bold text-slate-800 hover:text-brand-600 transition">
                                {{ $siteSettings['contact_phone'] }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if(!empty($siteSettings['company_address']))
                    <!-- Registered Office Card -->
                    <div class="p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 shadow-xs space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-bold shrink-0 border border-slate-200">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                            <span>Registered Headquarters</span>
                        </div>
                        <p class="text-xs text-slate-600 pl-10.5 leading-relaxed">{{ $siteSettings['company_address'] }}</p>
                    </div>
                    @endif

                    <!-- Privacy & Security Desk Card -->
                    <div class="p-4 sm:p-5 bg-white rounded-2xl border border-slate-200 hover:border-purple-300 transition shadow-xs space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xs font-bold shrink-0 border border-purple-100">
                                <i class="fa-solid fa-shield-halved"></i>
                            </span>
                            <span>Privacy &amp; Security Desk</span>
                        </div>
                        <p class="text-xs text-slate-500 pl-10.5">For DPDP/GDPR deletion requests, encryption inquiries, and bug disclosures.</p>
                        <div class="pl-10.5 pt-1">
                            <a href="mailto:{{ $siteSettings['privacy_email'] ?? ($siteSettings['contact_email'] ?? 'support@prahlix.com') }}" class="text-xs font-bold text-brand-600 hover:text-brand-800 underline inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-lock text-xs"></i>
                                <span>{{ $siteSettings['privacy_email'] ?? ($siteSettings['contact_email'] ?? 'support@prahlix.com') }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Social Channels Card -->
                    <div class="p-4 sm:p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-2.5">
                        <div class="font-bold text-slate-900 text-xs flex items-center gap-2">
                            <i class="fa-solid fa-globe text-brand-600"></i>
                            <span>Official Community &amp; Announcements</span>
                        </div>
                        <p class="text-[11px] text-slate-500">Follow official Sangfy channels for updates, releases, and guides:</p>
                        
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            @if(!empty($siteSettings['social_instagram']))
                                <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" title="Instagram" class="social-icon-btn btn-instagram w-8 h-8 rounded-xl shadow-2xs flex items-center justify-center">
                                    <i class="fa-brands fa-instagram text-xs"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_twitter']))
                                <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" title="X (Twitter)" class="social-icon-btn btn-x w-8 h-8 rounded-xl shadow-2xs flex items-center justify-center">
                                    <i class="fa-brands fa-x-twitter text-xs"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_telegram']))
                                <a href="{{ $siteSettings['social_telegram'] }}" target="_blank" rel="noopener noreferrer" title="Telegram" class="social-icon-btn btn-telegram w-8 h-8 rounded-xl shadow-2xs flex items-center justify-center">
                                    <i class="fa-brands fa-telegram text-xs"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_youtube']))
                                <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" title="YouTube" class="social-icon-btn btn-youtube w-8 h-8 rounded-xl shadow-2xs flex items-center justify-center">
                                    <i class="fa-brands fa-youtube text-xs"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_github']))
                                <a href="{{ $siteSettings['social_github'] }}" target="_blank" rel="noopener noreferrer" title="GitHub" class="social-icon-btn btn-github w-8 h-8 rounded-xl shadow-2xs flex items-center justify-center">
                                    <i class="fa-brands fa-github text-xs"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_discord']))
                                <a href="{{ $siteSettings['social_discord'] }}" target="_blank" rel="noopener noreferrer" title="Discord" class="social-icon-btn btn-discord w-8 h-8 rounded-xl shadow-2xs flex items-center justify-center">
                                    <i class="fa-brands fa-discord text-xs"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_facebook']))
                                <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" title="Facebook" class="social-icon-btn btn-facebook w-8 h-8 rounded-xl shadow-2xs flex items-center justify-center">
                                    <i class="fa-brands fa-facebook text-xs"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_linkedin']))
                                <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener noreferrer" title="LinkedIn" class="social-icon-btn btn-linkedin w-8 h-8 rounded-xl shadow-2xs flex items-center justify-center">
                                    <i class="fa-brands fa-linkedin text-xs"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Contact Form -->
            <div class="lg:col-span-7">
                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-9 shadow-sm space-y-6">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $siteSettings['contact_form_title'] ?? 'Send us a message' }}</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ $siteSettings['contact_form_subtitle'] ?? 'Our Android support engineering team responds within 24 business hours.' }}</p>
                    </div>

                    @if ($errors->any())
                        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 space-y-1">
                            <span class="font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                                <span>Please resolve the following errors:</span>
                            </span>
                            <ul class="list-disc list-inside text-xs space-y-0.5 pl-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        {{-- Anti-Bot Honeypot Field & Speed Token --}}
                        <div style="position: absolute; opacity: 0; pointer-events: none; height: 0; width: 0; overflow: hidden; z-index: -1;" aria-hidden="true">
                            <label for="sangfy_hp_check">Leave this field blank</label>
                            <input type="text" name="sangfy_hp_check" id="sangfy_hp_check" value="" tabindex="-1" autocomplete="off">
                            <input type="hidden" name="_form_render_ts" value="{{ time() }}">
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Your Name *</label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. Alex Rivera" class="w-full px-4 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition text-slate-900">
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Your Email Address *</label>
                                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="alex@example.com" class="w-full px-4 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition text-slate-900">
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Inquiry Subject *</label>
                            <input type="text" name="subject" id="subject" required value="{{ old('subject') }}" placeholder="e.g. Android 14 Notification Delivery or Feature Request" class="w-full px-4 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition text-slate-900">
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Your Message *</label>
                            <textarea name="message" id="message" rows="5" required placeholder="Describe your question, device model (e.g. Samsung S23, Xiaomi Note 12), Android OS version, or feedback..." class="w-full px-4 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition text-slate-900 leading-relaxed">{{ old('message') }}</textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 text-xs sm:text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg cursor-pointer">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                <span>Send Support Message</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
