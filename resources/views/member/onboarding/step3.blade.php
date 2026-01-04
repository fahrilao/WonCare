@extends('layouts.member')

@section('title', __('onboarding.step2_title'))
@section('body_class', 'member-onboarding')

@section('content')
    <div class="onboarding-shell page-animate">
        <div class="onboarding-card card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="onboarding-step mb-3">{{ __('onboarding.step') }} 3/5</div>
                    <h2 class="onboarding-title mb-2">{{ __('onboarding.step2_title') }}</h2>
                    <p class="onboarding-subtitle mb-0">{{ __('onboarding.step2_subtitle') }}</p>
                    <div class="onboarding-progress" aria-hidden="true">
                        <span class="is-done"></span>
                        <span class="is-done"></span>
                        <span class="is-active"></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <form action="{{ route('onboarding.step3.store') }}" method="POST" class="onboarding-actions">
                    @csrf

                    <div class="mb-4">
                        <label for="occupation" class="form-label">{{ __('onboarding.occupation') }}</label>
                        <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation"
                            name="occupation" value="{{ old('occupation', $member->occupation) }}"
                            placeholder="{{ __('onboarding.occupation_placeholder') }}" required>
                        @error('occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('onboarding.occupation_help') }}</small>
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
