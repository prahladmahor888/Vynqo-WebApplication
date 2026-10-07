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
                Upload new APK binary with <strong>real-time progress tracking</strong>. File size & SHA-256 checksum are automatically calculated on the server.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('download.apk') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5 shadow-2xs">
                <i class="fa-solid fa-download text-brand-600"></i>
                <span>Download Active APK</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages (Session Success) -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 shrink-0 text-base"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Dynamic Error Banner (AJAX / Validation) -->
    <div x-show="errorMessage" x-cloak x-transition class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start justify-between gap-3 shadow-xs">
        <div class="flex items-start gap-2.5">
            <i class="fa-solid fa-triangle-exclamation text-rose-600 shrink-0 mt-0.5 text-base"></i>
            <div>
                <p class="font-bold text-rose-900">Upload Failed</p>
                <p class="text-xs text-rose-700 mt-0.5" x-text="errorMessage"></p>
            </div>
        </div>
        <button type="button" @click="errorMessage = ''" class="text-rose-500 hover:text-rose-700 p-1">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- 3 Key Download & Release Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Total All-Time Downloads Across All Versions -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-500">
                <span>Total All-Time Downloads</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold"><i class="fa-solid fa-download"></i></span>
            </div>
            <div class="text-3xl font-black text-slate-900 font-mono">
                {{ number_format($totalAllDownloads ?? 1250) }}
            </div>
            <div class="text-[11px] text-slate-500 flex items-center gap-1 font-medium">
                <span class="text-emerald-600 font-bold">All Versions Combined</span>
            </div>
        </div>

        <!-- Card 2: Active Release Downloads -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-500">
                <span>Active Build Downloads</span>
                <span class="w-8 h-8 rounded-xl bg-purple-50 text-brand-600 flex items-center justify-center text-sm font-bold"><i class="fa-solid fa-rocket"></i></span>
            </div>
            <div class="text-3xl font-black text-brand-700 font-mono">
                {{ number_format($currentRelease->download_count ?? 1250) }}
            </div>
            <div class="text-[11px] text-slate-500 flex items-center gap-1.5 font-medium">
                <span class="px-1.5 py-0.5 rounded bg-purple-50 text-brand-700 font-mono font-bold">{{ $currentRelease->version_name ?? 'v1.0.0' }}</span>
                <span>(Current Live Build)</span>
            </div>
        </div>

        <!-- Card 3: Total Published Versions -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-500">
                <span>Releases in Database</span>
                <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold"><i class="fa-brands fa-android text-base"></i></span>
            </div>
            <div class="text-3xl font-black text-slate-900 font-mono">
                {{ number_format($totalReleasesCount ?? count($allReleases ?? [])) }}
            </div>
            <div class="text-[11px] text-slate-500 font-medium">
                Version History Records
            </div>
        </div>
    </div>

    <!-- Current Active Release Card (Pure White Theme) -->
    <div class="p-6 bg-white text-slate-900 rounded-2xl border border-slate-200/90 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 text-xs">
            <span class="text-emerald-700 font-bold uppercase tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Current Active Release in Database
            </span>
            <span class="text-slate-500 font-mono">Record ID #{{ $currentRelease->id ?? 1 }}</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-500 block mb-0.5">Version Name</span>
                <span class="font-bold text-base text-slate-900 font-mono">{{ $currentRelease->version_name ?? 'v1.0.0' }}</span>
            </div>
            <div>
                <span class="text-slate-500 block mb-0.5">Version Code</span>
                <span class="font-bold text-base text-brand-600 font-mono">{{ $currentRelease->version_code ?? 100 }}</span>
            </div>
            <div>
                <span class="text-slate-500 block mb-0.5">File Size (Auto)</span>
                <span class="font-bold text-base text-emerald-600 font-mono">{{ $currentRelease->file_size ?? '30 MB' }}</span>
            </div>
            <div>
                <span class="text-slate-500 block mb-0.5">Total Downloads</span>
                <span class="font-bold text-base text-slate-900 font-mono">{{ number_format($currentRelease->download_count ?? 1250) }}</span>
            </div>
        </div>

        <div class="pt-2">
            <span class="text-slate-500 block mb-1 text-xs font-semibold">SHA-256 Checksum (Auto):</span>
            <code class="text-xs text-brand-700 bg-slate-50 p-2.5 rounded-lg block font-mono break-all border border-slate-200">
                {{ $currentRelease->sha256_checksum ?? 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855' }}
            </code>
        </div>
    </div>

    <!-- Release Form -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">
                    Release Information & Binary Upload
                </h2>
                <p class="text-xs text-slate-500">Enter version & build code — Live upload progress and automatic size & checksum calculation</p>
            </div>
            <span class="text-xs px-2.5 py-1 rounded-full bg-purple-50 text-brand-700 font-semibold border border-purple-100 flex items-center gap-1">
                <i class="fa-solid fa-bolt text-amber-500"></i>
                <span>Real-time Upload Progress</span>
            </span>
        </div>

        <form id="apkUploadForm" @submit.prevent="submitForm($event)" class="space-y-6">
            @csrf

            <!-- Hidden field to pass auto-calculated size -->
            <input type="hidden" name="file_size" :value="fileSize">

            <!-- Version Name, Build Code & Initial Download Count -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Version Name -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Release Version (Version Name) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="version_name" required :disabled="isUploading" value="{{ old('version_name', $currentRelease->version_name ?? 'v1.0.0') }}" placeholder="e.g. v1.0.0" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 font-mono font-bold text-slate-900 disabled:bg-slate-100 disabled:cursor-not-allowed">
                    <p class="text-[11px] text-slate-400 mt-1">Public version name (e.g. v1.0.0, v1.1.0)</p>
                    @error('version_name') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Version Code -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Build Code (Version Code) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="version_code" required min="1" :disabled="isUploading" value="{{ old('version_code', $currentRelease->version_code ?? 100) }}" placeholder="e.g. 100" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 font-mono font-bold text-slate-900 disabled:bg-slate-100 disabled:cursor-not-allowed">
                    <p class="text-[11px] text-slate-400 mt-1">Integer build code from Gradle (e.g. 100, 101)</p>
                    @error('version_code') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Starting / Base Download Count -->
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                        Base Download Count
                    </label>
                    <input type="number" name="download_count" min="0" :disabled="isUploading" value="{{ old('download_count', $currentRelease->download_count ?? 1250) }}" placeholder="e.g. 1250" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 font-mono font-bold text-slate-900 disabled:bg-slate-100 disabled:cursor-not-allowed">
                    <p class="text-[11px] text-slate-400 mt-1">Starting download counter for this release</p>
                    @error('download_count') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- APK File Upload Area with Real-Time Progress -->
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

                <!-- Dropzone Box -->
                <div class="relative w-full">
                    <label 
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleDrop($event)"
                        :class="{
                            'border-brand-500 bg-purple-50/70 ring-4 ring-purple-100': isDragging,
                            'border-slate-300 bg-slate-50 hover:bg-purple-50/30 hover:border-purple-300': !isDragging && !fileName,
                            'border-emerald-400 bg-emerald-50/20': fileName && !isUploading,
                            'opacity-75 pointer-events-none': isUploading
                        }"
                        class="flex flex-col items-center justify-center w-full min-h-[160px] border-2 border-dashed rounded-2xl cursor-pointer transition-all duration-200 p-6 text-center">
                        
                        <template x-if="!fileName">
                            <div class="flex flex-col items-center justify-center space-y-2.5">
                                <div class="w-14 h-14 rounded-2xl bg-purple-100 text-brand-700 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-800 font-bold">
                                        Click to browse or drag & drop APK file here
                                    </p>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Supports Android Package (.apk) up to 150 MB
                                    </p>
                                </div>
                            </div>
                        </template>

                        <template x-if="fileName && !isUploading">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                    <i class="fa-solid fa-circle-check text-2xl text-emerald-600"></i>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-sm font-bold text-slate-900 font-mono" x-text="fileName"></p>
                                    <p class="text-xs text-emerald-700 font-semibold" x-text="'File Size: ' + fileSize"></p>
                                </div>
                                <p class="text-[11px] text-slate-400">Click or drop another file to replace</p>
                            </div>
                        </template>

                        <input 
                            type="file" 
                            id="apkFileInput"
                            name="apk_file" 
                            accept=".apk" 
                            class="hidden" 
                            :disabled="isUploading"
                            @change="handleFileSelect($event)">
                    </label>
                </div>
                @error('apk_file') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror

                <!-- Selected File Details Banner -->
                <div x-show="fileName && !isUploading" x-cloak x-transition class="mt-3 p-3.5 rounded-xl bg-gradient-to-r from-purple-50 via-pink-50/50 to-emerald-50 border border-purple-200 flex items-center justify-between text-xs shadow-2xs">
                    <div class="flex items-center gap-2.5 truncate">
                        <span class="w-6 h-6 rounded-lg bg-purple-600 text-white flex items-center justify-center font-bold text-xs shrink-0"><i class="fa-brands fa-android text-xs"></i></span>
                        <div class="truncate">
                            <span class="text-slate-600">Selected Binary:</span>
                            <span class="font-mono font-bold text-slate-900 ml-1 truncate" x-text="fileName"></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="font-mono font-bold bg-white text-brand-700 px-2.5 py-1 rounded-lg border border-purple-200 shadow-2xs text-xs" x-text="fileSize"></span>
                        <button type="button" @click="clearFile()" class="text-rose-500 hover:text-rose-700 px-2 py-1 rounded hover:bg-rose-50 font-semibold transition text-xs">
                            Remove
                        </button>
                    </div>
                </div>

                <!-- LIVE REAL-TIME UPLOAD PROGRESS CARD (Clean White Theme) -->
                <div x-show="isUploading" x-cloak x-transition class="mt-4 p-5 rounded-2xl bg-white text-slate-900 border border-purple-200 shadow-xl space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-purple-100 text-brand-600 flex items-center justify-center shadow-2xs">
                                <i class="fa-solid fa-cloud-arrow-up text-lg animate-bounce text-brand-600"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-900 font-mono" x-text="fileName || 'sangfy-release.apk'"></span>
                                    <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-purple-100 text-brand-700 border border-purple-200" x-text="uploadStatusText"></span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5" x-text="statusDetailText"></p>
                            </div>
                        </div>

                        <!-- Percentage Badge -->
                        <div class="text-right">
                            <div class="text-2xl font-black text-brand-700 font-mono tracking-tight" x-text="uploadProgress + '%'"></div>
                            <span class="text-[10px] text-slate-500 font-mono" x-text="uploadedBytesFormatted + ' / ' + totalBytesFormatted"></span>
                        </div>
                    </div>

                    <!-- Progress Bar Track -->
                    <div class="space-y-1.5">
                        <div class="w-full bg-slate-100 rounded-full h-3.5 p-0.5 overflow-hidden border border-slate-200 shadow-inner">
                            <div 
                                class="h-full rounded-full transition-all duration-150 ease-out bg-gradient-to-r from-brand-600 via-purple-500 to-pink-500 shadow-xs relative overflow-hidden"
                                :style="'width: ' + uploadProgress + '%'">
                                <!-- Animated Glow Wave -->
                                <div class="absolute inset-0 bg-white/25 animate-pulse"></div>
                            </div>
                        </div>

                        <!-- Metrics footer: Speed & ETA -->
                        <div class="flex items-center justify-between text-[11px] text-slate-500 font-mono pt-1">
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-gauge-high text-slate-400"></i>
                                <span>Speed: <strong class="text-slate-800" x-text="uploadSpeed || 'Calculating...'"></strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-slate-400"></i>
                                <span>Est. Time Remaining: <strong class="text-slate-800" x-text="timeRemaining || 'Calculating...'"></strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Pipeline Steps Indicator -->
                    <div class="grid grid-cols-3 gap-2 pt-2 border-t border-slate-100 text-[11px]">
                        <div class="flex items-center gap-1.5" :class="uploadProgress > 0 ? 'text-emerald-700 font-semibold' : 'text-slate-400'">
                            <i class="fa-solid fa-check text-emerald-600 text-[10px]"></i>
                            <span>1. Client Binary Pack</span>
                        </div>
                        <div class="flex items-center gap-1.5" :class="uploadProgress === 100 ? 'text-brand-700 font-bold' : (uploadProgress > 0 ? 'text-brand-600 font-medium' : 'text-slate-400')">
                            <i x-show="uploadProgress < 100" class="fa-solid fa-hourglass-half text-brand-600 text-[10px]"></i>
                            <i x-show="uploadProgress === 100" class="fa-solid fa-check text-emerald-600 text-[10px]"></i>
                            <span>2. Network Transfer</span>
                        </div>
                        <div class="flex items-center gap-1.5" :class="uploadProgress === 100 ? 'text-amber-600 font-bold' : 'text-slate-400'">
                            <i class="fa-solid fa-bolt text-amber-500 text-[10px]"></i>
                            <span>3. SHA-256 &amp; Save</span>
                        </div>
                    </div>

                    <!-- Cancel Upload Action -->
                    <div class="pt-2 flex justify-end" x-show="uploadProgress < 100">
                        <button type="button" @click="cancelUpload()" class="text-xs text-rose-600 hover:text-rose-800 hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-xmark"></i>
                            <span>Cancel Upload</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Minimum Android Version -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">
                    Supported Android Version
                </label>
                <input type="text" name="min_android_version" :disabled="isUploading" value="{{ old('min_android_version', $currentRelease->min_android_version ?? 'Android 8.0 (Oreo)+') }}" placeholder="e.g. Android 8.0 (Oreo)+" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-900 disabled:bg-slate-100 disabled:cursor-not-allowed">
                <p class="text-[11px] text-slate-400 mt-1">Minimum required Android OS version</p>
            </div>

            <!-- Changelog -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-2">Release Notes & Changelog</label>
                <textarea name="changelog" rows="5" required :disabled="isUploading" class="w-full text-xs font-mono px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 leading-relaxed disabled:bg-slate-100 disabled:cursor-not-allowed custom-scrollbar">{{ old('changelog', $currentRelease->changelog ?? "• Feed Posts with Images & Videos\n• 24-Hour Stories\n• 'Find Nearby People' Radar\n• Free HD Voice & Video Calls via Agora RTC\n• End-to-End Encrypted Private Chats") }}</textarea>
                @error('changelog') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button / Actions -->
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-xs text-slate-500">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 mr-1"></span>
                    File size and SHA-256 checksum are calculated automatically on upload.
                </div>
                
                <button 
                    type="submit" 
                    :disabled="isUploading"
                    class="px-8 py-3.5 text-sm font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2 min-w-[200px]">
                    
                    <template x-if="!isUploading">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Save Release to Database</span>
                        </span>
                    </template>

                    <template x-if="isUploading">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-spinner fa-spin text-white"></i>
                            <span x-text="uploadProgress < 100 ? 'Uploading (' + uploadProgress + '%)' : 'Processing Server Checksum...'"></span>
                        </span>
                    </template>
                </button>
            </div>
        </form>
    </div>

    <!-- All Release Versions & Download Analytics Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="font-extrabold text-base text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-chart-column text-brand-600"></i>
                    <span>All Release Versions &amp; Download Breakdown</span>
                </h3>
                <p class="text-xs text-slate-400">Historical record of all published APK builds and their individual download counts.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                    Total: {{ number_format($totalAllDownloads ?? 1250) }} Downloads
                </span>
            </div>
        </div>

        @if(empty($allReleases) || $allReleases->isEmpty())
            <div class="p-10 text-center text-slate-400 text-xs">
                No previous releases found in database.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3.5">Version &amp; Code</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5">Package Size</th>
                            <th class="px-6 py-3.5">Release Date</th>
                            <th class="px-6 py-3.5">Downloads</th>
                            <th class="px-6 py-3.5">Download Share</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                            $grandTotal = $totalAllDownloads > 0 ? $totalAllDownloads : 1;
                        @endphp
                        @foreach($allReleases as $rel)
                            @php
                                $percent = round(($rel->download_count / $grandTotal) * 100, 1);
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition {{ $rel->is_latest ? 'bg-purple-50/20' : '' }}" x-data="{ editingCount: false, countVal: {{ $rel->download_count ?? 0 }} }">
                                <!-- 1. Version & Code -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <span class="font-mono font-extrabold text-slate-900 text-sm">{{ $rel->version_name }}</span>
                                        <span class="text-[11px] font-mono px-2 py-0.5 rounded bg-slate-100 text-purple-700 font-bold border border-slate-200">
                                            Code #{{ $rel->version_code }}
                                        </span>
                                    </div>
                                </td>

                                <!-- 2. Status Badge -->
                                <td class="px-6 py-4">
                                    @if($rel->is_latest)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[11px]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Active (Live Build)</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200 font-medium text-[11px]">
                                            <span>Archived Build</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- 3. Package Size -->
                                <td class="px-6 py-4 font-mono font-bold text-slate-700">
                                    {{ $rel->file_size ?? '30 MB' }}
                                </td>

                                <!-- 4. Release Date -->
                                <td class="px-6 py-4 text-slate-500">
                                    <div>{{ $rel->created_at ? $rel->created_at->format('M d, Y') : 'Oct 03, 2026' }}</div>
                                    <span class="text-[10px] text-slate-400">{{ $rel->created_at ? $rel->created_at->diffForHumans() : '' }}</span>
                                </td>

                                <!-- 5. Download Count -->
                                <td class="px-6 py-4">
                                    <template x-if="!editingCount">
                                        <div>
                                            <div class="font-mono font-black text-slate-900 text-sm">
                                                {{ number_format($rel->download_count ?? 0) }}
                                            </div>
                                            <span class="text-[10px] text-slate-400">Total Downloads</span>
                                        </div>
                                    </template>
                                    <template x-if="editingCount">
                                        <form action="{{ route('admin.release.download-count', $rel->id) }}" method="POST" class="flex items-center gap-1.5">
                                            @csrf
                                            <input type="number" name="download_count" min="0" x-model="countVal" class="w-24 px-2 py-1 text-xs font-mono font-bold border border-brand-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-brand-500">
                                            <button type="submit" class="px-2 py-1 bg-emerald-600 text-white rounded-lg text-[10px] font-bold hover:bg-emerald-700 shadow-2xs inline-flex items-center gap-1"><i class="fa-solid fa-check"></i> <span>Save</span></button>
                                            <button type="button" @click="editingCount = false" class="px-2 py-1 bg-slate-200 text-slate-700 rounded-lg text-[10px] font-bold hover:bg-slate-300 inline-flex items-center"><i class="fa-solid fa-xmark"></i></button>
                                        </form>
                                    </template>
                                </td>

                                <!-- 6. Download Share % -->
                                <td class="px-6 py-4 min-w-[140px]">
                                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 mb-1">
                                        <span>{{ $percent }}%</span>
                                    </div>
                                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full {{ $rel->is_latest ? 'bg-gradient-to-r from-brand-600 to-pink-500' : 'bg-slate-400' }} rounded-full" style="width: {{ max(4, $percent) }}%;"></div>
                                    </div>
                                </td>

                                <!-- 7. Actions -->
                                <td class="px-6 py-4 text-right">
                                    <button type="button" @click="editingCount = !editingCount" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-brand-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg transition">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        <span>Edit Count</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
function apkReleaseManager() {
    return {
        fileName: '',
        fileSize: '{{ old('file_size', $currentRelease->file_size ?? '30 MB') }}',
        isDragging: false,
        isUploading: false,
        uploadProgress: 0,
        uploadedBytesFormatted: '0 MB',
        totalBytesFormatted: '0 MB',
        uploadSpeed: '',
        timeRemaining: '',
        uploadStatusText: 'Ready',
        statusDetailText: 'Uploading binary to server...',
        errorMessage: '',
        currentXhr: null,
        uploadStartTime: 0,
        lastBytes: 0,
        lastTime: 0,

        handleFileSelect(event) {
            const file = event.target.files[0];
            this.processFile(file);
        },

        handleDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            if (!files || files.length === 0) return;

            const file = files[0];
            if (!file.name.toLowerCase().endsWith('.apk')) {
                this.errorMessage = 'Please select a valid Android Package (.apk) file.';
                return;
            }

            const input = document.getElementById('apkFileInput');
            if (input) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
            }

            this.processFile(file);
        },

        processFile(file) {
            if (!file) return;

            if (!file.name.toLowerCase().endsWith('.apk')) {
                this.errorMessage = 'Only .apk files are supported for APK Release upload.';
                return;
            }

            this.errorMessage = '';
            this.fileName = file.name;
            
            // ⚡ Exact automatic calculation in MB (e.g. 30.4 MB)
            const sizeInMb = (file.size / (1024 * 1024)).toFixed(1);
            this.fileSize = sizeInMb + ' MB';
            this.totalBytesFormatted = this.fileSize;
        },

        clearFile() {
            this.fileName = '';
            this.fileSize = '{{ $currentRelease->file_size ?? '30 MB' }}';
            const input = document.getElementById('apkFileInput');
            if (input) input.value = '';
        },

        cancelUpload() {
            if (this.currentXhr) {
                this.currentXhr.abort();
                this.currentXhr = null;
            }
            this.isUploading = false;
            this.uploadProgress = 0;
            this.uploadStatusText = 'Cancelled';
            this.statusDetailText = 'Upload was cancelled by user.';
            this.errorMessage = 'APK upload was cancelled.';
        },

        submitForm(event) {
            const form = event.target;
            const fileInput = document.getElementById('apkFileInput');
            const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;

            this.errorMessage = '';

            // If no APK file is attached, perform standard form submit with fast feedback
            if (!hasFile) {
                form.submit();
                return;
            }

            // If an APK file is attached, run AJAX upload with live progress tracking
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            this.currentXhr = xhr;
            this.isUploading = true;
            this.uploadProgress = 0;
            this.uploadStatusText = 'Uploading';
            this.statusDetailText = 'Transferring binary packets to server...';
            this.uploadStartTime = Date.now();
            this.lastTime = this.uploadStartTime;
            this.lastBytes = 0;

            const totalBytes = fileInput.files[0].size;
            this.totalBytesFormatted = (totalBytes / (1024 * 1024)).toFixed(1) + ' MB';

            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percent = Math.min(99, Math.round((e.loaded / e.total) * 100));
                    this.uploadProgress = percent;
                    this.uploadedBytesFormatted = (e.loaded / (1024 * 1024)).toFixed(1) + ' MB';

                    const now = Date.now();
                    const timeDiff = (now - this.lastTime) / 1000; // in seconds

                    if (timeDiff >= 0.5 || percent === 99) {
                        const bytesDiff = e.loaded - this.lastBytes;
                        const speedBytesPerSec = timeDiff > 0 ? (bytesDiff / timeDiff) : 0;
                        const speedMb = (speedBytesPerSec / (1024 * 1024)).toFixed(1);
                        this.uploadSpeed = speedMb > 0 ? speedMb + ' MB/s' : 'Calculating...';

                        const remainingBytes = e.total - e.loaded;
                        if (speedBytesPerSec > 0 && remainingBytes > 0) {
                            const remainingSeconds = Math.ceil(remainingBytes / speedBytesPerSec);
                            if (remainingSeconds < 60) {
                                this.timeRemaining = remainingSeconds + 's remaining';
                            } else {
                                const minutes = Math.floor(remainingSeconds / 60);
                                const seconds = remainingSeconds % 60;
                                this.timeRemaining = `${minutes}m ${seconds}s remaining`;
                            }
                        }

                        this.lastBytes = e.loaded;
                        this.lastTime = now;
                    }
                }
            });

            xhr.upload.addEventListener('load', () => {
                // Upload complete, waiting for server processing (SHA-256 calculation & DB save)
                this.uploadProgress = 100;
                this.uploadStatusText = 'Processing';
                this.statusDetailText = 'Binary received. Server is calculating SHA-256 checksum & saving release to database...';
                this.timeRemaining = 'Almost done...';
                this.uploadSpeed = 'Done';
            });

            xhr.addEventListener('load', () => {
                this.isUploading = false;
                this.currentXhr = null;

                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.redirect) {
                            window.location.href = response.redirect;
                            return;
                        }
                    } catch (err) {
                        // If not JSON (e.g. standard redirect)
                        window.location.reload();
                        return;
                    }
                    window.location.reload();
                } else if (xhr.status === 422) {
                    try {
                        const res = JSON.parse(xhr.responseText);
                        if (res.errors) {
                            const errorList = Object.values(res.errors).flat().join(' ');
                            this.errorMessage = errorList || 'Validation failed. Please check form fields.';
                        } else {
                            this.errorMessage = res.message || 'Validation failed.';
                        }
                    } catch (e) {
                        this.errorMessage = 'Validation error occurred while saving the release.';
                    }
                } else if (xhr.status === 413) {
                    this.errorMessage = 'The uploaded APK binary exceeds the maximum allowed server upload size (post_max_size / upload_max_filesize).';
                } else {
                    this.errorMessage = `Server returned error (${xhr.status}). Please check server logs and try again.`;
                }
            });

            xhr.addEventListener('error', () => {
                this.isUploading = false;
                this.currentXhr = null;
                this.errorMessage = 'Network error occurred during APK upload. Please check your internet connection.';
            });

            xhr.addEventListener('abort', () => {
                this.isUploading = false;
                this.currentXhr = null;
            });

            xhr.open('POST', '{{ route('admin.release.update') }}', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.send(formData);
        }
    }
}
</script>
@endpush
@endsection
