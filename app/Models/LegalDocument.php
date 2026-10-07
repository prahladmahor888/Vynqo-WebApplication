<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'version',
        'effective_date',
        'summary',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get document by slug with database retrieval, auto-sync, and built-in fallback.
     */
    public static function getBySlug(string $slug)
    {
        $defaults = self::getDefaultsArray();
        $defaultDoc = $defaults[$slug] ?? null;

        try {
            $doc = self::where('slug', $slug)->first();
            if (!$doc && $defaultDoc) {
                $doc = self::create($defaultDoc);
            } elseif ($doc && $defaultDoc && (version_compare($doc->version ?? '1.0.0', '1.4.0', '<') || !str_contains($doc->content ?? '', 'Metadata Grid'))) {
                $doc->update($defaultDoc);
            }

            if ($doc && $doc->is_active) {
                return $doc;
            }
        } catch (\Throwable $e) {
            // Fallback gracefully if database is unreachable
        }

        return self::getDefaultDocument($slug);
    }

    /**
     * Get default contents for a given document slug.
     */
    public static function getDefaultDocument(string $slug): self
    {
        $defaults = self::getDefaultsArray();

        $data = $defaults[$slug] ?? [
            'slug' => $slug,
            'title' => ucfirst($slug) . ' Policy',
            'subtitle' => 'Official policy documentation for the Sangfy Android App.',
            'version' => '1.4.0',
            'effective_date' => 'October 2026',
            'summary' => 'Official Sangfy legal and compliance document.',
            'content' => '<p>Official policy documentation for the Sangfy Android App.</p>',
            'is_active' => true,
        ];

        return new self($data);
    }

    /**
     * Array of default full documents for seeding and fallback.
     */
    public static function getDefaultsArray(): array
    {
        return [
            'privacy' => [
                'slug' => 'privacy',
                'title' => 'Official Privacy Policy & Data Safety',
                'subtitle' => 'Comprehensive Data Safety, Device Permissions, End-to-End Encryption, and Privacy Compliance for Sangfy (com.prahlix.sangfy).',
                'version' => '1.4.0',
                'effective_date' => 'October 2026',
                'summary' => 'Official Privacy Policy for Sangfy. Complete disclosure on data collection, Android permissions, zero-knowledge Signal Protocol E2EE messaging, transient Agora RTC voice/video calling, nearby radar privacy, DPDP Act 2023 & GDPR compliance, and permanent account deletion rights.',
                'content' => <<<'HTML'
<div class="space-y-10 text-slate-700">
    <!-- Section 1: Overview & Scope -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>1. APPLICATION OVERVIEW &amp; SCOPE</span>
        </h2>
        
        <p class="text-slate-600">
            Welcome to <strong>Sangfy</strong>. This Privacy Policy clearly outlines how we handle, safeguard, and respect your personal data across the Sangfy mobile application, official website, and real-time communication services.
        </p>

        <!-- Clean Metadata Grid Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs">
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Application:</span>
                <span class="font-bold text-slate-900">Sangfy</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Package ID:</span>
                <code class="text-brand-700 bg-white px-2 py-0.5 rounded border border-purple-200 font-mono">com.prahlix.sangfy</code>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Developer:</span>
                <span class="font-bold text-slate-900">Prahlix Technologies</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Official Website:</span>
                <a href="https://sangfy.prahlix.com" target="_blank" class="text-brand-600 font-semibold underline">sangfy.prahlix.com</a>
            </div>
        </div>

        <p class="text-slate-600 leading-relaxed">
            At Sangfy, privacy is a fundamental human right. Our systems are built around <strong>Data Minimization</strong>, <strong>Zero-Knowledge Cryptography</strong>, and <strong>Complete User Sovereignty</strong>. We collect only what is strictly necessary to deliver a fast, safe, and authentic social experience.
        </p>
    </div>

    <!-- Section 2: Information We Collect -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>2. INFORMATION WE COLLECT</span>
        </h2>
        <p class="text-slate-600">We collect information strictly categorized as follows:</p>

        <div class="space-y-3 pl-1">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                <i class="fa-solid fa-user text-brand-600"></i>
                <span>2.1. Information Provided Directly by You</span>
            </h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Account Profile:</strong> Username, display name, verified email address, secure hashed credentials, optional avatar, and user bio.</li>
                <li><strong class="text-slate-900">Published Content:</strong> Photos, vertical video reels, 24-hour stories, captions, comments, and public bookmarks you choose to share on your feed.</li>
                <li><strong class="text-slate-900">Private Communications:</strong> 1-on-1 private text chats and voice notes. These are protected by <strong>Signal Protocol End-to-End Encryption (E2EE)</strong> — plaintext contents are never visible to Sangfy servers.</li>
                <li><strong class="text-slate-900">Support Inquiries:</strong> Bug reports, suggestions, or help tickets voluntarily sent to our support desk.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5 pt-2">
                <i class="fa-solid fa-mobile-screen text-brand-600"></i>
                <span>2.2. Information Collected Automatically</span>
            </h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Device Diagnostics:</strong> Phone model, manufacturer, Android OS version, architecture (ARM64/x86), and crash telemetry for bug fixes.</li>
                <li><strong class="text-slate-900">Notification Tokens:</strong> Device push registration tokens used strictly to deliver incoming call alerts and chat notifications.</li>
                <li><strong class="text-slate-900">Network Telemetry:</strong> IP address and transport layer latency for anti-DDoS security and server routing stability.</li>
            </ul>
        </div>
    </div>

    <!-- Section 3: Android Device Runtime Permissions -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>3. ANDROID DEVICE RUNTIME PERMISSIONS</span>
        </h2>
        <p class="text-slate-600">Sangfy requests hardware access only when you actively trigger a feature. You can toggle any permission anytime via your Android Device Settings:</p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1 text-xs">
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                <span class="font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-camera text-brand-600"></i> Camera</span>
                <p class="text-slate-600">For capturing photos, recording video reels and 24h stories, taking profile pictures, and participating in Agora RTC live HD video calls.</p>
            </div>
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                <span class="font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-microphone text-brand-600"></i> Microphone</span>
                <p class="text-slate-600">For recording voice notes in chat and transmitting audio during HD voice and video calls.</p>
            </div>
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                <span class="font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-folder-open text-brand-600"></i> Photo &amp; Media Storage</span>
                <p class="text-slate-600">For selecting and uploading media files (images, video reels, avatars) from device storage to publish on your profile.</p>
            </div>
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                <span class="font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-brand-600"></i> Nearby Radar (Optional)</span>
                <p class="text-slate-600">Used solely for calculating generalized distance approximations in Nearby discovery. Exact GPS coordinates are <strong>never stored or shared</strong>.</p>
            </div>
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                <span class="font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-bell text-brand-600"></i> Notifications</span>
                <p class="text-slate-600">Required to deliver instant message alerts, incoming call notifications, and security notices.</p>
            </div>
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                <span class="font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-headphones text-brand-600"></i> Bluetooth Headsets</span>
                <p class="text-slate-600">Enables wireless audio routing to Bluetooth earbuds and hands-free car systems during voice/video calls.</p>
            </div>
        </div>
    </div>

    <!-- Section 4: Real-Time Calling (Agora RTC) -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>4. REAL-TIME HD CALLING: AGORA RTC</span>
        </h2>
        <p class="text-slate-600">Sangfy integrates the <strong>Agora Real-Time Engagement (RTC) Engine</strong> to power sub-100ms ultra-low latency voice and video calling. Streams are encrypted in transit via <strong>DTLS-SRTP</strong>.</p>
        
        <div class="p-4 bg-purple-50/70 border border-purple-200 rounded-2xl space-y-1.5 text-xs text-slate-700">
            <div class="font-bold text-brand-800 flex items-center gap-1.5">
                <i class="fa-solid fa-shield-halved text-brand-600"></i>
                <span>Zero Server Call Recording Guarantee</span>
            </div>
            <p>Voice and video call packets flow transiently directly between call participants. Sangfy and Agora do <strong>not record, tap, save, or store audio/video call contents</strong> on any server under any operational circumstances.</p>
        </div>
    </div>

    <!-- Section 5: End-to-End Encryption -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>5. END-TO-END ENCRYPTED (E2EE) MESSAGING</span>
        </h2>
        <p class="text-slate-600">1-on-1 private text chats and voice notes are cryptographically secured using the <strong>Signal Protocol</strong>:</p>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">Device-Generated Keys:</strong> Private cryptographic keys are generated and stored exclusively inside the Android Hardware Keystore on your device.</li>
            <li><strong class="text-slate-900">Zero Interception:</strong> Ciphertext messages cannot be decrypted by any party other than the intended recipient's device.</li>
            <li><strong class="text-slate-900">Ephemeral Storage:</strong> Delivered messages are immediately purged from temporary transmission queues.</li>
        </ul>
    </div>

    <!-- Section 6: Data Non-Commercialization -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>6. DATA SHARING &amp; NON-COMMERCIALIZATION</span>
        </h2>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">No Selling of Data:</strong> We do not sell, rent, monetize, or trade your personal data to advertisers, data aggregators, or brokers.</li>
            <li><strong class="text-slate-900">Public UGC:</strong> Posts, reels, stories, and comments you publish to public feeds are visible to other users on the platform.</li>
            <li><strong class="text-slate-900">Legal Compliance:</strong> We disclose user information only when compelled by valid legal subpoenas or court orders, strictly to the minimum extent legally required.</li>
        </ul>
    </div>

    <!-- Section 7: Account Deletion -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>7. DATA RETENTION &amp; PERMANENT ACCOUNT DELETION</span>
        </h2>
        <p class="text-slate-600">You maintain complete control over your data lifecycle:</p>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">Content Deletion:</strong> You can delete any post, reel, comment, or story at any moment directly from the application.</li>
            <li><strong class="text-slate-900">Permanent Account Deletion:</strong> You can permanently delete your account at any time via <code>Settings &gt; Account &gt; Delete Account</code>. This action initiates an automated cryptographic wipe that permanently purges your profile, posts, media assets, and message logs from all database clusters within seconds.</li>
        </ul>
    </div>

    <!-- Section 8: Minor Protection -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>8. MINOR PROTECTION &amp; ZERO TOLERANCE</span>
        </h2>
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl space-y-1.5 text-xs text-rose-900">
            <div class="font-bold flex items-center gap-1.5 text-rose-800">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Strict 13+ Age Policy &amp; Child Safety</span>
            </div>
            <p>Sangfy is strictly intended for individuals aged 13 and above. We enforce an absolute zero-tolerance policy against Child Sexual Abuse Material (CSAM), grooming, or exploitation. Violations trigger immediate permanent account erasure, hardware blacklisting, and reporting to NCMEC and legal authorities.</p>
        </div>
    </div>

    <!-- Section 9: Regulatory Compliance -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>9. REGULATORY COMPLIANCE (DPDP ACT 2023 &amp; GDPR)</span>
        </h2>
        <p class="text-slate-600">In accordance with India’s Digital Personal Data Protection (DPDP) Act 2023, GDPR, and Google Play Data Safety standards, you hold full rights to:</p>
        <ul class="list-disc list-inside space-y-1.5 text-xs text-slate-700 pl-2">
            <li>Request an export of your personal account data.</li>
            <li>Rectify inaccurate or outdated profile information.</li>
            <li>Revoke consent for optional features (e.g. Nearby radar).</li>
            <li>Exercise your complete right to erasure / right to be forgotten.</li>
        </ul>
    </div>

    <!-- Section 10: Contact -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>10. DATA PRIVACY DESK</span>
        </h2>
        <p class="text-slate-600">For questions, privacy inquiries, or data requests, please reach our team:</p>
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-2">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-500 w-32 shrink-0">Official Email:</span>
                <a href="mailto:support@prahlix.com" class="font-bold text-brand-600 underline">support@prahlix.com</a>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-500 w-32 shrink-0">In-App Support:</span>
                <span class="text-slate-700 font-mono">Settings &gt; Help &amp; Support</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-500 w-32 shrink-0">Parent Company:</span>
                <span class="text-slate-900 font-bold">Prahlix Technologies</span>
            </div>
        </div>
    </div>
</div>
HTML,
                'is_active' => true,
            ],
            'guidelines' => [
                'slug' => 'guidelines',
                'title' => 'Community Guidelines & Safety Policy',
                'subtitle' => 'Official Safety Standards, Content Moderation Rules, Anti-Harassment Policies, and 4-Tier Enforcement Matrix for Sangfy.',
                'version' => '1.4.0',
                'effective_date' => 'October 2026',
                'summary' => 'Comprehensive community guidelines and safety rules for Sangfy feeds, video reels, 24h stories, nearby radar discovery, and private communications. Features progressive 4-tier enforcement matrix, anti-harassment safeguards, minor protection, and transparent appeal procedures.',
                'content' => <<<'HTML'
<div class="space-y-10 text-slate-700">
    <!-- Section 1: Overview & Scope -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>1. MISSION &amp; SCOPE</span>
        </h2>
        
        <p class="text-slate-600">
            At <strong>Sangfy</strong>, our mission is to build an authentic, creative, and respectful social community. These guidelines govern all activities across public feeds, video reels, 24-hour stories, comments, private messaging, HD calls, and nearby discovery.
        </p>

        <!-- Clean Metadata Grid Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs">
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Application:</span>
                <span class="font-bold text-slate-900">Sangfy</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Scope:</span>
                <span class="text-slate-700">Feeds, Reels, Stories, Calls, Radar</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Enforcement:</span>
                <span class="font-bold text-brand-700 bg-purple-50 px-2 py-0.5 rounded border border-purple-200 font-mono">4-Tier System</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Appeals:</span>
                <a href="mailto:support@prahlix.com" class="text-brand-600 font-semibold underline">support@prahlix.com</a>
            </div>
        </div>
    </div>

    <!-- Section 2: Core Standards -->
    <div class="space-y-6">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>2. CORE COMMUNITY STANDARDS</span>
        </h2>

        <div class="space-y-4 pl-1">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                <i class="fa-solid fa-handshake text-brand-600"></i>
                <span>2.1. Respect, Anti-Bullying &amp; Anti-Harassment</span>
            </h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Targeted Bullying:</strong> Unwanted contact, repetitive abusive comments, stalker behavior, or persistent calling after being blocked is strictly forbidden.</li>
                <li><strong class="text-slate-900">Hate Speech:</strong> Dehumanizing language, discrimination, or threats based on race, ethnicity, religion, caste, gender, sexual orientation, or disability are prohibited.</li>
                <li><strong class="text-slate-900">Threats &amp; Extortion:</strong> Physical threats, blackmail, or sextortion trigger immediate permanent termination and law enforcement referral.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5 pt-2">
                <i class="fa-solid fa-shield-virus text-brand-600"></i>
                <span>2.2. Prohibited Media &amp; Content Safety</span>
            </h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Adult &amp; Explicit Media:</strong> Pornography, explicit nudity, non-consensual sexual media, and sexual solicitation are banned.</li>
                <li><strong class="text-slate-900">Gore &amp; Dangerous Acts:</strong> Depictions of graphic gore, animal cruelty, or self-harm encouragement are strictly prohibited.</li>
                <li><strong class="text-slate-900">Regulated Goods:</strong> Buying, selling, or facilitating transactions for firearms, drugs, or counterfeit goods is prohibited.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5 pt-2">
                <i class="fa-solid fa-circle-check text-brand-600"></i>
                <span>2.3. Authenticity &amp; Anti-Fraud</span>
            </h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Impersonation:</strong> Creating misleading profiles pretending to represent another person or public figure is prohibited.</li>
                <li><strong class="text-slate-900">Scams &amp; Phishing:</strong> Financial fraud, crypto scams, phishing links, and deceptive contests are banned.</li>
                <li><strong class="text-slate-900">Spam Bots:</strong> Automated accounts or engagement manipulation bots are penalized.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5 pt-2">
                <i class="fa-solid fa-child text-rose-600"></i>
                <span>2.4. Child Safety &amp; Minor Protection</span>
            </h3>
            <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-900 space-y-1">
                <span class="font-bold flex items-center gap-1.5 text-rose-800"><i class="fa-solid fa-shield-halved"></i> Absolute Zero Tolerance for Minor Exploitation</span>
                <p>Sangfy enforces an uncompromising zero-tolerance policy against Child Sexual Abuse Material (CSAM) and child grooming. Offenses trigger immediate permanent account deletion, hardware blacklisting, and law enforcement escalation.</p>
            </div>
        </div>
    </div>

    <!-- Section 3: Enforcement Matrix -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>3. 4-TIER ENFORCEMENT MATRIX</span>
        </h2>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-2xs">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-900 text-white font-bold">
                        <th class="p-3.5 border-b border-slate-800">Tier</th>
                        <th class="p-3.5 border-b border-slate-800">Violation Severity</th>
                        <th class="p-3.5 border-b border-slate-800">Platform Action</th>
                        <th class="p-3.5 border-b border-slate-800">Account Penalty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="p-3.5 font-bold text-sky-600">Tier 1: Warning</td>
                        <td class="p-3.5 text-slate-600">Minor infraction (minor spam, offensive remark)</td>
                        <td class="p-3.5 text-slate-800 font-medium">Content removed + Compliance notice</td>
                        <td class="p-3.5 text-slate-600">1 Strike recorded on account profile</td>
                    </tr>
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="p-3.5 font-bold text-amber-600">Tier 2: Restriction</td>
                        <td class="p-3.5 text-slate-600">Second offense or moderate harassment</td>
                        <td class="p-3.5 text-slate-800 font-medium">Content removed + 24–72h feature lock</td>
                        <td class="p-3.5 text-slate-600">Posting reels, stories, calling &amp; messaging disabled</td>
                    </tr>
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="p-3.5 font-bold text-orange-600">Tier 3: Suspension</td>
                        <td class="p-3.5 text-slate-600">Repeated violations or severe harassment</td>
                        <td class="p-3.5 text-slate-800 font-medium">Profile hidden + 7–30 day lockout</td>
                        <td class="p-3.5 text-slate-600">Complete temporary platform access suspension</td>
                    </tr>
                    <tr class="hover:bg-rose-50/40 transition">
                        <td class="p-3.5 font-bold text-rose-600">Tier 4: Termination</td>
                        <td class="p-3.5 text-slate-600">Zero-tolerance (CSAM, death threats, extortion)</td>
                        <td class="p-3.5 text-rose-800 font-medium">Permanent data wipe + Hardware &amp; IP ban</td>
                        <td class="p-3.5 text-rose-600 font-bold">Irreversible permanent account deletion</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 4: Reporting & Appeals -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>4. IN-APP REPORTING &amp; APPEALS</span>
        </h2>
        <ul class="list-disc list-inside space-y-1.5 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">Report Content:</strong> Tap (<code>...</code>) on any post, reel, or story &gt; Select <strong>Report Content</strong>.</li>
            <li><strong class="text-slate-900">Block User:</strong> Open profile &gt; Tap menu &gt; Select <strong>Block User</strong>.</li>
            <li><strong class="text-slate-900">Appeals:</strong> Submit appeals to <a href="mailto:support@prahlix.com" class="text-brand-600 font-semibold underline">support@prahlix.com</a> with your registered username.</li>
        </ul>
    </div>
</div>
HTML,
                'is_active' => true,
            ],
            'terms' => [
                'slug' => 'terms',
                'title' => 'Terms of Service & User Agreement',
                'subtitle' => 'Official Legally Binding Agreement for Using the Sangfy Android Application (com.prahlix.sangfy) and Web Services.',
                'version' => '1.4.0',
                'effective_date' => 'October 2026',
                'summary' => 'Official Terms of Service for Sangfy. Details on user eligibility (13+), user-generated content ownership, limited display licenses, acceptable use restrictions, intellectual property, warranty disclaimers, limitation of liability, and dispute arbitration.',
                'content' => <<<'HTML'
<div class="space-y-10 text-slate-700">
    <!-- Section 1: Acceptance -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>1. ACCEPTANCE OF TERMS</span>
        </h2>
        <p class="text-slate-600">
            Welcome to <strong>Sangfy</strong>. By downloading, registering, or using the Sangfy Android Application or website, you agree to comply with and be bound by these Terms of Service.
        </p>

        <!-- Clean Metadata Grid Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs">
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Application:</span>
                <span class="font-bold text-slate-900">Sangfy</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Package ID:</span>
                <code class="text-brand-700 bg-white px-2 py-0.5 rounded border border-purple-200 font-mono">com.prahlix.sangfy</code>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Operator:</span>
                <span class="font-bold text-slate-900">Prahlix Technologies</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-24 shrink-0">Contact Desk:</span>
                <a href="mailto:support@prahlix.com" class="text-brand-600 font-semibold underline">support@prahlix.com</a>
            </div>
        </div>
    </div>

    <!-- Section 2: Eligibility -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>2. ELIGIBILITY &amp; ACCOUNT SECURITY</span>
        </h2>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">Age Requirement:</strong> You must be at least thirteen (13) years old to create an account and use the Application.</li>
            <li><strong class="text-slate-900">Account Safety:</strong> You are responsible for keeping your credentials and biometric locks secure.</li>
        </ul>
    </div>

    <!-- Section 3: Content Ownership -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>3. USER CONTENT &amp; COPYRIGHT OWNERSHIP</span>
        </h2>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">100% User Ownership:</strong> You retain full copyright and ownership of all photos, reels, stories, and text you post.</li>
            <li><strong class="text-slate-900">Limited License:</strong> You grant Sangfy a non-exclusive license solely to host, display, and distribute your content as chosen by your privacy settings.</li>
        </ul>
    </div>

    <!-- Section 4: Calling & Emergency -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>4. REAL-TIME CALLING &amp; EMERGENCY DISCLAIMER</span>
        </h2>
        <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 space-y-1">
            <span class="font-bold flex items-center gap-1.5 text-amber-800"><i class="fa-solid fa-phone-slash"></i> No Emergency Calling</span>
            <p>Sangfy is an internet communication app and does NOT support calls to emergency services (e.g. 911, 112, 100). Use standard telephone services for emergencies.</p>
        </div>
    </div>

    <!-- Section 5: Inquiries -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>5. CONTACT &amp; LEGAL INQUIRIES</span>
        </h2>
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-2">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-500 w-32 shrink-0">Support Desk:</span>
                <a href="mailto:support@prahlix.com" class="font-bold text-brand-600 underline">support@prahlix.com</a>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-500 w-32 shrink-0">Company:</span>
                <span class="text-slate-900 font-bold">Prahlix Technologies</span>
            </div>
        </div>
    </div>
</div>
HTML,
                'is_active' => true,
            ],
            'security' => [
                'slug' => 'security',
                'title' => 'Security & Privacy Architecture Whitepaper',
                'subtitle' => 'Comprehensive Technical Overview of Sangfy’s Signal Protocol End-to-End Encryption, Agora RTC DTLS-SRTP Calling, Device-Level Hardening, and Zero-Knowledge Defense.',
                'version' => '1.4.0',
                'effective_date' => 'October 2026',
                'summary' => 'Technical specifications covering Signal Protocol Double Ratchet E2EE private messaging, Agora RTC sub-100ms real-time calling with transient SRTP streams, Android BiometricPrompt hardware keystores, and differential proximity privacy.',
                'content' => <<<'HTML'
<div class="space-y-10 text-slate-700">
    <!-- Section 1: Overview & Principles -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>1. CORE ARCHITECTURE &amp; PRINCIPLES</span>
        </h2>
        
        <p class="text-slate-600">
            The <strong>Sangfy Security &amp; Privacy Architecture</strong> is engineered on the principle that user privacy must be mathematically guaranteed and verified at the protocol level.
        </p>

        <!-- Clean Metadata Grid Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs">
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-28 shrink-0">Chat Encryption:</span>
                <span class="font-bold text-brand-700 bg-purple-50 px-2 py-0.5 rounded border border-purple-200 font-mono">Signal Protocol E2EE</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-28 shrink-0">Calling Engine:</span>
                <span class="font-bold text-slate-900">Agora RTC (DTLS-SRTP)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-28 shrink-0">Key Storage:</span>
                <span class="font-bold text-slate-900">Android Hardware Keystore</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-slate-500 font-semibold w-28 shrink-0">Security Desk:</span>
                <a href="mailto:support@prahlix.com" class="text-brand-600 font-semibold underline">support@prahlix.com</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1 text-xs">
            <div class="p-3.5 bg-purple-50/70 border border-purple-200 rounded-2xl space-y-1">
                <span class="font-bold text-brand-800 flex items-center gap-1.5"><i class="fa-solid fa-lock text-brand-600"></i> Zero-Knowledge E2EE</span>
                <p class="text-slate-600">Private chats are encrypted with Signal Protocol. Plaintext is unreadable by server infrastructure.</p>
            </div>
            <div class="p-3.5 bg-indigo-50/70 border border-indigo-200 rounded-2xl space-y-1">
                <span class="font-bold text-indigo-900 flex items-center gap-1.5"><i class="fa-solid fa-bolt text-indigo-600"></i> Transient Calling</span>
                <p class="text-slate-600">Agora RTC voice/video streams flow point-to-point without server recording or media storage.</p>
            </div>
            <div class="p-3.5 bg-emerald-50/70 border border-emerald-200 rounded-2xl space-y-1">
                <span class="font-bold text-emerald-900 flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-emerald-600"></i> Hardware Keystore</span>
                <p class="text-slate-600">Cryptographic keys and biometric authentication are bound to Android hardware Trusted Execution Environments.</p>
            </div>
        </div>
    </div>

    <!-- Section 2: Cryptography Details -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>2. 1-ON-1 MESSAGING CRYPTOGRAPHY (SIGNAL PROTOCOL)</span>
        </h2>
        <div class="space-y-3 pl-1 text-xs">
            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl space-y-1.5">
                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                    <i class="fa-solid fa-key text-brand-600"></i>
                    <span>Double Ratchet Algorithm (Curve25519)</span>
                </div>
                <p class="text-slate-600">Every message utilizes a single-use ephemeral key derived via Diffie-Hellman ratcheting, guaranteeing <strong>Perfect Forward Secrecy</strong>.</p>
            </div>

            <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl space-y-1.5">
                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-brand-600"></i>
                    <span>Authenticated Encryption (AES-256-GCM &amp; SHA-256)</span>
                </div>
                <p class="text-slate-600">Message payloads and voice recordings are encrypted with AES-256 in Galois/Counter Mode with tamper-proof integrity checks.</p>
            </div>
        </div>
    </div>

    <!-- Section 3: Vulnerability Reporting -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>3. RESPONSIBLE VULNERABILITY DISCLOSURE</span>
        </h2>
        <p class="text-slate-600">If you discover a security vulnerability, please report it responsibly to:</p>
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-2">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-500 w-32 shrink-0">Security Desk:</span>
                <a href="mailto:support@prahlix.com" class="font-bold text-brand-600 underline">support@prahlix.com</a>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-500 w-32 shrink-0">Organization:</span>
                <span class="text-slate-900 font-bold">Prahlix Technologies</span>
            </div>
        </div>
    </div>
</div>
HTML,
                'is_active' => true,
            ],
        ];
    }
}
