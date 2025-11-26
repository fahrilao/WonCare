@extends('layouts.member')

@section('title', 'Donate to ' . $campaign->title)

@push('styles')
    <style>
        .payment-option {
            transition: all 0.2s ease;
            border: 2px solid #e9ecef !important;
        }

        .payment-option:hover {
            border-color: #0d6efd !important;
            background-color: #f8f9fa;
        }

        .payment-option input[type="radio"]:checked~* {
            color: #0d6efd;
        }

        .payment-option:has(input[type="radio"]:checked) {
            border-color: #0d6efd !important;
            background-color: #e7f1ff;
        }

        .campaign-summary {
            position: sticky;
            top: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Left: Donation Form -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <a href="{{ route('member.donate.show', $campaign) }}" class="btn btn-light me-3">
                                <i class="ti tabler-arrow-left"></i>
                            </a>
                            <h4 class="mb-0">Complete Your Donation</h4>
                        </div>

                        <form method="POST" action="{{ route('member.donate.store', $campaign) }}" id="donationForm">
                            @csrf

                            <!-- Currency Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="ti tabler-currency me-1"></i>
                                    Currency
                                </label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyIDR"
                                            value="IDR" {{ old('currency', 'IDR') === 'IDR' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="currencyIDR">
                                            <strong>Rupiah (Rp)</strong> - Indonesian
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyKRW"
                                            value="KRW" {{ old('currency') === 'KRW' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="currencyKRW">
                                            <strong>Won (₩)</strong> - Korean
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Payment gateway will be automatically selected based on your
                                    currency choice.</small>
                                @error('currency')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Donation Amount -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="ti tabler-cash me-1"></i>
                                    Donation Amount
                                </label>

                                <!-- Quick Amount Buttons (IDR) -->
                                <div class="d-flex flex-wrap mb-3 quick-amounts-idr" style="gap: 0.5rem;">
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="10000">
                                        Rp 10,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="25000">
                                        Rp 25,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="50000">
                                        Rp 50,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount"
                                        data-amount="100000">
                                        Rp 100,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount"
                                        data-amount="250000">
                                        Rp 250,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount"
                                        data-amount="500000">
                                        Rp 500,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount"
                                        data-amount="1000000">
                                        Rp 1,000,000
                                    </button>
                                </div>

                                <!-- Quick Amount Buttons (KRW) -->
                                <div class="d-none flex-wrap mb-3 quick-amounts-krw" style="gap: 0.5rem;">
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="1000">
                                        ₩ 1,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="3000">
                                        ₩ 3,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="5000">
                                        ₩ 5,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="10000">
                                        ₩ 10,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="30000">
                                        ₩ 30,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="50000">
                                        ₩ 50,000
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-amount"
                                        data-amount="100000">
                                        ₩ 100,000
                                    </button>
                                </div>

                                <!-- Custom Amount Input -->
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text" id="currencySymbol">Rp</span>
                                    <input type="number" name="amount" id="amountInput" class="form-control"
                                        min="1000" step="1000" value="{{ old('amount', $prefilledAmount ?? 50000) }}"
                                        placeholder="Enter custom amount" required>
                                </div>
                                <small class="text-muted" id="minAmountText">Minimum donation: Rp 1,000</small>
                                @error('amount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Message/Note -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="ti tabler-message me-1"></i>
                                    Wish (Optional)
                                </label>
                                <textarea name="note" class="form-control" rows="4" maxlength="1000"
                                    placeholder="Write your prayer or support message...">{{ old('note', $prefilledNote ?? '') }}</textarea>
                                <small class="text-muted">Give a wish to the campaign beneficiary.</small>
                                @error('note')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Payment Gateway Info -->
                            <div class="alert alert-info">
                                <i class="ti tabler-info-circle me-2"></i>
                                <strong>Payment Gateway:</strong>
                                <span id="gatewayInfo">Midtrans (for Rupiah)</span>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="ti tabler-heart me-2"></i>
                                    Proceed to Payment
                                </button>
                                <a href="{{ route('member.donate.show', $campaign) }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>

                            <p class="text-muted text-center mt-3 mb-0" style="font-size: 0.85rem;">
                                <i class="ti tabler-lock me-1"></i>
                                Secure payment processing
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Campaign Summary -->
            <div class="col-lg-4">
                <div class="campaign-summary">
                    <div class="card">
                        <div class="card-header p-0">
                            @php $primaryImage = $campaign->primaryImage; @endphp
                            @if ($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->image_url) }}" class="card-img-top"
                                    style="max-height: 200px; object-fit: cover;" alt="{{ $campaign->title }}">
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{ $campaign->title }}</h5>

                            <!-- Tags -->
                            <div class="d-flex flex-wrap mb-3" style="gap: 0.5rem;">
                                @foreach ($campaign->tags as $tag)
                                    <span class="badge text-white"
                                        style="background-color: {{ $tag->color ?? '#6c757d' }};">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Progress -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <strong>Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</strong>
                                    </small>
                                    <small class="text-muted">
                                        of Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}
                                    </small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $campaign->progress_percentage }}%"
                                        aria-valuenow="{{ $campaign->progress_percentage }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted">{{ $campaign->progress_percentage }}% funded</small>
                            </div>

                            @if ($campaign->end_date)
                                <div class="d-flex align-items-center text-muted mb-2">
                                    <i class="ti tabler-clock me-2"></i>
                                    <small>{{ $campaign->end_date->diffForHumans() }}</small>
                                </div>
                            @endif

                            <hr>

                            <div class="text-center">
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                    You're about to make a difference!
                                </p>
                            </div>
                        </div>
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
            const currencySymbol = document.getElementById('currencySymbol');
            const minAmountText = document.getElementById('minAmountText');
            const gatewayInfo = document.getElementById('gatewayInfo');
            const currencyIDR = document.getElementById('currencyIDR');
            const currencyKRW = document.getElementById('currencyKRW');
            const quickAmountsIDR = document.querySelector('.quick-amounts-idr');
            const quickAmountsKRW = document.querySelector('.quick-amounts-krw');

            // Handle currency change
            function updateCurrency() {
                const isIDR = currencyIDR.checked;

                if (isIDR) {
                    // Switch to Rupiah
                    currencySymbol.textContent = 'Rp';
                    minAmountText.textContent = 'Minimum donation: Rp 1,000';
                    gatewayInfo.textContent = 'Midtrans (for Rupiah)';
                    quickAmountsIDR.classList.remove('d-none');
                    quickAmountsIDR.classList.add('d-flex');
                    quickAmountsKRW.classList.remove('d-flex');
                    quickAmountsKRW.classList.add('d-none');
                    amountInput.value = 50000;
                } else {
                    // Switch to Won
                    currencySymbol.textContent = '₩';
                    minAmountText.textContent = 'Minimum donation: ₩ 1,000';
                    gatewayInfo.textContent = 'Toss Payments (for Korean Won)';
                    quickAmountsKRW.classList.remove('d-none');
                    quickAmountsKRW.classList.add('d-flex');
                    quickAmountsIDR.classList.remove('d-flex');
                    quickAmountsIDR.classList.add('d-none');
                    amountInput.value = 10000;
                }
            }

            // Listen to currency radio changes
            currencyIDR.addEventListener('change', updateCurrency);
            currencyKRW.addEventListener('change', updateCurrency);

            // Handle quick amount button clicks
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('quick-amount')) {
                    const amount = e.target.getAttribute('data-amount');
                    amountInput.value = amount;

                    // Update active state
                    document.querySelectorAll('.quick-amount').forEach(btn => btn.classList.remove(
                        'active'));
                    e.target.classList.add('active');
                }
            });

            // Format number input with thousand separators
            amountInput.addEventListener('blur', function() {
                const value = parseInt(this.value);
                if (!isNaN(value)) {
                    // Round to nearest 1000
                    const rounded = Math.round(value / 1000) * 1000;
                    this.value = rounded;
                }
            });

            // Initialize on page load
            updateCurrency();
        });
    </script>
@endpush
