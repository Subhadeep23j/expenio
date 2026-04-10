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

        $monthExpenses = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();

        $monthIncomes = $user->incomes()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();

        $monthTotal = (float) $monthExpenses
            ->sum(fn($expense) => (float) $expense->price);

        $monthIncome = (float) $monthIncomes
            ->sum(fn($income) => (float) $income->amount);

        $dailyExpense = (float) $monthExpenses
            ->filter(fn($expense) => $expense->date->isSameDay($today))
            ->sum(fn($expense) => (float) $expense->price);

        $dailyIncome = (float) $monthIncomes
            ->filter(fn($income) => $income->date->isSameDay($today))
            ->sum(fn($income) => (float) $income->amount);

        $dailySavings = $dailyIncome - $dailyExpense;

        $monthlySavings = $monthIncome - $monthTotal;

        $monthCount = $monthExpenses->count();

        $currentMonthBudget = $user->budgets()
            ->where('month', $today->month)
            ->where('year', $today->year)
            ->first();

        $hasBudget = !is_null($currentMonthBudget);
        $budgetAmount = $hasBudget ? (float) $currentMonthBudget->amount : 0.0;
        $remainingMoney = $hasBudget ? ($budgetAmount - $monthTotal) : null;

        $recentExpenses = $user->expenses()
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Daily totals for chart
        $dailyTotals = $monthExpenses
            ->groupBy(fn($expense) => $expense->date->toDateString())
            ->map(fn($dayExpenses) => (float) $dayExpenses->sum(fn($expense) => (float) $expense->price))
            ->toArray();

        $chartLabels = [];
        $chartData = [];
        for ($d = 1; $d <= $today->day; $d++) {
            $dateStr = $today->copy()->day($d)->toDateString();
            $chartLabels[] = $d;
            $chartData[] = (float) ($dailyTotals[$dateStr] ?? 0);
        }

        return view('dashboard', compact(
            'monthTotal',
            'monthIncome',
            'monthCount',
            'dailyIncome',
            'dailySavings',
            'monthlySavings',
            'hasBudget',
            'budgetAmount',
            'remainingMoney',
            'recentExpenses',
            'chartLabels',
            'chartData',
            'today'
        ));
    }
}
