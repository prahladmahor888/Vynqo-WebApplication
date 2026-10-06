<?php

namespace App\Http\Controllers;

use App\Models\AppPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionManagerController extends Controller
{
    /**
     * Show all Android app permissions in Admin Panel.
     */
    public function index()
    {
        // Auto-seed default permissions if table is empty
        if (AppPermission::count() === 0) {
            foreach (AppPermission::getDefaultPermissions() as $perm) {
                AppPermission::create($perm);
            }
        }

        $permissions = AppPermission::orderBy('order_index')->orderBy('id')->get();
        return view('pages.admin-permissions', compact('permissions'));
    }

    /**
     * Store a newly created permission in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:150',
            'icon' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:50',
            'purpose' => 'required|string',
            'order_index' => 'nullable|integer',
        ]);

        $validated['icon'] = !empty(trim($validated['icon'] ?? '')) ? trim($validated['icon']) : '🔒';
        $validated['category'] = !empty(trim($validated['category'] ?? '')) ? trim($validated['category']) : 'General';
        $validated['badge'] = !empty(trim($validated['badge'] ?? '')) ? trim($validated['badge']) : 'Feature-Based';
        $validated['code'] = !empty(trim($validated['code'] ?? '')) ? trim($validated['code']) : ('android.permission.' . strtoupper(Str::slug($validated['name'], '_')));
        $validated['is_required'] = $request->has('is_required') || $request->input('is_required') == '1';
        $validated['is_active'] = $request->has('is_active') || $request->input('is_active') == '1';
        $validated['order_index'] = (int) ($validated['order_index'] ?? 0);

        AppPermission::create($validated);

        return redirect()->route('admin.permissions.index')->with('success', "Android permission '{$validated['name']}' added successfully!");
    }

    /**
     * Update an existing permission.
     */
    public function update(Request $request, AppPermission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:150',
            'icon' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:50',
            'purpose' => 'required|string',
            'order_index' => 'nullable|integer',
        ]);

        $validated['icon'] = !empty(trim($validated['icon'] ?? '')) ? trim($validated['icon']) : ($permission->icon ?: '🔒');
        $validated['category'] = !empty(trim($validated['category'] ?? '')) ? trim($validated['category']) : 'General';
        $validated['badge'] = !empty(trim($validated['badge'] ?? '')) ? trim($validated['badge']) : 'Feature-Based';
        $validated['code'] = !empty(trim($validated['code'] ?? '')) ? trim($validated['code']) : ('android.permission.' . strtoupper(Str::slug($validated['name'], '_')));
        $validated['is_required'] = $request->has('is_required') || $request->input('is_required') == '1';
        $validated['is_active'] = $request->has('is_active') || $request->input('is_active') == '1';
        $validated['order_index'] = (int) ($validated['order_index'] ?? $permission->order_index ?? 0);

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')->with('success', "Permission '{$permission->name}' updated successfully!");
    }

    /**
     * Reset permissions to Android defaults.
     */
    public function reset()
    {
        AppPermission::truncate();
        foreach (AppPermission::getDefaultPermissions() as $perm) {
            AppPermission::create($perm);
        }

        return redirect()->route('admin.permissions.index')->with('success', 'All Android app permissions reset to official defaults successfully.');
    }

    /**
     * Toggle permission active/inactive status.
     */
    public function toggle(AppPermission $permission)
    {
        $permission->update(['is_active' => !$permission->is_active]);

        $status = $permission->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.permissions.index')->with('success', "Permission '{$permission->name}' is now {$status}.");
    }

    /**
     * Delete permission from database.
     */
    public function destroy(AppPermission $permission)
    {
        $name = $permission->name;
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', "Permission '{$name}' deleted successfully.");
    }
}
