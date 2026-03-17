@extends('layout.app')
@section('title', 'Income')
@section('page-title', 'Income')
@section('page-subtitle', 'Track your income sources')

@section('content')
    <div class="grid-2" style="margin-bottom: 2rem;">
        <!-- Add Income Form -->
        <div class="card">
            <div class="card-title" style="margin-bottom: 1.25rem;">Add Income</div>
            <form method="POST" action="{{ route('income.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-span-2">
                        <label for="source_name" class="form-label">Source Name</label>
                        <input type="text" id="source_name" name="source_name" value="{{ old('source_name') }}" required placeholder="e.g. Salary, Freelance, Dividends" class="form-input">
                    </div>
                    <div>
                        <label for="amount" class="form-label">Amount (₹)</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount') }}" required step="0.01" min="0.01" placeholder="0.00" class="form-input">
                    </div>
                    <div>
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" name="date" value="{{ old('date', $today->toDateString()) }}" required max="{{ $today->toDateString() }}" class="form-input">
                    </div>
                    <div class="form-span-2">
                        <button type="submit" class="btn-submit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add Income
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary -->
        <div class="flex-col-gap">
            <div class="card" style="flex:1;">
                <div class="card-label" style="margin-bottom:0.5rem;">This Month</div>
                <div class="card-value">₹{{ number_format($monthTotal, 2) }}</div>
                <div class="card-sub">{{ $today->format('F Y') }}</div>
            </div>
            <div class="card" style="flex:1;">
                <div class="card-label" style="margin-bottom:0.5rem;">All Time Income</div>
                <div class="card-value">₹{{ number_format($allTimeTotal, 2) }}</div>
                <div class="card-sub">Total recorded</div>
            </div>
        </div>
    </div>

    <!-- Income List -->
    <div class="card">
        <div class="card-title" style="margin-bottom:1.25rem;">Income — {{ $today->format('F Y') }}</div>
        @forelse ($incomes as $income)
            <div class="expense-row">
                <div class="expense-icon" style="background:rgba(61,107,79,0.08);">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                </div>
                <div class="expense-info">
                    <div class="expense-name">{{ $income->source_name }}</div>
                    <div style="font-size:0.72rem; color:var(--muted); margin-top:0.1rem;">{{ $income->date->format('M d, Y') }}</div>
                </div>
                <div style="font-size:0.9rem; font-weight:500; color:var(--accent); white-space:nowrap; margin-right:0.5rem;">+₹{{ number_format($income->amount, 2) }}</div>
                <form method="POST" action="{{ route('income.destroy', $income) }}" onsubmit="return confirm('Delete this income?')">
                    @csrf @method('DELETE')
                    <button type="submit" title="Delete" class="del-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </form>
            </div>
        @empty
            <div class="empty-state">
                <div style="font-size:0.95rem; font-weight:500; margin-bottom:0.35rem;">No income recorded yet</div>
                <div style="font-size:0.82rem;">Add your first income entry using the form above.</div>
            </div>
        @endforelse
    </div>
@endsection
