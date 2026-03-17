<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();

        $monthExpenses = $user->expenses()->whereBetween('date', [$monthStart, $monthEnd])->sum('price');
        $monthIncome = $user->incomes()->whereBetween('date', [$monthStart, $monthEnd])->sum('amount');
        $monthSavings = $monthIncome - $monthExpenses;
        $expenseCount = $user->expenses()->whereBetween('date', [$monthStart, $monthEnd])->count();

        // Daily totals for chart
        $dailyTotals = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->selectRaw('date, SUM(price) as total')
            ->groupBy('date')->orderBy('date')
            ->pluck('total', 'date')->toArray();

        $chartLabels = [];
        $chartData = [];
        for ($d = 1; $d <= $today->daysInMonth; $d++) {
            $dateStr = $today->copy()->day($d)->toDateString();
            $chartLabels[] = $d;
            $chartData[] = (float) ($dailyTotals[$dateStr] ?? 0);
        }

        // Online vs offline breakdown
        $onlineTotal = $user->expenses()->whereBetween('date', [$monthStart, $monthEnd])->where('type', 'online')->sum('price');
        $offlineTotal = $user->expenses()->whereBetween('date', [$monthStart, $monthEnd])->where('type', 'offline')->sum('price');

        // Category breakdown
        $categoryBreakdown = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->whereNotNull('category_id')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, categories.color, SUM(expenses.price) as total')
            ->groupBy('categories.name', 'categories.color')
            ->orderByDesc('total')
            ->get();

        // Last 6 months trend
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = $today->copy()->subMonths($i);
            $s = $m->copy()->startOfMonth();
            $e = $m->copy()->endOfMonth();
            $monthlyTrend[] = [
                'label' => $m->format('M'),
                'total' => (float) $user->expenses()->whereBetween('date', [$s, $e])->sum('price'),
            ];
        }

        return view('reports.index', compact(
            'monthExpenses',
            'monthIncome',
            'monthSavings',
            'expenseCount',
            'chartLabels',
            'chartData',
            'onlineTotal',
            'offlineTotal',
            'categoryBreakdown',
            'monthlyTrend',
            'today'
        ));
    }

    public function exportPdf(Request $request)
    {
        $user = $request->user();
        $month = $request->input('month', Carbon::today()->month);
        $year = $request->input('year', Carbon::today()->year);

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $expenses = $user->expenses()
            ->whereBetween('date', [$start, $end])
            ->orderBy('date')->orderBy('created_at')
            ->get();

        $totalExpense = $expenses->sum('price');
        $totalIncome = $user->incomes()->whereBetween('date', [$start, $end])->sum('amount');
        $onlineTotal = $expenses->where('type', 'online')->sum('price');
        $offlineTotal = $expenses->where('type', 'offline')->sum('price');

        $grouped = $expenses->groupBy(fn($e) => $e->date->toDateString());

        $monthName = $start->format('F Y');

        $pdf = Pdf::loadView('reports.pdf', compact(
            'expenses',
            'grouped',
            'totalExpense',
            'totalIncome',
            'onlineTotal',
            'offlineTotal',
            'monthName',
            'user'
        ));

        return $pdf->download("expenio-report-{$start->format('Y-m')}.pdf");
    }
}
