@extends('layouts.admin')

@section('title', __('payment_gateways.view_title'))

@section('content')
    <div class="container-xxl grow container-p-y">
        <div class="row gap-4">
            <div class="col-md-12">
                <!-- Gateway Status Information -->
                <div class="row align-items-stretch">
                    <div class="col-md-4">
                        <div class="card border-primary h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title text-primary">{{ __('payment_gateways.is_active') }}</h6>
                                <div class="mb-2">
                                    @if ($paymentGateway->is_active)
                                        <i class="ti tabler-circle-dashed-check text-success" style="font-size: 2rem;"></i>
                                        <p class="text-success mb-0">{{ __('common.active') }}</p>
                                    @else
                                        <i class="ti tabler-x-circle text-secondary" style="font-size: 2rem;"></i>
                                        <p class="text-secondary mb-0">{{ __('common.inactive') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-warning h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ __('payment_gateways.is_sandbox') }}</h6>
                                <div class="mb-2">
                                    @if ($paymentGateway->is_sandbox)
                                        <i class="ti tabler-test-pipe text-warning" style="font-size: 2rem;"></i>
                                        <p class="text-warning mb-0">{{ __('payment_gateways.sandbox') }}</p>
                                    @else
                                        <i class="ti tabler-world text-primary" style="font-size: 2rem;"></i>
                                        <p class="text-primary mb-0">{{ __('payment_gateways.production') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-success h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ __('payment_gateways.dt_configured') }}</h6>
                                <div class="mb-2">
                                    @if ($paymentGateway->isConfigured())
                                        <i class="ti tabler-shield-check text-success" style="font-size: 2rem;"></i>
                                        <p class="text-success mb-0">{{ __('payment_gateways.configured') }}</p>
                                    @else
                                        <i class="ti tabler-shield-x text-warning" style="font-size: 2rem;"></i>
                                        <p class="text-warning mb-0">{{ __('payment_gateways.not_configured') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('payment_gateways.view_title') }}</h4>
                        <div class="d-flex gap-2">
                            @if ($paymentGateway->isConfigured())
                                <button type="button" class="btn btn-success btn-sm" id="testConnection">
                                    <i class="ti tabler-plug"></i>
                                    {{ __('payment_gateways.test_connection') }}
                                </button>
                            @endif
                            <a href="{{ route('admin.payment-gateways.edit', $paymentGateway->id) }}"
                                class="btn btn-warning btn-sm">
                                <i class="ti tabler-pencil"></i>
                                {{ __('common.edit') }}
                            </a>
                            <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">
                                {{ __('common.back_to_list') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Gateway Details -->
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('payment_gateways.name') }}:</strong></div>
                                    <div class="col-md-9">{{ $paymentGateway->name }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('payment_gateways.provider') }}:</strong></div>
                                    <div class="col-md-9">
                                        <span class="badge bg-info">{{ $paymentGateway->provider_name }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('payment_gateways.is_active') }}:</strong></div>
                                    <div class="col-md-9">{!! $paymentGateway->status_badge !!}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('payment_gateways.is_sandbox') }}:</strong></div>
                                    <div class="col-md-9">{!! $paymentGateway->mode_badge !!}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('payment_gateways.api_key') }}:</strong></div>
                                    <div class="col-md-9">
                                        <code class="text-muted">{{ $paymentGateway->getMaskedApiKey() }}</code>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('payment_gateways.secret_key') }}:</strong></div>
                                    <div class="col-md-9">
                                        <code class="text-muted">{{ $paymentGateway->getMaskedSecretKey() }}</code>
                                    </div>
                                </div>

                                @if ($paymentGateway->webhook_secret)
                                    <div class="row mb-3">
                                        <div class="col-md-3"><strong>{{ __('payment_gateways.webhook_secret') }}:</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <code class="text-muted">{{ str_repeat('*', 20) }}</code>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('payment_gateways.creator') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $paymentGateway->creator ? $paymentGateway->creator->name : '-' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('common.created_at') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $paymentGateway->created_at ? $paymentGateway->created_at->format('M d, Y H:i') : '-' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('common.updated_at') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $paymentGateway->updated_at ? $paymentGateway->updated_at->format('M d, Y H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if ($paymentGateway->description)
                            <div class="mt-4">
                                <h5>{{ __('payment_gateways.description') }}</h5>
                                {!! nl2br(e($paymentGateway->description)) !!}
                            </div>
                        @endif

                        <!-- Additional Configuration -->
                        @if ($paymentGateway->additional_config)
                            <div class="mt-4">
                                <h5>{{ __('payment_gateways.additional_config') }}</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <pre><code>{{ json_encode($paymentGateway->additional_config, JSON_PRETTY_PRINT) }}</code></pre>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Test connection button
            $('#testConnection').on('click', function() {
                const button = $(this);
                const originalText = button.html();

                button.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status"></span> Testing...');

                $.ajax({
                    url: '{{ route('admin.payment-gateways.test-connection', $paymentGateway->id) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: '{{ __('common.success') }}',
                                text: response.message,
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                title: '{{ __('common.failed') }}',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: '{{ __('common.failed') }}',
                            text: '{{ __('common.error') }}',
                            icon: 'error'
                        });
                    },
                    complete: function() {
                        button.prop('disabled', false).html(originalText);
                    }
                });
            });
        });
    </script>
@endpush
