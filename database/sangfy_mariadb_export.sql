-- ============================================================================
-- SANGFY WEB APPLICATION — FULL MARIADB & MYSQL DATABASE EXPORT
-- Application: Sangfy (com.prahlix.sangfy)
-- Operator: Prahlix Technologies (support@prahlix.com)
-- Format: MariaDB 10.5+ / MySQL 8.0+ Compatible SQL Dump
-- Engine: InnoDB | Charset: utf8mb4 | Collation: utf8mb4_unicode_ci
-- Generated Date: 2026-10-07
-- ============================================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ----------------------------------------------------------------------------
-- Table structure for table `migrations`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_03_000001_create_app_releases_table', 1),
(5, '2026_10_03_000002_create_contact_messages_table', 1),
(6, '2026_10_03_000003_create_legal_documents_table', 1),
(7, '2026_10_03_000004_create_app_permissions_table', 1),
(8, '2026_10_03_000005_create_site_settings_table', 1),
(9, '2026_10_03_000006_create_visitor_traffic_table', 1),
(10, '2026_10_07_000007_create_blocked_bot_logs_table', 1);

-- ----------------------------------------------------------------------------
-- Table structure for table `users`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sangfy Administrator', 'admin@prahlix.com', '2026-10-03 00:00:00', '$2y$12$e0MYzXyjpJS7Pd0RVvHwHeFkV.8mU9w1mE2eBfR3XWqL9ZzE4/W4K', NULL, '2026-10-03 00:00:00', '2026-10-07 19:40:00');

-- ----------------------------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `sessions`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `cache`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `cache_locks`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `jobs`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `job_batches`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `failed_jobs`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `app_releases`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `app_releases`;
CREATE TABLE `app_releases` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version_code` int(11) NOT NULL,
  `release_notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `apk_file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_latest` tinyint(1) NOT NULL DEFAULT 1,
  `download_count` int(11) NOT NULL DEFAULT 0,
  `sha256_checksum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_android_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Android 8.0 (Oreo)+',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_releases` (`id`, `version_name`, `version_code`, `release_notes`, `apk_file_path`, `file_size`, `is_latest`, `download_count`, `sha256_checksum`, `min_android_version`, `created_at`, `updated_at`) VALUES
