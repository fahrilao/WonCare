@extends('layouts.member')

@section('title', __('financial.title'))
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">{{ __('financial.dashboard') }}</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <a href="{{ route('member.financial-tools.income-detail') }}" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1 text-muted">{{ __('financial.monthly_income') }}</h6>
                                    <h3 class="mb-0 text-success">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</h3>
                                    <small class="text-muted">{{ __('financial.view_details') }} <i
                                            class="ti tabler-arrow-right"></i></small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="ti tabler-trending-up ti-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('member.financial-tools.expense-detail') }}" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1 text-muted">{{ __('financial.monthly_expenses') }}</h6>
                                    <h3 class="mb-0 text-danger">Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</h3>
                                    <small class="text-muted">{{ __('financial.view_details') }} <i
                                            class="ti tabler-arrow-right"></i></small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-danger">
                                        <i class="ti tabler-trending-down ti-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('member.financial-tools.savings-detail') }}" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1 text-muted">{{ __('financial.monthly_savings') }}</h6>
                                    <h3
                                        class="mb-0 {{ $monthlyIncome - $monthlyExpenses >= 0 ? 'text-primary' : 'text-danger' }}">
                                        Rp {{ number_format($monthlyIncome - $monthlyExpenses, 0, ',', '.') }}
                                    </h3>
                                    <small class="text-muted">{{ __('financial.view_details') }} <i
                                            class="ti tabler-arrow-right"></i></small>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti tabler-wallet ti-md"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Budget Chart & Recommendations -->
            <div class="col-lg-8 mb-4">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="card-title mb-0">{{ __('financial.budget_chart') }}</h5>
                        <div class="d-flex align-items-center gap-2">
                            <select id="chartYear" class="form-select form-select-sm" style="width:auto;">
                                @for ($y = date('Y'); $y >= date('Y') - 4; $y--)
                                    <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endfor
                            </select>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-primary active"
                                    id="btnBar">{{ __('financial.chart_monthly') }}</button>
                                <button type="button" class="btn btn-outline-primary"
                                    id="btnPie">{{ __('financial.chart_expense_pie') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="barChartWrap">
                            <canvas id="barChart" height="280"></canvas>
                        </div>
                        <div id="pieChartWrap" class="d-none">
                            <canvas id="budgetChart" height="280"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('financial.recommendations.title') }}</h5>
                    </div>
                    <div class="card-body">
                        @if (isset($recommendations['status']) && $recommendations['status'] === 'no_data')
                            <div class="alert alert-info">{{ $recommendations['message'] }}</div>
                        @else
                            @if (isset($recommendations['savings']))
                                <div
                                    class="alert alert-{{ $recommendations['savings']['status'] === 'good' ? 'success' : ($recommendations['savings']['status'] === 'fair' ? 'warning' : 'danger') }}">
                                    <strong>{{ __('financial.recommendations.savings') }}:</strong>
                                    {{ $recommendations['savings']['message'] }}
                                    <br><small>{{ __('financial.recommendations.savings') }}:
                                        {{ $recommendations['summary']['savings_rate'] }}%</small>
                                </div>
                            @endif
                            @if (isset($recommendations['expenses']))
                                <div
                                    class="alert alert-{{ $recommendations['expenses']['status'] === 'good' ? 'success' : 'warning' }}">
                                    <strong>{{ __('financial.expenses') }}:</strong>
                                    {{ $recommendations['expenses']['message'] }}
                                    <br><small>{{ __('financial.expense_breakdown') }}:
                                        {{ $recommendations['summary']['expense_rate'] }}%</small>
                                </div>
                            @endif
                            <div class="mt-3">
                                <h6>{{ __('financial.recommendations.ideal_allocation') }}</h6>
                                <ul>
                                    <li>{{ __('financial.recommendations.needs') }}</li>
                                    <li>{{ __('financial.recommendations.wants') }}</li>
                                    <li>{{ __('financial.recommendations.savings') }}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Zakat -->
            <div class="col-lg-4 mb-4">
                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('common.actions') }}</h5>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-muted mb-2"
                            style="font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">
                            {{ __('common.actions') }}</p>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <button type="button" class="action-tile w-100" data-bs-toggle="modal"
                                    data-bs-target="#incomeModal">
                                    <span class="action-tile-icon bg-label-success"><i
                                            class="ti tabler-trending-up"></i></span>
                                    <span class="action-tile-label">{{ __('financial.add_income') }}</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="action-tile w-100" data-bs-toggle="modal"
                                    data-bs-target="#expenseModal">
                                    <span class="action-tile-icon bg-label-danger"><i
                                            class="ti tabler-trending-down"></i></span>
                                    <span class="action-tile-label">{{ __('financial.add_expense') }}</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="action-tile w-100" data-bs-toggle="modal"
                                    data-bs-target="#savingsModal">
                                    <span class="action-tile-icon bg-label-info"><i class="ti tabler-target"></i></span>
                                    <span class="action-tile-label">{{ __('financial.savings_target') }}</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="action-tile w-100" data-bs-toggle="modal"
                                    data-bs-target="#dreamAssetModal">
                                    <span class="action-tile-icon bg-label-warning"><i class="ti tabler-star"></i></span>
                                    <span class="action-tile-label">{{ __('financial.dream_asset') }}</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="action-tile w-100" id="calculateZakatBtn">
                                    <span class="action-tile-icon bg-label-primary"><i
                                            class="ti tabler-calculator"></i></span>
                                    <span class="action-tile-label">{{ __('financial.zakat.calculate_auto') }}</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('member.financial-tools.download-report') }}"
                                    class="action-tile w-100 text-decoration-none">
                                    <span class="action-tile-icon bg-label-secondary"><i
                                            class="ti tabler-download"></i></span>
                                    <span class="action-tile-label">{{ __('financial.report.download') }}</span>
                                </a>
                            </div>
                        </div>

                        <p class="text-muted mb-2"
                            style="font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">
                            {{ __('financial.view_details') }}</p>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('member.financial-tools.income-detail') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center gap-2 px-0 py-2 border-0">
                                <span class="avatar-initial rounded bg-label-success"
                                    style="width:28px;height:28px;font-size:.8rem;flex-shrink:0;">
                                    <i class="ti tabler-trending-up"></i>
                                </span>
                                <span style="font-size:.875rem;">{{ __('financial.income_detail') }}</span>
                                <i class="ti tabler-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('member.financial-tools.expense-detail') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center gap-2 px-0 py-2 border-0">
                                <span class="avatar-initial rounded bg-label-danger"
                                    style="width:28px;height:28px;font-size:.8rem;flex-shrink:0;">
                                    <i class="ti tabler-trending-down"></i>
                                </span>
                                <span style="font-size:.875rem;">{{ __('financial.expense_detail') }}</span>
                                <i class="ti tabler-chevron-right ms-auto text-muted"></i>
                            </a>
                            <a href="{{ route('member.financial-tools.savings-detail') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center gap-2 px-0 py-2 border-0">
                                <span class="avatar-initial rounded bg-label-primary"
                                    style="width:28px;height:28px;font-size:.8rem;flex-shrink:0;">
                                    <i class="ti tabler-wallet"></i>
                                </span>
                                <span style="font-size:.875rem;">{{ __('financial.savings_detail') }}</span>
                                <i class="ti tabler-chevron-right ms-auto text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Zakat Info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('financial.zakat.title') }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($zakatInfo['is_eligible'])
                            <div class="alert alert-success">
                                <strong>{{ __('financial.zakat.eligible') }}</strong>
                            </div>
                            <p><strong>{{ __('financial.zakat.zakat_amount') }}:</strong><br>
                                Rp {{ number_format($zakatInfo['zakat_amount'], 0, ',', '.') }}</p>
                            <a href="{{ route('member.donate.index') }}" class="btn btn-success w-100">
                                {{ __('financial.zakat.pay_now') }}
                            </a>
                        @else
                            <div class="alert alert-info">
                                <strong>{{ __('financial.zakat.not_eligible') }}</strong>
                            </div>
                            <p><strong>{{ __('financial.zakat.remaining_to_nisab') }}:</strong><br>
                                Rp {{ number_format($zakatInfo['remaining_to_nisab'], 0, ',', '.') }}</p>
                        @endif
                        <hr>
                        <small class="text-muted">
                            <strong>{{ __('financial.zakat.net_wealth') }}:</strong>
                            Rp {{ number_format($zakatInfo['net_wealth'], 0, ',', '.') }}<br>
                            <strong>{{ __('financial.zakat.nisab_threshold') }}:</strong>
                            Rp {{ number_format($zakatInfo['nisab_threshold'], 0, ',', '.') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Savings Target & Dream Assets -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('financial.savings_target') }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($savingsTarget)
                            <h6>{{ __('financial.target_year') }}: {{ $savingsTarget->target_year }}</h6>
                            <div class="progress mb-2" style="height: 25px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $savingsTarget->progress_percentage }}%"
                                    aria-valuenow="{{ $savingsTarget->progress_percentage }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                    {{ $savingsTarget->progress_percentage }}%
                                </div>
                            </div>
                            <p class="mb-1"><strong>{{ __('financial.target_amount') }}:</strong>
                                Rp {{ number_format($savingsTarget->target_amount, 0, ',', '.') }}</p>
                            <p class="mb-1"><strong>{{ __('financial.current_amount') }}:</strong>
                                Rp {{ number_format($savingsTarget->current_amount, 0, ',', '.') }}</p>
                            <p class="mb-0"><strong>{{ __('financial.remaining') }}:</strong>
                                Rp {{ number_format($savingsTarget->remaining_amount, 0, ',', '.') }}</p>
                        @else
                            <p class="text-muted">{{ __('financial.no_data') }}</p>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#savingsModal">
                                {{ __('financial.add_savings_target') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('financial.dream_assets') }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($dreamAssets->count() > 0)
                            <div class="list-group">
                                @foreach ($dreamAssets->take(5) as $asset)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $asset->asset_name }}</h6>
                                                <small>Rp {{ number_format($asset->estimated_cost, 0, ',', '.') }}</small>
                                            </div>
                                            {!! $asset->priority_badge !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">{{ __('financial.no_data') }}</p>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#dreamAssetModal">
                                {{ __('financial.add_dream_asset') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Income Modal -->
    <div class="modal fade" id="incomeModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('financial.add_income') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('member.financial-tools.store-income') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.gross_salary') }} *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="gross_salary" required
                                        step="0.01" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.income_date') }} *</label>
                                <input type="date" class="form-control" name="income_date" required
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <h6 class="mb-3">{{ __('financial.total_deductions') }}</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.kookmin_yeongeum') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="kookmin_yeongeum" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.twejigeum') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="twejigeum" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.insurance') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="insurance" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.tax') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="tax" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.other_deductions') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="other_deductions" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.notes') }}</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('financial.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('financial.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Expense Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('financial.add_expense') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('member.financial-tools.store-expense') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted mb-3">{{ __('onboarding.expense_help') }}</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.expense_categories.rent') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="rent" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.expense_categories.food') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="food" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.expense_categories.remittance') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="remittance" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.expense_categories.transport') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="transport" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.expense_categories.entertainment') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="entertainment" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.expense_categories.charity') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="charity" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.expense_categories.other') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="other" step="0.01"
                                        value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.expense_date') }} *</label>
                                <input type="date" class="form-control" name="expense_date" required
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.notes') }}</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('financial.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('financial.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Savings Target Modal -->
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
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.target_year') }} *</label>
                            <input type="number" class="form-control" name="target_year" required min="2024"
                                value="{{ date('Y') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.target_amount') }} *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="target_amount" required step="0.01"
                                    placeholder="0">
                            </div>
                            <small class="text-muted">{{ __('onboarding.savings_target_help') }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.description') }}</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                        <div class="alert alert-info mb-0 py-2">
                            <small><i
                                    class="ti tabler-info-circle me-1"></i>{{ __('financial.current_amount_auto_note') }}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('financial.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('financial.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Dream Asset Modal -->
    <div class="modal fade" id="dreamAssetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('financial.add_dream_asset') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('member.financial-tools.store-dream-asset') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <small class="text-muted d-block mb-3">{{ __('onboarding.dream_assets_help') }}</small>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.asset_name') }} *</label>
                            <input type="text" class="form-control" name="asset_name" required
                                placeholder="{{ __('financial.asset_name') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.estimated_cost') }} *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="estimated_cost" required step="0.01"
                                    placeholder="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.priority') }} *</label>
                            <select class="form-select" name="priority" required>
                                <option value="1">{{ __('financial.priority_levels.1') }}</option>
                                <option value="2" selected>{{ __('financial.priority_levels.2') }}</option>
                                <option value="3">{{ __('financial.priority_levels.3') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.target_date') }}</label>
                            <input type="date" class="form-control" name="target_date">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.description') }}</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('financial.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('financial.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .action-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.85rem 0.5rem;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 12px;
            cursor: pointer;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
            text-align: center;
        }

        .action-tile:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            background: var(--bs-body-bg);
        }

        .action-tile-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .action-tile-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--bs-body-color);
            line-height: 1.2;
        }

        a.action-tile .action-tile-label {
            color: var(--bs-body-color);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const pieColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF'];
            const translatedLabels = {
                @foreach (\App\Models\FinancialExpense::getCategories() as $key => $label)
                    '{{ $key }}': '{{ __($label) }}',
                @endforeach
            };

            // ── Bar Chart (Income vs Expense by month) ──
            const barCtx = document.getElementById('barChart').getContext('2d');
            let barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: monthNames,
                    datasets: []
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: v => 'Rp ' + (v / 1000000).toFixed(1) + 'M'
                            }
                        }
                    }
                }
            });

            function loadBarChart(year) {
                $.get('{{ route('member.financial-tools.monthly-chart') }}', {
                    year
                }, function(res) {
                    const incomes = res.data.map(d => d.income);
                    const expenses = res.data.map(d => d.expense);
                    const savings = res.data.map(d => d.savings);
                    barChart.data.datasets = [{
                            label: '{{ __('financial.income') }}',
                            data: incomes,
                            backgroundColor: 'rgba(40,199,111,0.75)',
                            borderColor: '#28c76f',
                            borderWidth: 1.5,
                            borderRadius: 4
                        },
                        {
                            label: '{{ __('financial.expenses') }}',
                            data: expenses,
                            backgroundColor: 'rgba(234,84,85,0.75)',
                            borderColor: '#ea5455',
                            borderWidth: 1.5,
                            borderRadius: 4
                        },
                        {
                            label: '{{ __('financial.monthly_savings') }}',
                            data: savings,
                            backgroundColor: 'rgba(0,207,232,0.55)',
                            borderColor: '#00cfe8',
                            borderWidth: 1.5,
                            borderRadius: 4,
                            type: 'line',
                            fill: false,
                            tension: 0.4,
                            pointRadius: 4
                        },
                    ];
                    barChart.update();
                });
            }
            loadBarChart($('#chartYear').val());

            $('#chartYear').on('change', function() {
                loadBarChart($(this).val());
            });

            // ── Pie Chart (Expense breakdown) ──
            const pieCtx = document.getElementById('budgetChart').getContext('2d');
            const expenseData = @json($expensesByCategory);
            const pieLabels = expenseData.map(d => translatedLabels[d.category] || d.category);
            const pieAmounts = expenseData.map(d => parseFloat(d.total));

            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: pieAmounts,
                        backgroundColor: pieColors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: '{{ __('financial.expense_breakdown') }} ({{ date('F Y') }})'
                        }
                    }
                }
            });

            // ── Toggle bar / pie ──
            $('#btnBar').on('click', function() {
                $('#barChartWrap').removeClass('d-none');
                $('#pieChartWrap').addClass('d-none');
                $(this).removeClass('btn-outline-primary').addClass('btn-primary active');
                $('#btnPie').removeClass('btn-primary active').addClass('btn-outline-primary');
            });
            $('#btnPie').on('click', function() {
                $('#pieChartWrap').removeClass('d-none');
                $('#barChartWrap').addClass('d-none');
                $(this).removeClass('btn-outline-primary').addClass('btn-primary active');
                $('#btnBar').removeClass('btn-primary active').addClass('btn-outline-primary');
            });

            // ── Calculate Zakat Button ──
            $('#calculateZakatBtn').on('click', function() {
                $.ajax({
                    url: '{{ route('member.financial-tools.calculate-zakat') }}',
                    type: 'GET',
                    success: function(response) {
                        let message = '';
                        if (response.is_eligible) {
                            message = '{{ __('financial.zakat.eligible') }}\n\n';
                            message += '{{ __('financial.zakat.zakat_amount') }}: Rp ' +
                                response.zakat_amount.toLocaleString('id-ID');
                        } else {
                            message = '{{ __('financial.zakat.not_eligible') }}\n\n';
                            message += '{{ __('financial.zakat.remaining_to_nisab') }}: Rp ' +
                                response.remaining_to_nisab.toLocaleString('id-ID');
                        }
                        alert(message);
                    },
                    error: function() {
                        alert('Error calculating zakat');
                    }
                });
            });
        });
    </script>
@endpush
