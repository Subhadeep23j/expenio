<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        $month = $today->month;
        $year = $today->year;

        $budget = $user->budgets()->where('month', $month)->where('year', $year)->first();
        $monthSpent = $user->expenses()
            ->whereBetween('date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])
            ->sum('price');

        $pastBudgets = $user->budgets()->orderByDesc('year')->orderByDesc('month')->limit(12)->get()
            ->map(function ($b) use ($user) {
                $start = Carbon::create($b->year, $b->month, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();
                $b->spent = $user->expenses()->whereBetween('date', [$start, $end])->sum('price');
                return $b;
            });

        return view('budgets.index', compact('budget', 'monthSpent', 'today', 'month', 'year', 'pastBudgets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:9999999.99'],
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'min:2020', 'max:2099'],
        ]);

        $request->user()->budgets()->updateOrCreate(
            ['month' => $validated['month'], 'year' => $validated['year']],
            ['amount' => $validated['amount']]
        );

        return back()->with('success', 'Budget saved.');
    }
}
