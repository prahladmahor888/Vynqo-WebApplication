<?php

namespace App\Http\Middleware;

use App\Models\BlockedBotLog;
use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class BotProtectionMiddleware
{
    /**
     * Known malicious vulnerability scanners, automated attack tools, and aggressive scraper signatures.
     */
    protected array $maliciousUserAgents = [
        'sqlmap',
        'nikto',
        'masscan',
        'zgrab',
        'nmap',
        'dirbuster',
        'gobuster',
        'wpscan',
        'acunetix',
        'havij',
        'hydra',
        'metasploit',
        'netsparker',
        'burpcollaborator',
        'morfeus',
        'openvas',
        'nessus',
        'arachni',
        'whatweb',
        'censys',
        'shodan',
        'libwww-perl',
        'python-requests',
        'python-urllib',
        'aiohttp',
        'scrapy',
        'bytespider',
        'go-http-client',
        'httpclient',
        'phantomjs',
        'headlesschrome',
        'selenium',
        'puppeteer',
        'curl/',
        'wget/',
        'semrushbot',
        'mj12bot',
        'dotbot',
        'zoominfobot',
        'petalbot',
        'ahrefsbot',
        'dataforseo',
        'seekport',
        'seznambot',
        'blexbot',
    ];

    /**
     * Legitimate search engine bots and social media link previewers (allowed for SEO).
     */
    protected array $searchEngineBots = [
        'googlebot',
        'bingbot',
        'duckduckbot',
        'yandexbot',
        'baiduspider',
        'slurp',
        'twitterbot',
        'facebookexternalhit',
        'linkedinbot',
        'applebot',
        'pinterestbot',
        'slackbot',
        'whatsapp',
        'telegrambot',
        'discordbot',
    ];

    /**
     * Known malicious exploit scanner paths frequently probed by automated bots.
     */
    protected array $exploitProbePaths = [
        '/.env',
        '/.git',
        '/wp-login.php',
        '/wp-admin',
        '/xmlrpc.php',
        '/phpmyadmin',
        '/pma',
        '/setup.php',
        '/eval-stdin.php',
        '/.aws',
        '/config.php',
        '/cgi-bin',
        '/actuator',
        '/alfa.php',
        '/wso.php',
        '/shell.php',
        '/.ds_store',
        '/.svn',
        '/solr',
        '/.remote',
        '/vendor/phpunit',
        '/debug/default/view',
        '/telescope',
        '/phpinfo.php',
        '/info.php',
        '/test.php',
        '/admin.php',
        '/user.php',
        '/install.php',
        '/backup',
        '/dump.sql',
        '/.htaccess',
    ];

    /**
     * Handle incoming request and filter automated / malicious bot traffic.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = '/' . ltrim(strtolower($request->path()), '/');

        // 1. Bypass Whitelist: Static assets and core link endpoints
        if (
            str_starts_with($path, '/assets') ||
            str_starts_with($path, '/build') ||
            str_starts_with($path, '/favicon.ico') ||
            str_starts_with($path, '/robots.txt') ||
            str_starts_with($path, '/sitemap.xml') ||
            str_starts_with($path, '/.well-known/assetlinks.json')
        ) {
            return $next($request);
        }

        // Check if master bot protection shield is enabled
        $shieldEnabled = SiteSetting::get('bot_protection_enabled', '1') === '1';
        if (!$shieldEnabled) {
            return $next($request);
        }

        $ip = $request->ip() ?: '127.0.0.1';
        $userAgent = (string) $request->header('User-Agent', '');
        $uaLower = strtolower(trim($userAgent));

        // 2. Custom IP Whitelist Check
        $whitelistStr = (string) SiteSetting::get('ip_whitelist', '');
        if (!empty($whitelistStr)) {
            $whitelistedIps = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $whitelistStr))));
            if (in_array($ip, $whitelistedIps, true)) {
                return $next($request);
            }
        }

        // 3. Custom IP Blacklist Check
        $blacklistStr = (string) SiteSetting::get('ip_blacklist', '');
        if (!empty($blacklistStr)) {
            $blacklistedIps = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $blacklistStr))));
            if (in_array($ip, $blacklistedIps, true)) {
                BlockedBotLog::record($request, 'IP Address explicitly blacklisted in Admin Firewall', 'blacklisted_ip');
                return $this->blockResponse('Access denied: Your IP address has been blacklisted.', 403);
            }
        }

        // 4. Exploit Scanner / Probe Path Blocker
        $blockExploitProbes = SiteSetting::get('block_exploit_probes', '1') === '1';
        if ($blockExploitProbes) {
            foreach ($this->exploitProbePaths as $probe) {
                if ($path === $probe || str_starts_with($path, $probe . '/') || str_contains($path, $probe)) {
                    BlockedBotLog::record($request, "Exploit Probe Blocked: {$path}", 'exploit_probe');
                    return $this->blockResponse('Access Forbidden: Suspicious path probing detected.', 403);
                }
            }
        }

        // 5. Empty / Missing User-Agent Filter
        $blockEmptyUa = SiteSetting::get('block_empty_user_agents', '1') === '1';
        if ($blockEmptyUa && empty($uaLower)) {
            BlockedBotLog::record($request, 'Empty / Missing User-Agent Header', 'bad_user_agent');
            return $this->blockResponse('Access denied: Request missing standard User-Agent header.', 403);
        }

        // 6. Check if request is from a legitimate search engine bot (Google, Bing, Twitterbot, etc.)
        $allowSearchBots = SiteSetting::get('allow_search_engines', '1') === '1';
        $isSearchBot = false;
        if (!empty($uaLower)) {
            foreach ($this->searchEngineBots as $sBot) {
                if (str_contains($uaLower, $sBot)) {
                    $isSearchBot = true;
                    break;
                }
            }
        }

        // If search engine bot and allowed, let it crawl public pages
        if ($isSearchBot && $allowSearchBots) {
            // Disallow crawling admin and login routes even for search bots
            if (str_starts_with($path, '/admin') || str_starts_with($path, '/login')) {
                return $this->blockResponse('Search engine crawlers disallowed in administrative zone.', 403);
            }
            return $next($request);
        }

        // 7. Malicious Automated Scraper & Bot Detection
        $blockScrapers = SiteSetting::get('block_known_scrapers', '1') === '1';
        if ($blockScrapers && !empty($uaLower)) {
            foreach ($this->maliciousUserAgents as $badAgent) {
                if (str_contains($uaLower, $badAgent)) {
                    BlockedBotLog::record($request, "Malicious Scraper / Bot Detected ({$badAgent})", 'scraper');
                    return $this->blockResponse("Automated scraper traffic blocked ({$badAgent}).", 403);
                }
            }
        }

        // 8. SQL Injection & Malicious Payload Heuristic Inspection
        $sqliProtectionEnabled = SiteSetting::get('sqli_protection_enabled', '1') === '1';
        if ($sqliProtectionEnabled && $this->detectSqlInjection($request)) {
            BlockedBotLog::record($request, "SQL Injection Attempt Detected on {$path}", 'sql_injection');
            return $this->blockResponse('Access Denied: Malicious SQL injection signature detected.', 403);
        }

        // 9. Cross-Site Scripting (XSS) Attack Detection & Prevention
        $xssProtectionEnabled = SiteSetting::get('xss_protection_enabled', '1') === '1';
        if ($xssProtectionEnabled && $this->detectXss($request)) {
            BlockedBotLog::record($request, "Cross-Site Scripting (XSS) Attempt Blocked on {$path}", 'xss_attack');
            return $this->blockResponse('Access Denied: Cross-Site Scripting (XSS) attack vector detected.', 403);
        }

        // 10. Adaptive Rate Limiting & Anti-Flood Protection (Sliding Window per IP)
        $maxPerMinute = (int) SiteSetting::get('max_requests_per_minute', 60);
        if ($maxPerMinute > 0 && !str_starts_with($path, '/admin')) {
            $rateKey = 'bot_rate_limit_' . md5($ip);
            $currentHits = (int) Cache::get($rateKey, 0);

            if ($currentHits >= $maxPerMinute) {
                BlockedBotLog::record($request, "Rate Limit Exceeded (> {$maxPerMinute} req/min)", 'rate_limit');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Too many requests. Bot flood protection triggered. Please slow down.',
                    'retry_after_seconds' => 60,
                ], 429, [
                    'Retry-After' => '60',
                    'Content-Type' => 'application/json',
                ]);
            }

            Cache::put($rateKey, $currentHits + 1, 60);
        }

        return $next($request);
    }

    /**
     * Inspect incoming request surface (URL, query string, headers, body) for Cross-Site Scripting (XSS) attack vectors.
     */
    protected function detectXss(Request $request): bool
    {
        // High-precision regex patterns for XSS vectors
        $patterns = [
            '/<\s*script\b[^>]*>/i',
            '/<\s*\/\s*script\s*>/i',
            '/javascript\s*:\s*/i',
            '/vbscript\s*:\s*/i',
            '/data\s*:\s*text\/html/i',
            '/<\s*(iframe|embed|object|applet|meta|link|base)\b[^>]*>/i',
            '/<\s*img\b[^>]*\bonerror\s*=/i',
            '/<\s*svg\b[^>]*\bonload\s*=/i',
            '/<\s*body\b[^>]*\bonload\s*=/i',
            '/<\s*input\b[^>]*\b(onfocus|autofocus|onblur)\s*=/i',
            '/\bon(load|error|click|dblclick|mouseover|mouseenter|mouseleave|focus|blur|change|submit|keydown|keyup|keypress)\s*=\s*[\'"].*?[\'"]/i',
            '/\bdocument\.(cookie|location|write|writeln|domain)\b/i',
            '/\bwindow\.(location|navigate|open)\b/i',
            '/\beval\s*\(\s*[\'"`]/i',
            '/\bString\.fromCharCode\b/i',
            '/expression\s*\(\s*.*?\)/i', // CSS expression XSS
            '/<[a-zA-Z0-9_-]+\s+[^>]*\bjavascript:[^>]*>/i',
        ];

        // 1. Check Raw URI and Query Strings (encoded and double decoded)
        $rawQuery = (string) $request->getQueryString();
        $rawUri = (string) $request->getRequestUri();
        $decodedUri = rawurldecode(rawurldecode($rawUri));

        foreach ($patterns as $pattern) {
            if (
                preg_match($pattern, $rawQuery) ||
                preg_match($pattern, $rawUri) ||
                preg_match($pattern, $decodedUri)
            ) {
                return true;
            }
        }

        // 2. Scan request parameters except trusted administrative code fields (e.g. custom analytics head script entered by authorized admin)
        if (str_starts_with(strtolower($request->path()), 'admin/')) {
            $inputs = $request->except(['_token', 'password', 'custom_head_code', 'custom_css']);
        } else {
            $inputs = $request->except(['_token', 'password']);
        }

        return $this->scanArrayForXss($inputs, $patterns);
    }

    /**
     * Recursively scan nested arrays/strings for XSS patterns.
     */
    protected function scanArrayForXss(array $data, array $patterns): bool
    {
        foreach ($data as $key => $value) {
            // Check array keys for XSS
            if (is_string($key)) {
                $decodedKey = rawurldecode($key);
                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, $key) || preg_match($pattern, $decodedKey)) {
                        return true;
                    }
                }
            }

            if (is_array($value)) {
                if ($this->scanArrayForXss($value, $patterns)) {
                    return true;
                }
            } elseif (is_string($value) && strlen($value) > 2) {
                $decoded = rawurldecode($value);
                $htmlDecoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                foreach ($patterns as $pattern) {
                    if (
                        preg_match($pattern, $value) ||
                        preg_match($pattern, $decoded) ||
                        preg_match($pattern, $htmlDecoded)
                    ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Inspect entire incoming request surface (URL path, query string, headers, body) for SQL injection attack vectors.
     */
    protected function detectSqlInjection(Request $request): bool
    {
        // Comprehensive SQL injection signatures & heuristic regex patterns
        $patterns = [
            '/\b(union\s+(all\s+)?select)\b/i',
            '/\b(select\s+.*\s+from\s+[\w\.\`]+)/i',
            '/\b(insert\s+into\s+[\w\.\`]+)/i',
            '/\b(update\s+[\w\.\`]+\s+set\s+[\w\.\`]+\s*=)/i',
            '/\b(delete\s+from\s+[\w\.\`]+)/i',
            '/\b(drop\s+(table|database|schema|view|column))\b/i',
            '/\b(alter\s+table\s+[\w\.\`]+)/i',
            '/\b(truncate\s+table\s+[\w\.\`]+)/i',
            '/\b(exec|execute)\s*\(\s*[\'\"]?\w+/i',
            '/\b(benchmark|sleep)\s*\(\s*\d+\s*\)/i',
            '/\bwaitfor\s+delay\s+[\'\"]\d+/i',
            '/\binformation_schema\b/i',
            '/\bload_file\s*\(/i',
            '/\binto\s+(out|dump)file\b/i',
            '/(\'|\")\s*or\s*(\'|\")?\d+(\'|\")?\s*=\s*(\'|\")?\d+/i',
            '/(\'|\")\s*or\s*(\'|\")?[a-zA-Z]+(\'|\")?\s*=\s*(\'|\")?[a-zA-Z]+/i',
            '/\b(or|and)\s+1\s*=\s*1\b/i',
            '/\b(or|and)\s+\'1\'\s*=\s*\'1\'\b/i',
            '/\b(or|and)\s+"1"\s*=\s*"1"\b/i',
            '/\b(or|and)\s+true\s*=\s*true\b/i',
            '/\b(group_concat|concat_ws)\s*\(/i',
            '/\b(extractvalue|updatexml)\s*\(/i',
            '/\bxp_cmdshell\b/i',
            '/(\/\*!.*?\*\/)/i',
        ];

        // 1. Check Full Path & Decoded Raw Query String
        $rawQuery = (string) $request->getQueryString();
        $rawUri = rawurldecode($request->getRequestUri());
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $rawQuery) || preg_match($pattern, $rawUri)) {
                return true;
            }
        }

        // 2. Gather all inputs (GET, POST, JSON, route parameters)
        $inputs = $request->except(['_token', 'password', 'custom_head_code', 'changelog', 'body', 'content']);

        return $this->scanArrayForSqlInjection($inputs, $patterns);
    }

    /**
     * Recursively scan nested arrays/strings for SQL injection patterns.
     */
    protected function scanArrayForSqlInjection(array $data, array $patterns): bool
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if ($this->scanArrayForSqlInjection($value, $patterns)) {
                    return true;
                }
            } elseif (is_string($value) && strlen($value) > 2) {
                $decoded = rawurldecode($value);
                foreach ($patterns as $pattern) {
                    if (
                        preg_match($pattern, $value) ||
                        preg_match($pattern, $decoded) ||
                        preg_match($pattern, (string) $key)
                    ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Return formatted Security Block Response.
     */
    protected function blockResponse(string $message, int $statusCode = 403): Response
    {
        $siteName = SiteSetting::get('site_name', 'Sangfy');

        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden — ' . htmlspecialchars($siteName) . ' Security Shield</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0b0f19; color: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; box-sizing: border-box; }
        .card { background: #131b2e; border: 1px solid #1e293b; border-radius: 16px; padding: 32px; max-width: 480px; width: 100%; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
        .icon { width: 56px; height: 56px; margin: 0 auto 16px; background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; }
        h1 { font-size: 22px; font-weight: 800; margin: 0 0 10px; color: #ffffff; letter-spacing: -0.02em; }
        p { font-size: 13px; color: #94a3b8; line-height: 1.6; margin: 0 0 20px; }
        .badge { display: inline-block; padding: 6px 12px; background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); border-radius: 8px; color: #a5b4fc; font-size: 11px; font-family: monospace; font-weight: 600; margin-bottom: 20px; }
        .footer { font-size: 11px; color: #64748b; border-top: 1px solid #1e293b; padding-top: 16px; margin-top: 8px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">🛡️</div>
        <h1>Security Shield Protected</h1>
        <p>' . htmlspecialchars($message) . '</p>
        <div class="badge">' . htmlspecialchars($siteName) . ' Anti-Bot Firewall Active</div>
        <div class="footer">If you believe this is an error, please contact support with your IP address.</div>
    </div>
</body>
</html>';

        return response($html, $statusCode, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'X-Robots-Tag' => 'noindex, nofollow, noarchive',
        ]);
    }
}
