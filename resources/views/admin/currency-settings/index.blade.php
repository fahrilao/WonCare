@extends('layouts.admin')

@section('title', 'Currency Settings')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="ti tabler-currency me-2"></i>
                Currency Settings
            </h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti tabler-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-4">Manage currency exchange rates for multi-currency payment support. All rates are
                    relative to Indonesian Rupiah (IDR) as the base currency.</p>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Currency Code</th>
                                <th>Currency Name</th>
                                <th>Symbol</th>
                                <th>Exchange Rate to IDR</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($currencies as $currency)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $currency->currency_code }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $currency->currency_name }}</div>
                                        @if ($currency->description)
                                            <small class="text-muted">{{ $currency->description }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fs-5">{{ $currency->currency_symbol }}</span>
                                    </td>
                                    <td>
                                        @if ($currency->is_base_currency)
                                            <span class="badge bg-info">Base Currency (1.0000)</span>
                                        @else
                                            <strong>{{ number_format($currency->exchange_rate_to_idr, 4) }}</strong>
                                            <div class="small text-muted">
                                                1 {{ $currency->currency_code }} =
                                                {{ number_format($currency->exchange_rate_to_idr, 2) }} IDR
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($currency->is_active)
                                            <span class="badge bg-success">
                                                <i class="ti tabler-check me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="ti tabler-x me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($currency->is_base_currency)
                                            <span class="badge bg-warning">
                                                <i class="ti tabler-star me-1"></i>Base
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark">Secondary</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.currency-settings.edit', $currency) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="ti tabler-edit"></i>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="ti tabler-currency-off fs-1 mb-2"></i>
                                        <p>No currency settings found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="mb-3"><i class="ti tabler-info-circle me-2"></i>About Currency Settings</h6>
                <ul class="mb-0">
                    <li><strong>Base Currency:</strong> Indonesian Rupiah (IDR) is the base currency with exchange rate of
                        1.0000</li>
                    <li><strong>Exchange Rate:</strong> Represents how much 1 unit of the currency equals in IDR</li>
                    <li><strong>Example:</strong> If 1 KRW = 12 IDR, then the exchange rate is 12.0000</li>
                    <li><strong>Zakat Calculator:</strong> Uses these rates to convert between currencies for accurate
                        calculations</li>
                    <li><strong>Donation Progress:</strong> Displays campaign progress in multiple currencies using these
                        rates</li>
                    <li><strong>Payment Gateway:</strong> IDR uses Midtrans, KRW uses Toss Payments automatically</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
