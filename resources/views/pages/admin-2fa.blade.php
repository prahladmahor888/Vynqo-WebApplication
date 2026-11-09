@extends('layouts.app')

@section('title', 'Two-Step Verification — Sangfy Admin Portal')

@section('content')
<section class="min-h-[75vh] flex items-center justify-center py-16 bg-slate-50 hero-glow-bg">
    <div class="max-w-md w-full mx-auto px-4 sm:px-6">
        
        <!-- 2FA Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8 space-y-6">
            
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-purple-50 border border-purple-100 shadow-inner mb-2 text-brand-600 text-2xl">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Two-Step Verification</h1>
                <p class="text-xs text-slate-500 leading-relaxed">
                    A 6-digit security OTP code was sent to <strong class="text-slate-800 font-mono">{{ $targetEmail ?? 'support@prahlix.com' }}</strong>
                </p>
            </div>

            @if(session('info'))
                <div class="p-3 rounded-lg bg-purple-50 border border-purple-200 text-purple-900 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-brand-600"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.2fa.verify') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2 text-center">
                        Enter 6-Digit Verification Code
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="otp" 
                            maxlength="6" 
                            inputmode="numeric" 
                            pattern="[0-9]{6}" 
                            required 
                            autofocus 
                            autocomplete="one-time-code" 
                            placeholder="••••••" 
                            class="w-full text-center text-2xl font-mono tracking-[0.5em] px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 font-bold text-slate-900"
                        >
                    </div>
                    @error('otp') 
                        <span class="text-xs text-rose-600 mt-1.5 block text-center font-medium">{{ $message }}</span> 
                    @enderror
                </div>

                <button type="submit" class="w-full py-3 px-4 text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-lock-open"></i>
                    <span>Verify &amp; Enter Admin Portal</span>
                </button>
            </form>

            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <form action="{{ route('admin.2fa.resend') }}" method="POST" id="resend-form">
                    @csrf
                    <button type="submit" class="text-brand-600 hover:text-brand-800 font-semibold underline flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-arrows-rotate text-[11px]"></i>
                        <span>Resend Code</span>
                    </button>
                </form>

                <a href="{{ route('admin.2fa.cancel') }}" class="text-slate-400 hover:text-slate-700 transition">
                    Cancel &amp; Sign Out
                </a>
            </div>

        </div>

    </div>
</section>
@endsection

