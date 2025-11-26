@extends('layouts.admin')

@section('title', 'Edit Currency Setting')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="ti tabler-edit me-2"></i>
                Edit Currency Setting
            </h3>
            <a href="{{ route('admin.currency-settings.index') }}" class="btn btn-secondary">
                <i class="ti tabler-arrow-left me-1"></i>
                Back
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.currency-settings.update', $currencySetting) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Currency Code</label>
                                <input type="text" class="form-control" value="{{ $currencySetting->currency_code }}"
                                    readonly>
                                <small class="text-muted">Currency code cannot be changed</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Currency Name <span class="text-danger">*</span></label>
                                <input type="text" name="currency_name"
                                    class="form-control @error('currency_name') is-invalid @enderror"
                                    value="{{ old('currency_name', $currencySetting->currency_name) }}" required>
                                @error('currency_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Currency Symbol <span class="text-danger">*</span></label>
                                <input type="text" name="currency_symbol"
                                    class="form-control @error('currency_symbol') is-invalid @enderror"
                                    value="{{ old('currency_symbol', $currencySetting->currency_symbol) }}" required
                                    maxlength="10">
                                <small class="text-muted">Example: Rp, ₩, $, €</small>
                                @error('currency_symbol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Exchange Rate to IDR <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">1 {{ $currencySetting->currency_code }} =</span>
                                    <input type="number" name="exchange_rate_to_idr"
                                        class="form-control @error('exchange_rate_to_idr') is-invalid @enderror"
                                        value="{{ old('exchange_rate_to_idr', $currencySetting->exchange_rate_to_idr) }}"
                                        min="0" step="0.0001" required
                                        {{ $currencySetting->is_base_currency ? 'readonly' : '' }}>
                                    <span class="input-group-text">IDR</span>
                                </div>
                                @if ($currencySetting->is_base_currency)
                                    <small class="text-warning">
                                        <i class="ti tabler-lock me-1"></i>
                                        Base currency exchange rate is locked at 1.0000
                                    </small>
                                @else
                                    <small class="text-muted">
                                        How much 1 {{ $currencySetting->currency_code }} equals in Indonesian Rupiah
                                    </small>
                                @endif
                                @error('exchange_rate_to_idr')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $currencySetting->description) }}</textarea>
                                <small class="text-muted">Optional notes about this currency</small>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                        {{ old('is_active', $currencySetting->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                                <small class="text-muted">If inactive, this currency will not be available for
                                    selection</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti tabler-device-floppy me-1"></i>
                                    Update Currency
                                </button>
                                <a href="{{ route('admin.currency-settings.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti tabler-info-circle me-2"></i>Currency Information</h6>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Code:</dt>
                            <dd class="col-sm-7">
                                <span class="badge bg-primary">{{ $currencySetting->currency_code }}</span>
                            </dd>

                            <dt class="col-sm-5">Type:</dt>
                            <dd class="col-sm-7">
                                @if ($currencySetting->is_base_currency)
                                    <span class="badge bg-warning">
                                        <i class="ti tabler-star me-1"></i>Base Currency
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark">Secondary</span>
                                @endif
                            </dd>

                            <dt class="col-sm-5">Created:</dt>
                            <dd class="col-sm-7">{{ $currencySetting->created_at->format('d M Y') }}</dd>

                            <dt class="col-sm-5">Updated:</dt>
                            <dd class="col-sm-7">{{ $currencySetting->updated_at->format('d M Y') }}</dd>

                            <dt class="col-sm-5">Status:</dt>
                            <dd class="col-sm-7">
                                @if ($currencySetting->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti tabler-help me-2"></i>Guidelines</h6>
                        <ul class="small mb-0">
                            <li>Update exchange rates regularly to reflect current market rates</li>
                            <li>Exchange rate represents: 1 {{ $currencySetting->currency_code }} = X IDR</li>
                            <li>Base currency (IDR) always has rate of 1.0000</li>
                            <li>Used in Zakat calculator for currency conversion</li>
                            <li>Used in donation campaigns to show progress in multiple currencies</li>
                            <li>Inactive currencies won't appear in selection options</li>
                        </ul>
                    </div>
                </div>

                @if (!$currencySetting->is_base_currency)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="mb-3"><i class="ti tabler-calculator me-2"></i>Conversion Examples</h6>
                            <div class="small">
                                <p class="mb-2">
                                    <strong>{{ $currencySetting->currency_symbol }} 1,000</strong> =
                                    Rp {{ number_format($currencySetting->exchange_rate_to_idr * 1000, 0, ',', '.') }}
                                </p>
                                <p class="mb-2">
                                    <strong>{{ $currencySetting->currency_symbol }} 10,000</strong> =
                                    Rp {{ number_format($currencySetting->exchange_rate_to_idr * 10000, 0, ',', '.') }}
                                </p>
                                <p class="mb-0">
                                    <strong>{{ $currencySetting->currency_symbol }} 100,000</strong> =
                                    Rp {{ number_format($currencySetting->exchange_rate_to_idr * 100000, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
