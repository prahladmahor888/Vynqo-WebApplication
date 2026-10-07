<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('pages.admin-login');
    }

    /**
     * Process admin login credentials.
     */
    public function login(Request $request)
    {
        // 1. Anti-Bot Honeypot Protection on Admin Login
        if ($request->filled('sangfy_hp_check')) {
            \App\Models\BlockedBotLog::record($request, 'Brute-force Bot trapped in Login Honeypot', 'honeypot');
            return back()->withErrors([
                'email' => 'The provided credentials do not match our admin records.',
            ])->onlyInput('email');
        }

        $rawEmail = (string) $request->input('email', '');

        // 2. Explicit SQL Injection Payload Inspection on Login Credentials
        if (preg_match('/[\'\"\;]|(--)|(\/\*)|(\bor\b)|(\bunion\b)|(\bselect\b)/i', $rawEmail)) {
            \App\Models\BlockedBotLog::record($request, 'SQL Injection payload attempted in Admin Login email field', 'sql_injection');
            return back()->withErrors([
                'email' => 'Invalid email format provided.',
            ])->onlyInput('email');
        }

        // 3. Strict RFC & Format Validation
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:120', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'password' => ['required', 'string', 'max:255'],
        ], [
            'email.regex' => 'Please provide a valid administrative email address.',
            'email.email' => 'The email address must be a valid formatted address.',
        ]);

        $credentials['email'] = strtolower(trim($credentials['email']));
        $remember = $request->boolean('remember');

        // 4. Parameterized Authentication (PDO Prepared Statements via Eloquent)
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our admin records.',
        ])->onlyInput('email');
    }

    /**
     * Log out admin user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }
}
