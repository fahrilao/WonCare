@extends('layouts.admin')

@section('title', __('payment_gateways.create_title'))

@section('content')
    <div class="container-xxl grow container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('payment_gateways.create_title') }}</h4>
                        <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-sm btn-secondary">
                            {{ __('common.back_to_list') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.payment-gateways.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- Gateway Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">
                                        {{ __('payment_gateways.name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="{{ __('payment_gateways.name_placeholder') }}" required>
                                    <small class="form-text text-muted">{{ __('payment_gateways.name_help') }}</small>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Provider -->
                                <div class="col-md-6 mb-3">
                                    <label for="provider" class="form-label">
                                        {{ __('payment_gateways.provider') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('provider') is-invalid @enderror" id="provider"
                                        name="provider" required>
                                        <option value="">{{ __('payment_gateways.provider_help') }}</option>
                                        @foreach ($providers as $key => $value)
                                            <option value="{{ $key }}" {{ old('provider') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('provider')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- API Key -->
                                <div class="col-md-6 mb-3">
                                    <label for="api_key" class="form-label">{{ __('payment_gateways.api_key') }}</label>
                                    <input type="password" class="form-control @error('api_key') is-invalid @enderror"
                                        id="api_key" name="api_key" value="{{ old('api_key') }}"
                                        placeholder="{{ __('payment_gateways.api_key_placeholder') }}">
                                    <small class="form-text text-muted">{{ __('payment_gateways.api_key_help') }}</small>
                                    @error('api_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Secret Key -->
                                <div class="col-md-6 mb-3">
                                    <label for="secret_key" class="form-label">{{ __('payment_gateways.secret_key') }}</label>
                                    <input type="password" class="form-control @error('secret_key') is-invalid @enderror"
                                        id="secret_key" name="secret_key" value="{{ old('secret_key') }}"
                                        placeholder="{{ __('payment_gateways.secret_key_placeholder') }}">
                                    <small class="form-text text-muted">{{ __('payment_gateways.secret_key_help') }}</small>
                                    @error('secret_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Webhook Secret -->
                                <div class="col-md-6 mb-3">
                                    <label for="webhook_secret" class="form-label">{{ __('payment_gateways.webhook_secret') }}</label>
                                    <input type="password" class="form-control @error('webhook_secret') is-invalid @enderror"
                                        id="webhook_secret" name="webhook_secret" value="{{ old('webhook_secret') }}"
                                        placeholder="{{ __('payment_gateways.webhook_secret_placeholder') }}">
                                    <small class="form-text text-muted">{{ __('payment_gateways.webhook_secret_help') }}</small>
                                    @error('webhook_secret')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status and Mode -->
                                <div class="col-md-6 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('payment_gateways.is_active') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                                       value="1" {{ old('is_active') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    {{ __('common.active') }}
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">{{ __('payment_gateways.is_active_help') }}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('payment_gateways.is_sandbox') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_sandbox" name="is_sandbox" 
                                                       value="1" {{ old('is_sandbox', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_sandbox">
                                                    {{ __('payment_gateways.sandbox') }}
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">{{ __('payment_gateways.is_sandbox_help') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('payment_gateways.description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="3"
                                    placeholder="{{ __('payment_gateways.description_placeholder') }}">{{ old('description') }}</textarea>
                                <small class="form-text text-muted">{{ __('payment_gateways.description_help') }}</small>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Additional Config -->
                            <div class="mb-3">
                                <label for="additional_config" class="form-label">{{ __('payment_gateways.additional_config') }}</label>
                                <textarea class="form-control @error('additional_config') is-invalid @enderror" 
                                    id="additional_config" name="additional_config" rows="4"
                                    placeholder='{"key": "value"}'></textarea>
                                <small class="form-text text-muted">{{ __('payment_gateways.additional_config_help') }}</small>
                                @error('additional_config')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">
                                    {{ __('common.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('common.create') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Show/hide password fields
            $('.password-toggle').on('click', function() {
                const target = $(this).data('target');
                const input = $(target);
                const icon = $(this).find('i');
                
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ti-eye').addClass('ti-eye-off');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ti-eye-off').addClass('ti-eye');
                }
            });

            // Validate JSON in additional_config
            $('#additional_config').on('blur', function() {
                const value = $(this).val().trim();
                if (value && value !== '') {
                    try {
                        JSON.parse(value);
                        $(this).removeClass('is-invalid').addClass('is-valid');
                    } catch (e) {
                        $(this).removeClass('is-valid').addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').text('Invalid JSON format');
                    }
                }
            });
        });
    </script>
@endpush
