<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();

        $todayTotal = $user->expenses()
            ->whereDate('date', $today)
            ->sum('price');

        $monthTotal = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->sum('price');

        $monthCount = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->count();

        $daysElapsed = $today->day;
        $dailyAverage = $daysElapsed > 0 ? $monthTotal / $daysElapsed : 0;

        $recentExpenses = $user->expenses()
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Daily totals for chart
        $dailyTotals = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->selectRaw('date, SUM(price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $chartLabels = [];
        $chartData = [];
        for ($d = 1; $d <= $today->day; $d++) {
            $dateStr = $today->copy()->day($d)->toDateString();
            $chartLabels[] = $d;
            $chartData[] = (float) ($dailyTotals[$dateStr] ?? 0);
        }

        return view('dashboard', compact(
            'todayTotal',
            'monthTotal',
            'monthCount',
            'dailyAverage',
            'recentExpenses',
            'chartLabels',
            'chartData',
            'today'
        ));
    }
}
