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
                'title' => 'Indian Instagram Alternative & Social Feed',
                'description' => 'Share high-resolution photo and video posts, write captions, use trending hashtags, and receive real-time likes & comments with zero ad interruptions.',
                'badge' => 'Indian Instagram',
                'color' => 'purple',
            ],
            [
                'icon' => 'clock',
                'title' => '24-Hour Stories & Moments',
                'description' => 'Post daily snapshots, festival memories, and quick video stories that stay active for exactly 24 hours and vanish automatically.',
                'badge' => '24h Stories',
                'color' => 'pink',
            ],
            [
                'icon' => 'map-pin',
                'title' => 'Smart Nearby Dating & Friend Radar',
                'description' => 'India\'s safest dating app radar to meet genuine singles, dating matches, and nearby friends based on 1 km to 50 km radius with location privacy.',
                'badge' => 'Indian Dating App',
                'color' => 'emerald',
            ],
            [
                'icon' => 'lock',
                'title' => 'End-to-End Encrypted Private Chat',
                'description' => 'Direct 1-on-1 private messaging, audio notes, stickers, and view-once disappearing media locked securely between you and your match.',
                'badge' => '100% Private E2EE',
                'color' => 'indigo',
            ],
            [
                'icon' => 'video',
                'title' => 'Free 1080p HD Voice & Video Calling',
                'description' => 'Crystal-clear high-definition voice and video calls powered by high-speed WebRTC/Agora RTC across India without carrier call costs.',
                'badge' => 'Free HD Calling',
                'color' => 'blue',
            ],
            [
                'icon' => 'shield-check',
                'title' => 'Made in India & Zero Advertisements',
                'description' => 'India\'s homegrown social network and dating app. No commercial trackers, no sponsored spam, and full control with Ghost Mode toggle.',
                'badge' => 'Indian Social Media',
                'color' => 'amber',
            ],
        ];

        $faqs = [
            [
                'question' => 'What is Sangfy and why is it called India\'s #1 Indian social media app?',
                'answer' => 'Sangfy is India\'s fastest growing homegrown social media and dating platform. Built for modern Indians, Sangfy combines high-resolution photo/video feeds (Indian Instagram alternative), 24-hour stories, a smart nearby dating radar to meet genuine singles, and 100% end-to-end encrypted private messaging and HD calls — completely free from commercial advertisements.',
            ],
            [
                'question' => 'How is Sangfy the best Indian Instagram alternative?',
                'answer' => 'Sangfy gives Indian creators and everyday users a clutter-free photo and video sharing platform. Unlike global apps that are overrun with aggressive ads and commercial algorithms, Sangfy offers a clean chronological feed, 24-hour disappearing stories, rich media posts without compression loss, real-time likes & comments, and zero sponsored noise.',
            ],
            [
                'question' => 'How does the "Nearby Dating App" feature work on Sangfy?',
                'answer' => 'Sangfy\'s Nearby Radar lets you discover and match with genuine singles and like-minded friends around your city based on your customizable distance filter (e.g. 1 km to 50 km). You can view bios, shared hobbies, and start a conversation. Your exact GPS coordinates are NEVER publicly revealed — only approximate distance is shown, keeping your real location 100% safe.',
            ],
            [
                'question' => 'Is Sangfy a safe dating and social app for Indian women and girls?',
                'answer' => 'Yes, safety is Sangfy\'s top priority. Users can enable "Ghost Mode / Incognito" at any moment to browse privately without appearing on the Nearby radar. All 1-on-1 chats are locked with End-to-End Encryption, view-once disappearing photos cannot be saved, and one-tap report/block features protect the community from harassment and fake profiles.',
            ],
            [
                'question' => 'Is Sangfy free to use or does it have paid subscription plans?',
                'answer' => 'Sangfy is 100% free to download and use! Unlike generic dating apps that charge expensive weekly subscriptions to match or chat, Sangfy offers unlimited nearby discovery, feed posting, encrypted chatting, and HD voice/video calls completely free of charge.',
            ],
            [
                'question' => 'How can I download the official Sangfy Android APK?',
                'answer' => 'You can download the official Sangfy Android APK directly from this website by tapping "Download Free for Android" or visiting the Download page. The APK works smoothly on all Android versions from Android 8.0 Oreo up to Android 15.',
            ],
            [
                'question' => 'Which Indian cities is Sangfy active in?',
                'answer' => 'Sangfy is active across India, including Delhi NCR, Mumbai, Bengaluru, Hyderabad, Pune, Kolkata, Ahmedabad, Jaipur, Chandigarh, Lucknow, Indore, Surat, Chennai, and tier-2/tier-3 cities. You can connect with people in your neighborhood or across the country.',
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

    /**
     * Display the About page.
     */
    public function about()
    {
        return view('pages.about');
    }
}
