@extends('layouts.app')

@section('title', ($document->title ?? 'Community Guidelines & Safety Standards') . ' — Sangfy')
@section('meta_description', $document->summary ?? 'Sangfy Community Guidelines and Safety Standards for feed posts, stories, nearby discovery, and private chats.')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-100 text-brand-700 text-xs font-semibold">
            <i class="fa-solid fa-shield-heart text-brand-600"></i>
            <span>Respect, Authenticity & Safety</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            {{ $document->title ?? 'Community Guidelines' }}
        </h1>
        <p class="text-slate-600 text-sm max-w-2xl mx-auto">
            {{ $document->subtitle ?? 'Our safety policies and standards for feed posts, 24h stories, nearby radar, and private communication.' }}
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3 text-xs text-slate-500 font-mono pt-1">
            <span>App: <strong>Sangfy (com.prahlix.sangfy)</strong></span>
            <span>•</span>
            <span>Version: <strong>v{{ $document->version ?? '1.0.0' }}</strong></span>
            <span>•</span>
            <span>Effective Date: <strong>{{ $document->effective_date ?? 'October 3, 2026' }}</strong></span>
        </div>
    </div>
</section>

<!-- Main Guidelines Document from Database -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-slate-700 leading-relaxed legal-content">
        {!! $document->content !!}
    </div>
</section>

<!-- Reporting & Help Banner -->
<section class="py-12 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <h3 class="text-base font-bold text-slate-900">Need to Report a Violation?</h3>
        <p class="text-xs text-slate-500">
            You can report any post or profile immediately inside the Android App, or email our 24/7 Safety & Trust Team.
        </p>
        <div class="pt-2 flex items-center justify-center gap-4">
            <a href="{{ route('contact') }}" class="px-5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-200 rounded-md hover:bg-slate-100 transition shadow-xs">
                Contact Safety Team
            </a>
            <a href="{{ route('download.page') }}" class="px-5 py-2.5 text-xs font-bold text-white btn-sangfy rounded-md shadow-xs">
                Download Official App
            </a>
        </div>
    </div>
</section>
@endsection
