<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

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

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'is_resolved' => false,
        ]);

        return redirect()->route('contact')->with('success', 'Thank you for reaching out! Your message has been received by the Vynqo team. We will respond via email within 24 hours.');
    }
}
