<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'icon',
        'category',
        'badge',
        'purpose',
        'is_required',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    /**
     * Scope for active permissions sorted by order index.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order_index')->orderBy('id');
    }

    /**
     * Default list of official Android permissions for Sangfy.
     */
    public static function getDefaultPermissions(): array
    {
        return [
            [
                'name' => 'Camera',
                'code' => 'android.permission.CAMERA',
                'icon' => 'fa-solid fa-camera',
                'category' => 'Media & Capture',
                'badge' => 'Feature-Based',
                'purpose' => 'Required for capturing photos, recording video reels and 24h stories, taking profile pictures, and participating in live HD video calls.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 1,
            ],
            [
                'name' => 'Microphone',
                'code' => 'android.permission.RECORD_AUDIO',
                'icon' => 'fa-solid fa-microphone',
                'category' => 'Communication',
                'badge' => 'Feature-Based',
                'purpose' => 'Required for recording voice notes in private chat and transmitting crystal-clear audio during HD voice and video calls powered by Agora RTC.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 2,
            ],
            [
                'name' => 'Photo & Media Library',
                'code' => 'android.permission.READ_MEDIA_IMAGES / READ_MEDIA_VIDEO',
                'icon' => 'fa-solid fa-folder-open',
                'category' => 'Storage',
                'badge' => 'Feature-Based',
                'purpose' => 'Required for selecting and uploading media files (images, video reels, avatars) from device storage to publish on the Platform.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 3,
            ],
            [
                'name' => 'Location (Nearby Radar)',
                'code' => 'android.permission.ACCESS_FINE_LOCATION / ACCESS_COARSE_LOCATION',
                'icon' => 'fa-solid fa-location-dot',
                'category' => 'Location & Discovery',
                'badge' => 'User-Initiated',
                'purpose' => 'Used solely for calculating generalized distance approximations in the optional Nearby feature. Exact GPS coordinates are never stored, transmitted, or displayed to other users.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 4,
            ],
            [
                'name' => 'Push Notifications',
                'code' => 'android.permission.POST_NOTIFICATIONS',
                'icon' => 'fa-solid fa-bell',
                'category' => 'Alerts & Messages',
                'badge' => 'Optional',
                'purpose' => 'Required to deliver instant message alerts, incoming call notifications, story replies, and important account security notices.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 5,
            ],
            [
                'name' => 'Bluetooth Audio & Headsets',
                'code' => 'android.permission.BLUETOOTH_CONNECT',
                'icon' => 'fa-solid fa-headphones',
                'category' => 'Audio Routing',
                'badge' => 'Feature-Based',
                'purpose' => 'Enables seamless audio routing to wireless Bluetooth headsets, earbuds, and hands-free car systems during active voice and video calls.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 6,
            ],
            [
                'name' => 'Network & Internet',
                'code' => 'android.permission.INTERNET',
                'icon' => 'fa-solid fa-globe',
                'category' => 'Core Connectivity',
                'badge' => 'Required',
                'purpose' => 'Required to establish secure TLS/HTTPS encrypted connections to servers, sync feeds, and stream real-time Agora RTC voice/video calls.',
                'is_required' => true,
                'is_active' => true,
                'order_index' => 7,
            ],
        ];
    }

    /**
     * Get properly formatted HTML rendering for this permission's icon.
     */
    public function getIconHtmlAttribute(): string
    {
        return self::renderIcon($this->icon, $this->name);
    }

    /**
     * Static helper to render any icon safely.
     */
    public static function renderIcon(?string $icon, string $name = 'Permission'): string
    {
        $icon = trim($icon ?? '');

        // 1. Uploaded or local image asset
        if (str_starts_with($icon, 'uploads/') || str_starts_with($icon, 'assets/') || str_starts_with($icon, 'http://') || str_starts_with($icon, 'https://') || str_starts_with($icon, '/')) {
            $src = (str_starts_with($icon, 'http://') || str_starts_with($icon, 'https://')) ? e($icon) : asset(ltrim($icon, '/'));
            return '<img src="' . $src . '" alt="' . e($name) . '" class="w-6 h-6 object-contain" />';
        }

        // 2. Font Awesome classes (fa-solid, fa-regular, fa-brands, fas, far, fab, or fa-*)
        if (str_starts_with($icon, 'fa-') || str_starts_with($icon, 'fas ') || str_starts_with($icon, 'far ') || str_starts_with($icon, 'fab ') || str_starts_with($icon, 'fa ')) {
            // If user only wrote fa-camera, auto add fa-solid
            if (str_starts_with($icon, 'fa-') && !str_contains($icon, 'fa-solid') && !str_contains($icon, 'fa-regular') && !str_contains($icon, 'fa-brands') && !str_contains($icon, 'fa-light') && !str_contains($icon, 'fa-thin') && !str_contains($icon, 'fa-duotone')) {
                $icon = 'fa-solid ' . $icon;
            }
            return '<i class="' . e($icon) . ' text-base text-brand-600"></i>';
        }

        // 3. Single keyword like 'camera', 'microphone'
        if (!empty($icon) && preg_match('/^[a-z0-9\-]+$/i', $icon)) {
            return '<i class="fa-solid fa-' . e(ltrim($icon, 'fa-')) . ' text-base text-brand-600"></i>';
        }

        // 4. Emoji or raw text
        if (!empty($icon)) {
            return '<span class="text-base leading-none">' . e($icon) . '</span>';
        }

        // 5. Fallback
        return '<i class="fa-solid fa-shield-halved text-base text-brand-600"></i>';
    }
}
