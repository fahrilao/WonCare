@extends('layouts.member')

@section('title', __('onboarding.step3_title'))
@section('body_class', 'member-onboarding')

@section('content')
    <div class="onboarding-shell page-animate">
        <div class="onboarding-card card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="onboarding-step mb-3">{{ __('onboarding.step') }} 4/5</div>
                    <h2 class="onboarding-title mb-2">{{ __('onboarding.step3_title') }}</h2>
                    <p class="onboarding-subtitle mb-0">{{ __('onboarding.step3_subtitle') }}</p>
                    <div class="onboarding-progress" aria-hidden="true">
                        <span class="is-done"></span>
                        <span class="is-done"></span>
                        <span class="is-done"></span>
                        <span class="is-active"></span>
                        <span></span>
                    </div>
                </div>

                <form action="{{ route('onboarding.step4.store') }}" method="POST" class="onboarding-actions">
                    @csrf

                    <div class="mb-4">
                        <label for="financial_goal" class="form-label">{{ __('onboarding.financial_goal') }}</label>
                        <textarea class="form-control @error('financial_goal') is-invalid @enderror" id="financial_goal" name="financial_goal"
                            rows="5" placeholder="{{ __('onboarding.financial_goal_placeholder') }}" required>{{ old('financial_goal', $member->financial_goal) }}</textarea>
                        @error('financial_goal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('onboarding.financial_goal_help') }}</small>
                    </div>

                    <div class="d-flex gap-2 onboarding-actions">
                        <a href="{{ route('onboarding.step3') }}" class="btn btn-label-secondary flex-fill">
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
