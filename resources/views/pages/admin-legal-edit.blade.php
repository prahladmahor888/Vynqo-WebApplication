@extends('layouts.admin')

@section('title', 'Edit ' . ($document->title ?? 'Legal Policy') . ' — Sangfy Admin')
@section('page_title', 'Edit ' . ($document->title ?? 'Legal Policy'))

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Header Breadcrumb & Actions -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.legal.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:underline mb-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Legal Documents List</span>
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Edit {{ $document->title ?? 'Legal Policy' }}</h1>
            <p class="text-slate-500 text-xs mt-1">Modifications are saved immediately to the database and will reflect live across the official website.</p>
        </div>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.legal.reset', $slug) }}" method="POST" onsubmit="return confirm('Reset this document to official default content?');">
                @csrf
                <button type="submit" class="px-4 py-2 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-100 transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Reset to Defaults</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Form Box -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.legal.update', $slug) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">Document Title</label>
                    <input type="text" name="title" value="{{ old('title', $document->title) }}" required class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    @error('title') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">Policy Slug (Read Only)</label>
                    <input type="text" value="{{ $slug }}" disabled class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">Policy Version</label>
                    <input type="text" name="version" value="{{ old('version', $document->version ?? '1.0.0') }}" required class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    @error('version') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">Effective Date</label>
                    <input type="text" name="effective_date" value="{{ old('effective_date', $document->effective_date ?? 'October 3, 2026') }}" required class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    @error('effective_date') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">Subtitle / Header Caption</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $document->subtitle) }}" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                @error('subtitle') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">Summary / SEO Description</label>
                <textarea name="summary" rows="2" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">{{ old('summary', $document->summary) }}</textarea>
                @error('summary') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider">Document Content (HTML / Structured)</label>
                    <span class="text-xs text-slate-400">Supports standard HTML elements & Tailwind classes</span>
                </div>
                <textarea name="content" rows="18" required class="w-full font-mono text-xs px-4 py-3 rounded-xl border border-slate-300 bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 leading-relaxed custom-scrollbar">{{ old('content', $document->content) }}</textarea>
                @error('content') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.legal.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800">
                    Cancel
                </a>

                <button type="submit" class="px-8 py-3 text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg inline-flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Policy to Database</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
