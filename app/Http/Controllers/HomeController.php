<?php

namespace App\Http\Controllers;

use App\Models\AppRelease;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the official landing page with real social media & messenger features.
     */
    public function index()
    {
        $latestRelease = AppRelease::getLatestRelease();

        $features = [
            [
                'icon' => 'camera',
                'title' => 'Image & Video Posts',
                'description' => 'Share your best photos and videos on your profile feed with captions, hashtags, likes, and real-time comments.',
                'badge' => 'Social Feed',
                'color' => 'purple',
            ],
            [
                'icon' => 'clock',
                'title' => '24-Hour Stories',
                'description' => 'Post daily moments, photos, and quick video clips that automatically vanish after 24 hours.',
                'badge' => 'Daily Stories',
                'color' => 'pink',
            ],
            [
                'icon' => 'map-pin',
                'title' => 'Find Nearby People',
                'description' => 'Discover friendly people around your area based on custom distance filters and shared interests, with full location privacy.',
                'badge' => 'Nearby Radar',
                'color' => 'emerald',
            ],
            [
                'icon' => 'lock',
                'title' => 'End-to-End Encrypted Chats',
                'description' => 'Direct 1-on-1 private messaging, voice notes, stickers, and view-once disappearing media locked on your phone.',
                'badge' => '100% Private',
                'color' => 'indigo',
            ],
            [
                'icon' => 'video',
                'title' => 'HD Voice & Video Calls',
                'description' => 'Crystal clear high-definition audio and 1080p video calls with friends anywhere in the world, completely free.',
                'badge' => 'Free & Unlimited',
                'color' => 'blue',
            ],
            [
                'icon' => 'shield-check',
                'title' => 'Privacy Controls & Ghost Mode',
                'description' => 'Toggle Ghost Mode to hide your location, lock chats with fingerprint, and enjoy zero commercial tracking or ads.',
                'badge' => 'Zero Ads',
                'color' => 'amber',
            ],
        ];

        $faqs = [
            [
                'question' => 'How does the "Find Nearby People" feature work?',
                'answer' => 'When you open Nearby Discovery, Sangfy finds other active users around your approximate area based on your preferred distance radius (e.g. 1 km to 25 km). Your exact GPS address is NEVER shared — only your approximate distance is displayed.',
            ],
            [
                'question' => 'Can I hide my location or turn off Nearby Discovery?',
                'answer' => 'Yes! You have full control. You can turn on "Ghost Mode / Incognito" in Settings at any time to browse privately without appearing on the Nearby radar.',
            ],
            [
                'question' => 'Are my private direct messages and calls encrypted?',
                'answer' => 'Yes. All 1-on-1 direct messages, voice notes, photos, and voice/video calls are secured with End-to-End Encryption. Only you and the recipient can see or hear them.',
            ],
            [
                'question' => 'How do 24-Hour Stories work?',
                'answer' => 'You can post photo or video stories to share with your friends. Stories stay live for exactly 24 hours and then vanish automatically.',
            ],
            [
                'question' => 'Is Sangfy free and does it have ads?',
                'answer' => 'Sangfy is 100% free to download and use for posts, stories, nearby discovery, and unlimited HD calls. There are ZERO ads and we never sell your personal data.',
            ],
            [
                'question' => 'How can I download and install Sangfy on my Android phone?',
                'answer' => 'Simply tap "Download Free for Android" on this website to get the official APK file, tap to install, pick your username, and start exploring!',
            ],
        ];

        return view('pages.home', compact('latestRelease', 'features', 'faqs'));
    }

    /**
     * Display the Features page.
     */
    public function features()
    {
        return view('pages.features');
    }
}
