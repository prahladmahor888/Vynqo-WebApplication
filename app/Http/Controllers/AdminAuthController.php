<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlockedBotLog;
use App\Mail\AdminLoginOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminAuthController extends Controller
{
    /**
     * Generate an alphanumeric visual SVG Captcha and store uppercase code in session.
     */
    public static function generateCaptchaSvg(): string
    {
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        session(['admin_captcha_code' => $code]);

        $width = 150;
        $height = 44;
        
        $bgR = random_int(243, 252);
        $bgG = random_int(243, 252);
        $bgB = random_int(248, 255);

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'" style="display:block;border-radius:8px;background:rgb('.$bgR.','.$bgG.','.$bgB.');user-select:none;">';
        
        // Distortion wave curves
        $lineColors = ['#c084fc', '#f472b6', '#a78bfa', '#818cf8'];
        for ($l = 0; $l < 3; $l++) {
            $x1 = random_int(0, 20);
            $y1 = random_int(8, 36);
            $cx = random_int(40, 100);
            $cy = random_int(5, 40);
            $x2 = random_int(130, 150);
            $y2 = random_int(8, 36);
            $color = $lineColors[$l % count($lineColors)];
            $svg .= '<path d="M'.$x1.','.$y1.' Q'.$cx.','.$cy.' '.$x2.','.$y2.'" fill="none" stroke="'.$color.'" stroke-width="1.6" opacity="0.55"/>';
        }

        // Noise dots
        for ($d = 0; $d < 22; $d++) {
            $dotX = random_int(4, $width - 4);
            $dotY = random_int(4, $height - 4);
            $dotR = random_int(1, 2);
            $svg .= '<circle cx="'.$dotX.'" cy="'.$dotY.'" r="'.$dotR.'" fill="rgba(147, 51, 234, 0.2)"/>';
        }

        // Render distinct alphanumeric characters
        $colors = ['#5b21b6', '#7c3aed', '#be185d', '#0f766e', '#1d4ed8', '#991b1b'];
        $spacing = $width / 5.5;

        for ($i = 0; $i < 5; $i++) {
            $char = $code[$i];
            $x = ($i + 0.6) * $spacing + random_int(-2, 2);
            $y = 30 + random_int(-2, 2);
            $rot = random_int(-16, 16);
            $color = $colors[random_int(0, count($colors) - 1)];
            $size = random_int(22, 25);
            
            $svg .= '<text x="'.$x.'" y="'.$y.'" font-family="Courier, monospace, sans-serif" font-size="'.$size.'" font-weight="900" fill="'.$color.'" transform="rotate('.$rot.' '.$x.' '.$y.')">'.$char.'</text>';
        }

        $svg .= '</svg>';

        return $svg;
    }

    /**
     * Show admin login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // If pending 2FA session exists, redirect to 2FA screen
        if (session()->has('admin_2fa')) {
            return redirect()->route('admin.2fa.show');
        }

        $captchaSvg = self::generateCaptchaSvg();

        return view('pages.admin-login', compact('captchaSvg'));
    }

    /**
     * Refresh Captcha dynamically via AJAX.
     */
    public function refreshCaptcha()
    {
        $svg = self::generateCaptchaSvg();
        return response()->json([
            'status' => 'success',
            'svg' => $svg,
        ]);
    }

    /**
     * Process admin login credentials with Captcha & trigger 2FA OTP.
     */
    public function login(Request $request)
    {
        // 1. Anti-Bot Honeypot Protection on Admin Login
        if ($request->filled('sangfy_hp_check')) {
            BlockedBotLog::record($request, 'Brute-force Bot trapped in Login Honeypot', 'honeypot');
            return back()->withErrors([
                'email' => 'The provided credentials do not match our admin records.',
            ])->onlyInput('email');
        }

        $rawEmail = (string) $request->input('email', '');

        // 2. Explicit SQL Injection Payload Inspection on Login Credentials
        if (preg_match('/[\'\"\;]|(--)|(\/\*)|(\bor\b)|(\bunion\b)|(\bselect\b)/i', $rawEmail)) {
            BlockedBotLog::record($request, 'SQL Injection payload attempted in Admin Login email field', 'sql_injection');
            return back()->withErrors([
                'email' => 'Invalid email format provided.',
            ])->onlyInput('email');
        }

        // 3. Captcha Verification Check
        $sessionCaptcha = (string) session('admin_captcha_code', '');
        $userCaptcha = strtoupper(trim((string) $request->input('captcha', '')));

        if (empty($sessionCaptcha) || $userCaptcha !== $sessionCaptcha) {
            // Regenerate a fresh captcha on failure
            self::generateCaptchaSvg();
            return back()->withErrors([
                'captcha' => 'Invalid security verification code. Please enter the characters displayed in the image.',
            ])->withInput($request->except('password', 'captcha'));
        }

        // Invalidate used captcha to prevent replay
        session()->forget('admin_captcha_code');

        // 4. Strict RFC & Format Validation
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:120', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'password' => ['required', 'string', 'max:255'],
            'captcha' => ['required', 'string', 'max:10'],
        ], [
            'email.regex' => 'Please provide a valid administrative email address.',
            'email.email' => 'The email address must be a valid formatted address.',
            'captcha.required' => 'Please enter the CAPTCHA code.',
        ]);

        $credentials['email'] = strtolower(trim($credentials['email']));
        $remember = $request->boolean('remember');

        // 5. Parameterized Credential Validation (Without logging in yet)
        if (!Auth::validate(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            self::generateCaptchaSvg();
            return back()->withErrors([
                'email' => 'The provided credentials do not match our admin records.',
            ])->onlyInput('email');
        }

        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            self::generateCaptchaSvg();
            return back()->withErrors([
                'email' => 'The provided credentials do not match our admin records.',
            ])->onlyInput('email');
        }

        // 6. Initiate Two-Step Verification (2FA) via Email OTP
        $otp = (string) random_int(100000, 999999);
        $targetEmail = 'support@prahlix.com';

        $request->session()->put('admin_2fa', [
            'user_id' => $user->id,
            'email' => $user->email,
            'target_email' => $targetEmail,
            'otp_hash' => hash('sha256', $otp),
            'expires_at' => now()->addMinutes(10)->timestamp,
            'attempts' => 0,
            'remember' => $remember,
            'resend_cooldown' => now()->addSeconds(60)->timestamp,
        ]);

        // Send OTP to support@prahlix.com
        try {
            Mail::to($targetEmail)->send(new AdminLoginOtpMail($otp, $user->name, $request->ip()));
        } catch (\Throwable $e) {
            Log::error('Admin 2FA Email Dispatch Error: ' . $e->getMessage());
        }

        Log::info("Admin 2FA OTP for [{$user->email}] sent to [{$targetEmail}]: {$otp}");

        return redirect()->route('admin.2fa.show')->with('info', "A 6-digit verification code has been dispatched to {$targetEmail}.");
    }

    /**
     * Show Two-Factor Authentication Form.
     */
    public function showTwoFactorForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $state = session('admin_2fa');
        if (!$state) {
            return redirect()->route('admin.login')->with('error', 'Please enter your login credentials first.');
        }

        return view('pages.admin-2fa', [
            'adminEmail' => $state['email'] ?? '',
            'targetEmail' => $state['target_email'] ?? 'support@prahlix.com',
        ]);
    }

    /**
     * Verify the 6-Digit Two-Factor OTP.
     */
    public function verifyTwoFactor(Request $request)
    {
        $state = session('admin_2fa');
        if (!$state) {
            return redirect()->route('admin.login')->with('error', 'Your session has expired. Please sign in again.');
        }

        $request->validate([
            'otp' => ['required', 'string', 'regex:/^[0-9]{6}$/'],
        ], [
            'otp.required' => 'Please enter the 6-digit verification code.',
            'otp.regex' => 'The verification code must be exactly 6 digits.',
        ]);

        // Check Expiration
        if (now()->timestamp > ($state['expires_at'] ?? 0)) {
            return back()->with('error', 'The verification code has expired. Please click "Resend Code".');
        }

        // Check Max Failed Attempts
        if (($state['attempts'] ?? 0) >= 5) {
            $request->session()->forget('admin_2fa');
            return redirect()->route('admin.login')->with('error', 'Too many invalid verification attempts. Please sign in again.');
        }

        $inputOtp = trim((string) $request->input('otp'));
        $inputHash = hash('sha256', $inputOtp);

        if (!hash_equals($state['otp_hash'], $inputHash)) {
            $state['attempts'] = ($state['attempts'] ?? 0) + 1;
            $request->session()->put('admin_2fa', $state);
            $remaining = 5 - $state['attempts'];
            return back()->withErrors([
                'otp' => "Incorrect verification code. {$remaining} attempts remaining.",
            ]);
        }

        // 2FA Success: Log in admin
        $userId = $state['user_id'];
        $remember = $state['remember'] ?? false;

        $request->session()->forget('admin_2fa');
        Auth::loginUsingId($userId, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))->with('success', 'Two-step verification completed successfully. Welcome back, ' . Auth::user()->name . '!');
    }

    /**
     * Resend Two-Factor OTP code to support@prahlix.com.
     */
    public function resendTwoFactor(Request $request)
    {
        $state = session('admin_2fa');
        if (!$state) {
            return redirect()->route('admin.login')->with('error', 'Please enter your login credentials first.');
        }

        // Check Cooldown
        if (now()->timestamp < ($state['resend_cooldown'] ?? 0)) {
            $waitSeconds = $state['resend_cooldown'] - now()->timestamp;
            return back()->with('error', "Please wait {$waitSeconds} seconds before requesting another code.");
        }

        $otp = (string) random_int(100000, 999999);
        $state['otp_hash'] = hash('sha256', $otp);
        $state['expires_at'] = now()->addMinutes(10)->timestamp;
        $state['attempts'] = 0;
        $state['resend_cooldown'] = now()->addSeconds(60)->timestamp;
        $request->session()->put('admin_2fa', $state);

        $user = User::find($state['user_id']);
        $adminName = $user ? $user->name : 'Administrator';

        try {
            Mail::to($state['target_email'])->send(new AdminLoginOtpMail($otp, $adminName, $request->ip()));
        } catch (\Throwable $e) {
            Log::error('Admin 2FA Resend Error: ' . $e->getMessage());
        }

        Log::info("Admin 2FA Resent OTP for [{$state['email']}] to [{$state['target_email']}]: {$otp}");

        return back()->with('success', "A new 6-digit verification code has been dispatched to {$state['target_email']}.");
    }

    /**
     * Cancel 2FA and return to login.
     */
    public function cancelTwoFactor(Request $request)
    {
        $request->session()->forget('admin_2fa');
        return redirect()->route('admin.login')->with('info', 'Two-step verification cancelled.');
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
