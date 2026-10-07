<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class BlockedBotLog extends Model
{
    use HasFactory;

    protected $table = 'blocked_bot_logs';

    protected $fillable = [
        'ip_address',
        'block_reason',
        'category',
        'path',
        'method',
        'user_agent',
        'country',
        'country_code',
    ];

    /**
     * Get Country Flag Emoji (e.g. 🇮🇳, 🇺🇸, 🇬🇧, 💻 for local).
     */
    public function getCountryFlagAttribute(): string
    {
        $code = strtoupper((string) ($this->country_code ?? ''));

        if (empty($code) || $code === 'DEV' || $code === 'LOCAL' || in_array($this->ip_address, ['127.0.0.1', '::1', 'localhost'])) {
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
     * Ensure table exists dynamically.
     */
    public static function ensureTableExists(): void
    {
        try {
            if (!Schema::hasTable('blocked_bot_logs')) {
                Schema::create('blocked_bot_logs', function (Blueprint $table) {
                    $table->id();
                    $table->string('ip_address', 45)->nullable();
                    $table->string('block_reason', 255)->default('Blocked Automated Bot');
                    $table->string('category', 50)->default('scraper'); // scraper, exploit_probe, honeypot, rate_limit, blacklisted_ip, bad_user_agent
                    $table->string('path', 500)->default('/');
                    $table->string('method', 10)->default('GET');
                    $table->text('user_agent')->nullable();
                    $table->string('country', 100)->nullable();
                    $table->string('country_code', 10)->nullable();
                    $table->timestamps();

                    $table->index('ip_address');
                    $table->index('category');
                    $table->index('created_at');
                });
            }
        } catch (\Throwable $e) {
            // Silently swallow schema errors
        }
    }

    /**
     * Log a blocked bot attempt safely.
     */
    public static function record(Request $request, string $reason, string $category = 'scraper'): void
    {
        try {
            self::ensureTableExists();

            $rawIp = $request->ip() ?: '127.0.0.1';
            $path = '/' . ltrim($request->path(), '/');
            $ua = (string) $request->header('User-Agent', '');

            // Quick CF header country check or cache
            $cfCountry = $request->header('CF-IPCountry');
            $countryCode = ($cfCountry && strlen($cfCountry) === 2 && strtoupper($cfCountry) !== 'XX') ? strtoupper($cfCountry) : 'UN';
            $countryName = $countryCode !== 'UN' ? $countryCode : 'Unknown';

            self::create([
                'ip_address' => $rawIp,
                'block_reason' => substr($reason, 0, 255),
                'category' => $category,
                'path' => substr($path, 0, 500),
                'method' => $request->method(),
                'user_agent' => substr($ua, 0, 1000),
                'country' => $countryName,
                'country_code' => $countryCode,
            ]);

            // Increment cached counter for instant fast dashboard read
            Cache::increment('shield_total_blocked_bots');
            Cache::increment('shield_blocked_' . $category);
        } catch (\Throwable $e) {
            // Never break response on analytics log failure
        }
    }

    /**
     * Get security & bot shield analytics summary.
     */
    public static function getShieldStats(): array
    {
        self::ensureTableExists();

        try {
            $today = Carbon::today();
            $thisWeek = Carbon::now()->startOfWeek();

            $totalBlocked = self::count();
            $todayBlocked = self::where('created_at', '>=', $today)->count();
            $weekBlocked = self::where('created_at', '>=', $thisWeek)->count();

            $byCategory = self::selectRaw('category, count(*) as count')
                ->groupBy('category')
                ->pluck('count', 'category')
                ->toArray();

            $recentBlocked = self::latest()->take(20)->get();

            $topBlockedIps = self::selectRaw('ip_address, count(*) as total, max(created_at) as last_seen')
                ->groupBy('ip_address')
                ->orderByDesc('total')
                ->take(8)
                ->get();

            return [
                'totalBlocked' => $totalBlocked,
                'todayBlocked' => $todayBlocked,
                'weekBlocked' => $weekBlocked,
                'scrapersBlocked' => ($byCategory['scraper'] ?? 0) + ($byCategory['bad_user_agent'] ?? 0),
                'exploitProbesBlocked' => $byCategory['exploit_probe'] ?? 0,
                'sqlInjectionBlocked' => $byCategory['sql_injection'] ?? 0,
                'xssBlocked' => $byCategory['xss_attack'] ?? 0,
                'honeypotTrapped' => $byCategory['honeypot'] ?? 0,
                'rateLimitBlocked' => $byCategory['rate_limit'] ?? 0,
                'recentBlocked' => $recentBlocked,
                'topBlockedIps' => $topBlockedIps,
            ];
        } catch (\Throwable $e) {
            return [
                'totalBlocked' => 0,
                'todayBlocked' => 0,
                'weekBlocked' => 0,
                'scrapersBlocked' => 0,
                'exploitProbesBlocked' => 0,
                'sqlInjectionBlocked' => 0,
                'xssBlocked' => 0,
                'honeypotTrapped' => 0,
                'rateLimitBlocked' => 0,
                'recentBlocked' => collect([]),
                'topBlockedIps' => collect([]),
            ];
        }
    }
}
