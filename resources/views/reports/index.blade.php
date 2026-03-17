@extends('layout.app')
@section('title', 'Reports')
@section('page-title', 'Reports')
@section('page-subtitle', 'Analytics for ' . $today->format('F Y'))

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
            <div class="card-value" style="color:{{ $monthSavings >= 0 ? 'var(--accent)' : 'var(--danger)' }};">₹{{ number_format(abs($monthSavings), 2) }}</div>
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
                            <span style="font-size:0.8rem; color:var(--text); display:flex; align-items:center; gap:0.4rem;">
                                <span style="width:10px; height:10px; border-radius:3px; background:{{ $cat->color }};"></span>
                                {{ $cat->name }}
                            </span>
                            <span style="font-size:0.8rem; font-weight:500; color:var(--text);">₹{{ number_format($cat->total, 2) }}</span>
                        </div>
                        <div style="height:6px; background:var(--bg); border-radius:99px; overflow:hidden;">
                            <div style="height:100%; width:{{ $catPct }}%; border-radius:99px; background:{{ $cat->color }};"></div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state" style="padding:1.5rem 0;"><div style="font-size:0.82rem;">No categorized expenses.</div></div>
            @endif
        </div>
    </div>

    <!-- PDF Export -->
    <div class="card" style="text-align:center;">
        <div class="card-title" style="margin-bottom:0.5rem;">Export Report</div>
        <div style="font-size:0.82rem; color:var(--muted); margin-bottom:1.25rem;">Download your monthly expense report as PDF</div>
        <form method="GET" action="{{ route('reports.export-pdf') }}" style="display:inline-flex; align-items:center; gap:0.75rem; flex-wrap:wrap; justify-content:center;">
            <select name="month" class="form-input" style="width:auto;">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $today->month == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endfor
            </select>
            <select name="year" class="form-input" style="width:auto;">
                @for ($y = $today->year - 2; $y <= $today->year; $y++)
                    <option value="{{ $y }}" {{ $today->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn-submit" style="width:auto; padding:0.6rem 1.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download PDF
            </button>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    const chartOpts = { responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false } } };

    // Daily bar chart
    new Chart(document.getElementById('dailyChart'), {
        type:'bar', data:{ labels:@json($chartLabels), datasets:[{ data:@json($chartData), backgroundColor:'rgba(61,107,79,0.6)', borderColor:'rgba(61,107,79,1)', borderWidth:1, borderRadius:4, maxBarThickness:24 }] },
        options:{...chartOpts, scales:{ x:{grid:{display:false}, ticks:{color:'#8c8070',font:{size:10}}}, y:{beginAtZero:true, grid:{color:'rgba(0,0,0,0.04)'}, ticks:{color:'#8c8070',font:{size:10}, callback:v=>'₹'+v.toLocaleString('en-IN')}} }}
    });

    // Doughnut
    new Chart(document.getElementById('typeChart'), {
        type:'doughnut', data:{ labels:['Online','Offline'], datasets:[{ data:[{{ $onlineTotal }}, {{ $offlineTotal }}], backgroundColor:['#5078c8','#b8892a'], borderWidth:0 }] },
        options:{...chartOpts, plugins:{legend:{display:true, position:'bottom', labels:{color:'#8c8070', padding:16, font:{size:12}}}}, cutout:'65%'}
    });

    // 6 month trend
    new Chart(document.getElementById('trendChart'), {
        type:'line', data:{ labels:{!! json_encode(array_column($monthlyTrend, 'label')) !!}, datasets:[{ data:{!! json_encode(array_column($monthlyTrend, 'total')) !!}, borderColor:'var(--accent)', backgroundColor:'rgba(61,107,79,0.1)', fill:true, tension:0.3, pointRadius:4, pointBackgroundColor:'var(--accent)' }] },
        options:{...chartOpts, scales:{ x:{grid:{display:false}, ticks:{color:'#8c8070'}}, y:{beginAtZero:true, grid:{color:'rgba(0,0,0,0.04)'}, ticks:{color:'#8c8070', callback:v=>'₹'+v.toLocaleString('en-IN')}} }}
    });
</script>
@endpush
