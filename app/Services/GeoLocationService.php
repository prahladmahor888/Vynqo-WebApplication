<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GeoLocationService
{
    /**
     * Check if an IP address belongs to Cloudflare's edge proxy network.
     * Prevents returning Cloudflare datacenter servers as visitor device IPs.
     */
    public static function isCloudflareProxyIp(?string $ip): bool
    {
        if (empty($ip)) {
            return false;
        }

        $cfPrefixes = [
            '173.245.48.', '173.245.49.', '173.245.5', '173.245.6',
            '103.21.244.', '103.21.245.', '103.21.246.', '103.21.247.',
            '103.22.200.', '103.22.201.', '103.22.202.', '103.22.203.',
            '103.31.4.', '103.31.5.', '103.31.6.', '103.31.7.',
            '141.101.',
            '108.162.',
            '190.93.',
            '188.114.',
            '197.234.',
            '198.41.',
            '162.158.', '162.159.',
            '104.16.', '104.17.', '104.18.', '104.19.', '104.20.', '104.21.', '104.22.', '104.23.', '104.24.', '104.25.', '104.26.', '104.27.',
            '172.64.', '172.65.', '172.66.', '172.67.', '172.68.', '172.69.', '172.70.', '172.71.',
            '131.0.72.',
        ];

        foreach ($cfPrefixes as $prefix) {
            if (str_starts_with($ip, $prefix)) {
                return true;
            }
        }

        // Cloudflare IPv6 subnets
        if (
            str_starts_with($ip, '2400:cb00:') ||
            str_starts_with($ip, '2606:4700:') ||
            str_starts_with($ip, '2803:f800:') ||
            str_starts_with($ip, '2405:b500:') ||
            str_starts_with($ip, '2405:8100:') ||
            str_starts_with($ip, '2a06:98c0:') ||
            str_starts_with($ip, '2c0f:f248:')
        ) {
            return true;
        }

        return false;
    }

    /**
     * Read request header or server variable across all web servers (LiteSpeed, Nginx, Apache, cPanel).
     */
    public static function readHeaderOrServer(Request $request, string $headerName): ?string
    {
        // 1. Standard Laravel request header
        $val = $request->header($headerName);
        if (!empty($val)) {
            return trim((string) $val);
        }

        // 2. $_SERVER / $request->server with HTTP_ prefix (e.g. HTTP_CF_CONNECTING_IP)
        $serverKey = 'HTTP_' . str_replace('-', '_', strtoupper($headerName));
        if (!empty($_SERVER[$serverKey])) {
            return trim((string) $_SERVER[$serverKey]);
        }
        if (!empty($request->server($serverKey))) {
            return trim((string) $request->server($serverKey));
        }

        // 3. $_SERVER / $request->server without HTTP_ prefix (e.g. CF_CONNECTING_IP or X_REAL_IP)
        $plainKey = str_replace('-', '_', strtoupper($headerName));
        if (!empty($_SERVER[$plainKey])) {
            return trim((string) $_SERVER[$plainKey]);
        }
        if (!empty($request->server($plainKey))) {
            return trim((string) $request->server($plainKey));
        }

        // 4. Apache / LiteSpeed apache_request_headers() fallback
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            foreach ($headers as $k => $v) {
                if (strcasecmp($k, $headerName) === 0 && !empty($v)) {
                    return trim((string) $v);
                }
            }
        }

        return null;
    }

    /**
     * Extract the genuine client device public IP address.
     * Prioritizes Cloudflare CF-Connecting-IP, True-Client-IP, and X-Real-IP over reverse proxies.
     */
    public static function getExactIp(Request $request): string
    {
        $ipv4Candidates = [];
        $ipv6Candidates = [];

        // 1. Check all proxy/CDN and forwarded headers in priority order
        $headers = [
            'CF-Pseudo-IPv4',
            'CF-Connecting-IP',
            'True-Client-IP',
            'X-Real-IP',
            'X-Client-IP',
            'Client-IP',
            'X-Cluster-Client-IP',
            'X-Forwarded-For',
            'Forwarded-For',
            'X-Forwarded',
        ];

        foreach ($headers as $header) {
            $val = self::readHeaderOrServer($request, $header);
            if (!empty($val)) {
                $candidates = explode(',', $val);
                foreach ($candidates as $candidate) {
                    $cleaned = self::cleanIp($candidate);
                    if ($cleaned && self::isValidPublicIp($cleaned) && !self::isCloudflareProxyIp($cleaned)) {
                        if (filter_var($cleaned, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                            $ipv4Candidates[] = $cleaned;
                        } elseif (filter_var($cleaned, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                            $ipv6Candidates[] = $cleaned;
                        }
                    }
                }
            }
        }

        // 2. RFC 7239 Forwarded header (e.g. for=103.21.244.5;proto=https)
        $rfcForwarded = self::readHeaderOrServer($request, 'Forwarded');
        if (!empty($rfcForwarded) && preg_match_all('/for="?([^";,\s]+)"?/i', $rfcForwarded, $matches)) {
            foreach ($matches[1] as $candidate) {
                $cleaned = self::cleanIp($candidate);
                if ($cleaned && self::isValidPublicIp($cleaned) && !self::isCloudflareProxyIp($cleaned)) {
                    if (filter_var($cleaned, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                        $ipv4Candidates[] = $cleaned;
                    } elseif (filter_var($cleaned, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                        $ipv6Candidates[] = $cleaned;
                    }
                }
            }
        }

        // 3. Laravel trusted proxy resolved IP
        $laravelIp = self::cleanIp($request->ip());
        if ($laravelIp && self::isValidPublicIp($laravelIp) && !self::isCloudflareProxyIp($laravelIp)) {
            if (filter_var($laravelIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ipv4Candidates[] = $laravelIp;
            } elseif (filter_var($laravelIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ipv6Candidates[] = $laravelIp;
            }
        }

        // 4. Direct web server remote address
        $remoteAddr = self::cleanIp($_SERVER['REMOTE_ADDR'] ?? $request->server('REMOTE_ADDR'));
        if ($remoteAddr && self::isValidPublicIp($remoteAddr) && !self::isCloudflareProxyIp($remoteAddr)) {
            if (filter_var($remoteAddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ipv4Candidates[] = $remoteAddr;
            } elseif (filter_var($remoteAddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ipv6Candidates[] = $remoteAddr;
            }
        }

        // ⚡ RULE: Agar IPv4 available hai to wahi dikhaye!
        if (!empty($ipv4Candidates)) {
            return $ipv4Candidates[0];
        }

        // ⚡ RULE: Agar IPv4 nahi hai aur IPv6 hai, tab hi IPv6 dikhaye!
        if (!empty($ipv6Candidates)) {
            return $ipv6Candidates[0];
        }

        // 5. Local development / Loopback fallback
        // When running on localhost (php artisan serve, 127.0.0.1, or cloudflared tunnel), resolve the machine's actual public IP
        if (empty($remoteAddr) || in_array($remoteAddr, ['127.0.0.1', '::1', 'localhost']) || str_starts_with($remoteAddr, '192.168.') || str_starts_with($remoteAddr, '10.')) {
            $devIp = self::getDevPublicIp();
            if (!empty($devIp)) {
                return $devIp;
            }
        }

        return !empty($remoteAddr) ? $remoteAddr : '127.0.0.1';
    }

    /**
     * Discover developer machine public external IP when testing on local server / 127.0.0.1.
     * Prioritizes IPv4 first; only falls back to IPv6 if machine has no IPv4.
     */
    public static function getDevPublicIp(): ?string
    {
        return Cache::remember('dev_machine_public_ip_v7', 1800, function () {
            // 1. Try IPv4-specific services first
            $ipv4Services = [
                'https://api.ipify.org',
                'https://checkip.amazonaws.com',
                'https://icanhazip.com',
            ];
            foreach ($ipv4Services as $svc) {
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
                    $res = @file_get_contents($svc, false, $ctx);
                    if ($res) {
                        $ip = self::cleanIp($res);
                        if ($ip && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) && self::isValidPublicIp($ip)) {
                            return $ip;
                        }
                    }
                } catch (\Throwable $e) {}
            }

            // 2. If machine has NO IPv4 at all, fall back to dual-stack IPv6 lookup
            $ipv6Services = [
                'https://api64.ipify.org',
                'https://icanhazip.com',
            ];
            foreach ($ipv6Services as $svc) {
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
                    $res = @file_get_contents($svc, false, $ctx);
                    if ($res) {
                        $ip = self::cleanIp($res);
                        if ($ip && self::isValidPublicIp($ip)) {
                            return $ip;
                        }
                    }
                } catch (\Throwable $e) {}
            }

            return null;
        });
    }

    /**
     * Clean and normalize raw IP address (strip surrounding quotes, spaces, brackets, and ports).
     */
    public static function cleanIp(?string $rawIp): ?string
    {
        if (empty($rawIp)) {
            return null;
        }

        $ip = trim((string) $rawIp);
        $ip = trim($ip, "\"' \t\n\r\0\x0B");

        // Strip IPv6 zone index if present (e.g. fe80::1%eth0 or 2405:...%1)
        if (str_contains($ip, '%')) {
            $ip = explode('%', $ip)[0];
        }

        // IPv6 bracketed format with optional port: [2405:201:...]:54321
        if (preg_match('/^\[([a-fA-F0-9:]+)\](?::\d+)?$/', $ip, $matches)) {
            return $matches[1];
        }

        // IPv4-mapped IPv6 format: ::ffff:103.21.244.5 -> 103.21.244.5
        if (preg_match('/^::ffff:(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/i', $ip, $matches)) {
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
     * Check if an IP address is an IPv6 address.
     */
    public static function isIpv6(?string $ip): bool
    {
        if (empty($ip)) {
            return false;
        }
        $clean = self::cleanIp($ip);
        return filter_var($clean, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * Check if an IP address is a valid public IP.
     * Safely allows Indian mobile carrier CGNAT (100.64.0.0/10) and mobile IPv6 allocations.
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

        // Must be a valid IPv4 or IPv6
        if (!filter_var($clean, FILTER_VALIDATE_IP)) {
            return false;
        }

        // Exclude loopback and unspecified
        if ($clean === '127.0.0.1' || $clean === '::1' || $clean === '0.0.0.0') {
            return false;
        }

        // Exclude private IPv4 subnets (10.0.0.0/8, 192.168.0.0/16, 169.254.0.0/16)
        if (
            str_starts_with($clean, '10.') ||
            str_starts_with($clean, '192.168.') ||
            str_starts_with($clean, '169.254.')
        ) {
            return false;
        }

        // Exclude private 172.16.0.0 - 172.31.255.255
        if (preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $clean)) {
            return false;
        }

        // Exclude private IPv6 (fc00::/7 unique local, fe80::/10 link-local)
        $lower = strtolower($clean);
        if (str_starts_with($lower, 'fc') || str_starts_with($lower, 'fd') || str_starts_with($lower, 'fe80:')) {
            return false;
        }

        // NOTE: We deliberately do NOT use FILTER_FLAG_NO_RES_RANGE because
        // Indian mobile operators (Jio, Airtel, Vi) use Carrier-Grade NAT (100.64.0.0/10)
        // and modern ISP IPv6 allocations that PHP's RFC filter rejects as reserved!

        return true;
    }

    /**
     * Resolve exact location (Country, Country Code, City, Region, Flag Emoji).
     */
    public static function resolveLocation(?string $ip, ?Request $request = null): array
    {
        $cleanIp = self::cleanIp($ip);

        // Check if dev environment resolved a real public IP
        if (empty($cleanIp) || in_array($cleanIp, ['127.0.0.1', '::1', 'localhost'])) {
            $devIp = self::getDevPublicIp();
            if (!empty($devIp)) {
                $cleanIp = $devIp;
            } else {
                return [
                    'country' => 'Localhost',
                    'country_code' => 'DEV',
                    'city' => 'Local Server',
                    'region' => 'Development',
                    'flag' => '💻',
                ];
            }
        }

        // Check for private subnet IP ranges
        if (
            str_starts_with($cleanIp, '192.168.') ||
            str_starts_with($cleanIp, '10.') ||
            preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $cleanIp)
        ) {
            $devIp = self::getDevPublicIp();
            if (!empty($devIp)) {
                $cleanIp = $devIp;
            } else {
                return [
                    'country' => 'Localhost',
                    'country_code' => 'DEV',
                    'city' => 'Local Network',
                    'region' => 'Private Subnet',
                    'flag' => '💻',
                ];
            }
        }

        // Check if Cloudflare provides headers
        $cfCountry = null;
        $cfCity = null;
        $cfRegion = null;

        if ($request) {
            $cfCountry = self::readHeaderOrServer($request, 'CF-IPCountry');
            $cfCity = self::readHeaderOrServer($request, 'CF-IPCity');
            $cfRegion = self::readHeaderOrServer($request, 'CF-Region') ?: self::readHeaderOrServer($request, 'CF-Region-Code');
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

        // Cache GeoIP lookup per unique IP for 30 days under v5 cache namespace (sanitize colons for IPv6)
        $safeCacheKey = str_replace([':', ' ', '%'], '_', $cleanIp);
        $cacheKey = "geoip_accurate_v5_{$safeCacheKey}";

        // Fast path: Return cached GeoIP if already resolved
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        // Cache lock to prevent thundering herd / parallel external API calls for same IP
        $geoLock = Cache::lock("geoip_lock_{$safeCacheKey}", 10);
        try {
            return $geoLock->block(3, function () use ($cacheKey, $cleanIp, $cfCountry) {
                return Cache::remember($cacheKey, 86400 * 30, function () use ($cleanIp, $cfCountry) {
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
            });
        } catch (\Throwable $e) {
            return Cache::remember($cacheKey, 86400 * 30, function () use ($cleanIp, $cfCountry) {
                return self::queryGeoIpProviders($cleanIp);
            });
        }
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

        // Provider 5: ipwhois.app (HTTPS fallback)
        $res = self::fetchJson("https://ipwhois.app/json/{$ip}", $timeout);
        if ($res && isset($res['success']) && $res['success'] == true && !empty($res['country_code'])) {
            $code = strtoupper((string) $res['country_code']);
            return [
                'country' => $res['country'] ?? self::getCountryNameByCode($code) ?? 'Unknown',
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
