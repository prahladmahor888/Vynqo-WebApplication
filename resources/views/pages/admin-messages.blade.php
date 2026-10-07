@extends('layouts.admin')

@section('title', 'User Support & Inquiries — Sangfy Admin')
@section('page_title', 'User Inquiries')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-bold uppercase tracking-wide border border-pink-200 mb-2">
                <i class="fa-solid fa-comments"></i>
                <span>Help Desk</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">User Inquiries & Support Messages</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Review contact form submissions, bug reports, and user feedback.</p>
        </div>

        <div>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 shrink-0 text-base"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Messages List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($messages->isEmpty())
            <div class="p-12 text-center space-y-3">
                <i class="fa-solid fa-inbox text-4xl text-slate-300"></i>
                <h3 class="text-lg font-bold text-slate-900">No Inquiries Yet</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">When users submit messages through the contact form or privacy desk, they will appear here.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($messages as $msg)
                    <div class="p-6 hover:bg-slate-50 transition space-y-3">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900 text-sm">{{ $msg->name }}</span>
                                <span class="text-xs text-slate-400 font-mono">&lt;{{ $msg->email }}&gt;</span>
                                @if($msg->is_resolved)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">Resolved</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200">Pending</span>
                                @endif
                            </div>
                            <span class="text-xs text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>

                        <div>
                            <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider mb-1">{{ $msg->subject }}</h4>
                            <p class="text-xs text-slate-600 bg-slate-50 p-3.5 rounded-xl border border-slate-200/60 leading-relaxed">{{ $msg->message }}</p>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-2">
                            <a href="mailto:{{ $msg->email }}?subject=Re: {{ rawurlencode($msg->subject) }}" class="px-3 py-1.5 text-xs font-semibold text-brand-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg transition inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-envelope text-xs"></i>
                                <span>Reply to User</span>
                            </a>

                            <form action="{{ route('admin.messages.toggle', $msg->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 transition">
                                    {{ $msg->is_resolved ? 'Mark Pending' : 'Mark Resolved' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.messages.delete', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 rounded-lg hover:bg-rose-100 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
