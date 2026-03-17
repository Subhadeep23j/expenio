<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
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

        $expenses = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn($e) => $e->date->toDateString());

        return view('expenses.index', compact('todayTotal', 'monthTotal', 'expenses', 'today'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:9999999.99'],
            'type' => ['required', 'in:online,offline'],
            'date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $request->user()->expenses()->create($validated);

        return back()->with('success', 'Expense added successfully.');
    }

    public function destroy(Request $request, Expense $expense)
    {
        if ($expense->user_id !== $request->user()->id) {
            abort(403);
        }

        $expense->delete();

        return back()->with('success', 'Expense deleted.');
    }

    public function chartData(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();

        $dailyTotals = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->selectRaw('date, SUM(price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $labels = [];
        $data = [];
        $daysInMonth = $today->daysInMonth;

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateStr = $today->copy()->day($d)->toDateString();
            $labels[] = $d;
            $data[] = (float) ($dailyTotals[$dateStr] ?? 0);
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'month' => $today->format('F Y'),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $validated = $request->validate([
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'min:2000', 'max:' . Carbon::today()->year],
        ]);

        $today = Carbon::today();
        $month = $validated['month'] ?? $today->month;
        $year = $validated['year'] ?? $today->year;

        $monthStart = Carbon::create($year, $month, 1)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        $expenses = $request->user()->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->orderBy('date')
            ->orderBy('created_at')
            ->get();

        $groupedExpenses = $expenses->groupBy(fn($expense) => $expense->date->toDateString());
        $monthTotal = $expenses->sum('price');
        $monthLabel = $monthStart->format('F Y');

        $pdf = Pdf::loadView('expenses.pdf', [
            'expenses' => $expenses,
            'groupedExpenses' => $groupedExpenses,
            'monthTotal' => $monthTotal,
            'monthLabel' => $monthLabel,
        ]);

        return $pdf->download('monthly-expenses-' . $monthStart->format('Y-m') . '.pdf');
    }
}
