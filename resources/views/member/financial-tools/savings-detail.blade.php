@extends('layouts.member')

@section('title', __('financial.savings_detail'))
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <div>
                <a href="{{ route('member.financial-tools.index') }}" class="text-muted text-decoration-none d-inline-flex align-items-center gap-1 mb-1" style="font-size:.85rem;">
                    <i class="ti tabler-arrow-left"></i> {{ __('financial.dashboard') }}
                </a>
                <h4 class="mb-0">{{ __('financial.savings_detail') }}</h4>
            </div>
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#savingsModal">
                <i class="ti tabler-target me-1"></i>{{ __('financial.add_savings_target') }}
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Year filter --}}
        <div class="card mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('member.financial-tools.savings-detail') }}" class="row g-2 align-items-end">
                    <div class="col-auto">
                        <label class="form-label mb-1">{{ __('financial.year') }}</label>
                        <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach ($availableYears as $y)
                                <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1" style="font-size:.8rem;">{{ __('financial.yearly_income') }}</p>
                        <h4 class="mb-0 text-success">Rp {{ number_format($yearlyIncome, 0, ',', '.') }}</h4>
                        <small class="text-muted">{{ $selectedYear }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1" style="font-size:.8rem;">{{ __('financial.yearly_expenses') }}</p>
                        <h4 class="mb-0 text-danger">Rp {{ number_format($yearlyExpense, 0, ',', '.') }}</h4>
                        <small class="text-muted">{{ $selectedYear }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1" style="font-size:.8rem;">{{ __('financial.yearly_savings') }}</p>
                        <h4 class="mb-0 text-primary">Rp {{ number_format($yearlySavings, 0, ',', '.') }}</h4>
                        <small class="text-muted">
                            {{ __('financial.savings_rate') }}:
                            {{ $yearlyIncome > 0 ? round(($yearlySavings / $yearlyIncome) * 100, 1) : 0 }}%
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1" style="font-size:.8rem;">{{ __('financial.savings_rate') }}</p>
                        @php $rate = $yearlyIncome > 0 ? round(($yearlySavings / $yearlyIncome) * 100, 1) : 0; @endphp
                        <h4 class="mb-0 {{ $rate >= 20 ? 'text-success' : ($rate >= 10 ? 'text-warning' : 'text-danger') }}">
                            {{ $rate }}%
                        </h4>
                        <small class="text-muted">{{ $rate >= 20 ? '✓ Good' : ($rate >= 10 ? '~ Fair' : '✗ Low') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            {{-- Monthly Savings Trend Chart --}}
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('financial.monthly_savings_trend') }} {{ $selectedYear }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="savingsChart" height="260"></canvas>
                    </div>
                </div>
            </div>

            {{-- Savings Target for selected year --}}
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('financial.target_progress') }} {{ $selectedYear }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($savingsTarget)
                            <div class="text-center mb-3">
                                <div style="position:relative;display:inline-block;width:120px;height:120px;">
                                    <canvas id="progressDonut" width="120" height="120"></canvas>
                                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                                        <strong style="font-size:1.2rem;">{{ $savingsTarget->progress_percentage }}%</strong>
                                    </div>
                                </div>
                            </div>
                            @if ($savingsTarget->is_achieved)
                                <div class="alert alert-success py-2 text-center mb-3">
                                    <i class="ti tabler-trophy me-1"></i> {{ __('financial.achieved') }}!
                                </div>
                            @else
                                <div class="alert alert-info py-2 text-center mb-3">
                                    <i class="ti tabler-clock me-1"></i> {{ __('financial.in_progress') }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">{{ __('financial.current_amount') }}</small>
                                <small class="fw-medium">Rp {{ number_format($savingsTarget->current_amount, 0, ',', '.') }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">{{ __('financial.target_amount') }}</small>
                                <small class="fw-medium">Rp {{ number_format($savingsTarget->target_amount, 0, ',', '.') }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <small class="text-muted">{{ __('financial.remaining') }}</small>
                                <small class="fw-medium text-danger">Rp {{ number_format($savingsTarget->remaining_amount, 0, ',', '.') }}</small>
                            </div>
                            @if ($savingsTarget->description)
                                <p class="text-muted small mb-0">{{ $savingsTarget->description }}</p>
                            @endif
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="ti tabler-target ti-xl mb-2 d-block"></i>
                                <p class="mb-3">{{ __('financial.no_target_set') }}</p>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#savingsModal">
                                    {{ __('financial.set_target') }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- All Savings Targets History --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('financial.savings_history') }}</h5>
                <span class="badge bg-label-primary">{{ $allTargets->count() }} {{ __('financial.records') }}</span>
            </div>
            <div class="card-body p-0">
                @if ($allTargets->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="ti tabler-inbox ti-xl mb-2 d-block"></i>
                        {{ __('financial.no_data') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('financial.target_year') }}</th>
                                    <th class="text-end">{{ __('financial.target_amount') }}</th>
                                    <th class="text-end">{{ __('financial.current_amount') }}</th>
                                    <th class="text-end d-none d-md-table-cell">{{ __('financial.remaining') }}</th>
                                    <th style="min-width:120px;">{{ __('financial.target_progress') }}</th>
                                    <th class="text-center">{{ __('financial.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allTargets as $target)
                                    <tr>
                                        <td class="fw-medium">{{ $target->target_year }}</td>
                                        <td class="text-end">Rp {{ number_format($target->target_amount, 0, ',', '.') }}</td>
                                        <td class="text-end text-primary">Rp {{ number_format($target->current_amount, 0, ',', '.') }}</td>
                                        <td class="text-end text-danger d-none d-md-table-cell">
                                            Rp {{ number_format($target->remaining_amount, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height:6px;">
                                                    <div class="progress-bar {{ $target->is_achieved ? 'bg-success' : 'bg-primary' }}"
                                                        style="width:{{ $target->progress_percentage }}%"></div>
                                                </div>
                                                <small class="text-muted" style="white-space:nowrap;">{{ $target->progress_percentage }}%</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($target->is_achieved)
                                                <span class="badge bg-label-success">{{ __('financial.achieved') }}</span>
                                            @else
                                                <span class="badge bg-label-warning">{{ __('financial.in_progress') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Savings Target Modal --}}
    <div class="modal fade" id="savingsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('financial.add_savings_target') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('member.financial-tools.store-savings-target') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info py-2 small">
                            <i class="ti tabler-info-circle me-1"></i>{{ __('financial.current_amount_auto_note') }}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.target_year') }} *</label>
                            <input type="number" class="form-control" name="target_year" required
                                value="{{ date('Y') }}" min="2020" max="2099">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.target_amount') }} *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="target_amount" required step="0.01" placeholder="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.description') }}</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('financial.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('financial.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const monthlyData = @json($monthlyData);

        // ── Monthly Savings Trend (bar + line) ──
        const savingsCtx = document.getElementById('savingsChart').getContext('2d');
        new Chart(savingsCtx, {
            data: {
                labels: monthNames,
                datasets: [
                    {
                        type: 'bar',
                        label: '{{ __('financial.income') }}',
                        data: monthlyData.map(d => d.income),
                        backgroundColor: 'rgba(40,199,111,0.6)',
                        borderColor: '#28c76f',
                        borderWidth: 1.5,
                        borderRadius: 4,
                    },
                    {
                        type: 'bar',
                        label: '{{ __('financial.expenses') }}',
                        data: monthlyData.map(d => d.expense),
                        backgroundColor: 'rgba(234,84,85,0.6)',
                        borderColor: '#ea5455',
                        borderWidth: 1.5,
                        borderRadius: 4,
                    },
                    {
                        type: 'line',
                        label: '{{ __('financial.yearly_savings') }}',
                        data: monthlyData.map(d => d.savings),
                        borderColor: '#00cfe8',
                        backgroundColor: 'rgba(0,207,232,0.1)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#00cfe8',
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: v => 'Rp ' + (v / 1000000).toFixed(1) + 'M' }
                    }
                }
            }
        });

        @if ($savingsTarget)
        // ── Progress Donut ──
        const donutCtx = document.getElementById('progressDonut').getContext('2d');
        const pct = {{ $savingsTarget->progress_percentage }};
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [pct, Math.max(0, 100 - pct)],
                    backgroundColor: [pct >= 100 ? '#28c76f' : '#7367f0', '#e9ecef'],
                    borderWidth: 0,
                }]
            },
            options: {
                cutout: '78%',
                responsive: false,
                plugins: { legend: { display: false }, tooltip: { enabled: false } }
            }
        });
        @endif
    </script>
@endpush
