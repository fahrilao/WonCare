@extends('layouts.member')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('members.change_password') }}</h5>
                        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                            <i class="ti tabler-arrow-left me-2"></i>{{ __('members.back_to_profile') }}
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ __('common.error') }}!</strong> {{ __('members.fix_errors_below') }}
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Account Type Info -->
                        <div class="alert alert-info mb-6">
                            <div class="d-flex align-items-center">
                                @if ($member->isGoogleUser())
                                    <i class="ti tabler-brand-google me-3 ti-lg"></i>
                                    <div>
                                        <h6 class="mb-1">{{ __('members.google_account') }}</h6>
                                        <small class="mb-0">
                                            @if ($member->password)
                                                {{ __('members.google_with_password_desc') }}
                                            @else
                                                {{ __('members.google_only_desc') }}
                                            @endif
                                        </small>
                                    </div>
                                @else
                                    <i class="ti tabler-user me-3 ti-lg"></i>
                                    <div>
                                        <h6 class="mb-1">{{ __('members.regular_account') }}</h6>
                                        <small class="mb-0">{{ __('members.regular_password_desc') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('profile.update-password') }}" method="POST" id="changePasswordForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12 mb-6">
                                    <h6>{{ __('members.change_password_form') }}</h6>
                                    <div class="mb-4 form-password-toggle">
                                        <label for="current_password" class="form-label">
                                            {{ __('members.current_password') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <input type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                id="current_password" name="current_password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                required>
                                            <span class="input-group-text cursor-pointer">
                                                <i class="icon-base ti tabler-eye-off"></i>
                                            </span>
                                        </div>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4 form-password-toggle">
                                        <label for="password" class="form-label">
                                            {{ __('members.new_password') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                required>
                                            <span class="input-group-text cursor-pointer">
                                                <i class="icon-base ti tabler-eye-off"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <div id="password-strength" class="mt-2"></div>
                                        </div>
                                    </div>

                                    <div class="mb-4 form-password-toggle">
                                        <label for="password_confirmation" class="form-label">
                                            {{ __('members.confirm_new_password') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                required>
                                            <span class="input-group-text cursor-pointer">
                                                <i class="icon-base ti tabler-eye-off"></i>
                                            </span>
                                        </div>
                                        <div class="form-text">
                                            <div id="password-match" class="mt-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                                            <i class="ti tabler-arrow-left me-2"></i>{{ __('common.cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="ti tabler-lock me-2"></i>{{ __('members.update_password') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const passwordStrengthDiv = document.getElementById('password-strength');
            const passwordMatchDiv = document.getElementById('password-match');
            const submitBtn = document.getElementById('submitBtn');

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                let feedback = [];

                if (password.length >= 8) {
                    strength += 1;
                } else {
                    feedback.push('{{ __('members.password_min_length') }}');
                }

                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
                    strength += 1;
                } else {
                    feedback.push('{{ __('members.password_mixed_case') }}');
                }

                if (/\d/.test(password)) {
                    strength += 1;
                } else {
                    feedback.push('{{ __('members.password_numbers') }}');
                }

                if (/[^A-Za-z0-9]/.test(password)) {
                    strength += 1;
                } else {
                    feedback.push('{{ __('members.password_special_chars') }}');
                }

                return {
                    strength,
                    feedback
                };
            }

            // Update password strength display
            function updatePasswordStrength() {
                const password = passwordInput.value;
                const result = checkPasswordStrength(password);

                if (password.length === 0) {
                    passwordStrengthDiv.innerHTML = '';
                    return;
                }

                let strengthText = '';
                let strengthClass = '';

                switch (result.strength) {
                    case 0:
                    case 1:
                        strengthText = '{{ __('members.password_weak') }}';
                        strengthClass = 'text-danger';
                        break;
                    case 2:
                        strengthText = '{{ __('members.password_fair') }}';
                        strengthClass = 'text-warning';
                        break;
                    case 3:
                        strengthText = '{{ __('members.password_good') }}';
                        strengthClass = 'text-info';
                        break;
                    case 4:
                        strengthText = '{{ __('members.password_strong') }}';
                        strengthClass = 'text-success';
                        break;
                }

                passwordStrengthDiv.innerHTML = `
            <small class="${strengthClass}">
                <i class="ti tabler-shield me-1"></i>${strengthText}
            </small>
        `;
            }

            // Check password match
            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (confirmPassword.length === 0) {
                    passwordMatchDiv.innerHTML = '';
                    return;
                }

                if (password === confirmPassword) {
                    passwordMatchDiv.innerHTML = `
                <small class="text-success">
                    <i class="ti tabler-check me-1"></i>{{ __('members.passwords_match') }}
                </small>
            `;
                } else {
                    passwordMatchDiv.innerHTML = `
                <small class="text-danger">
                    <i class="ti tabler-x me-1"></i>{{ __('members.passwords_no_match') }}
                </small>
            `;
                }
            }

            // Event listeners
            if (passwordInput) {
                passwordInput.addEventListener('input', updatePasswordStrength);
            }

            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', checkPasswordMatch);
                passwordInput.addEventListener('input', checkPasswordMatch);
            }

            // Form validation
            const form = document.getElementById('changePasswordForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const password = passwordInput.value;
                    const confirmPassword = confirmPasswordInput.value;
                    const result = checkPasswordStrength(password);

                    if (result.strength < 2) {
                        e.preventDefault();
                        alert('{{ __('members.password_too_weak') }}');
                        return false;
                    }

                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('{{ __('members.passwords_must_match') }}');
                        return false;
                    }
                });
            }
        });
    </script>
@endsection
