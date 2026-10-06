@extends('layouts.admin')

@section('title', 'APK & Release Manager — Sangfy Admin')
@section('page_title', 'APK & Release Manager')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="apkReleaseManager()">
    
    <!-- Header Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-200 text-brand-700 text-xs font-semibold mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Active Database Releases</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Sangfy APK & Release Manager
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Enter your release version and build code manually. APK file size and SHA-256 checksum are <strong>automatically calculated</strong>.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('download.apk') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Download Active APK</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Current Active Release Card -->
    <div class="p-6 bg-slate-900 text-white rounded-2xl border border-slate-800 shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800 text-xs">
            <span class="text-emerald-400 font-bold uppercase tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Current Active Release in Database
            </span>
            <span class="text-slate-400 font-mono">Record ID #{{ $currentRelease->id ?? 1 }}</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block mb-0.5">Version Name</span>
                <span class="font-bold text-base text-white font-mono">{{ $currentRelease->version_name ?? 'v1.0.0' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Version Code</span>
                <span class="font-bold text-base text-purple-300 font-mono">{{ $currentRelease->version_code ?? 100 }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">File Size (Auto)</span>
                <span class="font-bold text-base text-emerald-400 font-mono">{{ $currentRelease->file_size ?? '30 MB' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Total Downloads</span>
                <span class="font-bold text-base text-white font-mono">{{ number_format($currentRelease->download_count ?? 1250) }}</span>
            </div>
        </div>

        <div class="pt-2">
            <span class="text-slate-400 block mb-1 text-xs">SHA-256 Checksum (Auto):</span>
            <code class="text-xs text-purple-200 bg-slate-950 p-2.5 rounded-lg block font-mono break-all border border-slate-800">
                {{ $currentRelease->sha256_checksum ?? 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' }}
            </code>
        </div>
    </div>

    <!-- Release Form -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">
                    Release Information
                </h2>
                <p class="text-xs text-slate-500">Enter version & build code — APK size is calculated automatically</p>
            </div>
            <span class="text-xs px-2.5 py-1 rounded bg-purple-50 text-brand-700 font-semibold border border-purple-100 flex items-center gap-1">
                <span>⚡</span> Auto Size Calculation
            </span>
        </div>

        <form action="{{ route('admin.release.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Hidden field to pass auto-calculated size -->
            <input type="hidden" name="file_size" :value="fileSize">

            <!-- Version Name & Build Code (Manual Typing) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Version Name -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Release Version (Version Name) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="version_name" required value="{{ old('version_name', $currentRelease->version_name ?? 'v1.0.0') }}" placeholder="e.g. v1.0.0" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 font-mono font-bold text-slate-900">
                    <p class="text-[11px] text-slate-400 mt-1">Public version name (e.g. v1.0.0, v1.1.0)</p>
                    @error('version_name') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Version Code -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Build Code (Version Code) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="version_code" required min="1" value="{{ old('version_code', $currentRelease->version_code ?? 100) }}" placeholder="e.g. 100" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 font-mono font-bold text-slate-900">
                    <p class="text-[11px] text-slate-400 mt-1">Integer build code from Gradle (e.g. 100, 101)</p>
                    @error('version_code') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- APK File Upload Area with Automatic Size Detection -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider">
                        Upload APK File (.apk) <span class="text-slate-400 font-normal">(Optional if only updating changelog)</span>
                    </label>
                    <div class="flex items-center gap-1.5 text-xs text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Auto Size: <strong class="font-mono font-bold" x-text="fileSize"></strong></span>
                    </div>
                </div>

                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full min-h-[140px] border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-purple-50/40 hover:border-purple-300 transition p-6 text-center">
                        
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-purple-100 text-brand-700 flex items-center justify-center shadow-xs">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            </div>
                            <p class="text-sm text-slate-700 font-bold">
                                <span x-text="fileName ? 'Selected: ' + fileName : 'Click to browse or drop APK file here'"></span>
                            </p>
                            <p class="text-xs text-slate-500">
                                Size is calculated automatically from the selected APK binary
                            </p>
                        </div>

                        <input type="file" name="apk_file" accept=".apk" class="hidden" @change="handleFileSelect($event)">
                    </label>
                </div>
                @error('apk_file') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror

                <!-- Live Auto-Calculated Size Banner -->
                <div x-show="fileName" x-transition class="mt-3 p-3.5 rounded-xl bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 flex items-center justify-between text-xs" style="display:none;">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">✓</span>
                        <span class="text-slate-700">File: <strong class="font-mono text-slate-900" x-text="fileName"></strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 text-[11px]">Calculated Size:</span>
                        <span class="font-mono font-bold bg-white text-brand-700 px-3 py-1 rounded-lg border border-purple-200 shadow-2xs text-sm" x-text="fileSize"></span>
                    </div>
                </div>
            </div>

            <!-- Minimum Android Version -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                    Supported Android Version
                </label>
                <input type="text" name="min_android_version" value="{{ old('min_android_version', $currentRelease->min_android_version ?? 'Android 8.0 (Oreo)+') }}" placeholder="e.g. Android 8.0 (Oreo)+" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900">
                <p class="text-[11px] text-slate-400 mt-1">Minimum required Android OS version</p>
            </div>

            <!-- Changelog -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">Release Notes & Changelog</label>
                <textarea name="changelog" rows="5" required class="w-full text-xs font-mono px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 leading-relaxed">{{ old('changelog', $currentRelease->changelog ?? "• Feed Posts with Images & Videos\n• 24-Hour Stories\n• 'Find Nearby People' Radar\n• Free HD Voice & Video Calls via Agora RTC\n• End-to-End Encrypted Private Chats") }}</textarea>
                @error('changelog') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <div class="text-xs text-slate-500">
                    File size and SHA256 checksum are automatically recorded upon saving.
                </div>
                <button type="submit" class="px-8 py-3 text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg">
                    Save Release to Database
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
function apkReleaseManager() {
    return {
        fileName: '',
        fileSize: '{{ old('file_size', $currentRelease->file_size ?? '30 MB') }}',

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.fileName = file.name;
            
            // ⚡ Exact automatic calculation in MB (e.g. 30.4 MB)
            const sizeInMb = (file.size / (1024 * 1024)).toFixed(1);
            this.fileSize = sizeInMb + ' MB';
        }
    }
}
</script>
@endpush
@endsection
