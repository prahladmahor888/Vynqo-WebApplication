@extends('layouts.app')

@section('title', 'Android Only — Sangfy Official App')
@section('meta_description', 'Sangfy is an Android application (.apk). It is currently not available for Apple iOS devices.')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 hero-glow-bg">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-xl text-center">
        
        <!-- Apple & Android Visual Badge -->
        <div class="flex items-center justify-center gap-3 mb-6">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center text-2xl shadow-2xs">
                <i class="fa-brands fa-apple"></i>
            </div>
            <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-sm font-black">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center text-2xl shadow-2xs">
                <i class="fa-brands fa-android"></i>
            </div>
        </div>

        <!-- Pill Status -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold mb-4">
            <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
            <span>Apple iOS Device Detected</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
            This app is only for Android users
        </h1>

        <p class="text-slate-600 text-sm leading-relaxed mb-4">
            You cannot download it on an Apple iOS device (iPhone or iPad). The installation package is a native Android (.apk) file and cannot be run on iOS.
        </p>

        <div class="p-4 bg-amber-50/80 border border-amber-200 rounded-2xl text-left text-xs text-amber-800 space-y-1 mb-8">
            <div class="font-bold flex items-center gap-1.5 text-amber-900">
                <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                <span>Compatibility Notice:</span>
            </div>
            <p class="leading-relaxed">
                To use {{ $siteName ?? 'Sangfy' }}, please open this website from an <strong>Android smartphone or tablet</strong> (Android 8.0 Oreo or newer) to download and install the official app.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('home') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                <i class="fa-solid fa-house text-slate-500"></i>
                <span>Return to Home</span>
            </a>
            <a href="{{ route('features') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 text-xs font-bold text-white btn-sangfy rounded-xl shadow-md transition">
                <span>Explore Features</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

    </div>
</section>
@endsection
