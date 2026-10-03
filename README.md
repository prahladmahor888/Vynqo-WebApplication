# 🌐 Vynqo Official Website & Release Portal (Laravel)

Official lightweight, secure, and privacy-first web application for **Vynqo — Social Media Feed, 24h Stories, Nearby Discovery & End-to-End Encrypted HD Calling** (`com.vynqo.app`).

---

## 🚀 App Features & Architecture

- **Image & Video Feed Posts:** Share high-resolution photos and video clips with captions, likes, and comments.
- **24-Hour Stories:** Ephemeral daily moments that automatically vanish after 24 hours.
- **Find Nearby People:** Discovery radar to find people nearby based on custom distance filters and shared interests, with location privacy.
- **End-to-End Encrypted Private Chats:** Direct 1-on-1 messaging, voice notes, stickers, and view-once media.
- **Crystal Clear HD Voice & Video Calls:** Powered by embedded Agora RTC engine with sub-100ms latency.
- **Location Privacy & Ghost Mode:** Exact GPS is never publicly shared; Ghost Mode toggles instant invisibility.
- **Direct APK Distribution:** Direct download endpoint with automatic download counter increments, version management, and SHA-256 cryptographic verification.
- **Complete Page Suite:**
  - `GET /` — Hero showcase, interactive 4-mode phone mockup (Feed, Nearby Radar, E2EE Chat, HD Call), core features, and FAQ.
  - `GET /features` — Technical breakdown of Feed Posts, 24h Stories, Nearby Radar, E2EE messaging, and Agora RTC HD calling.
  - `GET /download` — APK download portal, SHA-256 copy tool, 3-step installation guide, and version changelog.
  - `GET /download/apk` — Direct APK download handler with auto-incrementing download counter.
  - `GET /security` — Cryptographic Whitepaper (ECDH Curve25519, AES-256-GCM, HKDF, Bug bounty).
  - `GET /community-guidelines` — Anti-harassment policies, minor protection, and in-app reporting guide.
  - `GET /privacy-policy` — GDPR & CCPA zero-knowledge data policy.
  - `GET /terms-of-service` — Terms of Service and acceptable use.
  - `GET /contact` & `POST /contact` — Support inquiry form storing messages in SQLite database.

---

## 🛠️ Local Development & Setup

### 1. Requirements
- PHP 8.2+ with SQLite extension enabled
- Composer
- Node.js & NPM (optional, Tailwind CDN & custom CSS are pre-configured)

### 2. Environment & Database Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations and seed release data
php artisan migrate --seed
```

### 3. Start Development Server
```bash
php artisan serve
```
Visit `http://localhost:8000` in your browser.

---

## 📦 Managing App Releases

To publish a new APK update:
```bash
php artisan tinker
```
```php
\App\Models\AppRelease::create([
    'version_name' => 'v1.0.5',
    'version_code' => 105,
    'apk_file_path' => 'downloads/vynqo-release.apk',
    'file_size' => '43.2 MB',
    'sha256_checksum' => 'YOUR_SHA256_HASH_HERE',
    'changelog' => "- Feature: New dark mode themes\n- Fix: Faster Agora RTC connect",
    'min_android_version' => 'Android 8.0+',
    'is_latest' => true,
]);
```
Place your signed APK file in `public/downloads/vynqo-release.apk`.
