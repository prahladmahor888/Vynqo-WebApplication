@extends('layouts.app')

@section('title', 'Contact & Android App Support — Sangfy')
@section('meta_description', 'Official support portal for the Sangfy Android App (com.prahlix.sangfy). Get help with app installation, camera/microphone permissions, notifications, or account support.')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-indigo-50 border border-indigo-100 text-brand-700 text-xs font-semibold">
            <span>📩 {{ $siteSettings['support_badge_text'] ?? 'Official Android App Support' }}</span>
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
                    <span>🔔 Notification Help</span>
                </div>
                <p class="text-slate-600">On Android 13+, ensure you have allowed notifications in <em>Settings &gt; Apps &gt; {{ $siteName ?? 'Sangfy' }} &gt; Notifications</em>.</p>
            </div>
            <div class="p-4 bg-white rounded-lg border border-slate-200 space-y-1">
                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                    <span>🎙️ Call & Mic Access</span>
                </div>
                <p class="text-slate-600">For crystal-clear HD calling, enable Microphone & Camera permissions when prompted.</p>
            </div>
            <div class="p-4 bg-white rounded-lg border border-slate-200 space-y-1">
                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                    <span>🗑️ Account Deletion</span>
                </div>
                <p class="text-slate-600">Permanently delete your account inside the app via <em>Settings &gt; Privacy &gt; Delete My Account</em>.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Channel Grid -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Contact Channels Info -->
            <div class="lg:col-span-5 space-y-8">
                <div class="space-y-3">
                    <h2 class="text-2xl font-bold text-slate-900">Direct Inquiries</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Choose the most relevant channel for your inquiry to ensure the quickest response.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="sangfy-card p-5 space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>💬 Customer & Technical Support</span>
                        </div>
                        <p class="text-xs text-slate-500">For account help, installation bugs, or app assistance.</p>
                        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'support@sangfy.prahlix.com' }}" class="text-xs font-semibold text-brand-600 hover:underline">{{ $siteSettings['contact_email'] ?? 'support@sangfy.prahlix.com' }}</a>
                        @if(!empty($siteSettings['support_hours']))
                            <div class="text-[11px] text-slate-400 mt-1">🕒 {{ $siteSettings['support_hours'] }}</div>
                        @endif
                    </div>

                    @if(!empty($siteSettings['contact_phone']))
                    <div class="sangfy-card p-5 space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>📞 Direct Helpline</span>
                        </div>
                        <p class="text-xs text-slate-500">Speak directly to our customer assistance desk.</p>
                        <a href="tel:{{ $siteSettings['contact_phone'] }}" class="text-xs font-semibold text-brand-600 hover:underline">{{ $siteSettings['contact_phone'] }}</a>
                    </div>
                    @endif

                    @if(!empty($siteSettings['company_address']))
                    <div class="sangfy-card p-5 space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>📍 Registered Office</span>
                        </div>
                        <p class="text-xs text-slate-600 whitespace-pre-line">{{ $siteSettings['company_address'] }}</p>
                    </div>
                    @endif

                    <div class="sangfy-card p-5 space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>🛡️ Privacy & Security Desk</span>
                        </div>
                        <p class="text-xs text-slate-500">For data deletion requests and vulnerability disclosures.</p>
                        <a href="mailto:{{ $siteSettings['privacy_email'] ?? ($siteSettings['contact_email'] ?? 'privacy@sangfy.prahlix.com') }}" class="text-xs font-semibold text-brand-600 hover:underline">{{ $siteSettings['privacy_email'] ?? ($siteSettings['contact_email'] ?? 'privacy@sangfy.prahlix.com') }}</a>
                    </div>

                    @if(!empty($siteSettings['safety_email']))
                    <div class="sangfy-card p-5 space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>🚩 Content Safety & Appeals</span>
                        </div>
                        <p class="text-xs text-slate-500">Report community violations, scams, or abuse appeals.</p>
                        <a href="mailto:{{ $siteSettings['safety_email'] }}" class="text-xs font-semibold text-brand-600 hover:underline">{{ $siteSettings['safety_email'] }}</a>
                    </div>
                    @endif

                    <div class="sangfy-card p-5 space-y-3">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>🌐 Social &amp; Community Channels</span>
                        </div>
                        <p class="text-xs text-slate-500">Connect with us on official platform channels for updates and announcements:</p>
                        
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            @if(!empty($siteSettings['social_instagram']))
                                <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" title="Instagram" class="social-icon-btn btn-instagram group w-8 h-8 rounded-lg shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_twitter']))
                                <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener noreferrer" title="X (Twitter)" class="social-icon-btn btn-x group w-8 h-8 rounded-lg shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24"><path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_telegram']))
                                <a href="{{ $siteSettings['social_telegram'] }}" target="_blank" rel="noopener noreferrer" title="Telegram" class="social-icon-btn btn-telegram group w-8 h-8 rounded-lg shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24"><path fill="currentColor" d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_youtube']))
                                <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" title="YouTube" class="social-icon-btn btn-youtube group w-8 h-8 rounded-lg shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_github']))
                                <a href="{{ $siteSettings['social_github'] }}" target="_blank" rel="noopener noreferrer" title="GitHub" class="social-icon-btn btn-github group w-8 h-8 rounded-lg shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_discord']))
                                <a href="{{ $siteSettings['social_discord'] }}" target="_blank" rel="noopener noreferrer" title="Discord" class="social-icon-btn btn-discord group w-8 h-8 rounded-lg shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24"><path fill="currentColor" d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.894.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.078.078 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_facebook']))
                                <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" title="Facebook" class="social-icon-btn btn-facebook group w-8 h-8 rounded-lg shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if(!empty($siteSettings['social_linkedin']))
                                <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener noreferrer" title="LinkedIn" class="social-icon-btn btn-linkedin group w-8 h-8 rounded-lg shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-inherit" fill="currentColor" viewBox="0 0 24 24"><path fill="currentColor" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Contact Form -->
            <div class="lg:col-span-7">
                <div class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $siteSettings['contact_form_title'] ?? 'Send us a message' }}</h3>
                    <p class="text-xs text-slate-500 mb-6">{{ $siteSettings['contact_form_subtitle'] ?? 'Our Android support engineering team responds within 24 business hours.' }}</p>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-md text-xs text-rose-700 space-y-1">
                            <span class="font-bold block">Please resolve the following errors:</span>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Your Name *</label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. Alex Rivera" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Your Email Address *</label>
                                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="alex@example.com" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-xs font-semibold text-slate-700 mb-1">Inquiry Subject *</label>
                            <input type="text" name="subject" id="subject" required value="{{ old('subject') }}" placeholder="e.g. Android 14 Notification Delivery or Feature Request" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-semibold text-slate-700 mb-1">Your Message *</label>
                            <textarea name="message" id="message" rows="5" required placeholder="Describe your question, device model (e.g. Samsung S23, Xiaomi Note 12), Android OS version, or feedback..." class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">{{ old('message') }}</textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 active:bg-brand-800 rounded-md shadow-sm transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
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
