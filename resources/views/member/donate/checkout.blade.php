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

                            <!-- Donation Amount -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="ti tabler-cash me-1"></i>
                                    Donation Amount
                                </label>

                                <!-- Quick Amount Buttons -->
                                <div class="d-flex flex-wrap mb-3" style="gap: 0.5rem;">
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
                                    <span class="input-group-text">₩</span>
                                    <input type="number" name="amount" id="amountInput" class="form-control"
                                        min="1000" step="1000" value="{{ old('amount', $prefilledAmount ?? 50000) }}"
                                        placeholder="Enter custom amount" required>
                                </div>
                                <small class="text-muted">Minimum donation: ₩ 1,000</small>
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

                            <!-- Payment Method Selection -->
                            @if ($paymentGateways->isNotEmpty())
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="ti tabler-credit-card me-1"></i>
                                        Payment Method
                                    </label>
                                    <div class="d-flex flex-column" style="gap: 0.75rem;">
                                        @foreach ($paymentGateways as $gateway)
                                            <label class="payment-option border rounded p-3 d-flex align-items-start"
                                                style="cursor: pointer;">
                                                <input type="radio" name="payment_provider"
                                                    value="{{ $gateway->provider }}" {{ $loop->first ? 'checked' : '' }}
                                                    class="form-check-input mt-1 me-3">
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
                                                        @if ($gateway->is_sandbox)
                                                            <span class="badge bg-warning text-dark ms-2"
                                                                style="font-size: 0.7rem;">Test Mode</span>
                                                        @endif
                                                    </div>
                                                    @if ($gateway->description)
                                                        <div class="text-muted" style="font-size: 0.85rem;">
                                                            {{ Str::limit($gateway->description, 80) }}</div>
                                                    @endif
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
                                    Payment gateway is not configured. Your donation will be recorded as pending.
                                </div>
                            @endif

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
                                        <strong>₩ {{ number_format($campaign->collected_amount, 0, ',', '.') }}</strong>
                                    </small>
                                    <small class="text-muted">
                                        of ₩ {{ number_format($campaign->goal_amount, 0, ',', '.') }}
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
            const quickAmountButtons = document.querySelectorAll('.quick-amount');

            // Handle quick amount button clicks
            quickAmountButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const amount = this.getAttribute('data-amount');
                    amountInput.value = amount;

                    // Update active state
                    quickAmountButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Format number input with thousand separators (optional)
            amountInput.addEventListener('blur', function() {
                const value = parseInt(this.value);
                if (!isNaN(value)) {
                    // Round to nearest 1000
                    const rounded = Math.round(value / 1000) * 1000;
                    this.value = rounded;
                }
            });
        });
    </script>
@endpush
