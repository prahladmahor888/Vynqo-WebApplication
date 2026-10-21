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
     * Default list of official Android permissions for Sangfy matching AndroidManifest.xml.
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
                'purpose' => 'Required for capturing photos, recording vertical video reels and 24h stories, taking profile pictures, and participating in live Agora RTC HD video calls.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 1,
            ],
            [
                'name' => 'Microphone & Audio Record',
                'code' => 'android.permission.RECORD_AUDIO',
                'icon' => 'fa-solid fa-microphone',
                'category' => 'Communication',
                'badge' => 'Feature-Based',
                'purpose' => 'Required for recording voice notes in private chat and transmitting crystal-clear live audio during HD voice and video calls powered by Agora RTC.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 2,
            ],
            [
                'name' => 'Photo & Image Library',
                'code' => 'android.permission.READ_MEDIA_IMAGES',
                'icon' => 'fa-solid fa-images',
                'category' => 'Storage & Media',
                'badge' => 'Feature-Based',
                'purpose' => 'Granular Android 13+ permission to select and upload photos, profile pictures, and image stories from your device gallery without accessing other files.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 3,
            ],
            [
                'name' => 'Video Media Library',
                'code' => 'android.permission.READ_MEDIA_VIDEO',
                'icon' => 'fa-solid fa-film',
                'category' => 'Storage & Media',
                'badge' => 'Feature-Based',
                'purpose' => 'Granular Android 13+ permission to select and upload video clips, stories, and feed reels from your device storage.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 4,
            ],
            [
                'name' => 'Legacy Device Storage',
                'code' => 'android.permission.READ_EXTERNAL_STORAGE',
                'icon' => 'fa-solid fa-folder-open',
                'category' => 'Storage & Media',
                'badge' => 'Legacy (<= Android 12)',
                'purpose' => 'Provides backward-compatible media picking support on older Android devices (Android 12 and below, maxSdkVersion=32) for avatar and story uploads.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 5,
            ],
            [
                'name' => 'Incoming Call Full-Screen Display',
                'code' => 'android.permission.USE_FULL_SCREEN_INTENT',
                'icon' => 'fa-solid fa-phone-volume',
                'category' => 'Calling Experience',
                'badge' => 'Critical for Calls',
                'purpose' => 'Allows incoming voice and video call notifications to wake up your screen and display a full-screen answering interface even when the phone is locked.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 6,
            ],
            [
                'name' => 'Call Foreground Services',
                'code' => 'android.permission.FOREGROUND_SERVICE / FOREGROUND_SERVICE_PHONE_CALL',
                'icon' => 'fa-solid fa-phone',
                'category' => 'Background Services',
                'badge' => 'System-Level',
                'purpose' => 'Required on Android 14+ to prevent call drops, maintaining real-time voice and video connection while the app is in the background or screen is off.',
                'is_required' => true,
                'is_active' => true,
                'order_index' => 7,
            ],
            [
                'name' => 'Audio Routing & Volume Control',
                'code' => 'android.permission.MODIFY_AUDIO_SETTINGS',
                'icon' => 'fa-solid fa-sliders',
                'category' => 'Audio Routing',
                'badge' => 'System-Level',
                'purpose' => 'Enables switching dynamically between handset earpiece, speakerphone, and external Bluetooth audio during active voice and video calls.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 8,
            ],
            [
                'name' => 'Bluetooth Audio & Headsets',
                'code' => 'android.permission.BLUETOOTH_CONNECT / BLUETOOTH',
                'icon' => 'fa-solid fa-headphones',
                'category' => 'Audio Routing',
                'badge' => 'Feature-Based',
                'purpose' => 'Discovers and routes ongoing call audio to wireless Bluetooth headsets, earbuds (AirPods/Galaxy Buds), and hands-free car audio systems.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 9,
            ],
            [
                'name' => 'Location (Nearby Radar)',
                'code' => 'android.permission.ACCESS_FINE_LOCATION / ACCESS_COARSE_LOCATION',
                'icon' => 'fa-solid fa-location-dot',
                'category' => 'Location & Discovery',
                'badge' => 'User-Initiated',
                'purpose' => 'Used solely for calculating generalized distance approximations in the optional Nearby feature. Exact GPS coordinates are never stored, logged, or displayed to other users.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 10,
            ],
            [
                'name' => 'Push Notifications',
                'code' => 'android.permission.POST_NOTIFICATIONS',
                'icon' => 'fa-solid fa-bell',
                'category' => 'Alerts & Messages',
                'badge' => 'Optional',
                'purpose' => 'Required on Android 13+ to deliver instant alerts for incoming chats, call invitations, story mentions, and security notifications.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 11,
            ],
            [
                'name' => 'Network & Internet Connectivity',
                'code' => 'android.permission.INTERNET',
                'icon' => 'fa-solid fa-globe',
                'category' => 'Core Connectivity',
                'badge' => 'Required',
                'purpose' => 'Required to establish secure TLS/HTTPS encrypted connections to servers, sync feeds, and stream real-time Agora RTC voice/video calls.',
                'is_required' => true,
                'is_active' => true,
                'order_index' => 12,
            ],
            [
                'name' => 'Network & Wi-Fi Quality Monitor',
                'code' => 'android.permission.ACCESS_NETWORK_STATE / ACCESS_WIFI_STATE',
                'icon' => 'fa-solid fa-wifi',
                'category' => 'Core Connectivity',
                'badge' => 'Performance',
                'purpose' => 'Monitors internet connection health (cellular vs Wi-Fi) to dynamically optimize video/audio call bitrate and smoothly resume paused downloads.',
                'is_required' => true,
                'is_active' => true,
                'order_index' => 13,
            ],
            [
                'name' => 'Device Wake Lock & Vibration',
                'code' => 'android.permission.WAKE_LOCK / android.permission.VIBRATE',
                'icon' => 'fa-solid fa-mobile-screen',
                'category' => 'Device Hardware',
                'badge' => 'System-Level',
                'purpose' => 'Prevents device CPU sleep during ongoing phone calls and provides tactile haptic feedback for ringtones, message alerts, and in-app gestures.',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 14,
            ],
            [
                'name' => 'Launcher App Icon Unread Badges',
                'code' => 'OEM Badges (Samsung, Xiaomi, Huawei, Vivo, Oppo, Sony, HTC)',
                'icon' => 'fa-solid fa-certificate',
                'category' => 'App Icon Badges',
                'badge' => 'OEM Integration',
                'purpose' => 'Displays unread message counts and missed call notification badges directly on the app icon across launcher OEM providers (Samsung OneUI, Xiaomi MIUI, Oppo ColorOS, Huawei EMUI, Sony Xperia, HTC, Badger).',
                'is_required' => false,
                'is_active' => true,
                'order_index' => 15,
            ],
        ];
    }

    /**
     * Synchronize permissions with the official AndroidManifest defaults.
     */
    public static function syncDefaultPermissions(): void
    {
        try {
            $defaults = self::getDefaultPermissions();
            foreach ($defaults as $p) {
                $existing = self::where('code', $p['code'])
                    ->orWhere('name', $p['name'])
                    ->first();

                if (!$existing) {
                    self::create($p);
                } else {
                    $existing->update([
                        'name' => $p['name'],
                        'code' => $p['code'],
                        'icon' => $p['icon'],
                        'category' => $p['category'],
                        'badge' => $p['badge'],
                        'purpose' => $p['purpose'],
                        'is_required' => $p['is_required'],
                        'order_index' => $p['order_index'],
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // Gracefully ignore DB errors
        }
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
