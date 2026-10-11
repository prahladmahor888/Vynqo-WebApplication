<?php

namespace App\Models;

use App\Services\GeoLocationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApkDownloadLog extends Model
{
    use HasFactory;

    protected $table = 'apk_download_logs';

    protected $fillable = [
        'release_id',
        'download_token',
        'ip_address',
        'country',
        'country_code',
        'city',
        'region',
        'device_type',
        'platform',
        'browser',
        'session_id',
        'user_agent',
        'status',
    ];

    /**
     * Get Country Flag Emoji (e.g. 🇮🇳, 🇺🇸, 💻).
     */
    public function getCountryFlagAttribute(): string
    {
        return GeoLocationService::getCountryFlag($this->country_code);
    }

    /**
     * Formatted location (e.g. "Mumbai, Maharashtra, India").
     */
    public function getLocationDisplayAttribute(): string
    {
        if (in_array($this->ip_address, ['127.0.0.1', '::1', 'localhost']) || $this->country === 'Localhost') {
            return 'Localhost / Dev';
        }

        $parts = [];
        if (!empty($this->city) && !in_array($this->city, ['Unknown', 'Local Server', ''])) {
            $parts[] = $this->city;
        }
        if (!empty($this->region) && !in_array($this->region, ['Unknown', 'Development', ''])) {
            $parts[] = $this->region;
        }
        if (!empty($this->country) && !in_array($this->country, ['Unknown', 'Localhost'])) {
            $parts[] = $this->country;
        }

        return !empty($parts) ? implode(', ', $parts) : ($this->country ?: 'India / Global');
    }

    /**
     * Associated App Release.
     */
    public function release()
    {
        return $this->belongsTo(AppRelease::class, 'release_id');
    }

    /**
     * Ensure table and columns exist dynamically in database.
     */
    public static function ensureTableExists(): void
    {
        try {
            if (!Schema::hasTable('apk_download_logs')) {
                Schema::create('apk_download_logs', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('release_id')->default(0);
                    $table->string('download_token', 64)->nullable();
                    $table->string('ip_address', 45)->nullable();
                    $table->string('country', 100)->nullable();
                    $table->string('country_code', 10)->nullable();
                    $table->string('city', 100)->nullable();
                    $table->string('region', 100)->nullable();
                    $table->string('device_type', 50)->nullable();
                    $table->string('platform', 100)->nullable();
                    $table->string('browser', 100)->nullable();
                    $table->string('session_id', 255)->nullable();
                    $table->text('user_agent')->nullable();
                    $table->string('status', 50)->default('counted');
                    $table->timestamps();

                    $table->index('release_id');
                    $table->index('download_token');
                    $table->index('ip_address');
                    $table->index('country');
                    $table->index('status');
                    $table->index('created_at');
                });
            } else {
                // Ensure new geo and device columns exist if table was previously created
                if (!Schema::hasColumn('apk_download_logs', 'country')) {
                    Schema::table('apk_download_logs', function (Blueprint $table) {
                        $table->string('country', 100)->nullable();
                        $table->string('country_code', 10)->nullable();
                        $table->string('city', 100)->nullable();
                        $table->string('region', 100)->nullable();
                        $table->string('device_type', 50)->nullable();
                        $table->string('platform', 100)->nullable();
                        $table->string('browser', 100)->nullable();
                    });
                }
            }
        } catch (\Throwable $e) {
            // Silently swallow schema errors
        }
    }

    /**
     * Atomically check database records inside a transaction.
     * Guarantees strictly +1 count per unique user download event.
     *
     * @param Request $request
     * @param AppRelease $release
     * @return bool True if this request was counted (+1), False if duplicate/ignored.
     */
    public static function attemptRecord(Request $request, AppRelease $release): bool
    {
        try {
            self::ensureTableExists();

            $releaseId = (int) $release->id;
            $exactIp = GeoLocationService::getExactIp($request);
            $sessionId = $request->hasSession() ? $request->session()->getId() : null;
            $rawToken = $request->query('dl_token');
            $cleanToken = !empty($rawToken) && is_string($rawToken)
                ? preg_replace('/[^a-zA-Z0-9_\-]/', '', substr($rawToken, 0, 64))
                : null;
            $userAgent = (string) $request->header('User-Agent', '');

            $deviceInfo = GeoLocationService::parseDeviceInfo($userAgent);
            $geo = GeoLocationService::resolveLocation($exactIp, $request);

            // Use Cache::lock on cache_locks table to guarantee atomic mutual exclusion across concurrent threads
            $lockKey = 'apk_download_lock_' . ($cleanToken ?: md5($exactIp . '_' . $releaseId));
            $lock = Cache::lock($lockKey, 15);

            try {
                return $lock->block(3, function () use (
                    $release,
                    $releaseId,
                    $exactIp,
                    $sessionId,
                    $cleanToken,
                    $userAgent,
                    $deviceInfo,
                    $geo
                ) {
                    return DB::transaction(function () use (
                        $release,
                        $releaseId,
                        $exactIp,
                        $sessionId,
                        $cleanToken,
                        $userAgent,
                        $deviceInfo,
                        $geo
                    ) {
                        // Base log data payload
                        $logPayload = [
                            'release_id' => $releaseId,
                            'download_token' => $cleanToken,
                            'ip_address' => $exactIp,
                            'country' => $geo['country'] ?? 'Unknown',
                            'country_code' => $geo['country_code'] ?? 'UN',
                            'city' => $geo['city'] ?? null,
                            'region' => $geo['region'] ?? null,
                            'device_type' => $deviceInfo['device'] ?? 'Mobile',
                            'platform' => $deviceInfo['platform'] ?? 'Android',
                            'browser' => $deviceInfo['browser'] ?? 'Browser',
                            'session_id' => $sessionId,
                            'user_agent' => substr($userAgent, 0, 1000),
                        ];

                        // 1. Database Check: Was this exact download token already recorded as counted?
                        if (!empty($cleanToken)) {
                            $tokenAlreadyCounted = self::where('download_token', $cleanToken)
                                ->where('status', 'counted')
                                ->exists();

                            if ($tokenAlreadyCounted) {
                                self::create(array_merge($logPayload, ['status' => 'duplicate_token']));
                                return false;
                            }
                        }

                        // 2. Database Check: Did this browser session recently record a download (10-minute window)?
                        if (!empty($sessionId)) {
                            $sessionRecentlyCounted = self::where('release_id', $releaseId)
                                ->where('session_id', $sessionId)
                                ->where('status', 'counted')
                                ->where('created_at', '>=', Carbon::now()->subMinutes(10))
                                ->exists();

                            if ($sessionRecentlyCounted) {
                                self::create(array_merge($logPayload, ['status' => 'duplicate_session']));
                                return false;
                            }
                        }

                        // 3. Database Check: Did this IP address download this release within the last 90 seconds?
                        // Catches mobile Chrome prompt handoffs to AndroidDownloadManager with different user-agents
                        $ipRecentlyCounted = self::where('release_id', $releaseId)
                            ->where('ip_address', $exactIp)
                            ->where('status', 'counted')
                            ->where('created_at', '>=', Carbon::now()->subSeconds(90))
                            ->exists();

                        if ($ipRecentlyCounted) {
                            self::create(array_merge($logPayload, ['status' => 'duplicate_ip_window']));
                            return false;
                        }

                        // 4. All checks passed: Save verified counted record in database
                        self::create(array_merge($logPayload, ['status' => 'counted']));

                        // Atomically increment the official release download counter in database
                        $release->recordDownload();

                        return true;
                    });
                });
            } catch (\Illuminate\Contracts\Cache\LockTimeoutException $e) {
                // Another thread was actively processing this exact download event
                return false;
            } finally {
                optional($lock)->release();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ApkDownloadLog error: ' . $e->getMessage());
            return false;
        }
    }
}
