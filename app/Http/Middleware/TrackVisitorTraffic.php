<?php

namespace App\Http\Middleware;

use App\Models\VisitorTraffic;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorTraffic
{
    /**
     * Handle an incoming request and track visitor analytics.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Perform tracking only on successful GET requests to public pages
        if ($request->isMethod('GET') && $response->getStatusCode() < 400) {
            $this->logTraffic($request);
        }

        return $response;
    }

    /**
     * Silently record page visit.
     */
    protected function logTraffic(Request $request): void
    {
        try {
            $path = '/' . ltrim($request->path(), '/');

            // Exclude admin routes, asset requests, and background endpoints
            if (
                str_starts_with($path, '/admin') ||
                str_starts_with($path, '/login') ||
                str_starts_with($path, '/assets') ||
                str_starts_with($path, '/downloads') ||
                str_starts_with($path, '/uploads') ||
                str_starts_with($path, '/clear-cache') ||
                str_starts_with($path, '/run-link') ||
                str_starts_with($path, '/.well-known')
            ) {
                return;
            }

            if (!Schema::hasTable('visitor_traffic')) {
                return;
            }

            $userAgent = (string) $request->header('User-Agent', '');
            $deviceInfo = $this->parseUserAgent($userAgent);

            VisitorTraffic::create([
                'url' => substr($request->fullUrl(), 0, 500),
                'path' => $path === '' ? '/' : $path,
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'device_type' => $deviceInfo['device'],
                'platform' => $deviceInfo['platform'],
                'browser' => $deviceInfo['browser'],
                'user_agent' => substr($userAgent, 0, 1000),
                'referer' => substr((string) $request->header('referer', ''), 0, 500) ?: null,
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
            ]);
        } catch (\Throwable $e) {
            // Silently swallow analytics errors so user experience is never blocked
        }
    }

    /**
     * Detect Device, OS Platform, and Browser from User-Agent string.
     */
    protected function parseUserAgent(string $ua): array
    {
        $uaLower = strtolower($ua);

        // 1. Device Type
        $device = 'Desktop';
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            $device = 'Tablet';
        } elseif (preg_match('/(mobi|iphone|ipod|android|blackberry|opera mini|iemobile|mobile)/i', $ua)) {
            $device = 'Mobile';
        } elseif (preg_match('/(bot|crawler|spider|slurp|facebookexternalhit|bingbot|googlebot)/i', $ua)) {
            $device = 'Bot';
        }

        // 2. Platform / OS
        $platform = 'Unknown';
        if (str_contains($uaLower, 'android')) {
            $platform = 'Android';
        } elseif (str_contains($uaLower, 'iphone') || str_contains($uaLower, 'ipad') || str_contains($uaLower, 'ios')) {
            $platform = 'iOS';
        } elseif (str_contains($uaLower, 'windows')) {
            $platform = 'Windows';
        } elseif (str_contains($uaLower, 'mac os') || str_contains($uaLower, 'macintosh')) {
            $platform = 'macOS';
        } elseif (str_contains($uaLower, 'linux')) {
            $platform = 'Linux';
        }

        // 3. Browser
        $browser = 'Browser';
        if (str_contains($uaLower, 'edg/')) {
            $browser = 'Edge';
        } elseif (str_contains($uaLower, 'chrome') || str_contains($uaLower, 'crios')) {
            $browser = 'Chrome';
        } elseif (str_contains($uaLower, 'safari') && !str_contains($uaLower, 'chrome')) {
            $browser = 'Safari';
        } elseif (str_contains($uaLower, 'firefox') || str_contains($uaLower, 'fxios')) {
            $browser = 'Firefox';
        } elseif (str_contains($uaLower, 'opr/') || str_contains($uaLower, 'opera')) {
            $browser = 'Opera';
        }

        return compact('device', 'platform', 'browser');
    }
}
