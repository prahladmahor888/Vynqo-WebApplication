<?php

namespace App\Http\Controllers;

use App\Models\AppPermission;
use Illuminate\Http\Request;

class PermissionManagerController extends Controller
{
    /**
     * Show all Android app permissions in Admin Panel.
     */
    public function index()
    {
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
            'category' => 'required|string|max:100',
            'badge' => 'required|string|max:50',
            'purpose' => 'required|string',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'order_index' => 'nullable|integer',
        ]);

        $validated['icon'] = $validated['icon'] ?: '🔒';
        $validated['is_required'] = $request->boolean('is_required');
        $validated['is_active'] = $request->boolean('is_active', true);
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
            'category' => 'required|string|max:100',
            'badge' => 'required|string|max:50',
            'purpose' => 'required|string',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'order_index' => 'nullable|integer',
        ]);

        $validated['icon'] = $validated['icon'] ?: '🔒';
        $validated['is_required'] = $request->boolean('is_required');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order_index'] = (int) ($validated['order_index'] ?? 0);

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')->with('success', "Permission '{$permission->name}' updated successfully!");
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
