@extends('layouts.member')

@section('title', 'Pay Zakat')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <a href="{{ route('member.zakat.calculator') }}" class="btn btn-light me-3">
                                <i class="ti tabler-arrow-left"></i>
                            </a>
                            <h4 class="mb-0">Complete Your Zakat Payment</h4>
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

                        <form action="{{ route('member.zakat.process') }}" method="POST">
                            @csrf

                            <!-- Zakat Summary -->
                            <div class="alert alert-info mb-4">
                                <h5 class="mb-2"><i class="ti tabler-calculator me-2"></i>Zakat Payment Summary</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Type:</strong> {{ $type ?? 'Zakat' }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Amount:</strong>
                                        @php
                                            $currency = request('currency', 'IDR');
                                            $symbol = $currency === 'KRW' ? '₩' : 'Rp';
                                        @endphp
                                        {{ $symbol }} {{ number_format($amount ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                                @if ($note)
                                    <div class="mt-2">
                                        <strong>Details:</strong> {{ $note }}
                                    </div>
                                @endif
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="ti tabler-info-circle me-1"></i>
                                        Currency: {{ $currency === 'KRW' ? 'Korean Won (₩)' : 'Indonesian Rupiah (Rp)' }}
                                    </small>
                                </div>
                            </div>

                            <!-- Hidden Fields -->
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="note" value="{{ $note }}">
                            <input type="hidden" name="currency" value="{{ request('currency', 'IDR') }}">

                            <!-- Payment Method Selection -->
                            @if ($paymentGateways->isNotEmpty())
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="ti tabler-credit-card me-1"></i>
                                        Select Payment Method
                                    </label>
                                    <div class="d-flex flex-column" style="gap: 0.75rem;">
                                        @foreach ($paymentGateways as $gateway)
                                            <label class="border rounded p-3 cursor-pointer payment-option">
                                                <input type="radio" name="payment_provider"
                                                    value="{{ $gateway->provider }}" class="form-check-input me-2"
                                                    required>
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center mb-1">
                                                            @if ($gateway->provider === 'midtrans')
                                                                <i class="ti tabler-building-bank text-primary me-2"
                                                                    style="font-size: 1.25rem;"></i>
                                                            @elseif($gateway->provider === 'stripe')
                                                                <i class="ti tabler-credit-card text-primary me-2"
                                                                    style="font-size: 1.25rem;"></i>
                                                            @elseif($gateway->provider === 'toss')
                                                                <i class="ti tabler-wallet text-primary me-2"
                                                                    style="font-size: 1.25rem;"></i>
                                                            @endif
                                                            <span class="fw-bold">{{ $gateway->provider_name }}</span>
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ $gateway->is_sandbox ? 'Sandbox Mode' : 'Live Mode' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('payment_provider')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="ti tabler-info-circle me-2"></i>
                                    Payment gateway is not configured. Your Zakat will be recorded as pending.
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="ti tabler-heart me-2"></i>
                                    Pay Zakat - {{ $symbol }} {{ number_format($amount ?? 0, 0, ',', '.') }}
                                </button>
                                <a href="{{ route('member.zakat.calculator') }}" class="btn btn-outline-secondary">
                                    Back to Calculator
                                </a>
                            </div>

                            @if ($paymentGateways->isNotEmpty())
                                <p class="text-muted text-center mt-3 mb-0" style="font-size: 0.85rem;">
                                    <i class="ti tabler-lock me-1"></i>
                                    Secure payment powered by
                                    {{ $paymentGateways->pluck('provider_name')->join(', ', ' and ') }}
                                </p>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti tabler-info-circle me-2"></i>About Zakat Payment</h6>
                        <ul class="mb-0">
                            <li>Your Zakat payment will be recorded in your donation history</li>
                            <li>You will receive a confirmation after successful payment</li>
                            <li>All payments are processed securely through our payment partners</li>
                            <li>For questions, please contact our support team</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .payment-option {
            cursor: pointer;
            transition: all 0.2s;
        }

        .payment-option:hover {
            background-color: #f8f9fa;
            border-color: #0d6efd !important;
        }

        .payment-option:has(input:checked) {
            background-color: #e7f1ff;
            border-color: #0d6efd !important;
        }
    </style>
@endpush
