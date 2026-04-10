@extends('layout.app')

@section('title', 'Expenses')
@section('page-title', 'Expenses')
@section('page-subtitle', 'Track and manage your daily spending')

@push('styles')
    <style>
        .bulk-card {
            background: linear-gradient(180deg, #ffffff 0%, #fbf9f5 100%);
        }

        .bulk-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.35rem;
        }

        .bulk-count-pill {
            font-size: 0.7rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--accent);
            background: rgba(61, 107, 79, 0.12);
            border: 1px solid rgba(61, 107, 79, 0.26);
            border-radius: 999px;
            padding: 0.28rem 0.65rem;
            white-space: nowrap;
        }

        .bulk-tip {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .bulk-toolbar {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .bulk-toolbar .btn-submit {
            width: auto;
            padding: 0.58rem 1rem;
        }

        .bulk-btn-outline {
            background: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
        }

        .bulk-btn-outline:hover {
            background: rgba(61, 107, 79, 0.08);
        }

        .bulk-btn-muted {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .bulk-btn-muted:hover {
            background: rgba(0, 0, 0, 0.03);
            color: var(--text);
        }

        .bulk-toolbar .btn-submit:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .bulk-rows {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }

        .bulk-row {
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
            padding: 0.95rem;
        }

        .bulk-row-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.6rem;
            margin-bottom: 0.7rem;
        }

        .bulk-row-label {
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .bulk-row-actions {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .bulk-icon-btn {
            width: 28px;
            height: 28px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: var(--muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .bulk-icon-btn:hover {
            color: var(--text);
            border-color: #cfc7bc;
            background: #f9f6f1;
        }

        .bulk-icon-btn-danger:hover {
            color: var(--danger);
            border-color: rgba(184, 58, 36, 0.35);
            background: rgba(184, 58, 36, 0.08);
        }

        .bulk-icon-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .bulk-row-grid {
            display: grid;
            gap: 0.75rem;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            align-items: end;
        }

        .bulk-submit-wrap {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.55rem;
            flex-wrap: wrap;
            padding: 0.45rem 0.25rem 0.15rem;
        }

        .bulk-submit-wrap .btn-submit {
            width: auto;
            padding: 0.62rem 1.35rem;
        }

        .budget-warning-box {
            border: 1px solid rgba(224, 168, 48, 0.45);
            background: #fef8ea;
            color: #6a4a08;
            border-radius: 10px;
            padding: 0.75rem 0.9rem;
            margin-bottom: 1rem;
        }

        .budget-warning-title {
            font-size: 0.74rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .budget-warning-text {
            font-size: 0.82rem;
            line-height: 1.45;
        }

        @media (max-width: 1024px) {
            .bulk-row-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .bulk-head {
                flex-direction: column;
            }

            .bulk-toolbar {
                display: grid;
                grid-template-columns: 1fr;
            }

            .bulk-toolbar .btn-submit {
                width: 100%;
                justify-content: center;
            }

            .bulk-row-grid {
                grid-template-columns: 1fr;
            }

            .bulk-submit-wrap {
                justify-content: stretch;
                padding: 0.2rem 0 0;
            }

            .bulk-submit-wrap .btn-submit {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')

    @if (session('success'))
        <div class="flash flash-success" style="margin-bottom: 1rem;">
            ✓ &nbsp;{{ session('success') }}
        </div>
    @endif

    <!-- Add Expense + Summary Row -->
    <div class="grid-2" style="margin-bottom: 2rem;">

        <!-- Add Expense Form -->
        <div class="card" id="single-expense-form">
            <div class="card-title" style="margin-bottom: 1.25rem;">Add Expense</div>

            @if (!empty($budgetWarningMessage))
                <div class="budget-warning-box">
                    <div class="budget-warning-title">Budget Alert</div>
                    <div class="budget-warning-text">{{ $budgetWarningMessage }}</div>
                </div>
            @endif

            @php
                $singleDefaultType = old('type', session('next_expense_type', 'offline'));
                $singleDefaultDate = old('date', session('next_expense_date', $today->toDateString()));
            @endphp

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
                        <input type="date" id="date" name="date" value="{{ $singleDefaultDate }}" required
                            max="{{ $today->toDateString() }}" class="form-input">
                    </div>

                    <!-- Type Toggle -->
                    <div class="form-span-2">
                        <label class="form-label">Purchase Type</label>
                        <div class="type-toggle">
                            <label class="type-btn {{ $singleDefaultType === 'offline' ? 'selected' : '' }}"
                                id="label-offline">
                                <input type="radio" name="type" value="offline"
                                    {{ $singleDefaultType === 'offline' ? 'checked' : '' }} style="display: none;"
                                    onchange="document.getElementById('label-offline').classList.add('selected'); document.getElementById('label-online').classList.remove('selected');">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                                Offline
                            </label>
                            <label class="type-btn {{ $singleDefaultType === 'online' ? 'selected' : '' }}"
                                id="label-online">
                                <input type="radio" name="type" value="online"
                                    {{ $singleDefaultType === 'online' ? 'checked' : '' }} style="display: none;"
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
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem;">
                            <button type="submit" class="btn-submit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Add Expense
                            </button>

                            <button type="submit" class="btn-submit" name="save_next" value="1"
                                style="background: transparent; color: var(--accent); border: 1px solid var(--accent);">
                                Save &amp; Next
                            </button>
                        </div>
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

    @php
        $hasBulkExpenseRoute = \Illuminate\Support\Facades\Route::has('expenses.store-bulk');
    @endphp

    <!-- Bulk Add Expense -->
    @if ($hasBulkExpenseRoute)
        <div class="card bulk-card" style="margin-bottom: 2rem;">
            <div class="bulk-head">
                <div>
                    <div class="card-title" style="margin-bottom: 0.35rem;">Bulk Add Expenses</div>
                    <div class="card-sub">Add many expenses quickly in one submission.</div>
                </div>
                <div class="bulk-count-pill" id="bulk-row-count">0 rows</div>
            </div>

            <div class="bulk-tip">Tip: Use <strong>Duplicate</strong> when entries are similar, then adjust only amount or
                name.</div>

            @php
                $oldBulkRows = old('expenses');
                $bulkRows =
                    is_array($oldBulkRows) && count($oldBulkRows) > 0
                        ? $oldBulkRows
                        : [
                            [
                                'product_name' => '',
                                'price' => '',
                                'date' => $today->toDateString(),
                                'type' => 'offline',
                            ],
                        ];
            @endphp

            <form method="POST" action="{{ route('expenses.store-bulk') }}" id="bulk-expense-form">
                @csrf

                {{-- <div class="bulk-toolbar">
                <button type="button" class="btn-submit bulk-btn-outline" id="add-bulk-row">
                    + Add Row
                </button>
                <button type="button" class="btn-submit bulk-btn-outline" id="duplicate-last-row">
                    Duplicate Last Row
                </button>
                <button type="button" class="btn-submit bulk-btn-muted" id="clear-bulk-rows">
                    Clear All
                </button>
            </div> --}}

                <div id="bulk-expense-rows" class="bulk-rows">
                    @foreach ($bulkRows as $index => $bulkExpense)
                        <div data-row class="bulk-row">
                            <div class="bulk-row-head">
                                <div data-row-label class="bulk-row-label">
                                    Row {{ $loop->iteration }}
                                </div>

                                <div class="bulk-row-actions">
                                    <button type="button" title="Duplicate row" class="bulk-icon-btn"
                                        data-duplicate-row>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2"
                                                ry="2" />
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                        </svg>
                                    </button>

                                    <button type="button" title="Remove row" class="bulk-icon-btn bulk-icon-btn-danger"
                                        data-remove-row>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="bulk-row-grid">
                                <div>
                                    <label class="form-label" data-field-label="product_name"
                                        for="bulk_product_name_{{ $index }}">Product / Service Name</label>
                                    <input type="text" class="form-input" data-field="product_name"
                                        id="bulk_product_name_{{ $index }}"
                                        name="expenses[{{ $index }}][product_name]"
                                        value="{{ $bulkExpense['product_name'] ?? '' }}" required
                                        placeholder="e.g. Coffee, Cab Fare, Snacks">
                                </div>

                                <div>
                                    <label class="form-label" data-field-label="price"
                                        for="bulk_price_{{ $index }}">Amount (₹)</label>
                                    <input type="number" class="form-input" data-field="price"
                                        id="bulk_price_{{ $index }}" name="expenses[{{ $index }}][price]"
                                        value="{{ $bulkExpense['price'] ?? '' }}" required step="0.01" min="0.01"
                                        placeholder="0.00">
                                </div>

                                <div>
                                    <label class="form-label" data-field-label="date"
                                        for="bulk_date_{{ $index }}">Date</label>
                                    <input type="date" class="form-input" data-field="date"
                                        id="bulk_date_{{ $index }}" name="expenses[{{ $index }}][date]"
                                        value="{{ $bulkExpense['date'] ?? $today->toDateString() }}" required
                                        max="{{ $today->toDateString() }}">
                                </div>

                                <div>
                                    <label class="form-label" data-field-label="type"
                                        for="bulk_type_{{ $index }}">Purchase Type</label>
                                    <select class="form-input" data-field="type" id="bulk_type_{{ $index }}"
                                        name="expenses[{{ $index }}][type]" required>
                                        <option value="offline"
                                            {{ ($bulkExpense['type'] ?? 'offline') === 'offline' ? 'selected' : '' }}>
                                            Offline
                                        </option>
                                        <option value="online"
                                            {{ ($bulkExpense['type'] ?? 'offline') === 'online' ? 'selected' : '' }}>Online
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bulk-submit-wrap">
                    <button type="button" class="btn-submit bulk-btn-outline" id="add-bulk-row">
                        + Add Row
                    </button>
                    <button type="button" class="btn-submit bulk-btn-outline" id="duplicate-last-row">
                        Duplicate Last Row
                    </button>
                    <button type="button" class="btn-submit bulk-btn-muted" id="clear-bulk-rows">
                        Clear All
                    </button>
                    <button type="submit" class="btn-submit">
                        Save Bulk Expenses
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-title" style="margin-bottom: 0.35rem;">Bulk Add Expenses</div>
            <div class="card-sub">Bulk add is temporarily unavailable while server routes are updating.</div>
        </div>
    @endif

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
        document.addEventListener('DOMContentLoaded', function() {
            const rowsContainer = document.getElementById('bulk-expense-rows');
            const addRowButton = document.getElementById('add-bulk-row');
            const duplicateLastButton = document.getElementById('duplicate-last-row');
            const clearRowsButton = document.getElementById('clear-bulk-rows');
            const rowCountPill = document.getElementById('bulk-row-count');
            const maxRows = 100;

            if (!rowsContainer || !addRowButton || !duplicateLastButton || !clearRowsButton) {
                return;
            }

            const defaultDate = @json($today->toDateString());

            const rowTemplate = (index) => `
                <div data-row class="bulk-row">
                    <div class="bulk-row-head">
                        <div data-row-label class="bulk-row-label">Row ${index + 1}</div>
                        <div class="bulk-row-actions">
                            <button type="button" title="Duplicate row" class="bulk-icon-btn" data-duplicate-row>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                </svg>
                            </button>

                            <button type="button" title="Remove row" class="bulk-icon-btn bulk-icon-btn-danger" data-remove-row>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="bulk-row-grid">
                        <div>
                            <label class="form-label" data-field-label="product_name" for="bulk_product_name_${index}">Product / Service Name</label>
                            <input type="text" class="form-input" data-field="product_name" id="bulk_product_name_${index}" name="expenses[${index}][product_name]" required placeholder="e.g. Coffee, Cab Fare, Snacks">
                        </div>

                        <div>
                            <label class="form-label" data-field-label="price" for="bulk_price_${index}">Amount (₹)</label>
                            <input type="number" class="form-input" data-field="price" id="bulk_price_${index}" name="expenses[${index}][price]" required step="0.01" min="0.01" placeholder="0.00">
                        </div>

                        <div>
                            <label class="form-label" data-field-label="date" for="bulk_date_${index}">Date</label>
                            <input type="date" class="form-input" data-field="date" id="bulk_date_${index}" name="expenses[${index}][date]" value="${defaultDate}" required max="${defaultDate}">
                        </div>

                        <div>
                            <label class="form-label" data-field-label="type" for="bulk_type_${index}">Purchase Type</label>
                            <select class="form-input" data-field="type" id="bulk_type_${index}" name="expenses[${index}][type]" required>
                                <option value="offline" selected>Offline</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;

            const readRowValues = (row) => {
                const product = row.querySelector('[data-field="product_name"]');
                const price = row.querySelector('[data-field="price"]');
                const date = row.querySelector('[data-field="date"]');
                const type = row.querySelector('[data-field="type"]');

                return {
                    product_name: product ? product.value : '',
                    price: price ? price.value : '',
                    date: date ? date.value : defaultDate,
                    type: type ? type.value : 'offline',
                };
            };

            const setRowValues = (row, values = {}) => {
                const defaults = {
                    product_name: '',
                    price: '',
                    date: defaultDate,
                    type: 'offline',
                };

                const merged = {
                    ...defaults,
                    ...values,
                };

                const product = row.querySelector('[data-field="product_name"]');
                const price = row.querySelector('[data-field="price"]');
                const date = row.querySelector('[data-field="date"]');
                const type = row.querySelector('[data-field="type"]');

                if (product) {
                    product.value = merged.product_name;
                }
                if (price) {
                    price.value = merged.price;
                }
                if (date) {
                    date.value = merged.date || defaultDate;
                }
                if (type) {
                    type.value = merged.type || 'offline';
                }
            };

            const updateRowCount = (count) => {
                if (!rowCountPill) {
                    return;
                }

                rowCountPill.textContent = count + ' row' + (count === 1 ? '' : 's') + (count >= maxRows ?
                    ' (max)' : '');
            };

            const appendRow = (values = null) => {
                const currentCount = rowsContainer.querySelectorAll('[data-row]').length;
                if (currentCount >= maxRows) {
                    return null;
                }

                rowsContainer.insertAdjacentHTML('beforeend', rowTemplate(currentCount));
                const rows = rowsContainer.querySelectorAll('[data-row]');
                const insertedRow = rows[rows.length - 1];

                if (values) {
                    setRowValues(insertedRow, values);
                }

                reindexRows();
                return insertedRow;
            };

            const reindexRows = () => {
                const rows = rowsContainer.querySelectorAll('[data-row]');
                const isMaxed = rows.length >= maxRows;

                addRowButton.disabled = isMaxed;
                duplicateLastButton.disabled = isMaxed || rows.length === 0;

                rows.forEach((row, index) => {
                    const rowLabel = row.querySelector('[data-row-label]');
                    if (rowLabel) {
                        rowLabel.textContent = 'Row ' + (index + 1);
                    }

                    row.querySelectorAll('[data-field]').forEach((field) => {
                        const key = field.getAttribute('data-field');
                        field.name = `expenses[${index}][${key}]`;
                        field.id = `bulk_${key}_${index}`;
                    });

                    row.querySelectorAll('[data-field-label]').forEach((label) => {
                        const key = label.getAttribute('data-field-label');
                        label.setAttribute('for', `bulk_${key}_${index}`);
                    });

                    const removeBtn = row.querySelector('[data-remove-row]');
                    if (removeBtn) {
                        const isSingleRow = rows.length === 1;
                        removeBtn.disabled = isSingleRow;
                    }

                    const duplicateBtn = row.querySelector('[data-duplicate-row]');
                    if (duplicateBtn) {
                        duplicateBtn.disabled = isMaxed;
                    }
                });

                updateRowCount(rows.length);
            };

            addRowButton.addEventListener('click', function() {
                appendRow();
            });

            duplicateLastButton.addEventListener('click', function() {
                const rows = rowsContainer.querySelectorAll('[data-row]');
                if (rows.length === 0 || rows.length >= maxRows) {
                    return;
                }

                const lastRow = rows[rows.length - 1];
                appendRow(readRowValues(lastRow));
            });

            clearRowsButton.addEventListener('click', function() {
                const rows = rowsContainer.querySelectorAll('[data-row]');
                if (rows.length === 0) {
                    return;
                }

                if (!confirm('Clear all bulk expense rows?')) {
                    return;
                }

                rowsContainer.innerHTML = '';
                appendRow();
            });

            rowsContainer.addEventListener('click', function(event) {
                const duplicateBtn = event.target.closest('[data-duplicate-row]');
                if (duplicateBtn) {
                    const rows = rowsContainer.querySelectorAll('[data-row]');
                    if (rows.length >= maxRows) {
                        return;
                    }

                    const row = duplicateBtn.closest('[data-row]');
                    if (row) {
                        appendRow(readRowValues(row));
                    }
                    return;
                }

                const removeBtn = event.target.closest('[data-remove-row]');
                if (!removeBtn) {
                    return;
                }

                const rows = rowsContainer.querySelectorAll('[data-row]');
                if (rows.length <= 1) {
                    const onlyRow = rows[0];
                    if (onlyRow) {
                        setRowValues(onlyRow);
                    }
                    reindexRows();
                    return;
                }

                const row = removeBtn.closest('[data-row]');
                if (row) {
                    row.remove();
                    reindexRows();
                }
            });

            reindexRows();
        });
    </script>
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

        @if (session('focus_next_expense'))
            const nextInput = document.getElementById('product_name');
            if (nextInput) {
                nextInput.focus();
            }
        @endif
    </script>
@endpush
