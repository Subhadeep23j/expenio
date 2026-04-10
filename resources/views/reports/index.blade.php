@extends('layout.app')
@section('title', 'Reports')
@section('page-title', 'Reports')
@section('page-subtitle', 'Analytics for ' . $today->format('F Y'))

@push('styles')
    <style>
        .report-export-actions {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .report-export-actions .btn-submit {
            width: auto;
            padding: 0.6rem 1.4rem;
        }

        .btn-outline {
            background: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
        }

        .btn-outline:hover {
            background: rgba(61, 107, 79, 0.08);
        }

        .btn-print {
            background: var(--text);
        }

        .btn-print:hover {
            background: #2a2620;
        }

        @media (max-width: 768px) {
            .report-export-form {
                width: 100%;
                flex-direction: column;
                align-items: stretch !important;
            }

            .report-export-form .form-input {
                width: 100% !important;
            }

            .report-export-actions {
                display: flex;
                width: 100%;
            }

            .report-export-actions .btn-submit {
                flex: 1;
                justify-content: center;
            }
        }

        @media print {

            #sidebar,
            #sidebar-overlay,
            #topbar,
            footer,
            .report-print-hide {
                display: none !important;
            }

            #main-wrap {
                margin-left: 0 !important;
            }

            #page-content {
                padding: 0 !important;
            }

            .card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Summary Row -->
    <div class="grid-4" style="margin-bottom:2rem;">
        <div class="card">
            <div class="card-label" style="margin-bottom:0.5rem;">Month Expenses</div>
            <div class="card-value" style="color:var(--danger);">₹{{ number_format($monthExpenses, 2) }}</div>
        </div>
        <div class="card">
            <div class="card-label" style="margin-bottom:0.5rem;">Month Income</div>
            <div class="card-value" style="color:var(--accent);">₹{{ number_format($monthIncome, 2) }}</div>
        </div>
        <div class="card">
            <div class="card-label" style="margin-bottom:0.5rem;">Net Savings</div>
            <div class="card-value" style="color:{{ $monthSavings >= 0 ? 'var(--accent)' : 'var(--danger)' }};">
                ₹{{ number_format(abs($monthSavings), 2) }}</div>
            <div class="card-sub">{{ $monthSavings >= 0 ? 'Saved' : 'Deficit' }}</div>
        </div>
        <div class="card">
            <div class="card-label" style="margin-bottom:0.5rem;">Transactions</div>
            <div class="card-value">{{ $expenseCount }}</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid-2" style="margin-bottom:2rem;">
        <!-- Daily Bar Chart -->
        <div class="card">
            <div class="card-title" style="margin-bottom:1rem;">Daily Expenses</div>
            <div class="chart-wrap"><canvas id="dailyChart"></canvas></div>
        </div>
        <!-- Online vs Offline Doughnut -->
        <div class="card">
            <div class="card-title" style="margin-bottom:1rem;">Online vs Offline</div>
            <div class="chart-wrap"><canvas id="typeChart"></canvas></div>
        </div>
    </div>

    <!-- Monthly Trend + Category Breakdown -->
    <div class="grid-2" style="margin-bottom:2rem;">
        <div class="card">
            <div class="card-title" style="margin-bottom:1rem;">6-Month Trend</div>
            <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
        </div>
        <div class="card">
            <div class="card-title" style="margin-bottom:1rem;">By Category</div>
            @if ($categoryBreakdown->count() > 0)
                @foreach ($categoryBreakdown as $cat)
                    @php $catPct = $monthExpenses > 0 ? ($cat->total / $monthExpenses) * 100 : 0; @endphp
                    <div style="margin-bottom:0.75rem;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.3rem;">
                            <span
                                style="font-size:0.8rem; color:var(--text); display:flex; align-items:center; gap:0.4rem;">
                                <span
                                    style="width:10px; height:10px; border-radius:3px; background:{{ $cat->color }};"></span>
                                {{ $cat->name }}
                            </span>
                            <span
                                style="font-size:0.8rem; font-weight:500; color:var(--text);">₹{{ number_format($cat->total, 2) }}</span>
                        </div>
                        <div style="height:6px; background:var(--bg); border-radius:99px; overflow:hidden;">
                            <div
                                style="height:100%; width:{{ $catPct }}%; border-radius:99px; background:{{ $cat->color }};">
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state" style="padding:1.5rem 0;">
                    <div style="font-size:0.82rem;">No categorized expenses.</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Export + Print -->
    <div class="card" style="text-align:center;">
        <div class="card-title" style="margin-bottom:0.5rem;">Export Report</div>
        <div style="font-size:0.82rem; color:var(--muted); margin-bottom:1.25rem;">Download your monthly report as PDF or
            Excel, or print the full report page.</div>
        @php
            $hasReportPdfRoute = \Illuminate\Support\Facades\Route::has('reports.export-pdf');
            $hasReportExcelRoute = \Illuminate\Support\Facades\Route::has('reports.export-excel');
        @endphp

        @if ($hasReportPdfRoute)
            <form method="GET" action="{{ route('reports.export-pdf') }}" class="report-export-form"
                style="display:inline-flex; align-items:center; gap:0.75rem; flex-wrap:wrap; justify-content:center;">
                <select name="month" class="form-input" style="width:auto;">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $today->month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                    @endfor
                </select>
                <select name="year" class="form-input" style="width:auto;">
                    @for ($y = $today->year - 2; $y <= $today->year; $y++)
                        <option value="{{ $y }}" {{ $today->year == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
                <div class="report-export-actions report-print-hide">
                    <button type="submit" class="btn-submit">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download PDF
                    </button>
                    @if ($hasReportExcelRoute)
                        <button type="submit" formaction="{{ route('reports.export-excel') }}"
                            class="btn-submit btn-outline">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 2h8l4 4v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="9" y1="15" x2="15" y2="15" />
                                <line x1="9" y1="11" x2="15" y2="11" />
                            </svg>
                            Download Excel
                        </button>
                    @endif
                    <button type="button" class="btn-submit btn-print" onclick="window.print()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9" />
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                            <rect x="6" y="14" width="12" height="8" />
                        </svg>
                        Print Report
                    </button>
                </div>
            </form>
        @else
            <div class="card-sub">Report export is temporarily unavailable while server routes are updating.</div>
            <div class="report-export-actions report-print-hide" style="margin-top:0.9rem;">
                <button type="button" class="btn-submit btn-print" onclick="window.print()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9" />
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                        <rect x="6" y="14" width="12" height="8" />
                    </svg>
                    Print Report
                </button>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        const chartOpts = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        };

        // Daily bar chart
        new Chart(document.getElementById('dailyChart'), {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    data: @json($chartData),
                    backgroundColor: 'rgba(61,107,79,0.6)',
                    borderColor: 'rgba(61,107,79,1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 24
                }]
            },
            options: {
                ...chartOpts,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#8c8070',
                            font: {
                                size: 10
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
                                size: 10
                            },
                            callback: v => '₹' + v.toLocaleString('en-IN')
                        }
                    }
                }
            }
        });

        // Doughnut
        new Chart(document.getElementById('typeChart'), {
            type: 'doughnut',
            data: {
                labels: ['Online', 'Offline'],
                datasets: [{
                    data: [{{ $onlineTotal }}, {{ $offlineTotal }}],
                    backgroundColor: ['#5078c8', '#b8892a'],
                    borderWidth: 0
                }]
            },
            options: {
                ...chartOpts,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#8c8070',
                            padding: 16,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // 6 month trend
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($monthlyTrend, 'label')) !!},
                datasets: [{
                    data: {!! json_encode(array_column($monthlyTrend, 'total')) !!},
                    borderColor: 'var(--accent)',
                    backgroundColor: 'rgba(61,107,79,0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: 'var(--accent)'
                }]
            },
            options: {
                ...chartOpts,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#8c8070'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.04)'
                        },
                        ticks: {
                            color: '#8c8070',
                            callback: v => '₹' + v.toLocaleString('en-IN')
                        }
                    }
                }
            }
        });
    </script>
@endpush
