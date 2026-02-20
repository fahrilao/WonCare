@extends('layouts.member')

@section('title', __('zakat.calculator'))
@section('body_class', 'member-modern')

@section('content')
    <div class="page-animate">
        {{-- Hero --}}
        <div class="zakat-hero mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="zakat-hero-icon">
                    <i class="icon-base ti tabler-calculator icon-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">{{ __('zakat.calculator') }}</h4>
                    <div class="text-white" style="opacity:.8;font-size:.9rem;">{{ __('zakat.calculator_description') }}</div>
                </div>
            </div>
        </div>

        {{-- Pill Tabs --}}
        <div class="zakat-tabs mb-4">
            <ul class="zakat-nav-pills" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="zakat-tab-btn active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#mal" aria-controls="mal" aria-selected="true">
                        <i class="icon-base ti tabler-coin"></i>
                        <span>{{ __('zakat.zakat_mal') }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="zakat-tab-btn" role="tab" data-bs-toggle="tab"
                        data-bs-target="#fitrah" aria-controls="fitrah" aria-selected="false">
                        <i class="icon-base ti tabler-users"></i>
                        <span>{{ __('zakat.zakat_fitrah') }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="zakat-tab-btn" role="tab" data-bs-toggle="tab"
                        data-bs-target="#profesi" aria-controls="profesi" aria-selected="false">
                        <i class="icon-base ti tabler-briefcase"></i>
                        <span>{{ __('zakat.zakat_profesi') }}</span>
                    </button>
                </li>
            </ul>
        </div>

        {{-- Tab Content --}}
        <div class="tab-content">
            {{-- Zakat Mal --}}
            <div class="tab-pane fade show active" id="mal" role="tabpanel">
                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div class="card zakat-card mb-4">
                            <div class="card-body">
                                <div class="zakat-section-label mb-3">
                                    <span class="zakat-section-icon"><i class="ti tabler-currency"></i></span>
                                    {{ __('zakat.select_currency') }}
                                </div>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach ($currencies as $index => $currency)
                                        <label class="zakat-currency-pill {{ $index === 0 ? 'active' : '' }}">
                                            <input type="radio" name="currency"
                                                id="currency{{ $currency->currency_code }}"
                                                value="{{ $currency->currency_code }}"
                                                data-symbol="{{ $currency->currency_symbol }}"
                                                data-rate="{{ $currency->exchange_rate_to_idr }}"
                                                {{ $index === 0 ? 'checked' : '' }} class="d-none">
                                            <strong>{{ $currency->currency_symbol }}</strong>
                                            <span class="ms-1"
                                                style="font-size:.8rem;opacity:.7;">{{ $currency->currency_code }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="zakat-info-box mt-3">
                                    <i class="ti tabler-info-circle"></i>
                                    <span id="exchangeRateInfo"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card zakat-card">
                            <div class="card-body">
                                <div class="zakat-section-label mb-1">
                                    <span class="zakat-section-icon"><i class="ti tabler-coin"></i></span>
                                    {{ __('zakat.calculate_zakat_mal') }}
                                </div>
                                <p class="text-muted mb-4" style="font-size:.875rem;padding-left:2.75rem;">
                                    {{ __('zakat.mal_description') }}</p>
                                <form id="zakatMalForm">
                                    <div class="row g-3">
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label">{{ __('zakat.gold_owned') }}
                                                ({{ __('zakat.grams') }})</label>
                                            <input type="number" class="form-control" id="goldGrams" min="0"
                                                step="0.01" value="0" placeholder="{{ __('zakat.enter_amount') }}">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label">{{ __('zakat.silver_owned') }}
                                                ({{ __('zakat.grams') }})</label>
                                            <input type="number" class="form-control" id="silverGrams" min="0"
                                                step="0.01" value="0" placeholder="{{ __('zakat.enter_amount') }}">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label">{{ __('zakat.cash_savings') }}</label>
                                            <input type="number" class="form-control" id="cash" min="0"
                                                step="1000" value="0"
                                                placeholder="{{ __('zakat.enter_amount') }}">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label">{{ __('zakat.business_assets') }}</label>
                                            <input type="number" class="form-control" id="assets" min="0"
                                                step="1000" value="0"
                                                placeholder="{{ __('zakat.enter_amount') }}">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label class="form-label">{{ __('zakat.debts') }}</label>
                                            <input type="number" class="form-control" id="debts" min="0"
                                                step="1000" value="0"
                                                placeholder="{{ __('zakat.enter_amount') }}">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="button" class="btn-calculate" onclick="calculateZakatMal()">
                                            <i class="ti tabler-calculator"></i>
                                            {{ __('zakat.calculate') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card result-card">
                            <div class="card-body">
                                <div class="result-header">
                                    <i class="ti tabler-chart-bar"></i>
                                    {{ __('zakat.calculation_result') }}
                                </div>
                                <div id="malResult">
                                    <p class="text-muted mb-0" style="font-size:.875rem;">
                                        {{ __('zakat.enter_details_calculate') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Zakat Fitrah --}}
            <div class="tab-pane fade" id="fitrah" role="tabpanel">
                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div class="card zakat-card">
                            <div class="card-body">
                                <div class="zakat-section-label mb-1">
                                    <span class="zakat-section-icon"><i class="ti tabler-users"></i></span>
                                    {{ __('zakat.calculate_zakat_fitrah') }}
                                </div>
                                <p class="text-muted mb-4" style="font-size:.875rem;padding-left:2.75rem;">
                                    {{ __('zakat.fitrah_description') }}</p>
                                <form id="zakatFitrahForm">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('zakat.number_of_people') }}</label>
                                        <input type="number" class="form-control" id="numPeople" min="1"
                                            value="1" placeholder="{{ __('zakat.enter_number') }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">{{ __('zakat.payment_type') }}</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="fitrahType"
                                                    id="fitrahMoney" value="money" checked>
                                                <label class="form-check-label"
                                                    for="fitrahMoney">{{ __('zakat.money') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="fitrahType"
                                                    id="fitrahRice" value="rice">
                                                <label class="form-check-label"
                                                    for="fitrahRice">{{ __('zakat.rice') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-calculate" onclick="calculateZakatFitrah()">
                                        <i class="ti tabler-calculator"></i>
                                        {{ __('zakat.calculate') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card result-card">
                            <div class="card-body">
                                <div class="result-header">
                                    <i class="ti tabler-chart-bar"></i>
                                    {{ __('zakat.calculation_result') }}
                                </div>
                                <div id="fitrahResult">
                                    <p class="text-muted mb-0" style="font-size:.875rem;">
                                        {{ __('zakat.enter_details_calculate') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Zakat Profesi --}}
            <div class="tab-pane fade" id="profesi" role="tabpanel">
                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div class="card zakat-card">
                            <div class="card-body">
                                <div class="zakat-section-label mb-1">
                                    <span class="zakat-section-icon"><i class="ti tabler-briefcase"></i></span>
                                    {{ __('zakat.calculate_zakat_profesi') }}
                                </div>
                                <p class="text-muted mb-4" style="font-size:.875rem;padding-left:2.75rem;">
                                    {{ __('zakat.profesi_description') }}</p>
                                <form id="zakatProfesiForm">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('zakat.period') }}</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="profesiPeriod"
                                                    id="profesiMonthly" value="monthly" checked>
                                                <label class="form-check-label"
                                                    for="profesiMonthly">{{ __('zakat.monthly') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="profesiPeriod"
                                                    id="profesiAnnual" value="annual">
                                                <label class="form-check-label"
                                                    for="profesiAnnual">{{ __('zakat.annual') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">{{ __('zakat.income') }}</label>
                                        <input type="number" class="form-control" id="income" min="0"
                                            step="100000" value="0" placeholder="{{ __('zakat.enter_amount') }}">
                                    </div>
                                    <button type="button" class="btn-calculate" onclick="calculateZakatProfesi()">
                                        <i class="ti tabler-calculator"></i>
                                        {{ __('zakat.calculate') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card result-card">
                            <div class="card-body">
                                <div class="result-header">
                                    <i class="ti tabler-chart-bar"></i>
                                    {{ __('zakat.calculation_result') }}
                                </div>
                                <div id="profesiResult">
                                    <p class="text-muted mb-0" style="font-size:.875rem;">
                                        {{ __('zakat.enter_details_calculate') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Configuration Card --}}
        <div class="card config-card mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ti tabler-settings me-2"></i>
                    {{ __('zakat.current_configuration') }}
                </h6>
                <p class="text-muted small mb-0 mt-1">{{ __('zakat.configuration_info') }}</p>
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="config-item">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="ti tabler-coin text-warning me-2"></i>
                                    <small class="text-muted">{{ __('zakat.gold_price') }}</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-link p-0 edit-config" data-field="gold"
                                    title="Edit">
                                    <i class="ti tabler-edit"></i>
                                </button>
                            </div>
                            <div class="config-display" id="goldPriceDisplay">
                                <h6 class="mb-0" id="displayGoldPrice"></h6>
                            </div>
                            <div class="config-edit d-none" id="goldPriceEdit">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="goldPriceSymbol">Rp</span>
                                    <input type="number" class="form-control" id="editGoldPrice" min="0"
                                        step="1000">
                                </div>
                            </div>
                            <small class="text-muted">{{ __('zakat.per_gram') }}</small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="config-item">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="ti tabler-coin text-secondary me-2"></i>
                                    <small class="text-muted">{{ __('zakat.silver_price') }}</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-link p-0 edit-config" data-field="silver"
                                    title="Edit">
                                    <i class="ti tabler-edit"></i>
                                </button>
                            </div>
                            <div class="config-display" id="silverPriceDisplay">
                                <h6 class="mb-0" id="displaySilverPrice"></h6>
                            </div>
                            <div class="config-edit d-none" id="silverPriceEdit">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="silverPriceSymbol">Rp</span>
                                    <input type="number" class="form-control" id="editSilverPrice" min="0"
                                        step="1000">
                                </div>
                            </div>
                            <small class="text-muted">{{ __('zakat.per_gram') }}</small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="config-item">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti tabler-scale text-warning me-2"></i>
                                <small class="text-muted">{{ __('zakat.gold_nisab') }}</small>
                            </div>
                            <h6 class="mb-0">{{ number_format($goldNisab, 0, ',', '.') }}
                                {{ __('zakat.grams') }}</h6>
                            <small class="text-muted" id="displayGoldNisabValue"></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="config-item">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti tabler-scale text-secondary me-2"></i>
                                <small class="text-muted">{{ __('zakat.silver_nisab') }}</small>
                            </div>
                            <h6 class="mb-0">{{ number_format($silverNisab, 0, ',', '.') }}
                                {{ __('zakat.grams') }}</h6>
                            <small class="text-muted" id="displaySilverNisabValue"></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="config-item">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="ti tabler-grain text-success me-2"></i>
                                    <small class="text-muted">{{ __('zakat.rice_price') }}</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-link p-0 edit-config" data-field="rice"
                                    title="Edit">
                                    <i class="ti tabler-edit"></i>
                                </button>
                            </div>
                            <div class="config-display" id="ricePriceDisplay">
                                <h6 class="mb-0" id="displayRicePrice"></h6>
                            </div>
                            <div class="config-edit d-none" id="ricePriceEdit">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text" id="ricePriceSymbol">Rp</span>
                                    <input type="number" class="form-control" id="editRicePrice" min="0"
                                        step="1000">
                                </div>
                            </div>
                            <small class="text-muted">{{ __('zakat.per_kg') }}</small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="config-item">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti tabler-users me-2" style="color: #1a6b47;"></i>
                                <small class="text-muted">{{ __('zakat.fitrah_per_person') }}</small>
                            </div>
                            <h6 class="mb-0">{{ number_format($fitrahAmount, 1) }} kg</h6>
                            <small class="text-muted" id="displayFitrahValue"></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="config-item">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti tabler-percentage me-2" style="color: #1a6b47;"></i>
                                <small class="text-muted">{{ __('zakat.zakat_rate') }}</small>
                            </div>
                            <h6 class="mb-0">{{ number_format($zakatPercentage, 1) }}%</h6>
                            <small class="text-muted">{{ __('zakat.standard_rate') }}</small>
                        </div>
                    </div>
                </div>
                <div class="zakat-info-box mt-3">
                    <i class="ti tabler-info-circle"></i>
                    <span>{{ __('zakat.configuration_note') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* ── Hero ── */
        .zakat-hero {
            background: linear-gradient(135deg, #1a6b47 0%, #2d8f5f 60%, #c4a962 100%);
            border-radius: 1.25rem;
            padding: 1.75rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .zakat-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.10) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.4;
            pointer-events: none;
        }

        .zakat-hero>* {
            position: relative;
            z-index: 1;
        }

        .zakat-hero-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        /* ── Pill Tabs ── */
        .zakat-tabs {
            background: var(--bs-body-bg, #fff);
            border: 1px solid var(--bs-border-color, #e8e8e8);
            border-radius: 14px;
            padding: 0.4rem;
            display: inline-flex;
        }

        .zakat-nav-pills {
            display: flex;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .zakat-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.1rem;
            border: none;
            border-radius: 10px;
            background: transparent;
            color: var(--bs-secondary-color, #6c757d);
            font-weight: 500;
            font-size: .875rem;
            cursor: pointer;
            transition: background 150ms ease, color 150ms ease;
        }

        .zakat-tab-btn:hover {
            background: rgba(26, 107, 71, 0.07);
            color: #1a6b47;
        }

        .zakat-tab-btn.active {
            background: #1a6b47;
            color: #fff;
            box-shadow: 0 2px 8px rgba(26, 107, 71, 0.30);
        }

        /* ── Cards ── */
        .zakat-card {
            border-radius: 16px;
        }

        .zakat-card .card-body {
            padding: 1.5rem;
        }

        /* ── Section Label ── */
        .zakat-section-label {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 600;
            font-size: 1rem;
            color: var(--bs-body-color, #1a1a1a);
        }

        .zakat-section-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(26, 107, 71, 0.12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #1a6b47;
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* ── Currency Pills ── */
        .zakat-currency-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.45rem 1rem;
            border: 1.5px solid var(--bs-border-color, #dee2e6);
            border-radius: 999px;
            cursor: pointer;
            font-size: .875rem;
            transition: all 150ms ease;
            color: var(--bs-body-color, #333);
        }

        .zakat-currency-pill:hover {
            border-color: #1a6b47;
        }

        .zakat-currency-pill.active {
            border-color: #1a6b47;
            background: rgba(26, 107, 71, 0.08);
            color: #1a6b47;
        }

        /* ── Info Box ── */
        .zakat-info-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(26, 107, 71, 0.08);
            border: 1px solid rgba(26, 107, 71, 0.18);
            border-radius: 10px;
            padding: 0.65rem 1rem;
            color: #1a6b47;
            font-size: .85rem;
        }

        /* ── Form ── */
        .form-label {
            font-weight: 500;
            margin-bottom: 0.4rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1a6b47;
            box-shadow: 0 0 0 3px rgba(26, 107, 71, 0.14);
        }

        .form-check-input:checked {
            background-color: #1a6b47;
            border-color: #1a6b47;
        }

        /* ── Buttons ── */
        .btn-calculate {
            background: linear-gradient(135deg, #1a6b47, #2d8f5f);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-calculate:hover {
            background: linear-gradient(135deg, #155a3c, #267a50);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-pay-zakat {
            background: linear-gradient(135deg, #1a6b47, #2d8f5f);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.7rem 1.25rem;
            font-weight: 600;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-pay-zakat:hover {
            background: linear-gradient(135deg, #155a3c, #267a50);
            color: #fff;
            transform: translateY(-1px);
        }

        /* ── Result Card ── */
        .result-card {
            background: linear-gradient(135deg, rgba(26, 107, 71, 0.05), rgba(45, 143, 95, 0.08));
            border: 1px solid rgba(26, 107, 71, 0.15) !important;
            border-radius: 16px;
            position: sticky;
            top: 80px;
        }

        .result-card .card-body {
            padding: 1.5rem;
        }

        .result-card .result-header {
            font-weight: 700;
            font-size: 1rem;
            color: #1a6b47;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .result-card .result-header i {
            font-size: 1.1rem;
        }

        /* ── Alert variants ── */
        .alert-zakat-info {
            background: rgba(26, 107, 71, 0.08);
            border: 1px solid rgba(26, 107, 71, 0.18);
            border-radius: 10px;
            color: #1a6b47;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: .875rem;
        }

        .alert-zakat-success {
            background: rgba(26, 107, 71, 0.12);
            border: 1px solid rgba(26, 107, 71, 0.25);
            border-radius: 10px;
            color: #155a3c;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: .875rem;
        }

        /* ── Config Card ── */
        .config-card {
            border-radius: 16px;
            overflow: hidden;
        }

        .config-card .card-header {
            background: linear-gradient(135deg, rgba(26, 107, 71, 0.06), rgba(45, 143, 95, 0.10));
            border-bottom: 1px solid rgba(26, 107, 71, 0.10);
            padding: 1rem 1.5rem;
        }

        .config-card .card-header h6 {
            color: #1a6b47;
            font-weight: 700;
            margin: 0;
        }

        .config-item {
            border: 1px solid var(--bs-border-color, #e8e8e8);
            border-radius: 12px;
            padding: 1rem;
            height: 100%;
            transition: border-color 150ms ease, background 150ms ease;
        }

        .config-item:hover {
            border-color: rgba(26, 107, 71, 0.30);
            background: rgba(26, 107, 71, 0.02);
        }

        .config-item h6 {
            color: #1a6b47;
            font-weight: 600;
        }

        .edit-config {
            color: #1a6b47;
        }

        .edit-config:hover {
            color: #155a3c;
        }

        /* ── Dark Mode ── */
        [data-bs-theme="dark"] .zakat-tabs {
            background: var(--bs-body-bg);
            border-color: var(--bs-border-color);
        }

        [data-bs-theme="dark"] .zakat-tab-btn {
            color: rgba(226, 232, 240, 0.55);
        }

        [data-bs-theme="dark"] .zakat-tab-btn:hover {
            background: rgba(16, 185, 129, 0.10);
            color: #34d399;
        }

        [data-bs-theme="dark"] .zakat-tab-btn.active {
            background: #1a6b47;
            color: #fff;
        }

        [data-bs-theme="dark"] .zakat-section-label {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .zakat-section-icon {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        [data-bs-theme="dark"] .zakat-currency-pill {
            color: #cbd5e1;
            border-color: rgba(255, 255, 255, 0.12);
        }

        [data-bs-theme="dark"] .zakat-currency-pill:hover {
            border-color: #10b981;
        }

        [data-bs-theme="dark"] .zakat-currency-pill.active {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
        }

        [data-bs-theme="dark"] .zakat-info-box {
            background: rgba(16, 185, 129, 0.10);
            border-color: rgba(16, 185, 129, 0.20);
            color: #34d399;
        }

        [data-bs-theme="dark"] .form-label {
            color: #cbd5e1;
        }

        [data-bs-theme="dark"] .result-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.07), rgba(16, 185, 129, 0.12));
            border-color: rgba(16, 185, 129, 0.20) !important;
        }

        [data-bs-theme="dark"] .result-card .result-header {
            color: #34d399;
        }

        [data-bs-theme="dark"] .alert-zakat-info {
            background: rgba(16, 185, 129, 0.10);
            border-color: rgba(16, 185, 129, 0.20);
            color: #34d399;
        }

        [data-bs-theme="dark"] .alert-zakat-success {
            background: rgba(16, 185, 129, 0.14);
            border-color: rgba(16, 185, 129, 0.28);
            color: #6ee7b7;
        }

        [data-bs-theme="dark"] .config-card .card-header {
            background: rgba(16, 185, 129, 0.08);
            border-color: rgba(16, 185, 129, 0.12);
        }

        [data-bs-theme="dark"] .config-card .card-header h6 {
            color: #34d399;
        }

        [data-bs-theme="dark"] .config-item {
            border-color: rgba(255, 255, 255, 0.08);
        }

        [data-bs-theme="dark"] .config-item:hover {
            border-color: rgba(16, 185, 129, 0.30);
            background: rgba(16, 185, 129, 0.05);
        }

        [data-bs-theme="dark"] .config-item h6 {
            color: #34d399;
        }

        [data-bs-theme="dark"] .edit-config {
            color: #34d399;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Zakat settings from backend (let so they can be updated by user)
        let GOLD_PRICE = {{ $goldPrice }};
        let SILVER_PRICE = {{ $silverPrice }};
        const GOLD_NISAB = {{ $goldNisab }};
        const SILVER_NISAB = {{ $silverNisab }};
        const ZAKAT_PERCENTAGE = {{ $zakatPercentage }};
        let RICE_PRICE = {{ $ricePrice }};
        const FITRAH_AMOUNT = {{ $fitrahAmount }};

        // Store calculated zakat amount for payment
        let calculatedZakat = {
            amount: 0,
            type: '',
            details: ''
        };

        // Currency state
        let selectedCurrency = '{{ $currencies->first()->currency_code ?? 'IDR' }}';
        let selectedSymbol = '{{ $currencies->first()->currency_symbol ?? 'Rp' }}';
        let selectedRate = {{ $currencies->first()->exchange_rate_to_idr ?? 1 }};

        function formatCurrency(amount) {
            // Convert from IDR to selected currency
            const convertedAmount = amount / selectedRate;
            return selectedSymbol + ' ' + Math.round(convertedAmount).toLocaleString();
        }

        function redirectToZakatPayment(amount, type, details) {
            // Convert amount to selected currency before redirecting
            const convertedAmount = amount / selectedRate;

            // Redirect directly to Zakat checkout with currency
            window.location.href = '/zakat/checkout?amount=' + Math.round(convertedAmount) +
                '&type=' + encodeURIComponent(type) +
                '&note=' + encodeURIComponent('Zakat ' + type + ' - ' + details) +
                '&currency=' + selectedCurrency;
        }

        // Update configuration display based on selected currency
        function updateConfigurationDisplay() {
            // Convert and display gold price
            const goldPriceConverted = GOLD_PRICE / selectedRate;
            document.getElementById('displayGoldPrice').textContent = selectedSymbol + ' ' + Math.round(goldPriceConverted)
                .toLocaleString();

            // Convert and display silver price
            const silverPriceConverted = SILVER_PRICE / selectedRate;
            document.getElementById('displaySilverPrice').textContent = selectedSymbol + ' ' + Math.round(
                silverPriceConverted).toLocaleString();

            // Convert and display gold nisab value
            const goldNisabValue = (GOLD_NISAB * GOLD_PRICE) / selectedRate;
            document.getElementById('displayGoldNisabValue').textContent = selectedSymbol + ' ' + Math.round(goldNisabValue)
                .toLocaleString();

            // Convert and display silver nisab value
            const silverNisabValue = (SILVER_NISAB * SILVER_PRICE) / selectedRate;
            document.getElementById('displaySilverNisabValue').textContent = selectedSymbol + ' ' + Math.round(
                silverNisabValue).toLocaleString();

            // Convert and display rice price
            const ricePriceConverted = RICE_PRICE / selectedRate;
            document.getElementById('displayRicePrice').textContent = selectedSymbol + ' ' + Math.round(ricePriceConverted)
                .toLocaleString();

            // Convert and display fitrah value
            const fitrahValue = (FITRAH_AMOUNT * RICE_PRICE) / selectedRate;
            document.getElementById('displayFitrahValue').textContent = selectedSymbol + ' ' + Math.round(fitrahValue)
                .toLocaleString();
        }

        // Handle currency change
        function updateCurrency() {
            const selectedRadio = document.querySelector('input[name="currency"]:checked');
            selectedCurrency = selectedRadio.value;
            selectedSymbol = selectedRadio.getAttribute('data-symbol');
            selectedRate = parseFloat(selectedRadio.getAttribute('data-rate'));

            // Update exchange rate info
            const exchangeRateInfo = document.getElementById('exchangeRateInfo');
            if (selectedRate === 1) {
                exchangeRateInfo.textContent = selectedCurrency + ' is the base currency';
            } else {
                exchangeRateInfo.textContent = '1 ' + selectedCurrency + ' = ' + selectedRate.toFixed(2) +
                    ' IDR';
            }

            // Update configuration display
            updateConfigurationDisplay();

            // Recalculate if there are results
            const malResult = document.getElementById('malResult');
            const fitrahResult = document.getElementById('fitrahResult');
            const profesiResult = document.getElementById('profesiResult');

            if (malResult && malResult.innerHTML.includes('Zakat Amount')) {
                calculateZakatMal();
            }
            if (fitrahResult && fitrahResult.innerHTML.includes('Total:')) {
                calculateZakatFitrah();
            }
            if (profesiResult && profesiResult.innerHTML.includes('Zakat Amount')) {
                calculateZakatProfesi();
            }
        }

        // Handle configuration editing
        document.addEventListener('click', function(e) {
            // Edit button clicked
            if (e.target.closest('.edit-config')) {
                const btn = e.target.closest('.edit-config');
                const field = btn.getAttribute('data-field');

                // Check if we're saving
                if (btn.getAttribute('data-action') === 'save') {
                    const displayDiv = document.getElementById(field + 'PriceDisplay');
                    const editDiv = document.getElementById(field + 'PriceEdit');
                    const editInput = document.getElementById('edit' + field.charAt(0).toUpperCase() + field.slice(
                        1) + 'Price');

                    // Get new value and convert to IDR
                    const newValue = parseFloat(editInput.value) || 0;
                    const newValueIDR = newValue * selectedRate;

                    // Update the mutable price variables
                    if (field === 'gold') {
                        GOLD_PRICE = newValueIDR;
                    } else if (field === 'silver') {
                        SILVER_PRICE = newValueIDR;
                    } else if (field === 'rice') {
                        RICE_PRICE = newValueIDR;
                    }

                    // Update display
                    updateConfigurationDisplay();

                    // Toggle display
                    editDiv.classList.add('d-none');
                    displayDiv.classList.remove('d-none');

                    // Change button back to edit
                    btn.innerHTML = '<i class="ti tabler-edit"></i>';
                    btn.classList.remove('text-success');
                    btn.removeAttribute('data-action');

                    // Recalculate if there are results
                    const malResult = document.getElementById('malResult');
                    const fitrahResult = document.getElementById('fitrahResult');
                    const profesiResult = document.getElementById('profesiResult');

                    if (malResult && malResult.innerHTML.includes('Zakat Amount')) {
                        calculateZakatMal();
                    }
                    if (fitrahResult && fitrahResult.innerHTML.includes('Total:')) {
                        calculateZakatFitrah();
                    }
                    if (profesiResult && profesiResult.innerHTML.includes('Zakat Amount')) {
                        calculateZakatProfesi();
                    }
                } else {
                    // Start editing
                    const displayDiv = document.getElementById(field + 'PriceDisplay');
                    const editDiv = document.getElementById(field + 'PriceEdit');
                    const editInput = document.getElementById('edit' + field.charAt(0).toUpperCase() + field.slice(
                        1) + 'Price');

                    // Get current value in IDR
                    let currentValue;
                    if (field === 'gold') currentValue = GOLD_PRICE;
                    else if (field === 'silver') currentValue = SILVER_PRICE;
                    else if (field === 'rice') currentValue = RICE_PRICE;

                    // Convert to selected currency
                    const convertedValue = Math.round(currentValue / selectedRate);
                    editInput.value = convertedValue;

                    // Toggle display
                    displayDiv.classList.add('d-none');
                    editDiv.classList.remove('d-none');
                    editInput.focus();

                    // Change button to save
                    btn.innerHTML = '<i class="ti tabler-check"></i>';
                    btn.classList.add('text-success');
                    btn.setAttribute('data-action', 'save');
                }
            }
        });

        // Handle Enter key in edit inputs
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.target.matches('[id^="edit"]')) {
                const field = e.target.id.replace('edit', '').replace('Price', '').toLowerCase();
                const saveBtn = document.querySelector('.edit-config[data-field="' + field +
                    '"][data-action="save"]');
                if (saveBtn) saveBtn.click();
            }
        });

        // Add event listeners for currency change
        document.addEventListener('DOMContentLoaded', function() {
            // Define updateSymbols first so it can be used in handlers below
            function updateSymbols() {
                document.getElementById('goldPriceSymbol').textContent = selectedSymbol;
                document.getElementById('silverPriceSymbol').textContent = selectedSymbol;
                document.getElementById('ricePriceSymbol').textContent = selectedSymbol;
            }

            // Currency pill: clicking the label checks the radio AND calls updateCurrency
            document.querySelectorAll('.zakat-currency-pill').forEach(pill => {
                pill.addEventListener('click', function() {
                    document.querySelectorAll('.zakat-currency-pill').forEach(p => p.classList
                        .remove('active'));
                    this.classList.add('active');
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                        updateCurrency();
                        updateSymbols();
                    }
                });
            });

            // Also handle direct radio change (keyboard / programmatic)
            document.querySelectorAll('input[name="currency"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.zakat-currency-pill').forEach(p => p.classList
                        .remove('active'));
                    const parentPill = this.closest('.zakat-currency-pill');
                    if (parentPill) parentPill.classList.add('active');
                    updateCurrency();
                    updateSymbols();
                });
            });

            // Initialize
            updateCurrency();
            updateSymbols();

            // Sync zakat-tab-btn active state with Bootstrap tab events
            document.querySelectorAll('.zakat-tab-btn').forEach(btn => {
                btn.addEventListener('shown.bs.tab', function() {
                    document.querySelectorAll('.zakat-tab-btn').forEach(b => b.classList.remove(
                        'active'));
                    this.classList.add('active');
                });
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.zakat-tab-btn').forEach(b => b.classList.remove(
                        'active'));
                    this.classList.add('active');
                });
            });
        });

        function calculateZakatMal() {
            const goldGrams = parseFloat(document.getElementById('goldGrams').value) || 0;
            const silverGrams = parseFloat(document.getElementById('silverGrams').value) || 0;
            const cash = parseFloat(document.getElementById('cash').value) || 0;
            const assets = parseFloat(document.getElementById('assets').value) || 0;
            const debts = parseFloat(document.getElementById('debts').value) || 0;

            // Convert user input from selected currency to IDR for calculation
            const cashIDR = cash * selectedRate;
            const assetsIDR = assets * selectedRate;
            const debtsIDR = debts * selectedRate;

            const goldValue = goldGrams * GOLD_PRICE;
            const silverValue = silverGrams * SILVER_PRICE;
            const totalWealth = goldValue + silverValue + cashIDR + assetsIDR - debtsIDR;

            const goldNisabValue = GOLD_NISAB * GOLD_PRICE;
            const silverNisabValue = SILVER_NISAB * SILVER_PRICE;
            const nisab = Math.min(goldNisabValue, silverNisabValue);

            let resultHTML = '';
            resultHTML += '<div class="mb-2"><small class="text-muted">Total Wealth:</small><br><strong>' + formatCurrency(
                totalWealth) + '</strong></div>';
            resultHTML += '<div class="mb-2"><small class="text-muted">Nisab (Gold):</small><br>' + formatCurrency(
                goldNisabValue) + '</div>';
            resultHTML += '<div class="mb-3"><small class="text-muted">Nisab (Silver):</small><br>' + formatCurrency(
                silverNisabValue) + '</div>';

            if (totalWealth >= nisab) {
                const zakat = totalWealth * (ZAKAT_PERCENTAGE / 100);
                const details = 'Total Wealth: ' + formatCurrency(totalWealth);

                resultHTML +=
                    '<div class="alert-zakat-success p-3 mb-2"><i class="ti tabler-circle-check me-1"></i> Zakat Obligatory</div>';
                resultHTML += '<div class="mb-3"><h5 style="color: #1a6b47;">Zakat Amount:<br>' + formatCurrency(zakat) +
                    '</h5></div>';
                resultHTML +=
                    '<button onclick="redirectToZakatPayment(' + zakat + ', \'Mal\', \'' + details +
                    '\')" class="btn-pay-zakat"><i class="ti tabler-heart me-1"></i> Pay Zakat Now</button>';
            } else {
                resultHTML +=
                    '<div class="alert-zakat-info p-3"><i class="ti tabler-info-circle me-1"></i> Zakat Not Obligatory<br><small>Your wealth is below nisab</small></div>';
            }

            document.getElementById('malResult').innerHTML = resultHTML;
        }

        function calculateZakatFitrah() {
            const numPeople = parseInt(document.getElementById('numPeople').value) || 1;
            const type = document.querySelector('input[name="fitrahType"]:checked').value;

            const perPersonMoney = FITRAH_AMOUNT * RICE_PRICE;
            const totalMoney = perPersonMoney * numPeople;
            const totalRice = FITRAH_AMOUNT * numPeople;

            let resultHTML = '';
            resultHTML += '<div class="mb-2"><small class="text-muted">Number of People:</small><br><strong>' + numPeople +
                '</strong></div>';
            resultHTML += '<div class="mb-2"><small class="text-muted">Per Person:</small><br>' + FITRAH_AMOUNT +
                ' kg or ' + formatCurrency(perPersonMoney) + '</div>';

            if (type === 'money') {
                resultHTML += '<div class="mb-3"><h5 style="color: #1a6b47;">Total:<br>' + formatCurrency(totalMoney) +
                    '</h5></div>';
            } else {
                resultHTML += '<div class="mb-3"><h5 style="color: #1a6b47;">Total:<br>' + totalRice +
                    ' kg rice</h5></div>';
                resultHTML += '<div class="mb-3"><small class="text-muted">Or equivalent: ' + formatCurrency(totalMoney) +
                    '</small></div>';
            }

            const details = numPeople + ' people';
            resultHTML +=
                '<button onclick="redirectToZakatPayment(' + totalMoney + ', \'Fitrah\', \'' + details +
                '\')" class="btn-pay-zakat"><i class="ti tabler-heart me-1"></i> Pay Zakat Fitrah</button>';

            document.getElementById('fitrahResult').innerHTML = resultHTML;
        }

        function calculateZakatProfesi() {
            const income = parseFloat(document.getElementById('income').value) || 0;
            const period = document.querySelector('input[name="profesiPeriod"]:checked').value;

            // Convert user input from selected currency to IDR for calculation
            const incomeIDR = income * selectedRate;

            const goldNisabValue = GOLD_NISAB * GOLD_PRICE;
            const nisabMonthly = goldNisabValue / 12;
            const nisabAnnual = goldNisabValue;

            const nisab = period === 'monthly' ? nisabMonthly : nisabAnnual;

            let resultHTML = '';
            resultHTML += '<div class="mb-2"><small class="text-muted">' + (period === 'monthly' ? 'Monthly' : 'Annual') +
                ' Income:</small><br><strong>' + formatCurrency(incomeIDR) + '</strong></div>';
            resultHTML += '<div class="mb-3"><small class="text-muted">Nisab:</small><br>' + formatCurrency(nisab) +
                '</div>';

            if (incomeIDR >= nisab) {
                const zakat = incomeIDR * (ZAKAT_PERCENTAGE / 100);
                const details = (period === 'monthly' ? 'Monthly' : 'Annual') + ' Income: ' + formatCurrency(income);

                resultHTML +=
                    '<div class="alert-zakat-success p-3 mb-2"><i class="ti tabler-check-circle me-1"></i> Zakat Obligatory</div>';
                resultHTML += '<div class="mb-3"><h5 style="color: #1a6b47;">Zakat Amount:<br>' + formatCurrency(zakat) +
                    '</h5></div>';
                resultHTML +=
                    '<button onclick="redirectToZakatPayment(' + zakat + ', \'Profesi\', \'' + details +
                    '\')" class="btn-pay-zakat"><i class="ti tabler-heart me-1"></i> Pay Zakat Now</button>';
            } else {
                resultHTML +=
                    '<div class="alert-zakat-info p-3"><i class="ti tabler-info-circle me-1"></i> Zakat Not Obligatory<br><small>Your income is below nisab</small></div>';
            }

            document.getElementById('profesiResult').innerHTML = resultHTML;
        }
    </script>
@endpush
