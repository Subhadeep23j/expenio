@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Your financial overview for ' . $today->format('F Y'))

@section('content')

    <!-- Summary Cards -->
    <div class="grid-4" style="margin-bottom: 2rem;">

        <div class="card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                <span class="card-label">Today's Spend</span>
                <div class="card-icon" style="background: rgba(61,107,79,0.08);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
            </div>
            <div class="card-value">₹{{ number_format($todayTotal, 2) }}</div>
        </div>

        <div class="card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                <span class="card-label">This Month</span>
                <div class="card-icon" style="background: rgba(184,137,42,0.08);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
            </div>
            <div class="card-value">₹{{ number_format($monthTotal, 2) }}</div>
        </div>

        <div class="card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                <span class="card-label">Transactions</span>
                <div class="card-icon" style="background: rgba(192,90,66,0.08);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>
            <div class="card-value">{{ $monthCount }}</div>
        </div>

        <div class="card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                <span class="card-label">Daily Average</span>
                <div class="card-icon" style="background: rgba(80,120,200,0.08);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#5078c8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                </div>
            </div>
            <div class="card-value">₹{{ number_format($dailyAverage, 2) }}</div>
        </div>

    </div>

    <!-- Chart + Recent Expenses -->
    <div class="grid-chart">

        <!-- Monthly Chart -->
        <div class="card">
            <div style="margin-bottom: 1.25rem;">
                <div class="card-title">Monthly Expenses</div>
                <div class="card-sub" style="margin-top: 0.15rem;">Daily breakdown for {{ $today->format('F Y') }}</div>
            </div>
            <div class="chart-wrap">
                <canvas id="expenseChart"></canvas>
            </div>
        </div>

        <!-- Recent Expenses -->
        <div class="card">
            <div class="card-title" style="margin-bottom: 1rem;">Recent Expenses</div>

            @forelse ($recentExpenses as $expense)
                <div class="tx-row">
                    <div class="tx-icon" style="background: {{ $expense->type === 'online' ? 'rgba(80,120,200,0.08)' : 'rgba(184,137,42,0.08)' }};">
                        @if ($expense->type === 'online')
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5078c8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                        @else
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        @endif
                    </div>
                    <div class="expense-info">
                        <div class="tx-name">{{ $expense->product_name }}</div>
                        <div class="tx-date">
                            {{ $expense->date->format('M d') }}
                            <span class="badge {{ $expense->type === 'online' ? 'badge-online' : 'badge-offline' }}" style="margin-left: 0.25rem;">
                                {{ $expense->type }}
                            </span>
                        </div>
                    </div>
                    <div class="tx-amt" style="color: var(--danger);">-₹{{ number_format($expense->price, 2) }}</div>
                </div>
            @empty
                <div class="empty-state" style="padding: 2rem 0; font-size: 0.875rem;">
                    No expenses yet. <a href="{{ route('expenses.index') }}" style="color: var(--accent); text-decoration: none;">Add your first expense</a>
                </div>
            @endforelse

            @if ($recentExpenses->count() > 0)
                <div style="text-align: center; margin-top: 1rem;">
                    <a href="{{ route('expenses.index') }}" style="font-size: 0.82rem; color: var(--accent); text-decoration: none;">
                        View all expenses →
                    </a>
                </div>
            @endif
        </div>

    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Daily Expense (₹)',
                data: @json($chartData),
                backgroundColor: 'rgba(61, 107, 79, 0.6)',
                borderColor: 'rgba(61, 107, 79, 1)',
                borderWidth: 1,
                borderRadius: 4,
                maxBarThickness: 28,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1814',
                    titleColor: '#ede7d5',
                    bodyColor: '#ede7d5',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(ctx) {
                            return '₹' + ctx.parsed.y.toLocaleString('en-IN', { minimumFractionDigits: 2 });
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#8c8070', font: { size: 11 } },
                    title: { display: true, text: 'Day of Month', color: '#8c8070', font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        color: '#8c8070', font: { size: 11 },
                        callback: function(val) { return '₹' + val.toLocaleString('en-IN'); }
                    }
                }
            }
        }
    });
</script>
@endpush
