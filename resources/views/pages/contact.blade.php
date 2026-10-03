@extends('layouts.app')

@section('title', 'Contact & Android App Support — Vynqo')
@section('meta_description', 'Official support portal for the Vynqo Android App (com.vynqo.app). Get help with app installation, camera/microphone permissions, notifications, or account support.')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-indigo-50 border border-indigo-100 text-brand-700 text-xs font-semibold">
            <span>📩 Official Android App Support</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            How Can We Help You?
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Need help with your Vynqo Android App (<code class="font-mono text-xs bg-slate-100 px-1 py-0.5 rounded text-slate-800">com.vynqo.app</code>), have feedback, or want to report an issue? Our team is here to assist.
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
                <p class="text-slate-600">On Android 13+, ensure you have allowed notifications in <em>Settings &gt; Apps &gt; Vynqo &gt; Notifications</em>.</p>
            </div>
            <div class="p-4 bg-white rounded-lg border border-slate-200 space-y-1">
                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                    <span>🎙️ Call & Mic Access</span>
                </div>
                <p class="text-slate-600">For crystal-clear Agora RTC HD calling, enable Microphone & Camera permissions when prompted.</p>
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
                    <div class="vynqo-card p-5 space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>💬 Android App Support</span>
                        </div>
                        <p class="text-xs text-slate-500">For account help, installation bugs, or APK assistance.</p>
                        <a href="mailto:support@vynqo.com" class="text-xs font-semibold text-brand-600 hover:underline">support@vynqo.com</a>
                    </div>

                    <div class="vynqo-card p-5 space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>🛡️ Privacy & Security Desk</span>
                        </div>
                        <p class="text-xs text-slate-500">For data deletion requests and vulnerability disclosures.</p>
                        <a href="mailto:privacy@vynqo.com" class="text-xs font-semibold text-brand-600 hover:underline">privacy@vynqo.com</a>
                    </div>

                    <div class="vynqo-card p-5 space-y-2">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>🚩 Content Safety & Appeals</span>
                        </div>
                        <p class="text-xs text-slate-500">Report community violations, scams, or abuse appeals.</p>
                        <a href="mailto:safety@vynqo.com" class="text-xs font-semibold text-brand-600 hover:underline">safety@vynqo.com</a>
                    </div>
                </div>
            </div>

            <!-- Right Contact Form -->
            <div class="lg:col-span-7">
                <div class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Send us a message</h3>
                    <p class="text-xs text-slate-500 mb-6">Our Android support engineering team responds within 24 business hours.</p>

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
