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
     * Get document by slug with database retrieval or built-in fallback.
     */
    public static function getBySlug(string $slug)
    {
        $doc = self::where('slug', $slug)->where('is_active', true)->first();
        if ($doc) {
            return $doc;
        }

        // Return default structured instance if DB record not present
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
            'version' => '1.0.0',
            'effective_date' => 'October 3, 2026',
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
                'subtitle' => 'Official Data Safety, Device Permissions, and Privacy Policy for the Sangfy Android Application (com.prahlix.sangfy).',
                'version' => '1.0.0',
                'effective_date' => 'September 17, 2026',
                'summary' => 'Official Legal Privacy Policy for Sangfy Social Platform. Complete disclosure on data collection, device permissions, end-to-end encryption, and account deletion rights.',
                'content' => <<<'HTML'
<div class="space-y-10 text-slate-700">
    <!-- Section 1 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>1. INTRODUCTION &amp; PREAMBLE</span>
        </h2>
        <p>This Privacy Policy ("Policy") governs the collection, processing, storage, and protection of personal data by <strong>Sangfy</strong> ("we," "our," or "the Platform") concerning users ("you" or "User") accessing or utilizing the Sangfy mobile application, website, and related services.</p>
        <p>By creating an account, accessing, or using the Platform, you acknowledge that you have read, understood, and agreed to the practices described herein. If you do not agree with this Policy, you must immediately discontinue use of the Platform.</p>
    </div>

    <!-- Section 2 -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>2. INFORMATION WE COLLECT</span>
        </h2>
        <p>We collect information necessary to provide and operate the Platform, categorized as follows:</p>

        <div class="space-y-3 pl-2">
            <h3 class="text-sm font-bold text-slate-900">2.1. Information Provided Directly by the User</h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Account Registration Information:</strong> Username, display name, email address, password credentials, profile picture, and bio provided during registration or profile management.</li>
                <li><strong class="text-slate-900">User Content:</strong> Photos, video reels, stories, captions, comments, bookmarks, and other media publicly published by the User on the Platform.</li>
                <li><strong class="text-slate-900">Direct Communications:</strong> Private messages and voice notes exchanged with other users (subject to End-to-End Encryption).</li>
                <li><strong class="text-slate-900">Customer Support:</strong> Communications, bug reports, and correspondence submitted to our support team or in-app assistance services.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 pt-2">2.2. Information Collected Automatically</h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Device and Technical Information:</strong> Device model, operating system version, unique device identifiers, IP address, and application performance/crash logs.</li>
                <li><strong class="text-slate-900">Notification Tokens:</strong> Device registration tokens required to deliver push notifications, message alerts, and incoming call notifications.</li>
            </ul>
        </div>
    </div>

    <!-- Section 3 -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>3. DEVICE PERMISSIONS</span>
        </h2>
        <p>The Platform may request access to specific hardware and software components of your device strictly upon runtime invocation for corresponding features:</p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
            <div class="p-4 bg-purple-50/60 border border-purple-200 rounded-xl space-y-1">
                <span class="font-bold text-xs text-purple-900 flex items-center gap-1.5">📷 Camera</span>
                <p class="text-xs text-slate-600">Required for capturing photos, recording video reels and stories, taking profile pictures, and participating in live video calls.</p>
            </div>
            <div class="p-4 bg-indigo-50/60 border border-indigo-200 rounded-xl space-y-1">
                <span class="font-bold text-xs text-indigo-900 flex items-center gap-1.5">🎙️ Microphone</span>
                <p class="text-xs text-slate-600">Required for recording voice notes in chat and transmitting audio during voice and video calls.</p>
            </div>
            <div class="p-4 bg-blue-50/60 border border-blue-200 rounded-xl space-y-1">
                <span class="font-bold text-xs text-blue-900 flex items-center gap-1.5">📁 Photo/Media Library</span>
                <p class="text-xs text-slate-600">Required for selecting and uploading media files from device storage to the Platform.</p>
            </div>
            <div class="p-4 bg-emerald-50/60 border border-emerald-200 rounded-xl space-y-1">
                <span class="font-bold text-xs text-emerald-900 flex items-center gap-1.5">📍 Location (Optional)</span>
                <p class="text-xs text-slate-600">Used solely for calculating generalized distance approximations in the optional Nearby feature. Exact GPS coordinates are never stored, transmitted, or displayed to other users.</p>
            </div>
        </div>
    </div>

    <!-- Section 4 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>4. PURPOSES OF DATA PROCESSING</span>
        </h2>
        <p>We process personal data solely for the following legitimate purposes:</p>
        <ol class="list-decimal list-inside space-y-1.5 text-xs text-slate-700 pl-2">
            <li>To authenticate user identity and maintain account security.</li>
            <li>To deliver, broadcast, and display User-Generated Content across platform feeds and discovery systems.</li>
            <li>To establish real-time, low-latency voice and video communications between users.</li>
            <li>To provide responsive technical and customer support.</li>
            <li>To enforce our Community Guidelines and safeguard users against harassment, abuse, spam, fraud, or unlawful conduct.</li>
        </ol>
    </div>

    <!-- Section 5 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>5. DATA SECURITY &amp; ENCRYPTION</span>
        </h2>
        <p>The Platform enforces industry-standard technical and organizational security measures:</p>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">End-to-End Encryption (E2EE):</strong> 1-on-1 private text messages and voice notes are cryptographically secured on the user's device. Plaintext message contents cannot be accessed, read, or intercepted by platform operators or unauthorized third parties.</li>
            <li><strong class="text-slate-900">Transient Call Streaming:</strong> Real-time voice and video calls are transmitted directly between call participants and are <strong>never recorded, stored, or archived</strong> on any server.</li>
            <li><strong class="text-slate-900">Data Protection Controls:</strong> Stored profile data and public content are safeguarded via encrypted connections (TLS/HTTPS) and strict server-side access controls.</li>
        </ul>
    </div>

    <!-- Section 6 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>6. DISCLOSURE &amp; SHARING OF INFORMATION</span>
        </h2>
        <p>We adhere to strict data sharing principles:</p>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">No Commercial Sale:</strong> We do not sell, rent, or lease personal user data to third-party advertisers or data brokers under any circumstances.</li>
            <li><strong class="text-slate-900">Public Distribution:</strong> Content published to public profiles, feeds, reels, and comment sections is accessible to all users of the Platform.</li>
            <li><strong class="text-slate-900">Legal Obligations:</strong> We may disclose user information only if mandatory under valid legal process, court subpoena, or enforceable government request, to the extent required by applicable law.</li>
        </ul>
    </div>

    <!-- Section 7 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>7. DATA RETENTION &amp; ACCOUNT DELETION</span>
        </h2>
        <p>Users maintain full rights over the retention and removal of their data:</p>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">Content Deletion:</strong> Users may delete individual posts, reels, stories, or comments at any time via the application interface.</li>
            <li><strong class="text-slate-900">Permanent Account Deletion:</strong> Users may permanently delete their account at any time via <code>Settings &gt; Delete Account</code>. Initiating this action immediately and irreversibly purges user profiles, published content, message records, and account identifiers from platform storage systems.</li>
        </ul>
    </div>

    <!-- Section 8 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>8. PROTECTION OF MINORS</span>
        </h2>
        <p>The Platform is strictly prohibited for individuals under thirteen (13) years of age. We enforce an absolute zero-tolerance policy regarding Child Sexual Abuse Material (CSAM), grooming, or exploitation. Any detected violations will result in immediate permanent account termination, hardware blacklisting, and reporting to legal authorities and international child safety organizations.</p>
    </div>

    <!-- Section 9 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>9. USER RIGHTS &amp; CHOICES</span>
        </h2>
        <p>In accordance with applicable data privacy regulations, users hold the following rights:</p>
        <ul class="list-disc list-inside space-y-2 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">Right of Access and Rectification:</strong> Users may access, review, and edit their account information at any time.</li>
            <li><strong class="text-slate-900">Right of Erasure:</strong> Users may exercise their right to be forgotten via permanent account deletion.</li>
            <li><strong class="text-slate-900">Permission Management:</strong> Users may grant or revoke device permissions at any time via device operating system settings.</li>
        </ul>
    </div>

    <!-- Section 10 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>10. AMENDMENTS &amp; CONTACT INFORMATION</span>
        </h2>
        <p>We reserve the right to modify this Policy periodically. Material revisions will be reflected by updating the "Effective Date" at the top of this document. Continued use of the Platform after such modifications constitutes acceptance of the revised Policy.</p>
        <p class="pt-1">For questions, privacy inquiries, or data requests, please contact:</p>
        <ul class="list-disc list-inside space-y-1.5 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">Email:</strong> <a href="mailto:support@sangfy.prahlix.com" class="text-brand-600 font-semibold underline">support@sangfy.prahlix.com</a></li>
            <li><strong class="text-slate-900">In-App Support:</strong> <code>Settings &gt; Help &amp; Support</code></li>
        </ul>
    </div>
</div>
HTML,
                'is_active' => true,
            ],
            'guidelines' => [
                'slug' => 'guidelines',
                'title' => 'Community Guidelines & Enforcement Policy',
                'subtitle' => 'Official Community Standards, Safety Rules, and Violation Enforcement Policy for Sangfy.',
                'version' => '1.0.0',
                'effective_date' => 'September 17, 2026',
                'summary' => 'Complete safety and conduct guidelines for Sangfy. Rules on anti-harassment, content moderation, minor protection, and the 4-tier enforcement matrix.',
                'content' => <<<'HTML'
<div class="space-y-10 text-slate-700">
    <!-- Section 1 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>1. MISSION STATEMENT &amp; SCOPE</span>
        </h2>
        <p>At <strong>Sangfy</strong>, our objective is to provide a creative, safe, respectful, and authentic social space. These Community Guidelines define acceptable and prohibited conduct across all platform features, including public feeds, video reels, stories, comments, private messaging, audio/video calls, and nearby discovery.</p>
        <p>Every user is required to abide by these rules. Failure to comply will result in automated and manual disciplinary penalties under our Enforcement Matrix.</p>
    </div>

    <!-- Section 2 -->
    <div class="space-y-6">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>2. CORE COMMUNITY STANDARDS</span>
        </h2>

        <div class="space-y-3 pl-2">
            <h3 class="text-sm font-bold text-slate-900">2.1. Respect &amp; Anti-Harassment</h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Harassment &amp; Bullying:</strong> Unwanted contact, targeted intimidation, abusive insults, or persistent calling after being asked to stop is strictly prohibited.</li>
                <li><strong class="text-slate-900">Hate Speech &amp; Discrimination:</strong> Promoting violence, dehumanizing language, or hatred based on race, ethnicity, religion, gender, sexual orientation, caste, or disability is forbidden.</li>
                <li><strong class="text-slate-900">Threats of Violence:</strong> Direct or indirect threats of physical violence, extortion, or blackmail will trigger immediate law enforcement referral.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 pt-2">2.2. Content Safety &amp; Prohibited Media</h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Adult &amp; Sexually Explicit Content:</strong> Pornography, explicit nudity, non-consensual sexual media, and sexually suggestive material are strictly prohibited.</li>
                <li><strong class="text-slate-900">Violence &amp; Dangerous Acts:</strong> Depictions of graphic gore, animal cruelty, self-harm encouragement, or promotion of extremist organizations are banned.</li>
                <li><strong class="text-slate-900">Regulated Goods:</strong> Buying, selling, or facilitating transactions for firearms, drugs, prescription medication, or counterfeit items is prohibited.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 pt-2">2.3. Authenticity &amp; Integrity</h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Impersonation:</strong> Creating misleading profiles pretending to represent another person, public figure, or brand with deceptive intent is prohibited.</li>
                <li><strong class="text-slate-900">Scams &amp; Fraud:</strong> Financial scams, fake investment schemes, phishing links, and deceptive contests are strictly forbidden.</li>
                <li><strong class="text-slate-900">Spam &amp; Artificial Engagement:</strong> Automated bot accounts, bulk messaging, or artificial engagement manipulation will be penalized.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 pt-2">2.4. Privacy &amp; Anti-Doxxing</h3>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">Anti-Doxxing:</strong> Never publish private telephone numbers, physical addresses, bank details, identity cards, or private conversation screenshots without explicit consent.</li>
                <li><strong class="text-slate-900">Location Privacy:</strong> Attempting to triangulate or spoof exact GPS coordinates of users through the Nearby feature is a severe violation.</li>
            </ul>

            <h3 class="text-sm font-bold text-slate-900 pt-2">2.5. Child Protection &amp; Minor Safety</h3>
            <p class="text-xs text-slate-700 bg-rose-50 border border-rose-200 p-3.5 rounded-xl">
                Sangfy enforces an absolute zero-tolerance policy against Child Sexual Abuse Material (CSAM), grooming, sexual exploitation, or endangerment of minors. Detected violations trigger immediate permanent account termination, device hardware blacklisting, and reporting to legal authorities and NCMEC.
            </p>
        </div>
    </div>

    <!-- Section 3: Enforcement Matrix -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>3. ENFORCEMENT MATRIX &amp; PENALTIES</span>
        </h2>
        <p>When a violation is detected or reported, our moderation system applies progressive disciplinary tiers:</p>

        <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-2xs">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-900 text-white font-bold">
                        <th class="p-3 border-b border-slate-800">Enforcement Tier</th>
                        <th class="p-3 border-b border-slate-800">Severity Level</th>
                        <th class="p-3 border-b border-slate-800">Platform Action</th>
                        <th class="p-3 border-b border-slate-800">Account Impact</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="p-3 font-bold text-sky-600">Tier 1: Warning</td>
                        <td class="p-3 text-slate-600">First minor offense (minor spam, offensive comment)</td>
                        <td class="p-3 text-slate-800 font-medium">Content removed + Formal in-app warning</td>
                        <td class="p-3 text-slate-600">1 Strike logged on account</td>
                    </tr>
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="p-3 font-bold text-amber-600">Tier 2: Restriction</td>
                        <td class="p-3 text-slate-600">Second offense or moderate harassment</td>
                        <td class="p-3 text-slate-800 font-medium">Content removed + 24–72 hour feature lock</td>
                        <td class="p-3 text-slate-600">Calling, reel uploading &amp; messaging disabled</td>
                    </tr>
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="p-3 font-bold text-orange-600">Tier 3: Suspension</td>
                        <td class="p-3 text-slate-600">Repeated violations or severe harassment</td>
                        <td class="p-3 text-slate-800 font-medium">Profile hidden + 7 to 30 days account lockout</td>
                        <td class="p-3 text-slate-600">Complete temporary access suspension</td>
                    </tr>
                    <tr class="hover:bg-rose-50/40 transition">
                        <td class="p-3 font-bold text-rose-600">Tier 4: Termination</td>
                        <td class="p-3 text-slate-600">Zero-tolerance (CSAM, death threats, major fraud)</td>
                        <td class="p-3 text-rose-800 font-medium">Immediate permanent wipe + Device &amp; IP blacklist</td>
                        <td class="p-3 text-rose-600 font-bold">Permanent account deletion; non-recoverable</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 4 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>4. REPORTING MECHANISMS</span>
        </h2>
        <p>Users are encouraged to report violations immediately:</p>
        <ul class="list-disc list-inside space-y-1.5 text-xs text-slate-700 pl-2">
            <li><strong class="text-slate-900">Report Content:</strong> Tap the three-dots menu (<code>...</code>) on any post or reel &gt; Select <strong>Report</strong> &gt; Choose violation category.</li>
            <li><strong class="text-slate-900">Report User:</strong> Open the user's profile &gt; Tap the menu &gt; Select <strong>Report User</strong> or <strong>Block User</strong>.</li>
            <li><strong class="text-slate-900">Urgent Safety Desk:</strong> Email our safety desk directly at <a href="mailto:safety@sangfy.prahlix.com" class="text-brand-600 font-semibold underline">safety@sangfy.prahlix.com</a>.</li>
        </ul>
    </div>

    <!-- Section 5 -->
    <div class="space-y-3">
        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
            <span>5. APPEALS &amp; DISPUTES</span>
        </h2>
        <p>If you believe disciplinary action was taken on your account in error, you may submit a formal appeal to <a href="mailto:appeals@sangfy.prahlix.com" class="text-brand-600 font-semibold underline">appeals@sangfy.prahlix.com</a> with your registered username and evidence. Appeals are reviewed within 48 business hours. Final decisions regarding zero-tolerance violations are non-negotiable.</p>
    </div>
</div>
HTML,
                'is_active' => true,
            ],
            'terms' => [
                'slug' => 'terms',
                'title' => 'Terms of Service',
                'subtitle' => 'Legal agreement for using the Sangfy Android App and web services.',
                'version' => '1.0.0',
                'effective_date' => 'October 3, 2026',
                'summary' => 'Standard user terms, account eligibility (13+), user-generated content ownership, and termination policies.',
                'content' => <<<'HTML'
<div class="space-y-10">
    <div class="space-y-3">
        <h2 class="text-xl font-bold text-slate-900">1. Acceptance of Terms</h2>
        <p>By creating an account or downloading the Sangfy Android App (<code>com.prahlix.sangfy</code>), you agree to be bound by these Terms of Service. If you do not agree, please do not use the application.</p>
    </div>
    <div class="space-y-3">
        <h2 class="text-xl font-bold text-slate-900">2. Eligibility</h2>
        <p>You must be at least 13 years old (or the minimum legal age in your country) to create an account and use Sangfy.</p>
    </div>
    <div class="space-y-3">
        <h2 class="text-xl font-bold text-slate-900">3. User Content Ownership</h2>
        <p>You retain full ownership and copyright of the photos, videos, stories, and text you post on Sangfy. You grant Sangfy a non-exclusive, royalty-free license solely to host, display, and transmit your content as directed by your privacy settings.</p>
    </div>
    <div class="space-y-3">
        <h2 class="text-xl font-bold text-slate-900">4. Account Termination</h2>
        <p>We reserve the right to suspend or terminate accounts that violate our Community Guidelines, engage in spam, or endanger other users.</p>
    </div>
</div>
HTML,
                'is_active' => true,
            ],
            'security' => [
                'slug' => 'security',
                'title' => 'Security & Privacy Architecture',
                'subtitle' => 'Technical overview of Sangfy’s End-to-End Encryption and Zero-Knowledge principles.',
                'version' => '1.0.0',
                'effective_date' => 'October 3, 2026',
                'summary' => 'Technical specifications of Signal Protocol E2EE messaging, Agora RTC point-to-point SRTP audio/video encryption, and local device biometric locks.',
                'content' => <<<'HTML'
<div class="space-y-10">
    <div class="space-y-3">
        <h2 class="text-xl font-bold text-slate-900">1. Cryptographic Foundation</h2>
        <p>Sangfy 1-on-1 private messaging is built using the Signal Protocol cryptographic standard (Double Ratchet Algorithm, Curve25519, AES-256-GCM, and SHA-256). No intermediary, including Sangfy servers, holds the private keys.</p>
    </div>
    <div class="space-y-3">
        <h2 class="text-xl font-bold text-slate-900">2. Agora RTC Real-Time Calling Security</h2>
        <p>Voice and video calls use Secure Real-time Transport Protocol (SRTP) point-to-point encryption, providing crystal clear HD audio/video with sub-100ms latency and no server-side recording.</p>
    </div>
    <div class="space-y-3">
        <h2 class="text-xl font-bold text-slate-900">3. Local Device Security & Biometric Lock</h2>
        <p>Users can protect their app access using Android BiometricPrompt (Fingerprint / Face Unlock) and enable automatic cache purging for expired stories and media.</p>
    </div>
</div>
HTML,
                'is_active' => true,
            ],
        ];
    }
}
