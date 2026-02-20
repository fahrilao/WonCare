@extends('layouts.member')

@section('title', __('financial.income_detail'))
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <div>
                <a href="{{ route('member.financial-tools.index') }}" class="text-muted text-decoration-none d-inline-flex align-items-center gap-1 mb-1" style="font-size:.85rem;">
                    <i class="ti tabler-arrow-left"></i> {{ __('financial.dashboard') }}
                </a>
                <h4 class="mb-0">{{ __('financial.income_detail') }}</h4>
            </div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#incomeModal">
                <i class="ti tabler-plus me-1"></i>{{ __('financial.add_income') }}
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
                <form method="GET" action="{{ route('member.financial-tools.income-detail') }}" class="row g-2 align-items-end">
                    <div class="col-auto">
                        <label class="form-label mb-1">{{ __('financial.year') }}</label>
                        <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                            @if ($availableYears->isEmpty())
                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            @else
                                @foreach ($availableYears as $y)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
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
                </form>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1" style="font-size:.8rem;">{{ __('financial.total_gross') }}</p>
                                <h4 class="mb-0 text-body">Rp {{ number_format($totalGross, 0, ',', '.') }}</h4>
                            </div>
                            <span class="avatar-initial rounded bg-label-warning" style="width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="ti tabler-cash ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1" style="font-size:.8rem;">{{ __('financial.total_deductions') }}</p>
                                <h4 class="mb-0 text-danger">Rp {{ number_format($totalDeductions, 0, ',', '.') }}</h4>
                            </div>
                            <span class="avatar-initial rounded bg-label-danger" style="width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="ti tabler-minus ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1" style="font-size:.8rem;">{{ __('financial.net_salary') }}</p>
                                <h4 class="mb-0 text-success">Rp {{ number_format($totalNet, 0, ',', '.') }}</h4>
                            </div>
                            <span class="avatar-initial rounded bg-label-success" style="width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="ti tabler-trending-up ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Income Table --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('financial.income_history') }}</h5>
                <span class="badge bg-label-primary">{{ $incomes->count() }} {{ __('financial.records') }}</span>
            </div>
            <div class="card-body p-0">
                @if ($incomes->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="ti tabler-inbox ti-xl mb-2 d-block"></i>
                        {{ __('financial.no_data') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('financial.income_date') }}</th>
                                    <th class="text-end">{{ __('financial.gross_salary') }}</th>
                                    <th class="text-end d-none d-md-table-cell">{{ __('financial.kookmin_yeongeum') }}</th>
                                    <th class="text-end d-none d-md-table-cell">{{ __('financial.twejigeum') }}</th>
                                    <th class="text-end d-none d-lg-table-cell">{{ __('financial.insurance') }}</th>
                                    <th class="text-end d-none d-lg-table-cell">{{ __('financial.tax') }}</th>
                                    <th class="text-end d-none d-lg-table-cell">{{ __('financial.other_deductions') }}</th>
                                    <th class="text-end">{{ __('financial.net_salary') }}</th>
                                    <th class="text-muted d-none d-md-table-cell">{{ __('financial.notes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($incomes as $income)
                                    <tr>
                                        <td>
                                            <span class="fw-medium">{{ $income->income_date->format('d M Y') }}</span>
                                        </td>
                                        <td class="text-end">Rp {{ number_format($income->gross_salary, 0, ',', '.') }}</td>
                                        <td class="text-end d-none d-md-table-cell text-muted">
                                            {{ $income->kookmin_yeongeum > 0 ? 'Rp '.number_format($income->kookmin_yeongeum, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-end d-none d-md-table-cell text-muted">
                                            {{ $income->twejigeum > 0 ? 'Rp '.number_format($income->twejigeum, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-end d-none d-lg-table-cell text-muted">
                                            {{ $income->insurance > 0 ? 'Rp '.number_format($income->insurance, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-end d-none d-lg-table-cell text-muted">
                                            {{ $income->tax > 0 ? 'Rp '.number_format($income->tax, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-end d-none d-lg-table-cell text-muted">
                                            {{ $income->other_deductions > 0 ? 'Rp '.number_format($income->other_deductions, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-end fw-bold text-success">
                                            Rp {{ number_format($income->net_salary, 0, ',', '.') }}
                                        </td>
                                        <td class="text-muted d-none d-md-table-cell" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            {{ $income->notes ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td>{{ __('financial.total') }}</td>
                                    <td class="text-end">Rp {{ number_format($totalGross, 0, ',', '.') }}</td>
                                    <td class="d-none d-md-table-cell"></td>
                                    <td class="d-none d-md-table-cell"></td>
                                    <td class="d-none d-lg-table-cell"></td>
                                    <td class="d-none d-lg-table-cell"></td>
                                    <td class="d-none d-lg-table-cell"></td>
                                    <td class="text-end text-success">Rp {{ number_format($totalNet, 0, ',', '.') }}</td>
                                    <td class="d-none d-md-table-cell"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add Income Modal (reused from index) --}}
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
                                    <input type="number" class="form-control" name="gross_salary" required step="0.01" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.income_date') }} *</label>
                                <input type="date" class="form-control" name="income_date" required value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <h6 class="mb-3">{{ __('financial.total_deductions') }}</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.kookmin_yeongeum') }}</label>
                                <div class="input-group"><span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="kookmin_yeongeum" step="0.01" value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.twejigeum') }}</label>
                                <div class="input-group"><span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="twejigeum" step="0.01" value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.insurance') }}</label>
                                <div class="input-group"><span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="insurance" step="0.01" value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.tax') }}</label>
                                <div class="input-group"><span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="tax" step="0.01" value="0" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('financial.other_deductions') }}</label>
                                <div class="input-group"><span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="other_deductions" step="0.01" value="0" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('financial.notes') }}</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
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
