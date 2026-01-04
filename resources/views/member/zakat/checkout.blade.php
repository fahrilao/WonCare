@extends('layouts.member')

@section('title', 'Pay Zakat')

@push('styles')
    <style>
        .back-link {
            color: #1a6b47;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #155a3c;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .section-title i {
            color: #1a6b47;
            font-size: 1.25rem;
        }

        .section-title h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: #1a1a1a;
        }

        .zakat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .zakat-summary {
            background: linear-gradient(135deg, rgba(26, 107, 71, 0.08), rgba(45, 143, 95, 0.12));
            border: 1px solid rgba(26, 107, 71, 0.15);
            border-radius: 10px;
            padding: 1.25rem;
        }

        .zakat-summary h5 {
            color: #1a6b47;
            font-weight: 600;
        }

        .form-label {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .form-control:focus {
            border-color: #1a6b47;
            box-shadow: 0 0 0 0.2rem rgba(26, 107, 71, 0.15);
        }

        .form-check-input:checked {
            background-color: #1a6b47;
            border-color: #1a6b47;
        }

        .btn-pay-zakat {
            background: linear-gradient(135deg, #1a6b47, #2d8f5f);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px 24px;
            font-size: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-pay-zakat:hover {
            background: linear-gradient(135deg, #155a3c, #267a50);
            color: #fff;
            transform: translateY(-1px);
        }

        .gateway-info {
            background: rgba(26, 107, 71, 0.1);
            border: 1px solid rgba(26, 107, 71, 0.2);
            border-radius: 8px;
            padding: 12px 16px;
            color: #1a6b47;
        }

        .gateway-info i {
            color: #1a6b47;
        }

        .info-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .info-card h6 {
            color: #1a6b47;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        {{-- Back Link --}}
        <a href="{{ route('member.zakat.calculator') }}" class="back-link mb-4 d-inline-block">
            <i class="ti tabler-arrow-left"></i>
            {{ __('zakat.back_to_calculator') }}
        </a>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card zakat-card">
                    <div class="card-body p-4">
                        <div class="section-title">
                            <i class="ti tabler-heart-handshake"></i>
                            <h2>{{ __('zakat.complete_payment') }}</h2>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('member.zakat.process') }}" method="POST" id="zakatForm">
                            @csrf

                            <!-- Zakat Summary -->
                            <div class="zakat-summary mb-4">
                                <h5 class="mb-3"><i
                                        class="ti tabler-calculator me-2"></i>{{ __('zakat.payment_summary') }}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">{{ __('zakat.zakat_type') }}</small>
                                        <div class="fw-bold">{{ $type ?? 'Zakat' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">{{ __('zakat.calculated_amount') }}</small>
                                        <div class="fw-bold" id="displayAmountIDR">Rp
                                            {{ number_format($amount ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                @if ($note)
                                    <div class="mt-3">
                                        <small class="text-muted">{{ __('zakat.details') }}</small>
                                        <div>{{ $note }}</div>
                                    </div>
                                @endif
                            </div>

                            <!-- Hidden Fields -->
                            <input type="hidden" name="amount" id="amountInput" value="{{ $amount }}">
                            <input type="hidden" name="note" value="{{ $note }}">

                            <!-- Currency Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="ti tabler-currency me-1"></i>
                                    {{ __('zakat.select_currency') }}
                                </label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyIDR"
                                            value="IDR"
                                            {{ old('currency', request('currency', 'IDR')) === 'IDR' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="currencyIDR">
                                            <strong>Rupiah (Rp)</strong> - Indonesian
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyKRW"
                                            value="KRW"
                                            {{ old('currency', request('currency')) === 'KRW' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="currencyKRW">
                                            <strong>Won (₩)</strong> - Korean
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">{{ __('zakat.currency_gateway_note') }}</small>
                                @error('currency')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Gateway Info -->
                            <div class="gateway-info mb-4">
                                <i class="ti tabler-info-circle me-2"></i>
                                <strong>{{ __('zakat.payment_gateway') }}:</strong>
                                <span id="gatewayInfo">Midtrans (for Rupiah)</span>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn-pay-zakat">
                                    <i class="ti tabler-heart"></i>
                                    <span id="submitBtnText">{{ __('zakat.pay_zakat') }} - Rp
                                        {{ number_format($amount ?? 0, 0, ',', '.') }}</span>
                                </button>
                                <a href="{{ route('member.zakat.calculator') }}" class="btn btn-outline-secondary">
                                    {{ __('common.cancel') }}
                                </a>
                            </div>

                            <p class="text-muted text-center mt-3 mb-0" style="font-size: 0.85rem;">
                                <i class="ti tabler-shield-check me-1"></i>
                                {{ __('zakat.secure_payment') }}
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="card info-card mt-4">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti tabler-info-circle me-2"></i>{{ __('zakat.about_payment') }}</h6>
                        <ul class="mb-0 text-muted">
                            <li>{{ __('zakat.payment_info_1') }}</li>
                            <li>{{ __('zakat.payment_info_2') }}</li>
                            <li>{{ __('zakat.payment_info_3') }}</li>
                            <li>{{ __('zakat.payment_info_4') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amountInput');
            const displayAmountIDR = document.getElementById('displayAmountIDR');
            const gatewayInfo = document.getElementById('gatewayInfo');
            const submitBtnText = document.getElementById('submitBtnText');
            const currencyIDR = document.getElementById('currencyIDR');
            const currencyKRW = document.getElementById('currencyKRW');

            // Original amount in IDR from calculator
            const originalAmountIDR = {{ $amount ?? 0 }};
            // Exchange rate: 1 KRW = approximately 11.5 IDR (adjust as needed)
            const exchangeRate = 11.5;

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Handle currency change
            function updateCurrency() {
                const isIDR = currencyIDR.checked;

                if (isIDR) {
                    // IDR selected
                    const amountIDR = originalAmountIDR;
                    amountInput.value = amountIDR;
                    displayAmountIDR.textContent = 'Rp ' + formatNumber(Math.round(amountIDR));
                    gatewayInfo.textContent = 'Midtrans (for Rupiah)';
                    submitBtnText.textContent = '{{ __('zakat.pay_zakat') }} - Rp ' + formatNumber(Math.round(
                        amountIDR));
                } else {
                    // KRW selected - convert IDR to KRW
                    const amountKRW = Math.round(originalAmountIDR / exchangeRate);
                    amountInput.value = amountKRW;
                    displayAmountIDR.textContent = '₩ ' + formatNumber(amountKRW);
                    gatewayInfo.textContent = 'Toss Payments (for Korean Won)';
                    submitBtnText.textContent = '{{ __('zakat.pay_zakat') }} - ₩ ' + formatNumber(amountKRW);
                }
            }

            // Listen to currency radio changes
            currencyIDR.addEventListener('change', updateCurrency);
            currencyKRW.addEventListener('change', updateCurrency);

            // Initialize on page load
            updateCurrency();
        });
    </script>
@endpush
