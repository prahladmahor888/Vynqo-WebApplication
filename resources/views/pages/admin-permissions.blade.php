@extends('layouts.admin')

@section('title', 'Android App Permissions Manager — Vynqo Admin')
@section('page_title', 'Android Permissions Manager')

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="permissionsManager()">
    
    <!-- Header Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 border border-purple-200 text-brand-700 text-xs font-semibold mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Dynamic Privacy Policy Permissions</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Android Device Permissions Desk
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Manage all Android runtime permissions. Changes reflect <strong>instantly on the public Privacy Policy page</strong> (<a href="{{ route('legal.privacy') }}" target="_blank" class="text-brand-600 underline font-semibold">/privacy-policy</a>).
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button @click="openCreateModal()" class="px-5 py-2.5 text-xs font-bold text-white btn-vynqo rounded-xl shadow-md transition hover:shadow-lg flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add New Permission</span>
            </button>
            <a href="{{ route('legal.privacy') }}" target="_blank" class="px-4 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded-xl transition flex items-center gap-1.5">
                <span>View Live Policy</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
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

    <!-- Permissions List Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Active Android Device Permissions</h2>
                <p class="text-xs text-slate-500">Listed in order of display on Privacy Policy and Google Play Store compliance</p>
            </div>
            <span class="text-xs font-mono font-bold px-2.5 py-1 rounded bg-slate-100 text-slate-700">
                Total: {{ count($permissions) }} Permissions
            </span>
        </div>

        <div class="overflow-x-auto">
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
                            <td class="p-4 max-w-xs sm:max-w-md">
                                <p class="text-slate-600 line-clamp-3 leading-relaxed">
                                    {{ $perm->purpose }}
                                </p>
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.permissions.toggle', $perm->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-full text-[11px] font-bold transition {{ $perm->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                                        {{ $perm->is_active ? 'Active' : 'Disabled' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-right space-x-1">
                                <button @click="openEditModal({{ json_encode($perm) }})" class="p-2 text-slate-600 hover:text-brand-600 hover:bg-purple-50 rounded-lg transition" title="Edit Permission">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>

                                <form action="{{ route('admin.permissions.delete', $perm->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete permission \'{{ $perm->name }}\'?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Delete Permission">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                No device permissions found. Click "Add New Permission" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create / Edit Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 border border-slate-200 shadow-2xl space-y-6" @click.away="showModal = false">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-lg font-bold text-slate-900" x-text="isEdit ? 'Edit Android Permission' : 'Add New Android Permission'"></h3>
                <button @click="showModal = false" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="isEdit ? '/admin/permissions/' + currentItem.id : '{{ route('admin.permissions.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Icon (Emoji)</label>
                        <input type="text" name="icon" x-model="currentItem.icon" required placeholder="e.g. 📷" class="w-full text-center text-lg px-3 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Permission Name *</label>
                        <input type="text" name="name" x-model="currentItem.name" required placeholder="e.g. Camera" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:outline-none font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Android Permission Code</label>
                    <input type="text" name="code" x-model="currentItem.code" placeholder="e.g. android.permission.CAMERA" class="w-full text-xs font-mono px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Category</label>
                        <input type="text" name="category" x-model="currentItem.category" placeholder="e.g. Media & Capture" class="w-full text-xs px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Badge Type</label>
                        <select name="badge" x-model="currentItem.badge" class="w-full text-xs px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:outline-none bg-white">
                            <option value="Feature-Based">Feature-Based</option>
                            <option value="User-Initiated">User-Initiated</option>
                            <option value="Optional">Optional</option>
                            <option value="Required">Required</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 tracking-wider mb-1.5">Purpose &amp; Justification *</label>
                    <textarea name="purpose" x-model="currentItem.purpose" rows="3" required placeholder="Explain why the Android app needs this permission and how user data is protected..." class="w-full text-xs px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:outline-none leading-relaxed"></textarea>
                </div>

                <div class="flex items-center gap-6 pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                        <input type="checkbox" name="is_required" x-model="currentItem.is_required" class="w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                        <span>Mandatory for App Operation</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                        <input type="checkbox" name="is_active" x-model="currentItem.is_active" class="w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                        <span>Show on Public Privacy Policy</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 text-xs font-bold text-white btn-vynqo rounded-xl shadow-md transition hover:shadow-lg">
                        <span x-text="isEdit ? 'Update Permission' : 'Save Permission'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
function permissionsManager() {
    return {
        showModal: false,
        isEdit: false,
        currentItem: {
            id: null,
            name: '',
            code: '',
            icon: '🔒',
            category: 'General',
            badge: 'Feature-Based',
            purpose: '',
            is_required: false,
            is_active: true,
            order_index: 0
        },

        openCreateModal() {
            this.isEdit = false;
            this.currentItem = {
                id: null,
                name: '',
                code: '',
                icon: '🔒',
                category: 'General',
                badge: 'Feature-Based',
                purpose: '',
                is_required: false,
                is_active: true,
                order_index: 0
            };
            this.showModal = true;
        },

        openEditModal(item) {
            this.isEdit = true;
            this.currentItem = { ...item };
            this.showModal = true;
        }
    }
}
</script>
@endpush
@endsection
