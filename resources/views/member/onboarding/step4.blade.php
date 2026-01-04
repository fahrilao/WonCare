@extends('layouts.member')

@section('title', __('onboarding.step3_title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-success rounded-pill" style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-success rounded-pill" style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-success rounded-pill" style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-primary rounded-pill" style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 40px; height: 8px;"></span>
                            </div>
                            <small class="text-muted">{{ __('onboarding.step') }} 4/5</small>
                        </div>
                        <h4 class="mb-2">{{ __('onboarding.step3_title') }}</h4>
                        <p class="text-muted">{{ __('onboarding.step3_subtitle') }}</p>
                    </div>

                    <form action="{{ route('onboarding.step4.store') }}" method="POST">
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

                        <div class="d-flex gap-2">
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
    </div>
@endsection
