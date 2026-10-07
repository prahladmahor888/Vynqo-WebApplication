@extends('layouts.app')

@section('title', ($document->title ?? 'Terms of Service') . ' — Sangfy Android App')
@section('meta_description', $document->summary ?? 'Official Terms of Service for the Sangfy Android Application (com.prahlix.sangfy).')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-indigo-50 border border-indigo-100 text-brand-700 text-xs font-semibold">
            <i class="fa-solid fa-scale-balanced text-brand-600"></i>
            <span>Terms of Use</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            {{ $document->title ?? 'Terms of Service' }}
        </h1>
        <p class="text-slate-600 text-sm max-w-2xl mx-auto">
            {{ $document->subtitle ?? 'Legal agreement for using the Sangfy Android Application and associated online services.' }}
        </p>
        <p class="text-xs text-slate-500 font-mono">
            App: <strong>Sangfy (com.prahlix.sangfy)</strong> • Version: <strong>v{{ $document->version ?? '1.0.0' }}</strong> • Effective Date: <strong>{{ $document->effective_date ?? 'October 3, 2026' }}</strong>
        </p>
    </div>
</section>

<!-- Terms Content from Database -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-slate-700 leading-relaxed legal-content">
        {!! $document->content !!}
    </div>
</section>

<!-- Bottom Inquiries Banner -->
<section class="py-12 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <h3 class="text-base font-bold text-slate-900">Questions Regarding Terms of Use?</h3>
        <p class="text-xs text-slate-500">
            For contractual questions, trademark permissions, or legal notices, reach out to our legal desk.
        </p>
        <div class="pt-2 flex items-center justify-center gap-4">
            <a href="{{ route('contact') }}" class="px-5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-200 rounded-md hover:bg-slate-100 transition shadow-xs">
                Contact Legal Desk
            </a>
            <a href="{{ route('download.page') }}" class="px-5 py-2.5 text-xs font-bold text-white btn-sangfy rounded-md shadow-xs">
                Download Official App
            </a>
        </div>
    </div>
</section>
@endsection
