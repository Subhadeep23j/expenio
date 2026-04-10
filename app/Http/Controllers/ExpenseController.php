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

        $monthExpenses = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        $todayTotal = (float) $monthExpenses
            ->filter(fn($expense) => $expense->date->isSameDay($today))
            ->sum(fn($expense) => (float) $expense->price);

        $monthTotal = (float) $monthExpenses
            ->sum(fn($expense) => (float) $expense->price);

        $currentBudgetStatus = $this->monthBudgetStatus($user, $today);
        $budgetWarningMessage = $this->budgetWarningMessage($currentBudgetStatus);

        $expenses = $monthExpenses
            ->groupBy(fn($e) => $e->date->toDateString());

        return view('expenses.index', compact(
            'todayTotal',
            'monthTotal',
            'expenses',
            'today',
            'currentBudgetStatus',
            'budgetWarningMessage'
        ));
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

        $budgetWarningMessage = $this->budgetWarningMessage(
            $this->monthBudgetStatus($request->user(), Carbon::parse($validated['date']))
        );

        if ($request->boolean('save_next')) {
            $response = redirect()
                ->to(route('expenses.index') . '#single-expense-form')
                ->with('success', 'Expense saved. Add the next one.')
                ->with('next_expense_date', $validated['date'])
                ->with('next_expense_type', $validated['type'])
                ->with('focus_next_expense', true);

            if ($budgetWarningMessage) {
                $response->with('warning', $budgetWarningMessage);
            }

            return $response;
        }

        $response = back()->with('success', 'Expense added successfully.');

        if ($budgetWarningMessage) {
            $response->with('warning', $budgetWarningMessage);
        }

        return $response;
    }

    public function storeBulk(Request $request)
    {
        $rows = collect($request->input('expenses', []))
            ->map(fn($row) => is_array($row) ? $row : [])
            ->filter(function ($row) {
                return filled($row['product_name'] ?? null)
                    || filled($row['price'] ?? null)
                    || filled($row['date'] ?? null)
                    || filled($row['type'] ?? null);
            })
            ->values()
            ->all();

        $request->merge(['expenses' => $rows]);

        $validated = $request->validate([
            'expenses' => ['required', 'array', 'min:1', 'max:100'],
            'expenses.*.product_name' => ['required', 'string', 'max:255'],
            'expenses.*.price' => ['required', 'numeric', 'min:0.01', 'max:9999999.99'],
            'expenses.*.type' => ['required', 'in:online,offline'],
            'expenses.*.date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $request->user()->expenses()->createMany($validated['expenses']);

        $count = count($validated['expenses']);

        $warnings = collect($validated['expenses'])
            ->map(fn($row) => Carbon::parse($row['date'])->startOfMonth()->format('Y-m'))
            ->unique()
            ->map(function ($monthKey) use ($request) {
                $monthDate = Carbon::createFromFormat('Y-m', $monthKey)->startOfMonth();

                return $this->budgetWarningMessage(
                    $this->monthBudgetStatus($request->user(), $monthDate)
                );
            })
            ->filter()
            ->values();

        $response = back()->with('success', $count . ' expense' . ($count === 1 ? '' : 's') . ' added successfully.');

        if ($warnings->isNotEmpty()) {
            $response->with('warning', $warnings->implode(' '));
        }

        return $response;
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

        $monthExpenses = $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();

        $dailyTotals = $monthExpenses
            ->groupBy(fn($expense) => $expense->date->toDateString())
            ->map(fn($dayExpenses) => (float) $dayExpenses->sum(fn($expense) => (float) $expense->price))
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
        $monthTotal = (float) $expenses->sum(fn($expense) => (float) $expense->price);
        $monthLabel = $monthStart->format('F Y');

        $pdf = Pdf::loadView('expenses.pdf', [
            'expenses' => $expenses,
            'groupedExpenses' => $groupedExpenses,
            'monthTotal' => $monthTotal,
            'monthLabel' => $monthLabel,
        ]);

        return $pdf->download('monthly-expenses-' . $monthStart->format('Y-m') . '.pdf');
    }

    protected function monthBudgetStatus($user, Carbon $date): ?array
    {
        $month = $date->month;
        $year = $date->year;

        $budget = $user->budgets()
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$budget) {
            return null;
        }

        $monthStart = $date->copy()->startOfMonth();
        $monthEnd = $date->copy()->endOfMonth();

        $spent = (float) $user->expenses()
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get()
            ->sum(fn($expense) => (float) $expense->price);

        $budgetAmount = (float) $budget->amount;

        if ($budgetAmount <= 0) {
            return null;
        }

        $remaining = $budgetAmount - $spent;
        $usagePercent = ($spent / $budgetAmount) * 100;

        return [
            'label' => $monthStart->format('F Y'),
            'spent' => $spent,
            'budget' => $budgetAmount,
            'remaining' => $remaining,
            'usage_percent' => $usagePercent,
        ];
    }

    protected function budgetWarningMessage(?array $status): ?string
    {
        if (!$status || $status['usage_percent'] < 90) {
            return null;
        }

        $usageText = number_format($status['usage_percent'], 1);

        if ($status['usage_percent'] >= 100) {
            return 'Budget warning for ' . $status['label'] . ': You have used ' . $usageText
                . '% and exceeded budget by Rs. ' . number_format(abs($status['remaining']), 2) . '.';
        }

        return 'Budget warning for ' . $status['label'] . ': You have used ' . $usageText
            . '% of your budget. Remaining Rs. ' . number_format($status['remaining'], 2) . '.';
    }
}
