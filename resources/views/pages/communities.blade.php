@extends('layouts.app')

@section('title', 'Explore Communities & Rooms — Sangfy')
@section('meta_description', 'Discover vibrant public and private community rooms on Sangfy. Join gaming lobbies, technology discussions, photography clubs, and travel groups without sharing your phone number.')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-indigo-50 border border-indigo-100 text-brand-700 text-xs font-semibold">
            <span>🌐 Social & Community Rooms</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            Discover Communities That Match Your Passion
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Connect with like-minded people around the world. Join discussions, share media, and participate in live HD voice lounges — without ever sharing your phone number.
        </p>
    </div>
</section>

<!-- Communities Explorer Section with Alpine Category Filter -->
<section class="py-16 bg-white border-b border-slate-200" x-data="{ selectedCategory: 'All' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Category Filter Pills -->
        <div class="flex flex-wrap items-center justify-center gap-2 pb-4">
            @foreach($categories as $category)
                <button 
                    @click="selectedCategory = '{{ $category }}'"
                    :class="selectedCategory === '{{ $category }}' ? 'bg-brand-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200/80'"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition"
                >
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <!-- Room Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allRooms as $room)
                <div 
                    x-show="selectedCategory === 'All' || selectedCategory === '{{ $room['category'] }}'"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="sangfy-card p-6 flex flex-col justify-between group space-y-4"
                >
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-2xl group-hover:scale-105 transition">
                                {{ $room['icon'] }}
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded bg-indigo-50 text-brand-700 border border-indigo-100">
                                {{ $room['badge'] }}
                            </span>
                        </div>

                        <div>
                            <span class="text-[11px] font-mono font-semibold text-brand-600">{{ $room['tag'] }}</span>
                            <h3 class="text-lg font-bold text-slate-900 mt-0.5">{{ $room['name'] }}</h3>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed">{{ $room['description'] }}</p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-xs text-slate-500">
                            <span class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <strong class="text-slate-800">{{ number_format($room['online']) }}</strong> online
                            </span>
                            <span>•</span>
                            <span>{{ number_format($room['members']) }} members</span>
                        </div>
                        <a href="{{ route('download.page') }}" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 hover:text-brand-700">
                            <span>Join</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Community Rules Callout -->
<section class="py-16 bg-slate-50 text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Want to create your own Community Room?</h3>
        <p class="text-sm text-slate-600 max-w-lg mx-auto">Download Sangfy now and start custom public or private groups with up to 50,000 members and live HD voice lounges.</p>
        <div>
            <a href="{{ route('download.apk') }}" class="inline-flex items-center gap-2 px-8 py-3.5 text-base font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Download Sangfy to Join</span>
            </a>
        </div>
    </div>
</section>
@endsection
