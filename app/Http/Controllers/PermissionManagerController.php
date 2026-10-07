<?php

namespace App\Http\Controllers;

use App\Models\AppPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        } else {
            // Auto-upgrade legacy emoji or missing icons in database
            $emojiMap = [
                '📷' => 'fa-solid fa-camera',
                '📸' => 'fa-solid fa-camera',
                '🎤' => 'fa-solid fa-microphone',
                '📁' => 'fa-solid fa-folder-open',
                '📂' => 'fa-solid fa-folder-open',
                '🗂️' => 'fa-solid fa-folder-open',
                '📍' => 'fa-solid fa-location-dot',
                '🗺️' => 'fa-solid fa-location-dot',
                '🔔' => 'fa-solid fa-bell',
                '🎧' => 'fa-solid fa-headphones',
                '🌐' => 'fa-solid fa-globe',
            ];
            
            $defaults = collect(AppPermission::getDefaultPermissions())->keyBy('name');

            foreach (AppPermission::all() as $p) {
                $rawIcon = trim($p->icon ?? '');
                if (isset($emojiMap[$rawIcon])) {
                    $p->update(['icon' => $emojiMap[$rawIcon]]);
                } elseif (empty($rawIcon) || $rawIcon === 'fa-') {
                    if (isset($defaults[$p->name])) {
                        $p->update(['icon' => $defaults[$p->name]['icon']]);
                    } else {
                        $p->update(['icon' => 'fa-solid fa-shield-halved']);
                    }
                }
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
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp,ico,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:50',
            'purpose' => 'required|string',
            'order_index' => 'nullable|integer',
        ]);

        if ($request->hasFile('icon_file')) {
            $uploadDir = public_path('uploads/permissions');
            File::ensureDirectoryExists($uploadDir);
            $file = $request->file('icon_file');
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'perm-' . time() . '-' . Str::random(6) . '.' . $extension;
            $file->move($uploadDir, $filename);
            $validated['icon'] = 'uploads/permissions/' . $filename;
        } else {
            $validated['icon'] = !empty(trim($validated['icon'] ?? '')) ? trim($validated['icon']) : 'fa-solid fa-lock';
        }

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
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp,ico,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:50',
            'purpose' => 'required|string',
            'order_index' => 'nullable|integer',
        ]);

        if ($request->hasFile('icon_file')) {
            $uploadDir = public_path('uploads/permissions');
            File::ensureDirectoryExists($uploadDir);
            $file = $request->file('icon_file');
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'perm-' . time() . '-' . Str::random(6) . '.' . $extension;
            $file->move($uploadDir, $filename);
            $validated['icon'] = 'uploads/permissions/' . $filename;
        } elseif ($request->has('icon')) {
            $validated['icon'] = !empty(trim($validated['icon'] ?? '')) ? trim($validated['icon']) : ($permission->icon ?: 'fa-solid fa-lock');
        } else {
            $validated['icon'] = $permission->icon ?: 'fa-solid fa-lock';
        }

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
