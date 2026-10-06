<?php

namespace App\Http\Middleware;

use App\Models\VisitorTraffic;
use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
     * Silently record page visit with IP Geolocation.
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

            // Ensure geolocation columns exist dynamically without needing manual migration command
            $this->ensureGeoColumnsExist();

            $rawIp = $request->ip() ?: '127.0.0.1';
            $userAgent = (string) $request->header('User-Agent', '');
            $deviceInfo = $this->parseUserAgent($userAgent);
            $geo = $this->resolveGeoLocation($rawIp, $request);

            VisitorTraffic::create([
                'url' => substr($request->fullUrl(), 0, 500),
                'path' => $path === '' ? '/' : $path,
                'method' => $request->method(),
                'ip_address' => $rawIp,
                'country' => $geo['country'] ?? 'Unknown',
                'country_code' => $geo['country_code'] ?? 'UN',
                'city' => $geo['city'] ?? null,
                'region' => $geo['region'] ?? null,
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
     * Ensure geo columns are present in visitor_traffic schema.
     */
    protected function ensureGeoColumnsExist(): void
    {
        try {
            if (!Schema::hasColumn('visitor_traffic', 'country')) {
                Schema::table('visitor_traffic', function (Blueprint $table) {
                    $table->string('country', 100)->nullable();
                    $table->string('country_code', 10)->nullable();
                    $table->string('city', 100)->nullable();
                    $table->string('region', 100)->nullable();
                });
            }
        } catch (\Throwable $e) {
            // Table alteration exception ignored
        }
    }

    /**
     * Resolve IP address to country, city, and region.
     */
    protected function resolveGeoLocation(?string $ip, Request $request): array
    {
        if (empty($ip)) {
            return [
                'country' => 'Unknown',
                'country_code' => 'UN',
                'city' => 'Unknown',
                'region' => null,
            ];
        }

        // Localhost / Internal IP Range
        if (
            in_array($ip, ['127.0.0.1', '::1', 'localhost']) ||
            str_starts_with($ip, '192.168.') ||
            str_starts_with($ip, '10.') ||
            str_starts_with($ip, '172.16.') ||
            str_starts_with($ip, '172.17.') ||
            str_starts_with($ip, '172.18.') ||
            str_starts_with($ip, '172.19.') ||
            str_starts_with($ip, '172.20.') ||
            str_starts_with($ip, '172.21.') ||
            str_starts_with($ip, '172.22.') ||
            str_starts_with($ip, '172.23.') ||
            str_starts_with($ip, '172.24.') ||
            str_starts_with($ip, '172.25.') ||
            str_starts_with($ip, '172.26.') ||
            str_starts_with($ip, '172.27.') ||
            str_starts_with($ip, '172.28.') ||
            str_starts_with($ip, '172.29.') ||
            str_starts_with($ip, '172.30.') ||
            str_starts_with($ip, '172.31.')
        ) {
            return [
                'country' => 'Localhost',
                'country_code' => 'DEV',
                'city' => 'Local Server',
                'region' => 'Development',
            ];
        }

        // Check Cloudflare or Reverse Proxy headers
        $cfCountry = $request->header('CF-IPCountry');
        if ($cfCountry && strlen($cfCountry) === 2 && strtoupper($cfCountry) !== 'XX') {
            $code = strtoupper($cfCountry);
            return [
                'country' => $this->getCountryNameByCode($code) ?: $code,
                'country_code' => $code,
                'city' => $request->header('CF-IPCity') ?: null,
                'region' => $request->header('CF-Region') ?: null,
            ];
        }

        // Cache lookup per unique IP for 30 days to ensure sub-millisecond response time
        return Cache::remember("geoip_record_{$ip}", 86400 * 30, function () use ($ip) {
            try {
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 2,
                        'header' => "User-Agent: Sangfy-Analytics/1.0\r\n"
                    ]
                ]);

                $url = "http://ip-api.com/json/{$ip}?fields=status,message,country,countryCode,regionName,city";
                $json = @file_get_contents($url, false, $context);

                if ($json) {
                    $data = json_decode($json, true);
                    if (isset($data['status']) && $data['status'] === 'success') {
                        return [
                            'country' => $data['country'] ?? 'Unknown',
                            'country_code' => strtoupper($data['countryCode'] ?? 'UN'),
                            'city' => $data['city'] ?? 'Unknown',
                            'region' => $data['regionName'] ?? null,
                        ];
                    }
                }
            } catch (\Throwable $e) {
                // GeoIP lookup error ignored
            }

            return [
                'country' => 'Unknown',
                'country_code' => 'UN',
                'city' => 'Unknown',
                'region' => null,
            ];
        });
    }

    /**
     * Common Country Code to Country Name mapping for headers.
     */
    protected function getCountryNameByCode(string $code): ?string
    {
        $countries = [
            'IN' => 'India',
            'US' => 'United States',
            'GB' => 'United Kingdom',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            'AE' => 'United Arab Emirates',
            'SA' => 'Saudi Arabia',
            'SG' => 'Singapore',
            'JP' => 'Japan',
            'BR' => 'Brazil',
            'PK' => 'Pakistan',
            'BD' => 'Bangladesh',
            'NP' => 'Nepal',
            'LK' => 'Sri Lanka',
            'RU' => 'Russia',
            'CN' => 'China',
            'ID' => 'Indonesia',
            'MY' => 'Malaysia',
            'PH' => 'Philippines',
            'ZA' => 'South Africa',
            'NL' => 'Netherlands',
            'IT' => 'Italy',
            'ES' => 'Spain',
        ];

        return $countries[strtoupper($code)] ?? null;
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
