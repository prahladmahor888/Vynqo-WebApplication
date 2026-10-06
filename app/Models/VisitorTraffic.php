<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VisitorTraffic extends Model
{
    use HasFactory;

    protected $table = 'visitor_traffic';

    protected $fillable = [
        'url',
        'path',
        'method',
        'ip_address',
        'country',
        'country_code',
        'city',
        'region',
        'device_type',
        'platform',
        'browser',
        'user_agent',
        'referer',
        'session_id',
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

        // Convert 2-letter ISO code to unicode flag emoji
        try {
            $flag = mb_chr(ord($code[0]) + 127397, 'UTF-8') . mb_chr(ord($code[1]) + 127397, 'UTF-8');
            return $flag;
        } catch (\Throwable $e) {
            return '📍';
        }
    }

    /**
     * Get formatted Place Name (e.g., "Mumbai, Maharashtra, India" or "Localhost / Dev Environment").
     */
    public function getLocationDisplayAttribute(): string
    {
        if (in_array($this->ip_address, ['127.0.0.1', '::1', 'localhost']) || $this->country === 'Localhost' || $this->country_code === 'DEV') {
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

        if (empty($parts)) {
            return 'India / Global';
        }

        return implode(', ', $parts);
    }

    /**
     * Alias for Place Name.
     */
    public function getPlaceNameAttribute(): string
    {
        return $this->location_display;
    }

    /**
     * Get analytics metrics summary.
     */
    public static function getStats(): array
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        $totalViews = self::count();
        $todayViews = self::where('created_at', '>=', $today)->count();
        $weekViews = self::where('created_at', '>=', $thisWeek)->count();
        $monthViews = self::where('created_at', '>=', $thisMonth)->count();

        $uniqueVisitors = self::distinct('ip_address')->count('ip_address');
        $todayUnique = self::where('created_at', '>=', $today)->distinct('ip_address')->count('ip_address');

        $topPages = self::selectRaw('path, count(*) as total_views')
            ->groupBy('path')
            ->orderByDesc('total_views')
            ->take(8)
            ->get();

        $devices = self::selectRaw('device_type, count(*) as total')
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        $platforms = self::selectRaw('platform, count(*) as total')
            ->whereNotNull('platform')
            ->groupBy('platform')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Top Countries / Places Breakdown
        $countries = self::selectRaw("COALESCE(country, 'Unknown') as country, COALESCE(country_code, 'UN') as country_code, count(*) as total")
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->take(6)
            ->get()
            ->map(function ($c) {
                $code = strtoupper((string)$c->country_code);
                $flag = '📍';
                if ($code === 'DEV' || $code === 'LOCAL' || $c->country === 'Localhost') {
                    $flag = '💻';
                    $c->country = 'Localhost (Dev)';
                } elseif (strlen($code) === 2 && $code !== 'UN') {
                    try {
                        $flag = mb_chr(ord($code[0]) + 127397, 'UTF-8') . mb_chr(ord($code[1]) + 127397, 'UTF-8');
                    } catch (\Throwable $e) {
                        $flag = '📍';
                    }
                } elseif ($c->country === 'Unknown') {
                    $c->country = 'India / Global';
                    $flag = '🇮🇳';
                }
                $c->flag = $flag;
                return $c;
            });

        // Top Cities Breakdown
        $cities = self::selectRaw("city, country, count(*) as total")
            ->whereNotNull('city')
            ->whereNotIn('city', ['Unknown', 'Local Server', ''])
            ->groupBy('city', 'country')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        $recentHits = self::latest()->take(15)->get();

        // Daily traffic trend for last 7 days
        $dailyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = self::whereDate('created_at', $date)->count();
            $dailyTrend[] = [
                'day' => $date->format('D, M d'),
                'short_day' => $date->format('D'),
                'count' => $count,
            ];
        }

        return compact(
            'totalViews',
            'todayViews',
            'weekViews',
            'monthViews',
            'uniqueVisitors',
            'todayUnique',
            'topPages',
            'devices',
            'platforms',
            'countries',
            'cities',
            'recentHits',
            'dailyTrend'
        );
    }
}
