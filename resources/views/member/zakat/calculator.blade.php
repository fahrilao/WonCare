@extends('layouts.member')

@section('title', __('zakat.calculator'))

@section('content')
    <div class="row">
        <div class="col-12">
            <h3 class="mb-3 mb-md-4">
                <i class="ti tabler-calculator me-2"></i>
                {{ __('zakat.calculator') }}
            </h3>
            <p class="text-muted mb-3 mb-md-4">{{ __('zakat.calculator_description') }}</p>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active waves-effect" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                        <span class="d-none d-sm-inline-flex align-items-center">
                            <i class="icon-base ti tabler-coin icon-sm me-1_5"></i>{{ __('zakat.zakat_mal') }}
                        </span>
                        <i class="icon-base ti tabler-coin icon-sm d-sm-none"></i>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                        <span class="d-none d-sm-inline-flex align-items-center">
                            <i class="icon-base ti tabler-users icon-sm me-1_5"></i>{{ __('zakat.zakat_fitrah') }}
                        </span>
                        <i class="icon-base ti tabler-users icon-sm d-sm-none"></i>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                        <span class="d-none d-sm-inline-flex align-items-center">
                            <i class="icon-base ti tabler-briefcase icon-sm me-1_5"></i>{{ __('zakat.zakat_profesi') }}
                        </span>
                        <i class="icon-base ti tabler-briefcase icon-sm d-sm-none"></i>
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content p-0">
                <!-- Zakat Mal -->
                <div class="tab-pane fade show active" id="mal" role="tabpanel">
                    <div class="row">
                        <div class="col-12 col-lg-8 mb-4 mb-lg-0">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3">{{ __('zakat.calculate_zakat_mal') }}</h5>
                                    <p class="text-muted mb-4">{{ __('zakat.mal_description') }}</p>

                                    <form id="zakatMalForm">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label class="form-label">{{ __('zakat.gold_owned') }}
                                                    ({{ __('zakat.grams') }})</label>
                                                <input type="number" class="form-control" id="goldGrams" min="0"
                                                    step="0.01" value="0"
                                                    placeholder="{{ __('zakat.enter_amount') }}">
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label class="form-label">{{ __('zakat.silver_owned') }}
                                                    ({{ __('zakat.grams') }})</label>
                                                <input type="number" class="form-control" id="silverGrams" min="0"
                                                    step="0.01" value="0"
                                                    placeholder="{{ __('zakat.enter_amount') }}">
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label class="form-label">{{ __('zakat.cash_savings') }}</label>
                                                <input type="number" class="form-control" id="cash" min="0"
                                                    step="1000" value="0"
                                                    placeholder="{{ __('zakat.enter_amount') }}">
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label class="form-label">{{ __('zakat.business_assets') }}</label>
                                                <input type="number" class="form-control" id="assets" min="0"
                                                    step="1000" value="0"
                                                    placeholder="{{ __('zakat.enter_amount') }}">
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label class="form-label">{{ __('zakat.debts') }}</label>
                                                <input type="number" class="form-control" id="debts" min="0"
                                                    step="1000" value="0"
                                                    placeholder="{{ __('zakat.enter_amount') }}">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary w-100 w-sm-auto"
                                            onclick="calculateZakatMal()">
                                            <i class="ti tabler-calculator me-1"></i>
                                            {{ __('zakat.calculate') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">{{ __('zakat.calculation_result') }}</h6>
                                    <div id="malResult">
                                        <p class="text-muted">{{ __('zakat.enter_details_calculate') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zakat Fitrah -->
                <div class="tab-pane fade" id="fitrah" role="tabpanel">
                    <div class="row">
                        <div class="col-12 col-lg-8 mb-4 mb-lg-0">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3">{{ __('zakat.calculate_zakat_fitrah') }}</h5>
                                    <p class="text-muted mb-4">{{ __('zakat.fitrah_description') }}</p>

                                    <form id="zakatFitrahForm">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('zakat.number_of_people') }}</label>
                                            <input type="number" class="form-control" id="numPeople" min="1"
                                                value="1" placeholder="{{ __('zakat.enter_number') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('zakat.payment_type') }}</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="fitrahType"
                                                        id="fitrahMoney" value="money" checked>
                                                    <label class="form-check-label"
                                                        for="fitrahMoney">{{ __('zakat.money') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="fitrahType"
                                                        id="fitrahRice" value="rice">
                                                    <label class="form-check-label"
                                                        for="fitrahRice">{{ __('zakat.rice') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary w-100 w-sm-auto"
                                            onclick="calculateZakatFitrah()">
                                            <i class="ti tabler-calculator me-1"></i>
                                            {{ __('zakat.calculate') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">{{ __('zakat.calculation_result') }}</h6>
                                    <div id="fitrahResult">
                                        <p class="text-muted">{{ __('zakat.enter_details_calculate') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zakat Profesi -->
                <div class="tab-pane fade" id="profesi" role="tabpanel">
                    <div class="row">
                        <div class="col-12 col-lg-8 mb-4 mb-lg-0">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3">{{ __('zakat.calculate_zakat_profesi') }}</h5>
                                    <p class="text-muted mb-4">{{ __('zakat.profesi_description') }}</p>

                                    <form id="zakatProfesiForm">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('zakat.period') }}</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="profesiPeriod"
                                                        id="profesiMonthly" value="monthly" checked>
                                                    <label class="form-check-label"
                                                        for="profesiMonthly">{{ __('zakat.monthly') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="profesiPeriod"
                                                        id="profesiAnnual" value="annual">
                                                    <label class="form-check-label"
                                                        for="profesiAnnual">{{ __('zakat.annual') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('zakat.income') }}</label>
                                            <input type="number" class="form-control" id="income" min="0"
                                                step="100000" value="0"
                                                placeholder="{{ __('zakat.enter_amount') }}">
                                        </div>
                                        <button type="button" class="btn btn-primary w-100 w-sm-auto"
                                            onclick="calculateZakatProfesi()">
                                            <i class="ti tabler-calculator me-1"></i>
                                            {{ __('zakat.calculate') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">{{ __('zakat.calculation_result') }}</h6>
                                    <div id="profesiResult">
                                        <p class="text-muted">{{ __('zakat.enter_details_calculate') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration Info Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="ti tabler-info-circle me-2"></i>
                        {{ __('zakat.current_configuration') }}
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">{{ __('zakat.configuration_info') }}</p>
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti tabler-coin text-warning me-2"></i>
                                    <small class="text-muted">{{ __('zakat.gold_price') }}</small>
                                </div>
                                <h6 class="mb-0">₩ {{ number_format($goldPrice, 0, ',', '.') }}</h6>
                                <small class="text-muted">{{ __('zakat.per_gram') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti tabler-coin text-secondary me-2"></i>
                                    <small class="text-muted">{{ __('zakat.silver_price') }}</small>
                                </div>
                                <h6 class="mb-0">₩ {{ number_format($silverPrice, 0, ',', '.') }}</h6>
                                <small class="text-muted">{{ __('zakat.per_gram') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti tabler-scale text-warning me-2"></i>
                                    <small class="text-muted">{{ __('zakat.gold_nisab') }}</small>
                                </div>
                                <h6 class="mb-0">{{ number_format($goldNisab, 0, ',', '.') }}
                                    {{ __('zakat.grams') }}</h6>
                                <small class="text-muted">₩
                                    {{ number_format($goldNisab * $goldPrice, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti tabler-scale text-secondary me-2"></i>
                                    <small class="text-muted">{{ __('zakat.silver_nisab') }}</small>
                                </div>
                                <h6 class="mb-0">{{ number_format($silverNisab, 0, ',', '.') }}
                                    {{ __('zakat.grams') }}</h6>
                                <small class="text-muted">₩
                                    {{ number_format($silverNisab * $silverPrice, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti tabler-grain text-success me-2"></i>
                                    <small class="text-muted">{{ __('zakat.rice_price') }}</small>
                                </div>
                                <h6 class="mb-0">₩ {{ number_format($ricePrice, 0, ',', '.') }}</h6>
                                <small class="text-muted">{{ __('zakat.per_kg') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti tabler-users text-primary me-2"></i>
                                    <small class="text-muted">{{ __('zakat.fitrah_per_person') }}</small>
                                </div>
                                <h6 class="mb-0">{{ number_format($fitrahAmount, 1) }} kg</h6>
                                <small class="text-muted">₩
                                    {{ number_format($fitrahAmount * $ricePrice, 0, ',', '.') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti tabler-percentage text-info me-2"></i>
                                    <small class="text-muted">{{ __('zakat.zakat_rate') }}</small>
                                </div>
                                <h6 class="mb-0">{{ number_format($zakatPercentage, 1) }}%</h6>
                                <small class="text-muted">{{ __('zakat.standard_rate') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3 mb-0">
                        <small>
                            <i class="ti tabler-info-circle me-1"></i>
                            {{ __('zakat.configuration_note') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Responsive tabs for mobile */
        @media (max-width: 767px) {
            .nav-tabs {
                border-bottom: 1px solid #dee2e6;
            }

            .nav-tabs .nav-item {
                flex: 1;
                min-width: auto;
            }

            .nav-tabs .nav-link {
                padding: 0.5rem 0.25rem;
                font-size: 0.875rem;
                text-align: center;
                white-space: normal;
                word-wrap: break-word;
            }

            .nav-tabs .nav-link i {
                display: block;
                margin: 0 auto 0.25rem;
                font-size: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .nav-tabs .nav-link {
                padding: 0.5rem 0.15rem;
                font-size: 0.75rem;
            }

            .nav-tabs .nav-link i {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Zakat settings from backend
        const GOLD_PRICE = {{ $goldPrice }};
        const SILVER_PRICE = {{ $silverPrice }};
        const GOLD_NISAB = {{ $goldNisab }};
        const SILVER_NISAB = {{ $silverNisab }};
        const ZAKAT_PERCENTAGE = {{ $zakatPercentage }};
        const RICE_PRICE = {{ $ricePrice }};
        const FITRAH_AMOUNT = {{ $fitrahAmount }};

        // Store calculated zakat amount for payment
        let calculatedZakat = {
            amount: 0,
            type: '',
            details: ''
        };

        function formatWon(amount) {
            return '₩ ' + amount.toLocaleString('ko-KR');
        }

        function redirectToZakatPayment(amount, type, details) {
            // Redirect directly to Zakat checkout
            window.location.href = '/zakat/checkout?amount=' + Math.round(amount) + '&type=' + encodeURIComponent(type) +
                '&note=' + encodeURIComponent('Zakat ' + type + ' - ' + details);
        }

        function calculateZakatMal() {
            const goldGrams = parseFloat(document.getElementById('goldGrams').value) || 0;
            const silverGrams = parseFloat(document.getElementById('silverGrams').value) || 0;
            const cash = parseFloat(document.getElementById('cash').value) || 0;
            const assets = parseFloat(document.getElementById('assets').value) || 0;
            const debts = parseFloat(document.getElementById('debts').value) || 0;

            const goldValue = goldGrams * GOLD_PRICE;
            const silverValue = silverGrams * SILVER_PRICE;
            const totalWealth = goldValue + silverValue + cash + assets - debts;

            const goldNisabValue = GOLD_NISAB * GOLD_PRICE;
            const silverNisabValue = SILVER_NISAB * SILVER_PRICE;
            const nisab = Math.min(goldNisabValue, silverNisabValue);

            let resultHTML = '';
            resultHTML += '<div class="mb-2"><small class="text-muted">Total Wealth:</small><br><strong>' + formatWon(
                totalWealth) + '</strong></div>';
            resultHTML += '<div class="mb-2"><small class="text-muted">Nisab (Gold):</small><br>' + formatWon(
                goldNisabValue) + '</div>';
            resultHTML += '<div class="mb-3"><small class="text-muted">Nisab (Silver):</small><br>' + formatWon(
                silverNisabValue) + '</div>';

            if (totalWealth >= nisab) {
                const zakat = totalWealth * (ZAKAT_PERCENTAGE / 100);
                const details = 'Total Wealth: ' + formatWon(totalWealth);

                resultHTML +=
                    '<div class="alert alert-success mb-2"><i class="ti tabler-check-circle me-1"></i> Zakat Obligatory</div>';
                resultHTML += '<div class="mb-3"><h5 class="text-success">Zakat Amount:<br>' + formatWon(zakat) +
                    '</h5></div>';
                resultHTML +=
                    '<button onclick="redirectToZakatPayment(' + zakat + ', \'Mal\', \'' + details +
                    '\')" class="btn btn-success btn-sm w-100"><i class="ti tabler-heart me-1"></i> Pay Zakat Now</button>';
            } else {
                resultHTML +=
                    '<div class="alert alert-info"><i class="ti tabler-info-circle me-1"></i> Zakat Not Obligatory<br><small>Your wealth is below nisab</small></div>';
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
                ' kg or ' + formatWon(perPersonMoney) + '</div>';

            if (type === 'money') {
                resultHTML += '<div class="mb-3"><h5 class="text-primary">Total:<br>' + formatWon(totalMoney) +
                    '</h5></div>';
            } else {
                resultHTML += '<div class="mb-3"><h5 class="text-primary">Total:<br>' + totalRice + ' kg rice</h5></div>';
                resultHTML += '<div class="mb-3"><small class="text-muted">Or equivalent: ' + formatWon(totalMoney) +
                    '</small></div>';
            }

            const details = numPeople + ' people';
            resultHTML +=
                '<button onclick="redirectToZakatPayment(' + totalMoney + ', \'Fitrah\', \'' + details +
                '\')" class="btn btn-primary btn-sm w-100"><i class="ti tabler-heart me-1"></i> Pay Zakat Fitrah</button>';

            document.getElementById('fitrahResult').innerHTML = resultHTML;
        }

        function calculateZakatProfesi() {
            const income = parseFloat(document.getElementById('income').value) || 0;
            const period = document.querySelector('input[name="profesiPeriod"]:checked').value;

            const goldNisabValue = GOLD_NISAB * GOLD_PRICE;
            const nisabMonthly = goldNisabValue / 12;
            const nisabAnnual = goldNisabValue;

            const nisab = period === 'monthly' ? nisabMonthly : nisabAnnual;

            let resultHTML = '';
            resultHTML += '<div class="mb-2"><small class="text-muted">' + (period === 'monthly' ? 'Monthly' : 'Annual') +
                ' Income:</small><br><strong>' + formatWon(income) + '</strong></div>';
            resultHTML += '<div class="mb-3"><small class="text-muted">Nisab:</small><br>' + formatWon(nisab) + '</div>';

            if (income >= nisab) {
                const zakat = income * (ZAKAT_PERCENTAGE / 100);
                const details = (period === 'monthly' ? 'Monthly' : 'Annual') + ' Income: ' + formatWon(income);

                resultHTML +=
                    '<div class="alert alert-success mb-2"><i class="ti tabler-check-circle me-1"></i> Zakat Obligatory</div>';
                resultHTML += '<div class="mb-3"><h5 class="text-success">Zakat Amount:<br>' + formatWon(zakat) +
                    '</h5></div>';
                resultHTML +=
                    '<button onclick="redirectToZakatPayment(' + zakat + ', \'Profesi\', \'' + details +
                    '\')" class="btn btn-success btn-sm w-100"><i class="ti tabler-heart me-1"></i> Pay Zakat Now</button>';
            } else {
                resultHTML +=
                    '<div class="alert alert-info"><i class="ti tabler-info-circle me-1"></i> Zakat Not Obligatory<br><small>Your income is below nisab</small></div>';
            }

            document.getElementById('profesiResult').innerHTML = resultHTML;
        }
    </script>
@endpush
