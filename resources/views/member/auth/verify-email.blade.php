@extends('layouts.auth')

@section('content')
    <div class="authentication-wrapper authentication-basic px-6">
        <div class="authentication-inner py-6">
            <!-- Verify Email -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-6">
                        <a href="{{ route('auth.login') }}" class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-heading fw-bold">WonCare</span>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <h4 class="mb-1">Verify your email ✉️</h4>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            A new verification link has been sent to your email address.
                        </div>
                    @endif

                    <p class="text-start mb-4">
                        Account activation link sent to your email address:
                        <span class="fw-medium">{{ Auth::guard('member')->user()->email }}</span>
                        Please follow the link inside to continue.
                    </p>

                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ route('auth.verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                Resend Verification Email
                            </button>
                        </form>
                    </div>

                    <p class="text-center mt-4 mb-0">
                        <a href="{{ route('logout') }}">Sign out</a>
                    </p>
                </div>
            </div>
            <!-- /Verify Email -->
        </div>
    </div>
@endsection
