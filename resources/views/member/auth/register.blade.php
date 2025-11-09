@extends('layouts.auth')

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{ route('auth.register') }}" class="app-brand-link">
                                <span class="app-brand-logo demo">
                                    <span class="text-primary">
                                        {{-- Logo --}}
                                    </span>
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">{{ __('members.register_title') }} 🚀</h4>
                        <p class="mb-6">{{ __('members.register_subtitle') }}</p>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="formAuthentication" class="mb-4" action="{{ route('auth.register.submit') }}"
                            method="POST">
                            @csrf

                            <div class="mb-6">
                                <label for="name" class="form-label">{{ __('members.name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="{{ __('members.name_placeholder') }}" autofocus required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="email" class="form-label">{{ __('members.email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="{{ __('members.email_placeholder') }}" required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">{{ __('members.password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer">
                                        <i class="icon-base ti tabler-eye-off"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-6 form-password-toggle">
                                <label class="form-label"
                                    for="password_confirmation">{{ __('members.confirm_password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password_confirmation" required />
                                    <span class="input-group-text cursor-pointer">
                                        <i class="icon-base ti tabler-eye-off"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    {{ __('members.register') }}
                                </button>
                            </div>
                        </form>

                        <!-- Google OAuth Button -->
                        <div class="mb-4">
                            <div class="divider my-6">
                                <div class="divider-text">{{ __('members.or') }}</div>
                            </div>
                            <a href="{{ route('auth.google.redirect') }}" class="btn btn-outline-danger w-100">
                                <i class="ti tabler-brand-google-filled me-2"></i>
                                {{ __('members.register_with_google') }}
                            </a>
                        </div>

                        <p class="text-center">
                            <span>{{ __('members.already_member') }}</span>
                            <a href="{{ route('auth.login') }}">
                                <span>{{ __('members.login_here') }}</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
@endsection
