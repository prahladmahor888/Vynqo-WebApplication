<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request and attach enterprise OWASP recommended security & anti-XSS headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Anti-MIME Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Anti-Clickjacking Frame Protection
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Legacy Browser Cross-Site Scripting (XSS) Filter Enforcer
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Privacy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Feature & Hardware Permissions Policy
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Strict Transport Security (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // Cross-Origin Isolation & Protection
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // Content-Security-Policy (CSP) Defense Against Cross-Site Scripting & Injection
        $csp = "default-src 'self' https: data: blob: 'unsafe-inline' 'unsafe-eval'; " .
               "img-src 'self' data: https: blob:; " .
               "media-src 'self' https: data: blob:; " .
               "font-src 'self' https: data:; " .
               "style-src 'self' https: 'unsafe-inline'; " .
               "script-src 'self' https: 'unsafe-inline' 'unsafe-eval'; " .
               "object-src 'none'; " .
               "base-uri 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
