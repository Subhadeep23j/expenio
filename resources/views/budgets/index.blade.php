@extends('layout.app')
@section('title', 'Budgets')
@section('page-title', 'Budgets')
@section('page-subtitle', 'Set and manage your monthly budgets')

@section('content')
    <div class="grid-2" style="margin-bottom:2rem;">
        <!-- Set Budget -->
        <div class="card">
            <div class="card-title" style="margin-bottom:1.25rem;">Set Monthly Budget</div>
            <form method="POST" action="{{ route('budgets.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-span-2">
                        <label for="amount" class="form-label">Budget Amount (₹)</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $budget->amount ?? '') }}" required step="0.01" min="1" placeholder="e.g. 30000" class="form-input">
                    </div>
                    <div>
                        <label for="month" class="form-label">Month</label>
                        <select name="month" id="month" class="form-input">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ (old('month', $month) == $m) ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="year" class="form-label">Year</label>
                        <select name="year" id="year" class="form-input">
                            @for ($y = $year - 1; $y <= $year + 1; $y++)
                                <option value="{{ $y }}" {{ (old('year', $year) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-span-2">
                        <button type="submit" class="btn-submit">Save Budget</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Current Month Status -->
        <div class="card">
            <div class="card-title" style="margin-bottom:1rem;">{{ $today->format('F Y') }} Status</div>
            @if ($budget)
                @php
                    $remaining = $budget->amount - $monthSpent;
                    $pct = $budget->amount > 0 ? min(100, ($monthSpent / $budget->amount) * 100) : 0;
                    $isOver = $remaining < 0;
                @endphp
                <div style="margin-bottom:1.5rem;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">
                        <span style="font-size:0.8rem; color:var(--muted);">Spent</span>
                        <span style="font-size:0.8rem; font-weight:500; color:var(--text);">₹{{ number_format($monthSpent, 2) }} / ₹{{ number_format($budget->amount, 2) }}</span>
                    </div>
                    <div style="height:8px; background:var(--bg); border-radius:99px; overflow:hidden;">
                        <div style="height:100%; width:{{ $pct }}%; border-radius:99px; background:{{ $isOver ? 'var(--danger)' : 'var(--accent)' }}; transition:width 0.3s;"></div>
                    </div>
                    <div style="margin-top:0.5rem; font-size:0.8rem; color:{{ $isOver ? 'var(--danger)' : 'var(--accent)' }}; font-weight:500;">
                        {{ $isOver ? 'Over budget by ₹' . number_format(abs($remaining), 2) : '₹' . number_format($remaining, 2) . ' remaining' }}
                    </div>
                </div>
                <div class="grid-2" style="gap:0.75rem;">
                    <div style="padding:0.75rem; background:var(--bg); border-radius:8px; text-align:center;">
                        <div class="card-label">Budget</div>
                        <div class="serif" style="font-size:1.2rem; font-weight:600; color:var(--text); margin-top:0.25rem;">₹{{ number_format($budget->amount, 2) }}</div>
                    </div>
                    <div style="padding:0.75rem; background:var(--bg); border-radius:8px; text-align:center;">
                        <div class="card-label">Spent</div>
                        <div class="serif" style="font-size:1.2rem; font-weight:600; color:var(--danger); margin-top:0.25rem;">₹{{ number_format($monthSpent, 2) }}</div>
                    </div>
                </div>
            @else
                <div class="empty-state" style="padding:2rem 0;">
                    <div style="font-size:0.95rem; font-weight:500; margin-bottom:0.35rem;">No budget set</div>
                    <div style="font-size:0.82rem;">Set a budget for this month using the form.</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Past Budgets -->
    <div class="card">
        <div class="card-title" style="margin-bottom:1.25rem;">Budget History</div>
        @forelse ($pastBudgets as $b)
            @php $bPct = $b->amount > 0 ? min(100, ($b->spent / $b->amount) * 100) : 0; $bOver = $b->spent > $b->amount; @endphp
            <div class="expense-row">
                <div class="expense-info">
                    <div class="expense-name">{{ \Carbon\Carbon::create($b->year, $b->month, 1)->format('F Y') }}</div>
                    <div style="font-size:0.72rem; color:var(--muted);">
                        ₹{{ number_format($b->spent, 2) }} of ₹{{ number_format($b->amount, 2) }}
                    </div>
                </div>
                <div style="width:80px; height:6px; background:var(--bg); border-radius:99px; overflow:hidden; margin-right:0.5rem;">
                    <div style="height:100%; width:{{ $bPct }}%; border-radius:99px; background:{{ $bOver ? 'var(--danger)' : 'var(--accent)' }};"></div>
                </div>
                <span class="badge" style="background:{{ $bOver ? 'rgba(184,58,36,0.1)' : 'rgba(61,107,79,0.1)' }}; color:{{ $bOver ? 'var(--danger)' : 'var(--accent)' }};">
                    {{ round($bPct) }}%
                </span>
            </div>
        @empty
            <div class="empty-state"><div style="font-size:0.82rem;">No budget history yet.</div></div>
        @endforelse
    </div>
@endsection
