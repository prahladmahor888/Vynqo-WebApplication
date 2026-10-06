@extends('layouts.app')

@section('title', ($document->title ?? 'Privacy Policy & Android Data Safety') . ' — Sangfy')
@section('meta_description', $document->summary ?? 'Official Privacy Policy & Data Safety for the Sangfy Android App (com.prahlix.sangfy).')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-semibold">
            <span>🛡️ Android App Data Safety & Privacy</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            {{ $document->title ?? 'Sangfy Privacy Policy' }}
        </h1>
        <p class="text-slate-600 text-sm max-w-2xl mx-auto">
            {{ $document->subtitle ?? 'Official Data Safety, Device Permissions, and Privacy Policy for the Sangfy Android Application.' }}
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3 text-xs text-slate-500 font-mono pt-1">
            <span>App: <strong>Sangfy (com.prahlix.sangfy)</strong></span>
            <span>•</span>
            <span>Version: <strong>v{{ $document->version ?? '1.0.0' }}</strong></span>
            <span>•</span>
            <span>Effective Date: <strong>{{ $document->effective_date ?? 'September 17, 2026' }}</strong></span>
            <span>•</span>
            <span>GDPR, DPDP & Google Play Compliant</span>
        </div>
    </div>
</section>

<!-- Dynamic Permissions Showcase -->
@if(isset($permissions) && count($permissions) > 0)
<section class="py-12 bg-slate-50 border-b border-slate-200/80">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-3">
            <div>
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span>📱 Live Android Device Runtime Permissions</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                </h2>
                <p class="text-xs text-slate-500">Dynamically synced permissions active in the Sangfy Android App</p>
            </div>
            <span class="text-xs font-mono font-bold px-2.5 py-1 rounded bg-white text-brand-700 border border-slate-200">
                {{ count($permissions) }} Active Permissions
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($permissions as $perm)
                <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-2xs hover:border-purple-200 transition space-y-2">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl p-1.5 rounded-lg bg-purple-50 border border-purple-100">{{ $perm['icon'] ?? '🔒' }}</span>
                            <div>
                                <h3 class="font-bold text-xs text-slate-900">{{ $perm['name'] }}</h3>
                                <code class="text-[10px] text-brand-700 font-mono block">{{ $perm['code'] ?? 'android.permission' }}</code>
                            </div>
                        </div>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ ($perm['badge'] ?? '') === 'Required' ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-purple-50 text-brand-700 border border-purple-100' }}">
                            {{ $perm['badge'] ?? 'Feature-Based' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed pt-1">
                        {{ $perm['purpose'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Main Policy Document from Database -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-slate-700 leading-relaxed legal-content">
        {!! $document->content !!}
    </div>
</section>

<!-- Bottom Compliance Banner -->
<section class="py-12 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <h3 class="text-base font-bold text-slate-900">Questions or Data Deletion Requests?</h3>
        <p class="text-xs text-slate-500">
            You can delete your account directly within the Sangfy Android App under <em>Settings &rarr; Account &rarr; Delete Account</em>, or contact our Data Privacy Officer.
        </p>
        <div class="pt-2 flex items-center justify-center gap-4">
            <a href="{{ route('contact') }}" class="px-5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-200 rounded-md hover:bg-slate-100 transition shadow-xs">
                Contact Privacy Desk
            </a>
            <a href="{{ route('download.page') }}" class="px-5 py-2.5 text-xs font-bold text-white btn-sangfy rounded-md shadow-xs">
                Download Official APK
            </a>
        </div>
    </div>
</section>
@endsection
