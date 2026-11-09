@extends('layouts.app')

@section('title', 'Child Safety Standards & CSAE Zero Tolerance — Sangfy')
@section('meta_description', 'Official Child Safety Standards for the Sangfy Android App (com.prahlix.sangfy). Absolute zero tolerance for CSAE/CSAM, automated AI screening, NCMEC reporting, and in-app reporting mechanism.')

@section('content')
<!-- Hero Section -->
<section class="py-16 sm:py-24 bg-white border-b border-slate-100 hero-glow-bg">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
            <i class="fa-solid fa-shield-heart text-rose-600"></i>
            <span>Google Play &amp; Global Child Safety Standards</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
            Child Safety Standards
        </h1>
        <p class="text-slate-600 text-sm max-w-2xl mx-auto">
            Sangfy (<code>com.prahlix.sangfy</code>), operated by Prahlix Technologies, enforces an uncompromising absolute zero-tolerance policy against Child Sexual Abuse Material (CSAM) and Child Sexual Exploitation and Abuse (CSAE).
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3 text-xs text-slate-500 font-mono pt-1">
            <span>App: <strong>Sangfy (com.prahlix.sangfy)</strong></span>
            <span>•</span>
            <span>Version: <strong>v2.0.0</strong></span>
            <span>•</span>
            <span>Effective Date: <strong>November 2026</strong></span>
            <span>•</span>
            <span class="text-rose-600 font-bold">Zero Tolerance Mandate</span>
        </div>
    </div>
</section>

