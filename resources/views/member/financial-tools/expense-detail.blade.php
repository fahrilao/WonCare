@extends('layouts.member')

@section('title', __('financial.expense_detail'))
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <div>
                <a href="{{ route('member.financial-tools.index') }}"
                    class="text-muted text-decoration-none d-inline-flex align-items-center gap-1 mb-1"
                    style="font-size:.85rem;">
                    <i class="ti tabler-arrow-left"></i> {{ __('financial.dashboard') }}
                </a>
                <h4 class="mb-0">{{ __('financial.expense_detail') }}</h4>
            </div>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#expenseModal">
                <i class="ti tabler-plus me-1"></i>{{ __('financial.add_expense') }}
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filters --}}
        <div class="card mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('member.financial-tools.expense-detail') }}"
                    class="row g-2 align-items-end">
                    <div class="col-auto">
                        <label class="form-label mb-1">{{ __('financial.year') }}</label>
                        <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                            @if ($availableYears->isEmpty())
                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            @else
                                @foreach ($availableYears as $y)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-auto">
                        <label class="form-label mb-1">{{ __('financial.month') }}</label>
                        <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">{{ __('financial.all_months') }}</option>
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <label class="form-label mb-1">{{ __('financial.expense_category') }}</label>
                        <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">{{ __('financial.all_categories') }}</option>
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}" {{ $key === $category ? 'selected' : '' }}>
                                    {{ __($label) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($month || $category)
                        <div class="col-auto">
                            <a href="{{ route('member.financial-tools.expense-detail', ['year' => $year]) }}"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="ti tabler-x me-1"></i>{{ __('financial.clear_filters') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="row mb-4">
            {{-- Category Breakdown --}}
            <div class="col-lg-5 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('financial.expense_breakdown') }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($byCategory->isEmpty())
                            <p class="text-muted text-center py-4">{{ __('financial.no_data') }}</p>
                        @else
                            <div class="mt-3">
                                @foreach ($byCategory as $cat)
                                    @php
                                        $pct = $totalExpenses > 0 ? round(($cat->total / $totalExpenses) * 100, 1) : 0;
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-label-secondary"
                                                style="min-width:24px;">{{ $cat->count }}</span>
                                            <span
                                                style="font-size:.875rem;">{{ __(\App\Models\FinancialExpense::getCategories()[$cat->category] ?? $cat->category) }}</span>
                                        </div>
                                        <div class="text-end">
                                            <span class="fw-medium">Rp {{ number_format($cat->total, 0, ',', '.') }}</span>
                                            <small class="text-muted ms-1">({{ $pct }}%)</small>
                                        </div>
                                    </div>
                                    <div class="progress mb-2" style="height:5px;">
                                        <div class="progress-bar bg-danger" style="width:{{ $pct }}%"></div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Total + quick stats --}}
            <div class="col-lg-7 mb-4">
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted mb-1" style="font-size:.8rem;">{{ __('financial.total_expenses') }}
                                </p>
                                <h4 class="mb-0 text-danger">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</h4>
                                <small class="text-muted">{{ $expenses->count() }}
                                    {{ __('financial.transactions') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <p class="text-muted mb-1" style="font-size:.8rem;">
                                    {{ __('financial.avg_per_transaction') }}</p>
                                <h4 class="mb-0">Rp
                                    {{ $expenses->count() > 0 ? number_format($totalExpenses / $expenses->count(), 0, ',', '.') : '0' }}
                                </h4>
                                <small class="text-muted">{{ __('financial.expense_category') }}:
                                    {{ $byCategory->count() }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Top category highlight --}}
                @if ($byCategory->isNotEmpty())
                    @php $top = $byCategory->first(); @endphp
                    <div class="card border-start border-danger border-3 mb-3">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">{{ __('financial.highest_category') }}</small>
                                    <h6 class="mb-0 mt-1">
                                        {{ __(\App\Models\FinancialExpense::getCategories()[$top->category] ?? $top->category) }}
                                    </h6>
                                </div>
                                <div class="text-end">
                                    <h5 class="mb-0 text-danger">Rp {{ number_format($top->total, 0, ',', '.') }}</h5>
                                    <small
                                        class="text-muted">{{ $totalExpenses > 0 ? round(($top->total / $totalExpenses) * 100, 1) : 0 }}%
                                        {{ __('financial.of_total') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Expense Table --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('financial.expense_history') }}</h5>
                <span class="badge bg-label-danger">{{ $expenses->count() }} {{ __('financial.records') }}</span>
            </div>
            <div class="card-body p-0">
                @if ($expenses->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="ti tabler-inbox ti-xl mb-2 d-block"></i>
                        {{ __('financial.no_data') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('financial.expense_date') }}</th>
                                    <th>{{ __('financial.expense_category') }}</th>
                                    <th class="text-end">{{ __('financial.expense_amount') }}</th>
                                    <th class="d-none d-md-table-cell">{{ __('financial.expense_description') }}</th>
                                    <th class="d-none d-lg-table-cell">{{ __('financial.notes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>
                                            <span class="fw-medium">{{ $expense->expense_date->format('d M Y') }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-secondary">
                                                {{ __(\App\Models\FinancialExpense::getCategories()[$expense->category] ?? $expense->category) }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold text-danger">
                                            Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted"
                                            style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            {{ $expense->description ?? '-' }}
                                        </td>
                                        <td class="d-none d-lg-table-cell text-muted"
                                            style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            {{ $expense->notes ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="2">{{ __('financial.total') }}</td>
                                    <td class="text-end text-danger">Rp {{ number_format($totalExpenses, 0, ',', '.') }}
                                    </td>
                                    <td class="d-none d-md-table-cell"></td>
                                    <td class="d-none d-lg-table-cell"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add Expense Modal --}}
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
                            @foreach (\App\Models\FinancialExpense::getCategories() as $key => $label)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __($label) }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="{{ $key }}"
                                            step="0.01" value="0" placeholder="0">
                                    </div>
                                </div>
                            @endforeach
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
@endsection
