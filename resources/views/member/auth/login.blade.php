@extends('layouts.auth')

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{ route('auth.login') }}" class="app-brand-link">
                                <span class="app-brand-logo demo">
                                    <span class="text-primary">
                                        {{-- Logo --}}
                                    </span>
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">{{ __('members.welcome_title', ['app' => config('app.name')]) }} 👋</h4>
                        <p class="mb-6">{{ __('members.login_subtitle') }}</p>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
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

                        <form id="formAuthentication" class="mb-4" action="{{ route('auth.login.submit') }}"
                            method="POST">
                            @csrf
                            <div class="mb-6 form-control-validation">
                                <label for="email" class="form-label">{{ __('members.email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="{{ __('members.email_placeholder') }}" autofocus required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-6 form-password-toggle form-control-validation">
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

                            <div class="my-8">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check mb-0 ms-2">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                                        <label class="form-check-label"
                                            for="remember">{{ __('members.remember_me') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    {{ __('members.login') }}
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
                                {{ __('members.login_with_google') }}
                            </a>
                        </div>

                        <p class="text-center">
                            <span>{{ __('members.new_member') }}</span>
                            <a href="{{ route('auth.register') }}">
                                <span>{{ __('members.create_account') }}</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>
@endsection
