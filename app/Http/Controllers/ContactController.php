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
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2500',
        ]);

        $messageRecord = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'is_resolved' => false,
        ]);

        // Send Email notification to configured recipient (Default: sangfy@prahlix.com)
        $receiverEmail = SiteSetting::get('support_receiver_email', 'sangfy@prahlix.com');
        if (!empty($receiverEmail)) {
            try {
                Mail::to($receiverEmail)->send(new ContactInquiryReceived($messageRecord));
            } catch (\Throwable $e) {
                Log::warning('Contact Inquiry email dispatch failed: ' . $e->getMessage(), [
                    'message_id' => $messageRecord->id,
                    'receiver' => $receiverEmail,
                ]);
            }
        }

        return redirect()->route('contact')->with('success', 'Thank you for reaching out! Your message has been received by the Sangfy team. We will respond via email within 24 hours.');
    }
}
