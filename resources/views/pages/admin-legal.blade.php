@extends('layouts.admin')

@section('title', 'Manage Legal Policies & Guidelines — Sangfy Admin')
@section('page_title', 'Legal Policies & Guidelines')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Admin Header -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 text-brand-700 text-xs font-bold uppercase tracking-wide border border-purple-200 mb-2">
                <span>📜 Policy Management</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Legal & Community Policies Manager</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Manage Privacy Policy, Community Guidelines, Terms of Service, and Security Whitepaper stored in the database.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('legal.privacy') }}" target="_blank" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5">
                <span>View Live Privacy Page</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    <!-- Alert messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Legal Documents Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        @foreach(['privacy' => 'Privacy Policy & Permissions', 'guidelines' => 'Community Guidelines', 'terms' => 'Terms of Service', 'security' => 'Security & Encryption'] as $slug => $label)
            @php
                $doc = $documents[$slug] ?? null;
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 flex flex-col justify-between hover:border-purple-300 transition group">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-mono font-bold">
                            slug: /{{ $slug }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                            Active (v{{ $doc->version ?? '1.0.0' }})
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-brand-600 transition">
                        {{ $doc->title ?? $label }}
                    </h3>

                    <p class="text-xs text-slate-500 line-clamp-2">
                        {{ $doc->subtitle ?? 'Policy documentation managed from database.' }}
                    </p>

                    <div class="text-xs text-slate-400 font-mono flex items-center gap-2 pt-1">
                        <span>Effective: {{ $doc->effective_date ?? 'October 3, 2026' }}</span>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-between gap-3 mt-4">
                    <a href="{{ route('admin.legal.edit', $slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white btn-sangfy rounded-xl shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Edit Policy in DB</span>
                    </a>

                    @php
                        $routeMap = [
                            'privacy' => route('legal.privacy'),
                            'guidelines' => route('legal.guidelines'),
                            'terms' => route('legal.terms'),
                            'security' => route('legal.security'),
                        ];
                    @endphp
                    <a href="{{ $routeMap[$slug] }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 hover:text-brand-600 transition">
                        <span>View Live Page</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>
        @endforeach

    </div>

</div>
@endsection
