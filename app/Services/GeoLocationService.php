<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GeoLocationService
{
    /**
     * Extract the genuine client device public IP address.
     * Prioritizes reverse proxy, Cloudflare, load balancer headers over internal socket connections.
     */
    public static function getExactIp(Request $request): string
    {
        $headersToInspect = [
            'CF-Connecting-IP',
            'True-Client-IP',
            'X-Real-IP',
            'X-Forwarded-For',
            'X-Client-IP',
            'X-Forwarded',
            'Forwarded-For',
            'Forwarded',
            'Client-IP',
        ];

        foreach ($headersToInspect as $headerName) {
            $val = $request->header($headerName);
            if (empty($val)) {
                $serverKey = 'HTTP_' . str_replace('-', '_', strtoupper($headerName));
                if (isset($_SERVER[$serverKey])) {
                    $val = $_SERVER[$serverKey];
                }
            }

            if (!empty($val)) {
                // Handle multiple comma-separated IPs (client, proxy1, proxy2)
                $candidates = explode(',', (string) $val);
                foreach ($candidates as $candidate) {
                    $cleaned = self::cleanIp($candidate);
                    if (self::isValidPublicIp($cleaned)) {
                        return $cleaned;
                    }
                }
            }
        }

        // Direct web server remote address
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $cleaned = self::cleanIp($_SERVER['REMOTE_ADDR']);
            if (self::isValidPublicIp($cleaned)) {
                return $cleaned;
            }
        }

        // Laravel default request IP
        $laravelIp = self::cleanIp($request->ip());
        if (self::isValidPublicIp($laravelIp)) {
            return $laravelIp;
        }

        return !empty($laravelIp) ? $laravelIp : '127.0.0.1';
    }

    /**
     * Clean and normalize raw IP address (strip surrounding quotes, spaces, and ports).
     */
    public static function cleanIp(?string $rawIp): ?string
    {
        if (empty($rawIp)) {
            return null;
        }

        $ip = trim((string) $rawIp);
        $ip = trim($ip, "\"' \t\n\r\0\x0B");

        // IPv6 bracketed format with optional port: [2405:201:...]:54321
        if (preg_match('/^\[([a-fA-F0-9:]+)\](?::\d+)?$/', $ip, $matches)) {
            return $matches[1];
        }

        // Standard IPv4 with optional port: 103.21.244.5:54321
        if (preg_match('/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::\d+)?$/', $ip, $matches)) {
            return $matches[1];
        }

        // Plain IPv6 without brackets
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return $ip;
        }

        // Plain IPv4
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $ip;
        }

        return $ip;
    }

    /**
     * Check if an IP address is a valid public IP (not a private, loopback, or reserved IP).
     */
    public static function isValidPublicIp(?string $ip): bool
    {
        if (empty($ip)) {
            return false;
        }

        $clean = self::cleanIp($ip);
        if (empty($clean)) {
            return false;
        }

        // Filter out private and reserved IP ranges (127.0.0.1, 10.*, 192.168.*, 172.16-31.*)
        return filter_var(
            $clean,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }

    /**
     * Resolve exact location (Country, Country Code, City, Region, Flag Emoji).
     */
    public static function resolveLocation(?string $ip, ?Request $request = null): array
    {
        $cleanIp = self::cleanIp($ip);

        if (empty($cleanIp) || in_array($cleanIp, ['127.0.0.1', '::1', 'localhost'])) {
            return [
                'country' => 'Localhost',
                'country_code' => 'DEV',
                'city' => 'Local Server',
                'region' => 'Development',
                'flag' => '💻',
            ];
        }

        // Check for private subnet IP ranges
        if (
            str_starts_with($cleanIp, '192.168.') ||
            str_starts_with($cleanIp, '10.') ||
            str_starts_with($cleanIp, '172.16.') ||
            str_starts_with($cleanIp, '172.17.') ||
            str_starts_with($cleanIp, '172.18.') ||
            str_starts_with($cleanIp, '172.19.') ||
            str_starts_with($cleanIp, '172.20.') ||
            str_starts_with($cleanIp, '172.21.') ||
            str_starts_with($cleanIp, '172.22.') ||
            str_starts_with($cleanIp, '172.23.') ||
            str_starts_with($cleanIp, '172.24.') ||
            str_starts_with($cleanIp, '172.25.') ||
            str_starts_with($cleanIp, '172.26.') ||
            str_starts_with($cleanIp, '172.27.') ||
            str_starts_with($cleanIp, '172.28.') ||
            str_starts_with($cleanIp, '172.29.') ||
            str_starts_with($cleanIp, '172.30.') ||
            str_starts_with($cleanIp, '172.31.')
        ) {
            return [
                'country' => 'Localhost',
                'country_code' => 'DEV',
                'city' => 'Local Network',
                'region' => 'Private Subnet',
                'flag' => '💻',
            ];
        }

        // Check if Cloudflare provides headers
        $cfCountry = null;
        $cfCity = null;
        $cfRegion = null;

        if ($request) {
            $cfCountry = $request->header('CF-IPCountry') ?: ($_SERVER['HTTP_CF_IPCOUNTRY'] ?? null);
            $cfCity = $request->header('CF-IPCity') ?: ($_SERVER['HTTP_CF_IPCITY'] ?? null);
            $cfRegion = $request->header('CF-Region') ?: ($request->header('CF-Region-Code') ?: ($_SERVER['HTTP_CF_REGION'] ?? null));
        }

        // If Cloudflare already provides both Country AND City, return immediately
        if (!empty($cfCountry) && strlen($cfCountry) === 2 && strtoupper($cfCountry) !== 'XX' && !empty($cfCity)) {
            $code = strtoupper($cfCountry);
            return [
                'country' => self::getCountryNameByCode($code) ?: $code,
                'country_code' => $code,
                'city' => trim($cfCity),
                'region' => !empty($cfRegion) ? trim($cfRegion) : null,
                'flag' => self::getCountryFlag($code),
            ];
        }

        // Cache GeoIP lookup per unique IP for 30 days for instant sub-millisecond execution
        return Cache::remember("geoip_accurate_v4_{$cleanIp}", 86400 * 30, function () use ($cleanIp, $cfCountry) {
            $data = self::queryGeoIpProviders($cleanIp);

            // If Cloudflare provided country code, prioritize it if lookup was empty
            if (!empty($cfCountry) && strlen($cfCountry) === 2 && strtoupper($cfCountry) !== 'XX') {
                if (empty($data['country_code']) || $data['country_code'] === 'UN') {
                    $code = strtoupper($cfCountry);
                    $data['country_code'] = $code;
                    $data['country'] = self::getCountryNameByCode($code) ?: $code;
                    $data['flag'] = self::getCountryFlag($code);
                }
            }

            return $data;
        });
    }

    /**
     * Query GeoIP APIs with multi-provider fallback using cURL and stream contexts.
     */
    protected static function queryGeoIpProviders(string $ip): array
    {
        $timeout = 3;

        // Provider 1: ipwho.is (HTTPS, fast, accurate city level worldwide)
        $res = self::fetchJson("https://ipwho.is/{$ip}", $timeout);
        if ($res && isset($res['success']) && $res['success'] === true && !empty($res['country_code'])) {
            $code = strtoupper((string) $res['country_code']);
            return [
                'country' => $res['country'] ?? self::getCountryNameByCode($code) ?? 'Unknown',
                'country_code' => $code,
                'city' => !empty($res['city']) ? trim($res['city']) : null,
                'region' => !empty($res['region']) ? trim($res['region']) : null,
                'flag' => self::getCountryFlag($code),
            ];
        }

        // Provider 2: freeipapi.com (HTTPS fallback)
        $res = self::fetchJson("https://freeipapi.com/api/json/{$ip}", $timeout);
        if ($res && !empty($res['countryCode'])) {
            $code = strtoupper((string) $res['countryCode']);
            return [
                'country' => $res['countryName'] ?? self::getCountryNameByCode($code) ?? 'Unknown',
                'country_code' => $code,
                'city' => !empty($res['cityName']) ? trim($res['cityName']) : null,
                'region' => !empty($res['regionName']) ? trim($res['regionName']) : null,
                'flag' => self::getCountryFlag($code),
            ];
        }

        // Provider 3: ip-api.com (HTTP fallback)
        $res = self::fetchJson("http://ip-api.com/json/{$ip}?fields=status,message,country,countryCode,regionName,city", $timeout);
        if ($res && isset($res['status']) && $res['status'] === 'success' && !empty($res['countryCode'])) {
            $code = strtoupper((string) $res['countryCode']);
            return [
                'country' => $res['country'] ?? self::getCountryNameByCode($code) ?? 'Unknown',
                'country_code' => $code,
                'city' => !empty($res['city']) ? trim($res['city']) : null,
                'region' => !empty($res['regionName']) ? trim($res['regionName']) : null,
                'flag' => self::getCountryFlag($code),
            ];
        }

        // Provider 4: ipapi.co (HTTPS fallback)
        $res = self::fetchJson("https://ipapi.co/{$ip}/json/", $timeout);
        if ($res && !empty($res['country_code'])) {
            $code = strtoupper((string) $res['country_code']);
            return [
                'country' => $res['country_name'] ?? self::getCountryNameByCode($code) ?? 'Unknown',
                'country_code' => $code,
                'city' => !empty($res['city']) ? trim($res['city']) : null,
                'region' => !empty($res['region']) ? trim($res['region']) : null,
                'flag' => self::getCountryFlag($code),
            ];
        }

        return [
            'country' => 'India / Global',
            'country_code' => 'IN',
            'city' => null,
            'region' => null,
            'flag' => '🇮🇳',
        ];
    }

    /**
     * Resilient HTTP GET that tries cURL first, then falls back to file_get_contents.
     */
    protected static function fetchJson(string $url, int $timeoutSeconds = 3): ?array
    {
        // 1. Try cURL
        if (function_exists('curl_init')) {
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeoutSeconds);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SangfyGeoResolver/1.0)');
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($response && $httpCode >= 200 && $httpCode < 300) {
                    $decoded = json_decode($response, true);
                    if (is_array($decoded)) {
                        return $decoded;
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 2. Fallback to file_get_contents
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => $timeoutSeconds,
                    'header' => "User-Agent: Mozilla/5.0 (compatible; SangfyGeoResolver/1.0)\r\nAccept: application/json\r\n",
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
            $response = @file_get_contents($url, false, $context);
            if ($response) {
                $decoded = json_decode($response, true);
                if (is_array($decoded)) {
                    return $decoded;
                }
            }
        } catch (\Throwable $e) {}

        return null;
    }

    /**
     * Convert 2-letter Country Code to Unicode Flag Emoji.
     */
    public static function getCountryFlag(?string $code): string
    {
        $code = strtoupper((string) $code);

        if (empty($code) || $code === 'DEV' || $code === 'LOCAL') {
            return '💻';
        }

        if ($code === 'UN' || strlen($code) !== 2) {
            return '📍';
        }

        try {
            return mb_chr(ord($code[0]) + 127397, 'UTF-8') . mb_chr(ord($code[1]) + 127397, 'UTF-8');
        } catch (\Throwable $e) {
            return '📍';
        }
    }

    /**
     * Check if the User-Agent represents an Apple iOS device (iPhone, iPad, iPod).
     */
    public static function isIos(?string $ua): bool
    {
        if (empty($ua)) {
            return false;
        }

        $uaLower = strtolower($ua);

        return str_contains($uaLower, 'iphone')
            || str_contains($uaLower, 'ipad')
            || str_contains($uaLower, 'ipod')
            || (str_contains($uaLower, 'macintosh') && str_contains($uaLower, 'mobile'))
            || (bool) preg_match('/cpu\s+(?:iphone\s+)?os\s+[0-9_\.]+/i', $ua);
    }

    /**
     * Detect Device Type, Platform/OS, and Browser from User-Agent string.
     */
    public static function parseDeviceInfo(string $ua): array
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
            if (preg_match('/android\s+([0-9\.]+)/i', $ua, $m)) {
                $platform = 'Android ' . $m[1];
            }
        } elseif (str_contains($uaLower, 'iphone')) {
            $platform = 'iOS (iPhone)';
        } elseif (str_contains($uaLower, 'ipad')) {
            $platform = 'iPadOS';
        } elseif (str_contains($uaLower, 'windows')) {
            $platform = 'Windows';
            if (str_contains($uaLower, 'windows nt 10.0')) $platform = 'Windows 10/11';
        } elseif (str_contains($uaLower, 'mac os') || str_contains($uaLower, 'macintosh')) {
            $platform = 'macOS';
        } elseif (str_contains($uaLower, 'linux')) {
            $platform = 'Linux';
        }

        // 3. Browser
        $browser = 'Browser';
        if (str_contains($uaLower, 'samsungbrowser')) {
            $browser = 'Samsung Internet';
        } elseif (str_contains($uaLower, 'edg/')) {
            $browser = 'Edge';
        } elseif (str_contains($uaLower, 'opr/') || str_contains($uaLower, 'opera')) {
            $browser = 'Opera';
        } elseif (str_contains($uaLower, 'ucbrowser')) {
            $browser = 'UC Browser';
        } elseif (str_contains($uaLower, 'miuibrowser')) {
            $browser = 'Mi Browser';
        } elseif (str_contains($uaLower, 'chrome') || str_contains($uaLower, 'crios')) {
            $browser = 'Chrome';
        } elseif (str_contains($uaLower, 'safari') && !str_contains($uaLower, 'chrome')) {
            $browser = 'Safari';
        } elseif (str_contains($uaLower, 'firefox') || str_contains($uaLower, 'fxios')) {
            $browser = 'Firefox';
        }

        return compact('device', 'platform', 'browser');
    }

    /**
     * Map common ISO Country Codes to Full Names.
     */
    public static function getCountryNameByCode(string $code): ?string
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
            'TH' => 'Thailand',
            'VN' => 'Vietnam',
            'KR' => 'South Korea',
            'TR' => 'Turkey',
            'EG' => 'Egypt',
            'KW' => 'Kuwait',
            'QA' => 'Qatar',
            'OM' => 'Oman',
            'BH' => 'Bahrain',
            'NZ' => 'New Zealand',
            'CH' => 'Switzerland',
            'SE' => 'Sweden',
            'NO' => 'Norway',
            'DK' => 'Denmark',
            'FI' => 'Finland',
            'IE' => 'Ireland',
            'BE' => 'Belgium',
            'AT' => 'Austria',
            'PL' => 'Poland',
            'MX' => 'Mexico',
            'AR' => 'Argentina',
            'CO' => 'Colombia',
            'NG' => 'Nigeria',
            'KE' => 'Kenya',
        ];

        return $countries[strtoupper($code)] ?? null;
    }
}
