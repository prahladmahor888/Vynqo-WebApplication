<?php

namespace App\Http\Controllers;

use App\Mail\ContactInquiryReceived;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display the contact and support page.
     */
    public function index()
    {
        return view('pages.contact');
    }

    /**
     * Handle support inquiry form submission.
     */
    public function submit(Request $request)
    {
        // 1. Anti-Bot Honeypot Protection
        $honeypotEnabled = SiteSetting::get('honeypot_enabled', '1') === '1';
        if ($honeypotEnabled) {
            // Check if invisible honeypot trap field was filled by an automated bot
            if ($request->filled('sangfy_hp_check')) {
                \App\Models\BlockedBotLog::record($request, 'Form Spam Bot trapped in Honeypot Field', 'honeypot');
                // Return immediate synthetic success so bot doesn't retry while discarding payload
                return redirect()->route('contact')->with('success', 'Thank you for reaching out! Your message has been received by the Sangfy team. We will respond via email within 24 hours.');
            }

            // Check form submission speed (bots submit within milliseconds, humans take >= 2 seconds)
            $renderTs = (int) $request->input('_form_render_ts', 0);
            if ($renderTs > 0 && (time() - $renderTs) < 2) {
                \App\Models\BlockedBotLog::record($request, 'Form Spam Bot: Sub-second instantaneous submission', 'honeypot');
                return redirect()->route('contact')->with('success', 'Thank you for reaching out! Your message has been received by the Sangfy team. We will respond via email within 24 hours.');
            }
        }

        $rawInputs = $request->only(['name', 'email', 'subject', 'message']);

        // 2. Explicit SQL Injection Payload Inspection on Contact Form Fields
        foreach ($rawInputs as $field => $val) {
            if (is_string($val) && preg_match('/(\bunion\s+(all\s+)?select\b)|(\bselect\s+.*\s+from\b)|(\bdrop\s+table\b)|(\binsert\s+into\b)|(\bupdate\s+[\w\.\`]+\s+set\b)|(\bdelete\s+from\b)|(\bexec\s*\()|(\bsleep\s*\(\s*\d+\s*\))|(\bbenchmark\s*\()|(\binto\s+(out|dump)file\b)|(\b(\'|\")\s*or\s*(\'|\")?\d+(\'|\")?\s*=\s*(\'|\")?\d+)/i', $val)) {
                \App\Models\BlockedBotLog::record($request, "SQL Injection attempt in contact form field: {$field}", 'sql_injection');
                return back()->withErrors([
                    $field => 'Suspicious characters or commands detected. Please enter normal text only.',
                ])->withInput();
            }
        }

        // 3. Strict RFC & Content Validation
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\.\,\'\-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:150', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:5', 'max:2500'],
        ], [
            'name.regex' => 'The name may only contain letters, spaces, hyphens, and dots.',
            'email.regex' => 'Please provide a valid formatted email address.',
            'message.min' => 'Please write at least 5 characters in your message.',
        ]);

        // 4. Sanitize and Normalize Clean Data
        $cleanName = htmlspecialchars(strip_tags(trim($validated['name'])), ENT_QUOTES, 'UTF-8');
        $cleanEmail = strtolower(trim($validated['email']));
        $cleanSubject = htmlspecialchars(strip_tags(trim($validated['subject'])), ENT_QUOTES, 'UTF-8');
        $cleanMessage = htmlspecialchars(strip_tags(trim($validated['message'])), ENT_QUOTES, 'UTF-8');

        // 5. Parameterized Database Insert via Eloquent PDO Prepared Statements
        $messageRecord = ContactMessage::create([
            'name' => $cleanName,
            'email' => $cleanEmail,
            'subject' => $cleanSubject,
            'message' => $cleanMessage,
            'ip_address' => $request->ip(),
            'is_resolved' => false,
        ]);

        // 6. Queue Email Notification to configured support desk via background queue (jobs table)
        $receiverEmail = SiteSetting::get('support_receiver_email', 'support@prahlix.com');
        if (!empty($receiverEmail)) {
            try {
                \App\Jobs\SendContactInquiryJob::dispatch($messageRecord, $receiverEmail);
            } catch (\Throwable $e) {
                // Fallback to sync send if queue driver fails
                try {
                    Mail::to($receiverEmail)->send(new ContactInquiryReceived($messageRecord));
                } catch (\Throwable $fallbackEx) {
                    Log::warning('Contact inquiry email failed: ' . $fallbackEx->getMessage());
                }
            }
        }

        return redirect()->route('contact')->with('success', 'Thank you for reaching out! Your message has been received by the Sangfy team. We will respond via email within 24 hours.');
    }
}
