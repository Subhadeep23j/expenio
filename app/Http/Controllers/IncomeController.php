<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();

        $incomes = $user->incomes()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->orderByDesc('date')->orderByDesc('created_at')
            ->get();

        $monthTotal = (float) $incomes->sum(fn($income) => (float) $income->amount);

        $allTimeTotal = (float) $user->incomes()
            ->get()
            ->sum(fn($income) => (float) $income->amount);

        return view('income.index', compact('incomes', 'monthTotal', 'allTimeTotal', 'today'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'source_name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999.99'],
            'date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $request->user()->incomes()->create($validated);

        return back()->with('success', 'Income added successfully.');
    }

    public function destroy(Request $request, Income $income)
    {
        if ($income->user_id !== $request->user()->id) {
            abort(403);
        }
        $income->delete();
        return back()->with('success', 'Income deleted.');
    }
}
