@extends('layouts.admin')

@section('title', 'Android App Permissions Manager — Sangfy Admin')
@section('page_title', 'Android Permissions Manager')

@section('content')
<div class="max-w-6xl mx-auto space-y-5 sm:space-y-6">
    
    <!-- Header Card -->
    <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200 shadow-sm flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-200 text-brand-700 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Dynamic Privacy Policy Permissions</span>
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                Android Device Permissions Desk
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-2xl">
                Manage Android runtime permissions. Changes reflect <strong>instantly on the public Privacy Policy page</strong> (<a href="{{ route('legal.privacy') }}" target="_blank" class="text-brand-600 underline font-semibold">/privacy-policy</a>).
            </p>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 sm:gap-2.5 pt-2 lg:pt-0">
            <button type="button" onclick="openCreateModal()" class="w-full sm:w-auto px-4 py-2.5 text-xs font-bold text-white btn-sangfy rounded-xl shadow-md transition hover:shadow-lg flex items-center justify-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Permission</span>
            </button>
            
            <form action="{{ route('admin.permissions.reset') }}" method="POST" onsubmit="return confirm('Restore all 7 official Android app permissions to default state? Custom edits will be overwritten.');" class="w-full sm:w-auto inline-flex">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-3.5 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer" title="Reset all permissions to official Android defaults">
                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Reset Defaults</span>
                </button>
            </form>

            <a href="{{ route('legal.privacy') }}" target="_blank" class="w-full sm:w-auto px-3.5 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center justify-center gap-1.5">
                <span>View Live</span>
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm space-y-1 shadow-xs">
            <div class="font-bold flex items-center gap-1.5">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Please fix the following validation errors:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Permissions Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Table / List Header -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900">Active Android Device Permissions</h2>
                <p class="text-[11px] sm:text-xs text-slate-500">Listed in order of display on Privacy Policy and Google Play compliance</p>
            </div>
            <span class="text-xs font-mono font-bold px-2.5 py-1 rounded bg-slate-100 text-slate-700 w-fit">
                Total: {{ count($permissions) }} Permissions
            </span>
        </div>

        <!-- 1. Mobile Card View (< md screens) -->
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse($permissions as $perm)
                <div class="p-4 space-y-3 {{ !$perm->is_active ? 'opacity-60 bg-slate-50/40' : 'bg-white' }}">
                    
                    <!-- Top row: Icon, Name, Category badge -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl p-2 rounded-xl bg-purple-50 border border-purple-100 shadow-2xs shrink-0">{{ $perm->icon }}</span>
                            <div>
                                <div class="font-bold text-sm text-slate-900 flex items-center gap-1.5 flex-wrap">
                                    <span>{{ $perm->name }}</span>
                                    @if($perm->is_required)
                                        <span class="text-[10px] bg-rose-100 text-rose-700 font-bold px-1.5 py-0.2 rounded">Required</span>
                                    @endif
                                </div>
                                <code class="text-[10px] text-brand-700 font-mono break-all block mt-0.5">{{ $perm->code ?: 'N/A' }}</code>
                            </div>
                        </div>

                        <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-purple-100 text-brand-800">
                            {{ $perm->badge }}
                        </span>
                    </div>

                    <!-- Middle: Purpose -->
                    <p class="text-xs text-slate-600 leading-relaxed bg-slate-50/80 p-2.5 rounded-xl border border-slate-100">
                        {{ $perm->purpose }}
                    </p>

                    <!-- Bottom row: Category, Status Toggle, Actions -->
                    <div class="flex items-center justify-between pt-1 text-xs">
                        <span class="text-[11px] text-slate-500 font-medium">
                            Category: <strong class="text-slate-700">{{ $perm->category }}</strong>
                        </span>

                        <div class="flex items-center gap-2">
                            <!-- Status Toggle -->
                            <form action="{{ route('admin.permissions.toggle', $perm->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-full text-[11px] font-bold transition cursor-pointer {{ $perm->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                                    {{ $perm->is_active ? 'Active' : 'Disabled' }}
                                </button>
                            </form>

                            <!-- Edit -->
                            <button type="button" onclick="openEditModal({{ json_encode($perm) }})" class="p-1.5 text-slate-600 hover:text-brand-600 bg-slate-100 hover:bg-purple-50 rounded-lg transition cursor-pointer" title="Edit Permission">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('admin.permissions.delete', $perm->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete permission \'{{ $perm->name }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 bg-slate-100 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Delete Permission">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @empty
                <div class="p-8 text-center text-slate-500 text-xs">
                    No device permissions found. Click "Add Permission" or "Reset Defaults" above.
                </div>
            @endforelse
        </div>

        <!-- 2. Desktop Table View (>= md screens) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                        <th class="p-4">Permission & Code</th>
                        <th class="p-4">Category & Badge</th>
                        <th class="p-4">Purpose / Justification</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($permissions as $perm)
                        <tr class="hover:bg-slate-50/60 transition {{ !$perm->is_active ? 'opacity-60 bg-slate-50/30' : '' }}">
                            <!-- Permission & Code -->
                            <td class="p-4">
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl p-2 rounded-xl bg-purple-50 border border-purple-100 shadow-2xs">{{ $perm->icon }}</span>
                                    <div>
                                        <div class="font-bold text-sm text-slate-900 flex items-center gap-2">
                                            <span>{{ $perm->name }}</span>
                                            @if($perm->is_required)
                                                <span class="text-[10px] bg-rose-100 text-rose-700 font-bold px-2 py-0.5 rounded">Required</span>
                                            @endif
                                        </div>
                                        <code class="text-[11px] text-brand-700 font-mono block mt-0.5">{{ $perm->code ?: 'N/A' }}</code>
                                    </div>
                                </div>
                            </td>

                            <!-- Category & Badge -->
                            <td class="p-4">
                                <div class="space-y-1">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-purple-100 text-brand-800">
                                        {{ $perm->category }}
                                    </span>
                                    <div class="text-[11px] text-slate-500 font-medium">Badge: <strong>{{ $perm->badge }}</strong></div>
                                </div>
                            </td>

                            <!-- Purpose -->
                            <td class="p-4 max-w-xs lg:max-w-md">
                                <p class="text-slate-600 line-clamp-3 leading-relaxed">
                                    {{ $perm->purpose }}
                                </p>
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.permissions.toggle', $perm->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-full text-[11px] font-bold transition cursor-pointer {{ $perm->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                                        {{ $perm->is_active ? 'Active' : 'Disabled' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-right space-x-1 whitespace-nowrap">
                                <button type="button" onclick="openEditModal({{ json_encode($perm) }})" class="p-2 text-slate-600 hover:text-brand-600 hover:bg-purple-50 rounded-lg transition cursor-pointer" title="Edit Permission">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>

                                <form action="{{ route('admin.permissions.delete', $perm->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete permission \'{{ $perm->name }}\'?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Delete Permission">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                No device permissions found. Click "Add Permission" or "Reset Defaults" above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Create / Edit Modal -->
    <div id="permissionModal" 
         style="display: none;" 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4 md:p-6">
        
        <div class="bg-white rounded-2xl sm:rounded-3xl max-w-lg w-full border border-slate-200 shadow-2xl overflow-hidden flex flex-col max-h-[92vh] my-auto" 
             onclick="event.stopPropagation()">
            
            <!-- Modal Header -->
            <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70 shrink-0">
                <div class="flex items-center gap-2.5 min-w-0">
                    <span id="perm_icon_preview" class="w-8 h-8 rounded-xl bg-purple-100 text-brand-700 flex items-center justify-center font-bold text-sm shrink-0">🔒</span>
                    <h3 id="modalTitle" class="text-sm sm:text-base md:text-lg font-bold text-slate-900 truncate">Add New Android Permission</h3>
                </div>
                <button type="button" onclick="closePermissionModal()" class="p-2 text-slate-400 hover:text-slate-700 rounded-xl hover:bg-slate-100 transition cursor-pointer shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="permissionForm" action="{{ route('admin.permissions.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <input type="hidden" name="_method" id="perm_method" value="POST">

                <!-- Scrollable Form Body -->
                <div class="p-4 sm:p-6 overflow-y-auto space-y-4 flex-1">
                    
                    <!-- Icon & Name -->
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div class="sm:col-span-1">
                            <label class="block text-[11px] font-bold uppercase text-slate-700 tracking-wider mb-1">Emoji</label>
                            <input type="text" name="icon" id="perm_icon" oninput="document.getElementById('perm_icon_preview').innerText = this.value || '🔒'" required placeholder="📷" value="🔒" class="w-full text-center text-xl px-2 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:outline-none bg-slate-50 focus:bg-white font-mono">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-[11px] font-bold uppercase text-slate-700 tracking-wider mb-1">Permission Name *</label>
                            <input type="text" name="name" id="perm_name" required placeholder="e.g. Camera" class="w-full text-sm px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:outline-none font-bold">
                        </div>
                    </div>

                    <!-- Code -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase text-slate-700 tracking-wider mb-1">Android Permission Manifest Code</label>
                        <input type="text" name="code" id="perm_code" placeholder="e.g. android.permission.CAMERA" class="w-full text-xs font-mono px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:outline-none">
                    </div>

                    <!-- Category & Badge -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-700 tracking-wider mb-1">Category</label>
                            <input type="text" name="category" id="perm_category" placeholder="e.g. Media & Capture" value="General" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-700 tracking-wider mb-1">Badge Type</label>
                            <select name="badge" id="perm_badge" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:outline-none bg-white">
                                <option value="Feature-Based">Feature-Based</option>
                                <option value="User-Initiated">User-Initiated</option>
                                <option value="Optional">Optional</option>
                                <option value="Required">Required</option>
                            </select>
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase text-slate-700 tracking-wider mb-1">Purpose / Data Safety Justification *</label>
                        <textarea name="purpose" id="perm_purpose" rows="3" required placeholder="Explain why the Sangfy app needs this permission..." class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:outline-none leading-relaxed"></textarea>
                    </div>

                    <!-- Flags -->
                    <div class="pt-2 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6 bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                        <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_required" id="perm_is_required" value="1" class="w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                            <span>Mandatory for App</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" name="is_active" id="perm_is_active" value="1" checked class="w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                            <span>Show on Privacy Policy</span>
                        </label>
                    </div>

                </div>

                <!-- Sticky Modal Footer with High-Contrast Action Buttons -->
                <div class="px-4 py-3 sm:px-6 sm:py-4 bg-slate-50 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2 sm:gap-3 shrink-0">
                    <button type="button" onclick="closePermissionModal()" class="w-full sm:w-auto px-4 py-2.5 text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 border border-slate-300 rounded-xl transition cursor-pointer shadow-2xs text-center">
                        Cancel
                    </button>
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-purple-600 via-brand-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl shadow-md hover:shadow-lg transition cursor-pointer flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span id="submitBtnText">Save Permission</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
const STORE_URL = "{{ route('admin.permissions.store') }}";
const BASE_UPDATE_URL = "{{ url('admin/permissions') }}";

function openCreateModal() {
    const modal = document.getElementById('permissionModal');
    const form = document.getElementById('permissionForm');
    
    form.action = STORE_URL;
    document.getElementById('perm_method').value = 'POST';
    document.getElementById('modalTitle').innerText = 'Add New Android Permission';
    document.getElementById('submitBtnText').innerText = 'Save Permission';
    
    document.getElementById('perm_icon').value = '🔒';
    document.getElementById('perm_icon_preview').innerText = '🔒';
    document.getElementById('perm_name').value = '';
    document.getElementById('perm_code').value = '';
    document.getElementById('perm_category').value = 'General';
    document.getElementById('perm_badge').value = 'Feature-Based';
    document.getElementById('perm_purpose').value = '';
    document.getElementById('perm_is_required').checked = false;
    document.getElementById('perm_is_active').checked = true;
    
    modal.style.display = 'flex';
}

function openEditModal(item) {
    const modal = document.getElementById('permissionModal');
    const form = document.getElementById('permissionForm');
    
    form.action = BASE_UPDATE_URL + '/' + item.id;
    document.getElementById('perm_method').value = 'PUT';
    document.getElementById('modalTitle').innerText = 'Edit Android Permission: ' + (item.name || '');
    document.getElementById('submitBtnText').innerText = 'Update Permission';
    
    const icon = item.icon || '🔒';
    document.getElementById('perm_icon').value = icon;
    document.getElementById('perm_icon_preview').innerText = icon;
    document.getElementById('perm_name').value = item.name || '';
    document.getElementById('perm_code').value = item.code || '';
    document.getElementById('perm_category').value = item.category || 'General';
    document.getElementById('perm_badge').value = item.badge || 'Feature-Based';
    document.getElementById('perm_purpose').value = item.purpose || '';
    document.getElementById('perm_is_required').checked = Boolean(item.is_required);
    document.getElementById('perm_is_active').checked = Boolean(item.is_active);
    
    modal.style.display = 'flex';
}

function closePermissionModal() {
    const modal = document.getElementById('permissionModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Close modal when clicking on backdrop
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('permissionModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closePermissionModal();
            }
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePermissionModal();
        }
    });
});
</script>
@endpush
@endsection
