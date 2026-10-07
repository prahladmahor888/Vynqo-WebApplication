@extends('layouts.app')

@section('title', ($document->title ?? 'Security & Privacy Architecture') . ' — Sangfy')
@section('meta_description', $document->summary ?? 'Learn how Sangfy protects your chats and calls with automatic privacy locks, zero company access, and open security standards.')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-purple-50 border border-purple-100 text-brand-700 text-xs font-semibold">
            <i class="fa-solid fa-shield-halved text-brand-600"></i>
            <span>Security & Cryptographic Trust</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            {{ $document->title ?? 'How Sangfy Keeps Your Conversations Safe' }}
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            {{ $document->subtitle ?? 'Your privacy is protected by mathematics. We design our software so that we cannot read your chats, listen to your calls, or sell your data.' }}
        </p>
        <p class="text-xs text-slate-500 font-mono">
            Version: <strong>v{{ $document->version ?? '1.0.0' }}</strong> • Effective Date: <strong>{{ $document->effective_date ?? 'October 3, 2026' }}</strong>
        </p>
    </div>
</section>

<!-- Main Security Policy Document from Database -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-slate-700 leading-relaxed legal-content">
        {!! $document->content !!}
    </div>
</section>

<!-- Bottom Security Banner -->
<section class="py-12 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <h3 class="text-base font-bold text-slate-900">Security Inquiries & Bug Bounty</h3>
        <p class="text-xs text-slate-500">
            Discovered a potential vulnerability or have questions about our cryptography? Contact our security desk directly.
        </p>
        <div class="pt-2 flex items-center justify-center gap-4">
            <a href="mailto:support@prahlix.com" class="px-5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-200 rounded-md hover:bg-slate-100 transition shadow-xs">
                Email Security Desk
            </a>
            <a href="{{ route('download.page') }}" class="px-5 py-2.5 text-xs font-bold text-white btn-sangfy rounded-md shadow-xs">
                Download Official App
            </a>
        </div>
    </div>
</section>
@endsection
