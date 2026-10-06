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
        'device_type',
        'platform',
        'browser',
        'user_agent',
        'referer',
        'session_id',
    ];

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
            'recentHits',
            'dailyTrend'
        );
    }
}
