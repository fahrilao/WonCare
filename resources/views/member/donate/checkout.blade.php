@extends('layouts.member')

@section('title', 'Donate to ' . $campaign->title)
@section('body_class', 'member-modern')

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

        .quick-amount {
            border-color: #1a6b47;
            color: #1a6b47;
        }

        .quick-amount:hover,
        .quick-amount.active {
            background: #1a6b47;
            border-color: #1a6b47;
            color: #fff;
        }

        .btn-donate-checkout {
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

        .btn-donate-checkout:hover {
            background: linear-gradient(135deg, #155a3c, #267a50);
            color: #fff;
            transform: translateY(-1px);
        }

        .currency-option {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .currency-option:hover {
            border-color: #1a6b47;
        }

        .currency-option.selected {
            border-color: #1a6b47;
            background: rgba(26, 107, 71, 0.05);
        }

        .currency-option input[type="radio"] {
            accent-color: #1a6b47;
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

        .campaign-summary {
            position: sticky;
            top: 20px;
        }

        .campaign-summary-image {
            height: 180px;
            border-radius: 0.5rem 0.5rem 0 0;
            overflow: hidden;
            background: linear-gradient(135deg, #1a6b47 0%, #2d8f5f 50%, #c4a962 100%);
        }

        .campaign-summary-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .campaign-tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .campaign-progress-bar {
            height: 8px;
            background: #e8e8e8;
            border-radius: 4px;
            overflow: hidden;
        }

        .campaign-progress-bar .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1a6b47 0%, #2d8f5f 100%);
            border-radius: 4px;
        }

        .sidebar-stat {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.875rem;
        }

        .sidebar-stat-label {
            color: #6c757d;
        }

        .sidebar-stat-value {
            font-weight: 600;
            color: #1a6b47;
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

        /* ── Dark Mode ── */
        [data-bs-theme="dark"] .section-title h2 {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .form-label {
            color: #cbd5e1;
        }

        [data-bs-theme="dark"] .currency-option {
            border-color: rgba(255, 255, 255, 0.12);
        }

        [data-bs-theme="dark"] .currency-option:hover {
            border-color: #10b981;
        }

        [data-bs-theme="dark"] .currency-option.selected {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.08);
        }

        [data-bs-theme="dark"] .campaign-progress-bar {
            background: rgba(255, 255, 255, 0.10);
        }

        [data-bs-theme="dark"] .sidebar-stat-label {
            color: rgba(226, 232, 240, 0.50);
        }

        [data-bs-theme="dark"] .gateway-info {
            background: rgba(16, 185, 129, 0.10);
            border-color: rgba(16, 185, 129, 0.20);
            color: #34d399;
        }

        [data-bs-theme="dark"] .gateway-info i {
            color: #34d399;
        }
    </style>
@endpush

@section('content')
    <div class="page-animate">
        <div class="container py-4">
            {{-- Back Link --}}
            <a href="{{ route('member.donate.show', $campaign) }}" class="back-link mb-4 d-inline-block">
                <i class="ti tabler-arrow-left"></i>
                {{ __('donation_campaigns.back_to_campaign') }}
            </a>

            <div class="row">
                <!-- Left: Donation Form -->
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="section-title">
                                <i class="ti tabler-heart-handshake"></i>
                                <h2>{{ __('donation_campaigns.complete_donation') }}</h2>
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
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="10000">
                                            Rp 10,000
                                        </button>
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="25000">
                                            Rp 25,000
                                        </button>
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="50000">
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
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="1000">
                                            ₩ 1,000
                                        </button>
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="3000">
                                            ₩ 3,000
                                        </button>
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="5000">
                                            ₩ 5,000
                                        </button>
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="10000">
                                            ₩ 10,000
                                        </button>
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="30000">
                                            ₩ 30,000
                                        </button>
                                        <button type="button" class="btn btn-outline-primary quick-amount"
                                            data-amount="50000">
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
                                            min="1000" step="1000"
                                            value="{{ old('amount', $prefilledAmount ?? 50000) }}"
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
                                <div class="gateway-info mb-4">
                                    <i class="ti tabler-info-circle me-2"></i>
                                    <strong>{{ __('donation_campaigns.payment_gateway') }}:</strong>
                                    <span id="gatewayInfo">Midtrans (for Rupiah)</span>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn-donate-checkout">
                                        <i class="ti tabler-heart"></i>
                                        {{ __('donation_campaigns.proceed_to_payment') }}
                                    </button>
                                    <a href="{{ route('member.donate.show', $campaign) }}"
                                        class="btn btn-outline-secondary">
                                        {{ __('common.cancel') }}
                                    </a>
                                </div>

                                <p class="text-muted text-center mt-3 mb-0" style="font-size: 0.85rem;">
                                    <i class="ti tabler-shield-check me-1"></i>
                                    {{ __('donation_campaigns.secure_payment') }}
                                </p>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Campaign Summary -->
                <div class="col-lg-4">
                    <div class="campaign-summary">
                        <div class="card">
                            <div class="campaign-summary-image">
                                @php $primaryImage = $campaign->primaryImage; @endphp
                                @if ($primaryImage)
                                    <img src="{{ asset('storage/' . $primaryImage->image_url) }}"
                                        alt="{{ $campaign->title }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <i class="ti tabler-photo"
                                            style="font-size: 3rem; color: rgba(255,255,255,0.3);"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold mb-2">{{ $campaign->title }}</h5>

                                <!-- Tags -->
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach ($campaign->tags as $tag)
                                        <span class="campaign-tag text-white"
                                            style="background-color: {{ $tag->color ?? '#1a6b47' }};">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <!-- Progress -->
                                <div class="mb-3">
                                    <div class="sidebar-stat">
                                        <span class="sidebar-stat-label">{{ __('donation_campaigns.raised') }}</span>
                                        <span class="sidebar-stat-value">Rp
                                            {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="campaign-progress-bar mb-2">
                                        <div class="progress-fill"
                                            style="width: {{ min($campaign->progress_percentage, 100) }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">{{ number_format($campaign->progress_percentage, 1) }}%
                                            {{ __('donation_campaigns.funded') }}</small>
                                        <small class="text-muted">{{ __('donation_campaigns.goal_amount') }}: Rp
                                            {{ number_format($campaign->goal_amount, 0, ',', '.') }}</small>
                                    </div>
                                </div>

                                @if ($campaign->end_date)
                                    <div class="d-flex align-items-center text-muted mb-3">
                                        <i class="ti tabler-clock me-2"></i>
                                        <small>{{ $campaign->end_date->diffInDays(now()) }}
                                            {{ __('donation_campaigns.days_left') }}</small>
                                    </div>
                                @endif

                                <hr>

                                <div class="text-center">
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                        <i class="ti tabler-heart me-1" style="color: #1a6b47;"></i>
                                        {{ __('donation_campaigns.make_difference_message') }}
                                    </p>
                                </div>
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
