@extends('layout.app')

@section('title', 'Expenses')
@section('page-title', 'Expenses')
@section('page-subtitle', 'Track and manage your daily spending')

@section('content')

    <!-- Add Expense + Summary Row -->
    <div class="grid-2" style="margin-bottom: 2rem;">

        <!-- Add Expense Form -->
        <div class="card">
            <div class="card-title" style="margin-bottom: 1.25rem;">Add Expense</div>

            <form method="POST" action="{{ route('expenses.store') }}">
                @csrf

                <div class="form-grid">
                    <!-- Product Name -->
                    <div class="form-span-2">
                        <label for="product_name" class="form-label">Product / Service Name</label>
                        <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}"
                            required placeholder="e.g. Coffee, Netflix, Groceries" class="form-input">
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="form-label">Amount (₹)</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" required
                            step="0.01" min="0.01" placeholder="0.00" class="form-input">
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" name="date"
                            value="{{ old('date', $today->toDateString()) }}" required max="{{ $today->toDateString() }}"
                            class="form-input">
                    </div>

                    <!-- Type Toggle -->
                    <div class="form-span-2">
                        <label class="form-label">Purchase Type</label>
                        <div class="type-toggle">
                            <label class="type-btn {{ old('type', 'offline') === 'offline' ? 'selected' : '' }}"
                                id="label-offline">
                                <input type="radio" name="type" value="offline"
                                    {{ old('type', 'offline') === 'offline' ? 'checked' : '' }} style="display: none;"
                                    onchange="document.getElementById('label-offline').classList.add('selected'); document.getElementById('label-online').classList.remove('selected');">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                                Offline
                            </label>
                            <label class="type-btn {{ old('type') === 'online' ? 'selected' : '' }}" id="label-online">
                                <input type="radio" name="type" value="online"
                                    {{ old('type') === 'online' ? 'checked' : '' }} style="display: none;"
                                    onchange="document.getElementById('label-online').classList.add('selected'); document.getElementById('label-offline').classList.remove('selected');">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="2" y1="12" x2="22" y2="12" />
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                </svg>
                                Online
                            </label>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="form-span-2">
                        <button type="submit" class="btn-submit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add Expense
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="flex-col-gap">
            <!-- Today's Total -->
            <div class="card" style="flex: 1;">
                <div class="card-label" style="margin-bottom: 0.5rem;">Today's Total</div>
                <div class="card-value">₹{{ number_format($todayTotal, 2) }}</div>
                <div class="card-sub">{{ $today->format('l, M d, Y') }}</div>
            </div>

            <!-- Monthly Total -->
            <div class="card" style="flex: 1;">
                <div class="card-label" style="margin-bottom: 0.5rem;">Monthly Total</div>
                <div class="card-value">₹{{ number_format($monthTotal, 2) }}</div>
                <div class="card-sub">{{ $today->format('F Y') }}</div>
            </div>
        </div>

    </div>

    <!-- Expense Chart -->
    <div class="card" style="margin-bottom: 2rem;">
        <div style="margin-bottom: 1rem;">
            <div class="card-title">Expense Graph</div>
            <div class="card-sub" style="margin-top: 0.15rem;">Daily spending for {{ $today->format('F Y') }}</div>
        </div>
        <div class="chart-wrap">
            <canvas id="expenseChart"></canvas>
        </div>
    </div>

    <!-- Monthly PDF Export -->
    <div class="card" style="margin-bottom: 2rem; text-align: center;">
        <div class="card-title" style="margin-bottom: 0.5rem;">Export Monthly Expenses</div>
        <div style="font-size: 0.82rem; color: var(--muted); margin-bottom: 1rem;">Download monthly expense details in PDF
            format</div>

        <form method="GET" action="{{ route('expenses.export-pdf') }}"
            style="display: inline-flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; justify-content: center;">
            <select name="month" class="form-input" style="width: auto;">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $today->month == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endfor
            </select>

            <select name="year" class="form-input" style="width: auto;">
                @for ($y = $today->year - 2; $y <= $today->year; $y++)
                    <option value="{{ $y }}" {{ $today->year == $y ? 'selected' : '' }}>{{ $y }}
                    </option>
                @endfor
            </select>

            <button type="submit" class="btn-submit" style="width: auto; padding: 0.6rem 1.4rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Download PDF
            </button>
        </form>
    </div>

    <!-- Expenses List -->
    <div class="card">
        <div class="card-title" style="margin-bottom: 1.25rem;">
            All Expenses — {{ $today->format('F Y') }}
        </div>

        @forelse ($expenses as $date => $dayExpenses)
            @php
                $dayTotal = $dayExpenses->sum('price');
                $dateObj = \Carbon\Carbon::parse($date);
            @endphp

            <!-- Date Header -->
            <div class="date-header" style="margin-top: {{ $loop->first ? '0' : '1rem' }};">
                <div class="date-label">
                    {{ $dateObj->format('l, M d') }}
                    @if ($dateObj->isToday())
                        <span class="badge badge-today">Today</span>
                    @endif
                </div>
                <div class="date-total">₹{{ number_format($dayTotal, 2) }}</div>
            </div>

            <!-- Day's Expenses -->
            @foreach ($dayExpenses as $expense)
                <div class="expense-row">
                    <div class="expense-icon"
                        style="background: {{ $expense->type === 'online' ? 'rgba(80,120,200,0.08)' : 'rgba(184,137,42,0.08)' }};">
                        @if ($expense->type === 'online')
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#5078c8"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path
                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                        @else
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--gold)"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                        @endif
                    </div>

                    <div class="expense-info">
                        <div class="expense-name">{{ $expense->product_name }}</div>
                        <div style="margin-top: 0.1rem;">
                            <span class="badge {{ $expense->type === 'online' ? 'badge-online' : 'badge-offline' }}">
                                {{ ucfirst($expense->type) }}
                            </span>
                        </div>
                    </div>

                    <div class="expense-amt" style="margin-right: 0.5rem;">₹{{ number_format($expense->price, 2) }}</div>

                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                        onsubmit="return confirm('Delete this expense?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete" class="del-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
                        </button>
                    </form>
                </div>
            @endforeach
        @empty
            <div class="empty-state">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--border)"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    style="margin: 0 auto 1rem; display: block;">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
                <div style="font-size: 0.95rem; font-weight: 500; margin-bottom: 0.35rem;">No expenses yet</div>
                <div style="font-size: 0.82rem;">Add your first expense using the form above.</div>
            </div>
        @endforelse

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        fetch('{{ route('expenses.chart-data') }}')
            .then(r => r.json())
            .then(res => {
                const ctx = document.getElementById('expenseChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 240);
                gradient.addColorStop(0, 'rgba(61, 107, 79, 0.7)');
                gradient.addColorStop(1, 'rgba(61, 107, 79, 0.1)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: res.labels,
                        datasets: [{
                            label: 'Daily Expense (₹)',
                            data: res.data,
                            backgroundColor: gradient,
                            borderColor: 'rgba(61, 107, 79, 0.9)',
                            borderWidth: 1,
                            borderRadius: 4,
                            maxBarThickness: 24,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1a1814',
                                titleColor: '#ede7d5',
                                bodyColor: '#ede7d5',
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    title: function(items) {
                                        return 'Day ' + items[0].label;
                                    },
                                    label: function(ctx) {
                                        return '₹' + ctx.parsed.y.toLocaleString('en-IN', {
                                            minimumFractionDigits: 2
                                        });
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#8c8070',
                                    font: {
                                        size: 11
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Day of Month',
                                    color: '#8c8070',
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.04)'
                                },
                                ticks: {
                                    color: '#8c8070',
                                    font: {
                                        size: 11
                                    },
                                    callback: function(val) {
                                        return '₹' + val.toLocaleString('en-IN');
                                    }
                                }
                            }
                        }
                    }
                });
            });
    </script>
@endpush
