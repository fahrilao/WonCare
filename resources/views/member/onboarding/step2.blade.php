@extends('layouts.member')

@section('title', __('onboarding.step1_title'))
@section('body_class', 'member-onboarding')

@section('content')
    <div class="onboarding-shell page-animate">
        <div class="onboarding-card card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="onboarding-step mb-3">{{ __('onboarding.step') }} 2/5</div>
                    <h2 class="onboarding-title mb-2">{{ __('onboarding.step1_title') }}</h2>
                    <p class="onboarding-subtitle mb-0">{{ __('onboarding.step1_subtitle') }}</p>
                    <div class="onboarding-progress" aria-hidden="true">
                        <span class="is-done"></span>
                        <span class="is-active"></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <form action="{{ route('onboarding.step2.store') }}" method="POST" class="onboarding-actions">
                    @csrf

                    <div class="mb-4">
                        <label for="monthly_income" class="form-label">{{ __('onboarding.monthly_income') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('monthly_income') is-invalid @enderror"
                                id="monthly_income" name="monthly_income"
                                value="{{ old('monthly_income', $member->monthly_income) }}" placeholder="0" step="0.01"
                                required>
                        </div>
                        @error('monthly_income')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('onboarding.monthly_income_help') }}</small>
                    </div>

                    <div class="mb-4">
                        <label for="monthly_expense" class="form-label">{{ __('onboarding.monthly_expense') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('monthly_expense') is-invalid @enderror"
                                id="monthly_expense" name="monthly_expense"
                                value="{{ old('monthly_expense', $member->monthly_expense) }}" placeholder="0"
                                step="0.01" required>
                        </div>
                        @error('monthly_expense')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('onboarding.monthly_expense_help') }}</small>
                    </div>

                    <div class="d-flex gap-2 onboarding-actions">
                        <a href="{{ route('onboarding.step1') }}" class="btn btn-label-secondary flex-fill">
                            {{ __('onboarding.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary flex-fill">
                            {{ __('onboarding.continue') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
