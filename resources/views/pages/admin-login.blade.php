@extends('layouts.app')

@section('title', 'Admin Portal Login — Sangfy')

@section('content')
<section class="min-h-[75vh] flex items-center justify-center py-16 bg-slate-50 hero-glow-bg">
    <div class="max-w-md w-full mx-auto px-4 sm:px-6">
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8 space-y-6">
            
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-purple-50 border border-purple-100 shadow-inner mb-2">
                    <img src="{{ $siteLogo ?? asset('assets/images/logo.png') }}" alt="{{ $siteName ?? 'Sangfy' }} Logo" class="w-9 h-9 object-contain">
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Admin Portal</h1>
                <p class="text-xs text-slate-500">Sign in with your admin credentials. Two-step verification OTP is required.</p>
            </div>

            @if(session('info'))
                <div class="p-3 rounded-lg bg-purple-50 border border-purple-200 text-purple-900 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-brand-600"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Anti-Bot Honeypot Trap --}}
                <div style="position: absolute; opacity: 0; pointer-events: none; height: 0; width: 0; overflow: hidden; z-index: -1;" aria-hidden="true">
                    <input type="text" name="sangfy_hp_check" value="" tabindex="-1" autocomplete="off">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-envelope text-slate-400"></i>
                        <span>Admin Email</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com" class="w-full text-sm px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900">
                    @error('email') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-key text-slate-400"></i>
                        <span>Password</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="admin-password" 
                            name="password" 
                            required 
                            value="" 
                            placeholder="••••••••" 
                            class="w-full text-sm px-4 py-2.5 pr-11 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900"
                        >
                        <button 
                            type="button" 
                            id="toggle-password-btn" 
                            tabindex="-1"
                            title="Show/Hide Password" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 transition cursor-pointer"
                        >
                            <i class="fa-regular fa-eye text-sm" id="toggle-password-icon"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Security Verification (CAPTCHA) -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved text-brand-600"></i>
                            <span>Security Verification</span>
                        </span>
                        <span class="text-[10px] text-slate-400 lowercase font-normal">case-insensitive</span>
                    </label>
                    
                    <div class="flex items-center gap-2 mb-2">
                        <div id="captcha-svg-wrapper" class="flex-1 bg-slate-100 rounded-lg p-1 border border-slate-200 flex items-center justify-center overflow-hidden shadow-2xs">
                            {!! $captchaSvg ?? '' !!}
                        </div>
                        <button type="button" id="refresh-captcha-btn" title="Refresh Captcha" class="p-2.5 rounded-lg border border-slate-200 bg-white hover:bg-purple-50 hover:text-brand-600 hover:border-purple-200 text-slate-600 transition shadow-2xs">
                            <i class="fa-solid fa-arrows-rotate text-sm"></i>
                        </button>
                    </div>

                    <input 
                        type="text" 
                        name="captcha" 
                        maxlength="6" 
                        required 
                        autocomplete="off" 
                        placeholder="Enter the 5 characters" 
                        style="text-transform: uppercase; letter-spacing: 2px;" 
                        class="w-full text-sm font-mono font-bold px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900"
                    >
                    @error('captcha') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between text-xs text-slate-600">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span>Remember my session</span>
                    </label>
                    <span class="text-slate-400 flex items-center gap-1 text-[11px]">
                        <i class="fa-solid fa-envelope-shield text-emerald-500"></i>
                        <span>2FA via Email</span>
                    </span>
                </div>

                <button type="submit" class="w-full py-3 px-4 text-sm font-bold text-white btn-sangfy rounded-lg shadow-md transition hover:shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>Proceed to Verification</span>
                </button>
            </form>

            <div class="pt-3 border-t border-slate-100 text-center">
                <span class="text-[11px] text-slate-400 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-lock text-[10px] text-slate-400"></i>
                    <span>Protected by Captcha &amp; Two-Step OTP Verification</span>
                </span>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Password Visibility Eye Toggle
        const togglePasswordBtn = document.getElementById('toggle-password-btn');
        const passwordInput = document.getElementById('admin-password');
        const passwordIcon = document.getElementById('toggle-password-icon');

        if (togglePasswordBtn && passwordInput && passwordIcon) {
            togglePasswordBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    passwordIcon.classList.remove('fa-eye', 'fa-regular');
                    passwordIcon.classList.add('fa-eye-slash', 'fa-solid', 'text-brand-600');
                    togglePasswordBtn.setAttribute('title', 'Hide Password');
                } else {
                    passwordIcon.classList.remove('fa-eye-slash', 'fa-solid', 'text-brand-600');
                    passwordIcon.classList.add('fa-eye', 'fa-regular');
                    togglePasswordBtn.setAttribute('title', 'Show Password');
                }
            });
        }

        // 2. Dynamic Captcha Refresh
        const refreshBtn = document.getElementById('refresh-captcha-btn');
        const wrapper = document.getElementById('captcha-svg-wrapper');

        if (refreshBtn && wrapper) {
            refreshBtn.addEventListener('click', function () {
                const icon = refreshBtn.querySelector('i');
                if (icon) icon.classList.add('fa-spin');
                refreshBtn.disabled = true;

                fetch("{{ route('admin.captcha.refresh') }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data && data.svg) {
                        wrapper.innerHTML = data.svg;
                    }
                })
                .catch(err => console.error('Captcha refresh error:', err))
                .finally(() => {
                    if (icon) icon.classList.remove('fa-spin');
                    refreshBtn.disabled = false;
                });
            });
        }
    });
</script>
@endpush
@endsection
