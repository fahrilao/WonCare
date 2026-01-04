@extends('layouts.member')

@section('title', __('onboarding.step2_title'))

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
                                <span class="badge bg-primary rounded-pill" style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 40px; height: 8px;"></span>
                            </div>
                            <small class="text-muted">{{ __('onboarding.step') }} 3/5</small>
                        </div>
                        <h4 class="mb-2">{{ __('onboarding.step2_title') }}</h4>
                        <p class="text-muted">{{ __('onboarding.step2_subtitle') }}</p>
                    </div>

                    <form action="{{ route('onboarding.step3.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="occupation" class="form-label">{{ __('onboarding.occupation') }}</label>
                            <input type="text" class="form-control @error('occupation') is-invalid @enderror"
                                id="occupation" name="occupation" value="{{ old('occupation', $member->occupation) }}"
                                placeholder="{{ __('onboarding.occupation_placeholder') }}" required>
                            @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('onboarding.occupation_help') }}</small>
                        </div>

                        <div class="d-flex gap-2">
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
    </div>
@endsection
