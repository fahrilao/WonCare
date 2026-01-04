@extends('layouts.member')

@section('title', __('financial.title'))

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
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-1">{{ __('financial.monthly_income') }}</h6>
                                <h3 class="mb-0">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</h3>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-trending-up ti-md"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-1">{{ __('financial.monthly_expenses') }}</h6>
                                <h3 class="mb-0">Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</h3>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-trending-down ti-md"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title mb-1">{{ __('financial.monthly_savings') }}</h6>
                                <h3 class="mb-0">Rp {{ number_format($monthlyIncome - $monthlyExpenses, 0, ',', '.') }}
                                </h3>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-wallet ti-md"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Budget Chart & Recommendations -->
            <div class="col-lg-8 mb-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('financial.budget_chart') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="budgetChart" height="300"></canvas>
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
                    <div class="card-body">
                        <button type="button" class="btn btn-primary w-100 mb-2" data-bs-toggle="modal"
                            data-bs-target="#incomeModal">
                            <i class="ti ti-plus me-1"></i>{{ __('financial.add_income') }}
                        </button>
                        <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal"
                            data-bs-target="#expenseModal">
                            <i class="ti ti-plus me-1"></i>{{ __('financial.add_expense') }}
                        </button>
                        <button type="button" class="btn btn-info w-100 mb-2" data-bs-toggle="modal"
                            data-bs-target="#savingsModal">
                            <i class="ti ti-target me-1"></i>{{ __('financial.add_savings_target') }}
                        </button>
                        <button type="button" class="btn btn-warning w-100 mb-2" data-bs-toggle="modal"
                            data-bs-target="#dreamAssetModal">
                            <i class="ti ti-star me-1"></i>{{ __('financial.add_dream_asset') }}
                        </button>
                        <hr>
                        <button type="button" class="btn btn-success w-100 mb-2" id="calculateZakatBtn">
                            <i class="ti ti-calculator me-1"></i>{{ __('financial.zakat.calculate_auto') }}
                        </button>
                        <a href="{{ route('member.financial-tools.download-report') }}" class="btn btn-secondary w-100">
                            <i class="ti ti-download me-1"></i>{{ __('financial.report.download') }}
                        </a>
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
                                <input type="number" class="form-control" name="gross_salary" required step="0.01">
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
                                <input type="number" class="form-control" name="kookmin_yeongeum" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.twejigeum') }}</label>
                                <input type="number" class="form-control" name="twejigeum" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.insurance') }}</label>
                                <input type="number" class="form-control" name="insurance" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.tax') }}</label>
                                <input type="number" class="form-control" name="tax" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.other_deductions') }}</label>
                                <input type="number" class="form-control" name="other_deductions" step="0.01">
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('financial.add_expense') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('member.financial-tools.store-expense') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.expense_category') }} *</label>
                            <select class="form-select" name="category" required>
                                @foreach (\App\Models\FinancialExpense::getCategories() as $key => $label)
                                    <option value="{{ $key }}">{{ __($label) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.expense_amount') }} *</label>
                            <input type="number" class="form-control" name="amount" required step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.expense_date') }} *</label>
                            <input type="date" class="form-control" name="expense_date" required
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.expense_description') }}</label>
                            <input type="text" class="form-control" name="description">
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
                            <input type="number" class="form-control" name="target_amount" required step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.current_amount') }}</label>
                            <input type="number" class="form-control" name="current_amount" step="0.01">
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
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.asset_name') }} *</label>
                            <input type="text" class="form-control" name="asset_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.estimated_cost') }} *</label>
                            <input type="number" class="form-control" name="estimated_cost" required step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.priority') }} *</label>
                            <select class="form-select" name="priority" required>
                                <option value="1">{{ __('financial.priority_levels.1') }}</option>
                                <option value="2">{{ __('financial.priority_levels.2') }}</option>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Budget Pie Chart
            const ctx = document.getElementById('budgetChart');
            const expenseData = @json($expensesByCategory);
            const categories = [];
            const amounts = [];
            const colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF'];

            expenseData.forEach((item, index) => {
                categories.push(item.category);
                amounts.push(parseFloat(item.total));
            });

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: categories.map(cat => '{{ __('financial.expense_categories.') }}' + cat),
                    datasets: [{
                        data: amounts,
                        backgroundColor: colors,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: '{{ __('financial.expense_breakdown') }}'
                        }
                    }
                }
            });

            // Calculate Zakat Button
            $('#calculateZakatBtn').on('click', function() {
                $.ajax({
                    url: '{{ route('member.financial-tools.calculate-zakat') }}',
                    type: 'GET',
                    success: function(response) {
                        let message = '';
                        if (response.is_eligible) {
                            message = '{{ __('financial.zakat.eligible') }}\n\n';
                            message += '{{ __('financial.zakat.zakat_amount') }}: Rp ' +
                                response
                                .zakat_amount.toLocaleString('id-ID');
                        } else {
                            message = '{{ __('financial.zakat.not_eligible') }}\n\n';
                            message += '{{ __('financial.zakat.remaining_to_nisab') }}: Rp ' +
                                response
                                .remaining_to_nisab.toLocaleString('id-ID');
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
