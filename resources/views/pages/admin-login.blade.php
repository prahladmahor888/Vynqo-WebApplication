@extends('layouts.app')

@section('title', 'Admin Portal Login — Vynqo')

@section('content')
<section class="min-h-[75vh] flex items-center justify-center py-16 bg-slate-50 hero-glow-bg">
    <div class="max-w-md w-full mx-auto px-4 sm:px-6">
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8 space-y-6">
            
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-purple-50 border border-purple-100 shadow-inner mb-2">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Vynqo Logo" class="w-9 h-9 object-contain">
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Admin Portal</h1>
                <p class="text-xs text-slate-500">Sign in to manage APK releases, database metrics, and legal policies.</p>
            </div>

            @if(session('error'))
                <div class="p-3 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Admin Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com" class="w-full text-sm px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    @error('email') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Password</label>
                    <input type="password" name="password" required value="" placeholder="••••••••" class="w-full text-sm px-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    @error('password') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between text-xs text-slate-600">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span>Remember my session</span>
                    </label>
                    <span class="text-slate-400">Encrypted AES-256</span>
                </div>

                <button type="submit" class="w-full py-3 px-4 text-sm font-bold text-white btn-vynqo rounded-lg shadow-md transition hover:shadow-lg">
                    Sign In to Admin Dashboard
                </button>
            </form>
        </div>

    </div>
</section>
@endsection