(1, 'v1.0.0', 100, 'Official Public Launch of Sangfy Android Application. Featuring Signal Protocol E2EE private chats, Agora RTC sub-100ms ultra-low latency voice and video calls, vertical reels, 24h stories, nearby radar discovery, and biometric security.', 'downloads/sangfy_v1.0.0.apk', '30 MB', 1, 1250, 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Android 8.0 (API 26)+', '2026-10-03 00:00:00', '2026-10-07 19:40:00');

-- ----------------------------------------------------------------------------
-- Table structure for table `contact_messages`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_resolved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `app_permissions`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `app_permissions`;
CREATE TABLE `app_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Feature-Based',
  `purpose` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order_index` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_permissions_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `app_permissions` (`id`, `name`, `code`, `icon`, `category`, `badge`, `purpose`, `is_required`, `is_active`, `order_index`, `created_at`, `updated_at`) VALUES
(1, 'Camera', 'android.permission.CAMERA', 'fa-solid fa-camera', 'Media & Capture', 'Feature-Based', 'Required for capturing photos, recording video reels and 24h stories, taking profile pictures, and participating in live HD video calls.', 0, 1, 1, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(2, 'Microphone', 'android.permission.RECORD_AUDIO', 'fa-solid fa-microphone', 'Communication', 'Feature-Based', 'Required for recording voice notes in private chat and transmitting crystal-clear audio during HD voice and video calls powered by Agora RTC.', 0, 1, 2, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(3, 'Photo & Media Library', 'android.permission.READ_MEDIA_IMAGES / READ_MEDIA_VIDEO', 'fa-solid fa-folder-open', 'Storage', 'Feature-Based', 'Required for selecting and uploading media files (images, video reels, avatars) from device storage to publish on the Platform.', 0, 1, 3, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(4, 'Location (Nearby Radar)', 'android.permission.ACCESS_FINE_LOCATION / ACCESS_COARSE_LOCATION', 'fa-solid fa-location-dot', 'Location & Discovery', 'User-Initiated', 'Used solely for calculating generalized distance approximations in the optional Nearby feature. Exact GPS coordinates are never stored, transmitted, or displayed to other users.', 0, 1, 4, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(5, 'Push Notifications', 'android.permission.POST_NOTIFICATIONS', 'fa-solid fa-bell', 'Alerts & Messages', 'Optional', 'Required to deliver instant message alerts, incoming call notifications, story replies, and important account security notices.', 0, 1, 5, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(6, 'Bluetooth Audio & Headsets', 'android.permission.BLUETOOTH_CONNECT', 'fa-solid fa-headphones', 'Audio Routing', 'Feature-Based', 'Enables seamless audio routing to wireless Bluetooth headsets, earbuds, and hands-free car systems during active voice and video calls.', 0, 1, 6, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(7, 'Network & Internet', 'android.permission.INTERNET', 'fa-solid fa-globe', 'Core Connectivity', 'Required', 'Required to establish secure TLS/HTTPS encrypted connections to servers, sync feeds, and stream real-time Agora RTC voice/video calls.', 1, 1, 7, '2026-10-03 00:00:00', '2026-10-07 19:40:00');

-- ----------------------------------------------------------------------------
-- Table structure for table `site_settings`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Sangfy', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(2, 'site_tagline', 'Instant Connection, Absolute Privacy', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(3, 'android_package_name', 'com.prahlix.sangfy', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(4, 'contact_email', 'support@prahlix.com', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(5, 'privacy_email', 'support@prahlix.com', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(6, 'safety_email', 'support@prahlix.com', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(7, 'support_receiver_email', 'support@prahlix.com', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(8, 'company_name', 'Prahlix Technologies', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(9, 'official_website', 'https://sangfy.prahlix.com', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(10, 'hero_title', 'Real-Time Voice, Video & E2EE Social Network', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(11, 'hero_subtitle', 'Experience zero-lag Agora RTC voice & HD video calling, Signal Protocol encrypted private messaging, vertical reels, and nearby discovery without trackers or ads.', '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(12, 'hero_badge_text', 'Official Android Release v1.0.0 (Build 100)', '2026-10-03 00:00:00', '2026-10-07 19:40:00');

-- ----------------------------------------------------------------------------
-- Table structure for table `visitor_traffic`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `visitor_traffic`;
CREATE TABLE `visitor_traffic` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_visited` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Unknown',
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'XX',
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Unknown',
  `flag` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '🌐',
  `is_bot` tinyint(1) NOT NULL DEFAULT 0,
  `visited_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitor_traffic_visited_at_index` (`visited_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `blocked_bot_logs`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `blocked_bot_logs`;
CREATE TABLE `blocked_bot_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `threat_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blocked_bot_logs_blocked_at_index` (`blocked_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table structure for table `legal_documents`
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `legal_documents`;
CREATE TABLE `legal_documents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.4.0',
  `effective_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `legal_documents_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `legal_documents` (`id`, `slug`, `title`, `subtitle`, `version`, `effective_date`, `summary`, `content`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'privacy', 'Official Privacy Policy & Data Safety', 'Comprehensive Data Safety, Device Permissions, End-to-End Encryption, and Privacy Compliance for Sangfy (com.prahlix.sangfy).', '1.4.0', 'October 2026', 'Official Privacy Policy for Sangfy. Complete disclosure on data collection, Android permissions, zero-knowledge Signal Protocol E2EE messaging, transient Agora RTC voice/video calling, nearby radar privacy, DPDP Act 2023 & GDPR compliance, and permanent account deletion rights.', '<div class=\"space-y-10 text-slate-700\">\n    <!-- Section 1: Overview & Scope -->\n    <div class=\"space-y-4\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>1. APPLICATION OVERVIEW &amp; SCOPE</span>\n        </h2>\n        \n        <p class=\"text-slate-600\">\n            Welcome to <strong>Sangfy</strong>. This Privacy Policy clearly outlines how we handle, safeguard, and respect your personal data across the Sangfy mobile application, official website, and real-time communication services.\n        </p>\n\n        <!-- Clean Metadata Grid Card -->\n        <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs\">\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Application:</span>\n                <span class=\"font-bold text-slate-900\">Sangfy</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Package ID:</span>\n                <code class=\"text-brand-700 bg-white px-2 py-0.5 rounded border border-purple-200 font-mono\">com.prahlix.sangfy</code>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Developer:</span>\n                <span class=\"font-bold text-slate-900\">Prahlix Technologies</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Official Website:</span>\n                <a href=\"https://sangfy.prahlix.com\" target=\"_blank\" class=\"text-brand-600 font-semibold underline\">sangfy.prahlix.com</a>\n            </div>\n        </div>\n\n        <p class=\"text-slate-600 leading-relaxed\">\n            At Sangfy, privacy is a fundamental human right. Our systems are built around <strong>Data Minimization</strong>, <strong>Zero-Knowledge Cryptography</strong>, and <strong>Complete User Sovereignty</strong>. We collect only what is strictly necessary to deliver a fast, safe, and authentic social experience.\n        </p>\n    </div>\n\n    <!-- Section 2: Information We Collect -->\n    <div class=\"space-y-4\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>2. INFORMATION WE COLLECT</span>\n        </h2>\n        <p class=\"text-slate-600\">We collect information strictly categorized as follows:</p>\n\n        <div class=\"space-y-3 pl-1\">\n            <h3 class=\"text-sm font-bold text-slate-900 flex items-center gap-1.5\">\n                <i class=\"fa-solid fa-user text-brand-600\"></i>\n                <span>2.1. Information Provided Directly by You</span>\n            </h3>\n            <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-600 pl-2\">\n                <li><strong class=\"text-slate-900\">Account Profile:</strong> Username, display name, verified email address, secure hashed credentials, optional avatar, and user bio.</li>\n                <li><strong class=\"text-slate-900\">Published Content:</strong> Photos, vertical video reels, 24-hour stories, captions, comments, and public bookmarks you choose to share on your feed.</li>\n                <li><strong class=\"text-slate-900\">Private Communications:</strong> 1-on-1 private text chats and voice notes. These are protected by <strong>Signal Protocol End-to-End Encryption (E2EE)</strong> — plaintext contents are never visible to Sangfy servers.</li>\n                <li><strong class=\"text-slate-900\">Support Inquiries:</strong> Bug reports, suggestions, or help tickets voluntarily sent to our support desk.</li>\n            </ul>\n\n            <h3 class=\"text-sm font-bold text-slate-900 flex items-center gap-1.5 pt-2\">\n                <i class=\"fa-solid fa-mobile-screen text-brand-600\"></i>\n                <span>2.2. Information Collected Automatically</span>\n            </h3>\n            <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-600 pl-2\">\n                <li><strong class=\"text-slate-900\">Device Diagnostics:</strong> Phone model, manufacturer, Android OS version, architecture (ARM64/x86), and crash telemetry for bug fixes.</li>\n                <li><strong class=\"text-slate-900\">Notification Tokens:</strong> Device push registration tokens used strictly to deliver incoming call alerts and chat notifications.</li>\n                <li><strong class=\"text-slate-900\">Network Telemetry:</strong> IP address and transport layer latency for anti-DDoS security and server routing stability.</li>\n            </ul>\n        </div>\n    </div>\n\n    <!-- Section 3: Android Device Runtime Permissions -->\n    <div class=\"space-y-4\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>3. ANDROID DEVICE RUNTIME PERMISSIONS</span>\n        </h2>\n        <p class=\"text-slate-600\">Sangfy requests hardware access only when you actively trigger a feature. You can toggle any permission anytime via your Android Device Settings:</p>\n        \n        <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1 text-xs\">\n            <div class=\"p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1\">\n                <span class=\"font-bold text-slate-900 flex items-center gap-1.5\"><i class=\"fa-solid fa-camera text-brand-600\"></i> Camera</span>\n                <p class=\"text-slate-600\">For capturing photos, recording video reels and 24h stories, taking profile pictures, and participating in Agora RTC live HD video calls.</p>\n            </div>\n            <div class=\"p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1\">\n                <span class=\"font-bold text-slate-900 flex items-center gap-1.5\"><i class=\"fa-solid fa-microphone text-brand-600\"></i> Microphone</span>\n                <p class=\"text-slate-600\">For recording voice notes in chat and transmitting audio during HD voice and video calls.</p>\n            </div>\n            <div class=\"p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1\">\n                <span class=\"font-bold text-slate-900 flex items-center gap-1.5\"><i class=\"fa-solid fa-folder-open text-brand-600\"></i> Photo &amp; Media Storage</span>\n                <p class=\"text-slate-600\">For selecting and uploading media files (images, video reels, avatars) from device storage to publish on your profile.</p>\n            </div>\n            <div class=\"p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1\">\n                <span class=\"font-bold text-slate-900 flex items-center gap-1.5\"><i class=\"fa-solid fa-location-dot text-brand-600\"></i> Nearby Radar (Optional)</span>\n                <p class=\"text-slate-600\">Used solely for calculating generalized distance approximations in Nearby discovery. Exact GPS coordinates are <strong>never stored or shared</strong>.</p>\n            </div>\n            <div class=\"p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1\">\n                <span class=\"font-bold text-slate-900 flex items-center gap-1.5\"><i class=\"fa-solid fa-bell text-brand-600\"></i> Notifications</span>\n                <p class=\"text-slate-600\">Required to deliver instant message alerts, incoming call notifications, and security notices.</p>\n            </div>\n            <div class=\"p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1\">\n                <span class=\"font-bold text-slate-900 flex items-center gap-1.5\"><i class=\"fa-solid fa-headphones text-brand-600\"></i> Bluetooth Headsets</span>\n                <p class=\"text-slate-600\">Enables wireless audio routing to Bluetooth earbuds and hands-free car systems during voice/video calls.</p>\n            </div>\n        </div>\n    </div>\n\n    <!-- Section 4: Real-Time Calling (Agora RTC) -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>4. REAL-TIME HD CALLING: AGORA RTC</span>\n        </h2>\n        <p class=\"text-slate-600\">Sangfy integrates the <strong>Agora Real-Time Engagement (RTC) Engine</strong> to power sub-100ms ultra-low latency voice and video calling. Streams are encrypted in transit via <strong>DTLS-SRTP</strong>.</p>\n        \n        <div class=\"p-4 bg-purple-50/70 border border-purple-200 rounded-2xl space-y-1.5 text-xs text-slate-700\">\n            <div class=\"font-bold text-brand-800 flex items-center gap-1.5\">\n                <i class=\"fa-solid fa-shield-halved text-brand-600\"></i>\n                <span>Zero Server Call Recording Guarantee</span>\n            </div>\n            <p>Voice and video call packets flow transiently directly between call participants. Sangfy and Agora do <strong>not record, tap, save, or store audio/video call contents</strong> on any server under any operational circumstances.</p>\n        </div>\n    </div>\n\n    <!-- Section 5: End-to-End Encryption -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>5. END-TO-END ENCRYPTED (E2EE) MESSAGING</span>\n        </h2>\n        <p class=\"text-slate-600\">1-on-1 private text chats and voice notes are cryptographically secured using the <strong>Signal Protocol</strong>:</p>\n        <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-700 pl-2\">\n            <li><strong class=\"text-slate-900\">Device-Generated Keys:</strong> Private cryptographic keys are generated and stored exclusively inside the Android Hardware Keystore on your device.</li>\n            <li><strong class=\"text-slate-900\">Zero Interception:</strong> Ciphertext messages cannot be decrypted by any party other than the intended recipient\'s device.</li>\n            <li><strong class=\"text-slate-900\">Ephemeral Storage:</strong> Delivered messages are immediately purged from temporary transmission queues.</li>\n        </ul>\n    </div>\n\n    <!-- Section 6: Data Non-Commercialization -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>6. DATA SHARING &amp; NON-COMMERCIALIZATION</span>\n        </h2>\n        <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-700 pl-2\">\n            <li><strong class=\"text-slate-900\">No Selling of Data:</strong> We do not sell, rent, monetize, or trade your personal data to advertisers, data aggregators, or brokers.</li>\n            <li><strong class=\"text-slate-900\">Public UGC:</strong> Posts, reels, stories, and comments you publish to public feeds are visible to other users on the platform.</li>\n            <li><strong class=\"text-slate-900\">Legal Compliance:</strong> We disclose user information only when compelled by valid legal subpoenas or court orders, strictly to the minimum extent legally required.</li>\n        </ul>\n    </div>\n\n    <!-- Section 7: Account Deletion -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>7. DATA RETENTION &amp; PERMANENT ACCOUNT DELETION</span>\n        </h2>\n        <p class=\"text-slate-600\">You maintain complete control over your data lifecycle:</p>\n        <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-700 pl-2\">\n            <li><strong class=\"text-slate-900\">Content Deletion:</strong> You can delete any post, reel, comment, or story at any moment directly from the application.</li>\n            <li><strong class=\"text-slate-900\">Permanent Account Deletion:</strong> You can permanently delete your account at any time via <code>Settings &gt; Account &gt; Delete Account</code>. This action initiates an automated cryptographic wipe that permanently purges your profile, posts, media assets, and message logs from all database clusters within seconds.</li>\n        </ul>\n    </div>\n\n    <!-- Section 8: Minor Protection -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>8. MINOR PROTECTION &amp; ZERO TOLERANCE</span>\n        </h2>\n        <div class=\"p-4 bg-rose-50 border border-rose-200 rounded-2xl space-y-1.5 text-xs text-rose-900\">\n            <div class=\"font-bold flex items-center gap-1.5 text-rose-800\">\n                <i class=\"fa-solid fa-triangle-exclamation text-rose-600\"></i>\n                <span>Strict 13+ Age Policy &amp; Child Safety</span>\n            </div>\n            <p>Sangfy is strictly intended for individuals aged 13 and above. We enforce an absolute zero-tolerance policy against Child Sexual Abuse Material (CSAM), grooming, or exploitation. Violations trigger immediate permanent account erasure, hardware blacklisting, and reporting to NCMEC and legal authorities.</p>\n        </div>\n    </div>\n\n    <!-- Section 9: Regulatory Compliance -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>9. REGULATORY COMPLIANCE (DPDP ACT 2023 &amp; GDPR)</span>\n        </h2>\n        <p class=\"text-slate-600\">In accordance with India’s Digital Personal Data Protection (DPDP) Act 2023, GDPR, and Google Play Data Safety standards, you hold full rights to:</p>\n        <ul class=\"list-disc list-inside space-y-1.5 text-xs text-slate-700 pl-2\">\n            <li>Request an export of your personal account data.</li>\n            <li>Rectify inaccurate or outdated profile information.</li>\n            <li>Revoke consent for optional features (e.g. Nearby radar).</li>\n            <li>Exercise your complete right to erasure / right to be forgotten.</li>\n        </ul>\n    </div>\n\n    <!-- Section 10: Contact -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>10. DATA PRIVACY DESK</span>\n        </h2>\n        <p class=\"text-slate-600\">For questions, privacy inquiries, or data requests, please reach our team:</p>\n        <div class=\"p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-2\">\n            <div class=\"flex items-center gap-2\">\n                <span class=\"font-semibold text-slate-500 w-32 shrink-0\">Official Email:</span>\n                <a href=\"mailto:support@prahlix.com\" class=\"font-bold text-brand-600 underline\">support@prahlix.com</a>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"font-semibold text-slate-500 w-32 shrink-0\">In-App Support:</span>\n                <span class=\"text-slate-700 font-mono\">Settings &gt; Help &amp; Support</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"font-semibold text-slate-500 w-32 shrink-0\">Parent Company:</span>\n                <span class=\"text-slate-900 font-bold\">Prahlix Technologies</span>\n            </div>\n        </div>\n    </div>\n</div>', 1, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(2, 'guidelines', 'Community Guidelines & Safety Policy', 'Official Safety Standards, Content Moderation Rules, Anti-Harassment Policies, and 4-Tier Enforcement Matrix for Sangfy.', '1.4.0', 'October 2026', 'Comprehensive community guidelines and safety rules for Sangfy feeds, video reels, 24h stories, nearby radar discovery, and private communications. Features progressive 4-tier enforcement matrix, anti-harassment safeguards, minor protection, and transparent appeal procedures.', '<div class=\"space-y-10 text-slate-700\">\n    <!-- Section 1: Overview & Scope -->\n    <div class=\"space-y-4\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>1. MISSION &amp; SCOPE</span>\n        </h2>\n        \n        <p class=\"text-slate-600\">\n            At <strong>Sangfy</strong>, our mission is to build an authentic, creative, and respectful social community. These guidelines govern all activities across public feeds, video reels, 24-hour stories, comments, private messaging, HD calls, and nearby discovery.\n        </p>\n\n        <!-- Clean Metadata Grid Card -->\n        <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs\">\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Application:</span>\n                <span class=\"font-bold text-slate-900\">Sangfy</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Scope:</span>\n                <span class=\"text-slate-700\">Feeds, Reels, Stories, Calls, Radar</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Enforcement:</span>\n                <span class=\"font-bold text-brand-700 bg-purple-50 px-2 py-0.5 rounded border border-purple-200 font-mono\">4-Tier System</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Appeals:</span>\n                <a href=\"mailto:support@prahlix.com\" class=\"text-brand-600 font-semibold underline\">support@prahlix.com</a>\n            </div>\n        </div>\n    </div>\n\n    <!-- Section 2: Core Standards -->\n    <div class=\"space-y-6\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>2. CORE COMMUNITY STANDARDS</span>\n        </h2>\n\n        <div class=\"space-y-4 pl-1\">\n            <h3 class=\"text-sm font-bold text-slate-900 flex items-center gap-1.5\">\n                <i class=\"fa-solid fa-handshake text-brand-600\"></i>\n                <span>2.1. Respect, Anti-Bullying &amp; Anti-Harassment</span>\n            </h3>\n            <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-600 pl-2\">\n                <li><strong class=\"text-slate-900\">Targeted Bullying:</strong> Unwanted contact, repetitive abusive comments, stalker behavior, or persistent calling after being blocked is strictly forbidden.</li>\n                <li><strong class=\"text-slate-900\">Hate Speech:</strong> Dehumanizing language, discrimination, or threats based on race, ethnicity, religion, caste, gender, sexual orientation, or disability are prohibited.</li>\n                <li><strong class=\"text-slate-900\">Threats &amp; Extortion:</strong> Physical threats, blackmail, or sextortion trigger immediate permanent termination and law enforcement referral.</li>\n            </ul>\n\n            <h3 class=\"text-sm font-bold text-slate-900 flex items-center gap-1.5 pt-2\">\n                <i class=\"fa-solid fa-shield-virus text-brand-600\"></i>\n                <span>2.2. Prohibited Media &amp; Content Safety</span>\n            </h3>\n            <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-600 pl-2\">\n                <li><strong class=\"text-slate-900\">Adult &amp; Explicit Media:</strong> Pornography, explicit nudity, non-consensual sexual media, and sexual solicitation are banned.</li>\n                <li><strong class=\"text-slate-900\">Gore &amp; Dangerous Acts:</strong> Depictions of graphic gore, animal cruelty, or self-harm encouragement are strictly prohibited.</li>\n                <li><strong class=\"text-slate-900\">Regulated Goods:</strong> Buying, selling, or facilitating transactions for firearms, drugs, or counterfeit goods is prohibited.</li>\n            </ul>\n\n            <h3 class=\"text-sm font-bold text-slate-900 flex items-center gap-1.5 pt-2\">\n                <i class=\"fa-solid fa-circle-check text-brand-600\"></i>\n                <span>2.3. Authenticity &amp; Anti-Fraud</span>\n            </h3>\n            <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-600 pl-2\">\n                <li><strong class=\"text-slate-900\">Impersonation:</strong> Creating misleading profiles pretending to represent another person or public figure is prohibited.</li>\n                <li><strong class=\"text-slate-900\">Scams &amp; Phishing:</strong> Financial fraud, crypto scams, phishing links, and deceptive contests are banned.</li>\n                <li><strong class=\"text-slate-900\">Spam Bots:</strong> Automated accounts or engagement manipulation bots are penalized.</li>\n            </ul>\n\n            <h3 class=\"text-sm font-bold text-slate-900 flex items-center gap-1.5 pt-2\">\n                <i class=\"fa-solid fa-child text-rose-600\"></i>\n                <span>2.4. Child Safety &amp; Minor Protection</span>\n            </h3>\n            <div class=\"p-3.5 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-900 space-y-1\">\n                <span class=\"font-bold flex items-center gap-1.5 text-rose-800\"><i class=\"fa-solid fa-shield-halved\"></i> Absolute Zero Tolerance for Minor Exploitation</span>\n                <p>Sangfy enforces an uncompromising zero-tolerance policy against Child Sexual Abuse Material (CSAM) and child grooming. Offenses trigger immediate permanent account deletion, hardware blacklisting, and law enforcement escalation.</p>\n            </div>\n        </div>\n    </div>\n\n    <!-- Section 3: Enforcement Matrix -->\n    <div class=\"space-y-4\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>3. 4-TIER ENFORCEMENT MATRIX</span>\n        </h2>\n\n        <div class=\"overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs\">\n            <table class=\"w-full text-left border-collapse text-xs\">\n                <thead>\n                    <tr class=\"bg-slate-900 text-white font-bold\">\n                        <th class=\"p-3.5 border-b border-slate-800\">Tier</th>\n                        <th class=\"p-3.5 border-b border-slate-800\">Violation Severity</th>\n                        <th class=\"p-3.5 border-b border-slate-800\">Platform Action</th>\n                        <th class=\"p-3.5 border-b border-slate-800\">Account Penalty</th>\n                    </tr>\n                </thead>\n                <tbody class=\"divide-y divide-slate-100 bg-white\">\n                    <tr class=\"hover:bg-slate-50/70 transition\">\n                        <td class=\"p-3.5 font-bold text-sky-600\">Tier 1: Warning</td>\n                        <td class=\"p-3.5 text-slate-600\">Minor infraction (minor spam, offensive remark)</td>\n                        <td class=\"p-3.5 text-slate-800 font-medium\">Content removed + Compliance notice</td>\n                        <td class=\"p-3.5 text-slate-600\">1 Strike recorded on account profile</td>\n                    </tr>\n                    <tr class=\"hover:bg-slate-50/70 transition\">\n                        <td class=\"p-3.5 font-bold text-amber-600\">Tier 2: Restriction</td>\n                        <td class=\"p-3.5 text-slate-600\">Second offense or moderate harassment</td>\n                        <td class=\"p-3.5 text-slate-800 font-medium\">Content removed + 24–72h feature lock</td>\n                        <td class=\"p-3.5 text-slate-600\">Posting reels, stories, calling &amp; messaging disabled</td>\n                    </tr>\n                    <tr class=\"hover:bg-slate-50/70 transition\">\n                        <td class=\"p-3.5 font-bold text-orange-600\">Tier 3: Suspension</td>\n                        <td class=\"p-3.5 text-slate-600\">Repeated violations or severe harassment</td>\n                        <td class=\"p-3.5 text-slate-800 font-medium\">Profile hidden + 7–30 day lockout</td>\n                        <td class=\"p-3.5 text-slate-600\">Complete temporary platform access suspension</td>\n                    </tr>\n                    <tr class=\"hover:bg-rose-50/40 transition\">\n                        <td class=\"p-3.5 font-bold text-rose-600\">Tier 4: Termination</td>\n                        <td class=\"p-3.5 text-slate-600\">Zero-tolerance (CSAM, death threats, extortion)</td>\n                        <td class=\"p-3.5 text-rose-800 font-medium\">Permanent data wipe + Hardware &amp; IP ban</td>\n                        <td class=\"p-3.5 text-rose-600 font-bold\">Irreversible permanent account deletion</td>\n                    </tr>\n                </tbody>\n            </table>\n        </div>\n    </div>\n\n    <!-- Section 4: Reporting & Appeals -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>4. IN-APP REPORTING &amp; APPEALS</span>\n        </h2>\n        <ul class=\"list-disc list-inside space-y-1.5 text-xs text-slate-700 pl-2\">\n            <li><strong class=\"text-slate-900\">Report Content:</strong> Tap (<code>...</code>) on any post, reel, or story &gt; Select <strong>Report Content</strong>.</li>\n            <li><strong class=\"text-slate-900\">Block User:</strong> Open profile &gt; Tap menu &gt; Select <strong>Block User</strong>.</li>\n            <li><strong class=\"text-slate-900\">Appeals:</strong> Submit appeals to <a href=\"mailto:support@prahlix.com\" class=\"text-brand-600 font-semibold underline\">support@prahlix.com</a> with your registered username.</li>\n        </ul>\n    </div>\n</div>', 1, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(3, 'terms', 'Terms of Service & User Agreement', 'Official Legally Binding Agreement for Using the Sangfy Android Application (com.prahlix.sangfy) and Web Services.', '1.4.0', 'October 2026', 'Official Terms of Service for Sangfy. Details on user eligibility (13+), user-generated content ownership, limited display licenses, acceptable use restrictions, intellectual property, warranty disclaimers, limitation of liability, and dispute arbitration.', '<div class=\"space-y-10 text-slate-700\">\n    <!-- Section 1: Acceptance -->\n    <div class=\"space-y-4\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>1. ACCEPTANCE OF TERMS</span>\n        </h2>\n        <p class=\"text-slate-600\">\n            Welcome to <strong>Sangfy</strong>. By downloading, registering, or using the Sangfy Android Application or website, you agree to comply with and be bound by these Terms of Service.\n        </p>\n\n        <!-- Clean Metadata Grid Card -->\n        <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs\">\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Application:</span>\n                <span class=\"font-bold text-slate-900\">Sangfy</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Package ID:</span>\n                <code class=\"text-brand-700 bg-white px-2 py-0.5 rounded border border-purple-200 font-mono\">com.prahlix.sangfy</code>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Operator:</span>\n                <span class=\"font-bold text-slate-900\">Prahlix Technologies</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-24 shrink-0\">Contact Desk:</span>\n                <a href=\"mailto:support@prahlix.com\" class=\"text-brand-600 font-semibold underline\">support@prahlix.com</a>\n            </div>\n        </div>\n    </div>\n\n    <!-- Section 2: Eligibility -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>2. ELIGIBILITY &amp; ACCOUNT SECURITY</span>\n        </h2>\n        <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-700 pl-2\">\n            <li><strong class=\"text-slate-900\">Age Requirement:</strong> You must be at least thirteen (13) years old to create an account and use the Application.</li>\n            <li><strong class=\"text-slate-900\">Account Safety:</strong> You are responsible for keeping your credentials and biometric locks secure.</li>\n        </ul>\n    </div>\n\n    <!-- Section 3: Content Ownership -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>3. USER CONTENT &amp; COPYRIGHT OWNERSHIP</span>\n        </h2>\n        <ul class=\"list-disc list-inside space-y-2 text-xs text-slate-700 pl-2\">\n            <li><strong class=\"text-slate-900\">100% User Ownership:</strong> You retain full copyright and ownership of all photos, reels, stories, and text you post.</li>\n            <li><strong class=\"text-slate-900\">Limited License:</strong> You grant Sangfy a non-exclusive license solely to host, display, and distribute your content as chosen by your privacy settings.</li>\n        </ul>\n    </div>\n\n    <!-- Section 4: Calling & Emergency -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>4. REAL-TIME CALLING &amp; EMERGENCY DISCLAIMER</span>\n        </h2>\n        <div class=\"p-3.5 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 space-y-1\">\n            <span class=\"font-bold flex items-center gap-1.5 text-amber-800\"><i class=\"fa-solid fa-phone-slash\"></i> No Emergency Calling</span>\n            <p>Sangfy is an internet communication app and does NOT support calls to emergency services (e.g. 911, 112, 100). Use standard telephone services for emergencies.</p>\n        </div>\n    </div>\n\n    <!-- Section 5: Inquiries -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>5. CONTACT &amp; LEGAL INQUIRIES</span>\n        </h2>\n        <div class=\"p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-2\">\n            <div class=\"flex items-center gap-2\">\n                <span class=\"font-semibold text-slate-500 w-32 shrink-0\">Support Desk:</span>\n                <a href=\"mailto:support@prahlix.com\" class=\"font-bold text-brand-600 underline\">support@prahlix.com</a>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"font-semibold text-slate-500 w-32 shrink-0\">Company:</span>\n                <span class=\"text-slate-900 font-bold\">Prahlix Technologies</span>\n            </div>\n        </div>\n    </div>\n</div>', 1, '2026-10-03 00:00:00', '2026-10-07 19:40:00'),
(4, 'security', 'Security & Privacy Architecture Whitepaper', 'Comprehensive Technical Overview of Sangfy’s Signal Protocol End-to-End Encryption, Agora RTC DTLS-SRTP Calling, Device-Level Hardening, and Zero-Knowledge Defense.', '1.4.0', 'October 2026', 'Technical specifications covering Signal Protocol Double Ratchet E2EE private messaging, Agora RTC sub-100ms real-time calling with transient SRTP streams, Android BiometricPrompt hardware keystores, and differential proximity privacy.', '<div class=\"space-y-10 text-slate-700\">\n    <!-- Section 1: Overview & Principles -->\n    <div class=\"space-y-4\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>1. CORE ARCHITECTURE &amp; PRINCIPLES</span>\n        </h2>\n        \n        <p class=\"text-slate-600\">\n            The <strong>Sangfy Security &amp; Privacy Architecture</strong> is engineered on the principle that user privacy must be mathematically guaranteed and verified at the protocol level.\n        </p>\n\n        <!-- Clean Metadata Grid Card -->\n        <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs\">\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-28 shrink-0\">Chat Encryption:</span>\n                <span class=\"font-bold text-brand-700 bg-purple-50 px-2 py-0.5 rounded border border-purple-200 font-mono\">Signal Protocol E2EE</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-28 shrink-0\">Calling Engine:</span>\n                <span class=\"font-bold text-slate-900\">Agora RTC (DTLS-SRTP)</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-28 shrink-0\">Key Storage:</span>\n                <span class=\"font-bold text-slate-900\">Android Hardware Keystore</span>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"text-slate-500 font-semibold w-28 shrink-0\">Security Desk:</span>\n                <a href=\"mailto:support@prahlix.com\" class=\"text-brand-600 font-semibold underline\">support@prahlix.com</a>\n            </div>\n        </div>\n\n        <div class=\"grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1 text-xs\">\n            <div class=\"p-3.5 bg-purple-50/70 border border-purple-200 rounded-2xl space-y-1\">\n                <span class=\"font-bold text-brand-800 flex items-center gap-1.5\"><i class=\"fa-solid fa-lock text-brand-600\"></i> Zero-Knowledge E2EE</span>\n                <p class=\"text-slate-600\">Private chats are encrypted with Signal Protocol. Plaintext is unreadable by server infrastructure.</p>\n            </div>\n            <div class=\"p-3.5 bg-indigo-50/70 border border-indigo-200 rounded-2xl space-y-1\">\n                <span class=\"font-bold text-indigo-900 flex items-center gap-1.5\"><i class=\"fa-solid fa-bolt text-indigo-600\"></i> Transient Calling</span>\n                <p class=\"text-slate-600\">Agora RTC voice/video streams flow point-to-point without server recording or media storage.</p>\n            </div>\n            <div class=\"p-3.5 bg-emerald-50/70 border border-emerald-200 rounded-2xl space-y-1\">\n                <span class=\"font-bold text-emerald-900 flex items-center gap-1.5\"><i class=\"fa-solid fa-shield-halved text-emerald-600\"></i> Hardware Keystore</span>\n                <p class=\"text-slate-600\">Cryptographic keys and biometric authentication are bound to Android hardware Trusted Execution Environments.</p>\n            </div>\n        </div>\n    </div>\n\n    <!-- Section 2: Cryptography Details -->\n    <div class=\"space-y-4\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>2. 1-ON-1 MESSAGING CRYPTOGRAPHY (SIGNAL PROTOCOL)</span>\n        </h2>\n        <div class=\"space-y-3 pl-1 text-xs\">\n            <div class=\"p-3.5 bg-slate-50 border border-slate-200 rounded-2xl space-y-1.5\">\n                <div class=\"font-bold text-slate-900 flex items-center gap-1.5\">\n                    <i class=\"fa-solid fa-key text-brand-600\"></i>\n                    <span>Double Ratchet Algorithm (Curve25519)</span>\n                </div>\n                <p class=\"text-slate-600\">Every message utilizes a single-use ephemeral key derived via Diffie-Hellman ratcheting, guaranteeing <strong>Perfect Forward Secrecy</strong>.</p>\n            </div>\n\n            <div class=\"p-3.5 bg-slate-50 border border-slate-200 rounded-2xl space-y-1.5\">\n                <div class=\"font-bold text-slate-900 flex items-center gap-1.5\">\n                    <i class=\"fa-solid fa-shield-halved text-brand-600\"></i>\n                    <span>Authenticated Encryption (AES-256-GCM &amp; SHA-256)</span>\n                </div>\n                <p class=\"text-slate-600\">Message payloads and voice recordings are encrypted with AES-256 in Galois/Counter Mode with tamper-proof integrity checks.</p>\n            </div>\n        </div>\n    </div>\n\n    <!-- Section 3: Vulnerability Reporting -->\n    <div class=\"space-y-3\">\n        <h2 class=\"text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2\">\n            <span>3. RESPONSIBLE VULNERABILITY DISCLOSURE</span>\n        </h2>\n        <p class=\"text-slate-600\">If you discover a security vulnerability, please report it responsibly to:</p>\n        <div class=\"p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-2\">\n            <div class=\"flex items-center gap-2\">\n                <span class=\"font-semibold text-slate-500 w-32 shrink-0\">Security Desk:</span>\n                <a href=\"mailto:support@prahlix.com\" class=\"font-bold text-brand-600 underline\">support@prahlix.com</a>\n            </div>\n            <div class=\"flex items-center gap-2\">\n                <span class=\"font-semibold text-slate-500 w-32 shrink-0\">Organization:</span>\n                <span class=\"text-slate-900 font-bold\">Prahlix Technologies</span>\n            </div>\n        </div>\n    </div>\n</div>', 1, '2026-10-03 00:00:00', '2026-10-07 19:40:00');

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
