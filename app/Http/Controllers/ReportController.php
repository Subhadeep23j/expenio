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

        $monthExpenseRows = $user->expenses()
            ->with('category')
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();

        $monthIncomeRows = $user->incomes()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();

        $monthExpenses = (float) $monthExpenseRows->sum(fn($expense) => (float) $expense->price);
        $monthIncome = (float) $monthIncomeRows->sum(fn($income) => (float) $income->amount);
        $monthSavings = $monthIncome - $monthExpenses;
        $expenseCount = $monthExpenseRows->count();

        // Daily totals for chart
        $dailyTotals = $monthExpenseRows
            ->groupBy(fn($expense) => $expense->date->toDateString())
            ->map(fn($dayExpenses) => (float) $dayExpenses->sum(fn($expense) => (float) $expense->price))
            ->toArray();

        $chartLabels = [];
        $chartData = [];
        for ($d = 1; $d <= $today->daysInMonth; $d++) {
            $dateStr = $today->copy()->day($d)->toDateString();
            $chartLabels[] = $d;
            $chartData[] = (float) ($dailyTotals[$dateStr] ?? 0);
        }

        // Online vs offline breakdown
        $onlineTotal = (float) $monthExpenseRows
            ->where('type', 'online')
            ->sum(fn($expense) => (float) $expense->price);

        $offlineTotal = (float) $monthExpenseRows
            ->where('type', 'offline')
            ->sum(fn($expense) => (float) $expense->price);

        // Category breakdown
        $categoryBreakdown = $monthExpenseRows
            ->filter(fn($expense) => !is_null($expense->category_id))
            ->groupBy('category_id')
            ->map(function ($categoryExpenses) {
                $category = $categoryExpenses->first()->category;

                return (object) [
                    'name' => $category?->name ?? 'Uncategorized',
                    'color' => $category?->color ?? '#8c8070',
                    'total' => (float) $categoryExpenses->sum(fn($expense) => (float) $expense->price),
                ];
            })
            ->sortByDesc('total')
            ->values();

        // Last 6 months trend
        $trendStart = $today->copy()->startOfMonth()->subMonths(5);
        $trendRows = $user->expenses()
            ->whereBetween('date', [$trendStart, $monthEnd])
            ->get();

        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = $today->copy()->subMonths($i);
            $s = $m->copy()->startOfMonth();
            $e = $m->copy()->endOfMonth();

            $monthTrendTotal = (float) $trendRows
                ->filter(fn($expense) => $expense->date->between($s, $e))
                ->sum(fn($expense) => (float) $expense->price);

            $monthlyTrend[] = [
                'label' => $m->format('M'),
                'total' => $monthTrendTotal,
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

        $totalExpense = (float) $expenses->sum(fn($expense) => (float) $expense->price);
        $totalIncome = (float) $user->incomes()
            ->whereBetween('date', [$start, $end])
            ->get()
            ->sum(fn($income) => (float) $income->amount);
        $onlineTotal = (float) $expenses->where('type', 'online')->sum(fn($expense) => (float) $expense->price);
        $offlineTotal = (float) $expenses->where('type', 'offline')->sum(fn($expense) => (float) $expense->price);

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

    public function exportExcel(Request $request)
    {
        $user = $request->user();
        $month = (int) $request->input('month', Carbon::today()->month);
        $year = (int) $request->input('year', Carbon::today()->year);

        $month = max(1, min(12, $month));
        $currentYear = Carbon::today()->year;
        if ($year < $currentYear - 10 || $year > $currentYear + 1) {
            $year = $currentYear;
        }

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $expenses = $user->expenses()
            ->with('category')
            ->whereBetween('date', [$start, $end])
            ->orderBy('date')->orderBy('created_at')
            ->get();

        $totalExpense = (float) $expenses->sum(fn($expense) => (float) $expense->price);
        $totalIncome = (float) $user->incomes()
            ->whereBetween('date', [$start, $end])
            ->get()
            ->sum(fn($income) => (float) $income->amount);
        $netSavings = $totalIncome - $totalExpense;

        $fileName = "expenio-report-{$start->format('Y-m')}.csv";

        return response()->streamDownload(function () use (
            $expenses,
            $totalExpense,
            $totalIncome,
            $netSavings,
            $start,
            $user
        ) {
            $output = fopen('php://output', 'w');

            // UTF-8 BOM helps Excel open CSV with correct encoding.
            fwrite($output, "\xEF\xBB\xBF");

            fputcsv($output, ['Expenio Monthly Report']);
            fputcsv($output, ['Month', $start->format('F Y')]);
            fputcsv($output, ['User', $user->name]);
            fputcsv($output, ['Email', $user->email]);
            fputcsv($output, []);

            fputcsv($output, ['Summary']);
            fputcsv($output, ['Total Expenses', number_format($totalExpense, 2, '.', '')]);
            fputcsv($output, ['Total Income', number_format($totalIncome, 2, '.', '')]);
            fputcsv($output, ['Net Savings', number_format($netSavings, 2, '.', '')]);
            fputcsv($output, ['Transactions', $expenses->count()]);
            fputcsv($output, []);

            fputcsv($output, ['#', 'Date', 'Product', 'Category', 'Type', 'Amount']);

            foreach ($expenses as $index => $expense) {
                fputcsv($output, [
                    $index + 1,
                    $expense->date->format('Y-m-d'),
                    $expense->product_name,
                    optional($expense->category)->name ?? 'Uncategorized',
                    ucfirst($expense->type),
                    number_format((float) $expense->price, 2, '.', ''),
                ]);
            }

            fclose($output);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