<!-- Main Safety Standards Content -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 text-sm text-slate-700 leading-relaxed">

        <!-- Section 1: Absolute Zero Tolerance -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
                <span class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs font-bold shrink-0">1</span>
                <span>ABSOLUTE ZERO-TOLERANCE POLICY (CSAE / CSAM)</span>
            </h2>
            <p class="text-slate-600">
                Sangfy strictly prohibits any depiction, sharing, solicitation, facilitation, or promotion of Child Sexual Exploitation and Abuse (<strong class="text-slate-900">CSAE</strong>) and Child Sexual Abuse Material (<strong class="text-slate-900">CSAM</strong>). This includes, without limitation:
            </p>
            <ul class="list-disc list-inside space-y-2 text-xs text-slate-600 pl-2">
                <li><strong class="text-slate-900">CSAM Possession, Creation &amp; Distribution:</strong> Uploading, distributing, streaming, linking to, or possessing visual media depicting minors engaged in explicit conduct.</li>
                <li><strong class="text-slate-900">Child Grooming &amp; Enticement:</strong> Any attempt to solicit explicit imagery, establish deceptive romantic contact with minors, or arrange offline meetups.</li>
                <li><strong class="text-slate-900">Sextortion &amp; Blackmail:</strong> Coercing or threatening minors using real or fabricated imagery.</li>
                <li><strong class="text-slate-900">Child Trafficking &amp; Commercial Exploitation:</strong> Advertising or facilitating the exploitation or trafficking of any individual under 18 years of age.</li>
            </ul>

            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-900 space-y-1">
                <div class="font-bold flex items-center gap-1.5 text-rose-800">
                    <i class="fa-solid fa-gavel text-rose-600"></i>
                    <span>Immediate Enforcement Sanction:</span>
                </div>
                <p>Any account or device associated with CSAM or CSAE is immediately subjected to a permanent platform ban, hardware device ID revocation, IP blacklist, and immediate referral to federal law enforcement without prior warning.</p>
            </div>
        </div>

        <!-- Section 2: Mandatory Reporting to NCMEC & Law Enforcement -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
                <span class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs font-bold shrink-0">2</span>
                <span>MANDATORY REPORTING TO NCMEC &amp; LAW ENFORCEMENT</span>
            </h2>
            <p class="text-slate-600">
                In strict compliance with statutory obligations (including 18 U.S.C. § 2258A, the Protection of Children from Sexual Offences [POCSO] Act 2012, and Google Play Developer Child Safety Policies):
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-1">
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-flag-usa text-blue-600"></i>
                        <span>NCMEC CyberTipline Reporting</span>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        Whenever CSAM/CSAE is detected, Sangfy immediately files a formal incident report with the <strong class="text-slate-800">National Center for Missing &amp; Exploited Children (NCMEC)</strong> via its automated CyberTipline integration.
                    </p>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-building-shield text-emerald-600"></i>
                        <span>International &amp; National Police</span>
                    </div>
                    <p class="text-slate-600 leading-relaxed">
                        We actively collaborate with the <strong class="text-slate-800">Indian Cyber Crime Coordination Centre (I4C)</strong>, state police cyber units, Interpol, and national law enforcement to assist in the investigation and criminal prosecution of offenders.
                    </p>
                </div>
            </div>

            <p class="text-xs text-slate-500">
                Forensic Preservation: Digital evidence (IP logs, account identifiers, upload timestamps, device signatures, and quarantined files) is preserved under cryptographic chain of custody for law enforcement production under lawful warrant.
            </p>
        </div>

        <!-- Section 3: Automated AI Screening & SafeSearch -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
                <span class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs font-bold shrink-0">3</span>
                <span>AUTOMATED AI SCREENING &amp; QUARANTINE STORAGE</span>
            </h2>
            <p class="text-slate-600">
                Sangfy employs proactive technological defenses to inspect and intercept media uploads before they can appear publicly on the platform:
            </p>

            <div class="space-y-3 text-xs">
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                    <div class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-eye text-brand-600"></i>
                        <span>Google Cloud Vision SafeSearch AI</span>
                    </div>
                    <p class="text-slate-600">
                        Images uploaded for public feeds, 24-hour stories, or profile avatars pass through Google Cloud Vision SafeSearch machine learning filters. Any media with elevated likelihood of sexually explicit or harmful material involving minors is automatically blocked at the ingestion gateway.
                    </p>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                    <div class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-fingerprint text-purple-600"></i>
                        <span>Perceptual Hash Matching</span>
                    </div>
                    <p class="text-slate-600">
                        Uploaded media is verified against standardized hash databases of known illicit material to prevent re-circulation of harmful imagery.
                    </p>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                    <div class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-box-archive text-amber-600"></i>
                        <span>Air-Gapped Quarantine Vault</span>
                    </div>
                    <p class="text-slate-600">
                        Flagged content is immediately blocked from Content Delivery Networks (CDNs) and isolated in an encrypted, access-restricted quarantine vault strictly accessible to designated safety personnel for evidence handoff.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 4: In-App Feedback & Reporting Instructions -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
                <span class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs font-bold shrink-0">4</span>
                <span>IN-APP FEEDBACK &amp; REPORTING MECHANISMS</span>
            </h2>
            <p class="text-slate-600">
                Sangfy provides transparent, real-time in-app reporting tools. Reports categorized under child safety are prioritized at the highest emergency level:
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <!-- 1. Post Reporting -->
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center text-[10px] font-bold">1</span>
                        <span>Report a Feed Post or Story</span>
                    </div>
                    <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-1">
                        <li>Tap the <strong class="text-slate-900">three dots menu (⋮)</strong> on the top-right corner of the post/story.</li>
                        <li>Select <strong class="text-rose-600">"Report Post"</strong>.</li>
                        <li>Choose <strong class="text-slate-900">"Child Safety / Minor Endangerment"</strong> and submit.</li>
                    </ol>
                </div>

                <!-- 2. Profile Reporting -->
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center text-[10px] font-bold">2</span>
                        <span>Report a User Profile</span>
                    </div>
                    <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-1">
                        <li>Navigate to the user's profile page.</li>
                        <li>Tap the <strong class="text-slate-900">three dots menu (⋮)</strong> on the header.</li>
                        <li>Select <strong class="text-rose-600">"Report Profile"</strong>.</li>
                        <li>Choose <strong class="text-slate-900">"Predatory Behavior / Underage Endangerment"</strong>.</li>
                    </ol>
                </div>

                <!-- 3. Chat Reporting -->
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center text-[10px] font-bold">3</span>
                        <span>Report inside Direct Messages</span>
                    </div>
                    <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-1">
                        <li>Open the private conversation.</li>
                        <li>Tap the options / header icon at the top.</li>
                        <li>Tap <strong class="text-rose-600">"Report &amp; Block User"</strong>.</li>
                        <li>Select <strong class="text-slate-900">"Solicitation / Child Safety Violation"</strong>.</li>
                    </ol>
                </div>

                <!-- 4. Settings Help Center -->
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="font-bold text-slate-900 flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center text-[10px] font-bold">4</span>
                        <span>App Settings Safety Center</span>
                    </div>
                    <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-1">
                        <li>Open Sangfy &rarr; Profile &rarr; <strong class="text-slate-900">Settings</strong>.</li>
                        <li>Tap <strong class="text-brand-600">"Help &amp; Safety"</strong> &rarr; <strong class="text-brand-600">"Trust &amp; Safety Center"</strong>.</li>
                        <li>Select <strong class="text-slate-900">"Report an Incident"</strong> with details.</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Section 5: Dedicated Trust & Safety Contact -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-2">
                <span class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs font-bold shrink-0">5</span>
                <span>DEDICATED TRUST &amp; SAFETY TEAM &amp; OFFICER</span>
            </h2>
            <p class="text-slate-600">
                Sangfy has designated a specialized Trust &amp; Safety Officer and escalation channel for child safety:
            </p>

            <div class="p-5 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-3">
                <div class="space-y-1">
                    <div class="text-sm font-bold text-slate-900">Sangfy Trust &amp; Safety Team</div>
                    <div class="text-slate-600">Designated Safety Officer / Grievance Officer: <strong class="text-slate-900">Prahlad Mahor</strong></div>
                    <div class="text-slate-500">Prahlix Technologies — Sangfy Platform</div>
                </div>

                <div class="pt-2 border-t border-slate-200 space-y-1.5">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 w-32 shrink-0">Primary Safety Email:</span>
                        <a href="mailto:safety@prahlix.com" class="font-bold text-brand-600 underline font-mono">safety@prahlix.com</a>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 w-32 shrink-0">Alternative Safety Email:</span>
                        <a href="mailto:safety@sangfy.prahlix.com" class="font-bold text-brand-600 underline font-mono">safety@sangfy.prahlix.com</a>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 w-32 shrink-0">Emergency SLA:</span>
                        <span class="text-emerald-700 font-semibold">Triage 24/7 with immediate response within 1 to 4 hours</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Bottom Compliance Banner -->
<section class="py-12 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <h3 class="text-base font-bold text-slate-900">Review Related Safety Policies</h3>
        <p class="text-xs text-slate-500">
            Learn more about how Sangfy protects user data, enforces community guidelines, and ensures digital safety.
        </p>
        <div class="pt-2 flex items-center justify-center gap-4">
            <a href="{{ route('legal.privacy') }}" class="px-5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-200 rounded-md hover:bg-slate-100 transition shadow-xs">
                Privacy Policy
            </a>
            <a href="{{ route('legal.guidelines') }}" class="px-5 py-2.5 text-xs font-bold text-slate-800 bg-white border border-slate-200 rounded-md hover:bg-slate-100 transition shadow-xs">
                Community Guidelines
            </a>
            <a href="{{ route('contact') }}" class="px-5 py-2.5 text-xs font-bold text-white btn-sangfy rounded-md shadow-xs">
                Contact Safety Desk
            </a>
        </div>
    </div>
</section>
@endsection
