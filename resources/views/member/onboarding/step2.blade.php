@extends('layouts.member')

@section('title', __('onboarding.step1_title'))
@section('body_class', 'member-onboarding')

@section('content')
    <div class="onboarding-shell page-animate">
        <div class="onboarding-card card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="onboarding-step mb-3">{{ __('onboarding.step') }} 2/5</div>
                    <h2 class="onboarding-title mb-2">{{ __('onboarding.step2_title') }}</h2>
                    <p class="onboarding-subtitle mb-0">{{ __('onboarding.step2_subtitle') }}</p>
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
                        <label for="gross_salary" class="form-label">{{ __('financial.gross_salary') }} *</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('gross_salary') is-invalid @enderror"
                                id="gross_salary" name="gross_salary" value="{{ old('gross_salary') }}" placeholder="0"
                                step="0.01" required>
                        </div>
                        @error('gross_salary')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <h6 class="mb-3">{{ __('financial.total_deductions') }}</h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kookmin_yeongeum" class="form-label">{{ __('financial.kookmin_yeongeum') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="kookmin_yeongeum" name="kookmin_yeongeum"
                                    value="{{ old('kookmin_yeongeum', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="twejigeum" class="form-label">{{ __('financial.twejigeum') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="twejigeum" name="twejigeum"
                                    value="{{ old('twejigeum', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="insurance" class="form-label">{{ __('financial.insurance') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="insurance" name="insurance"
                                    value="{{ old('insurance', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tax" class="form-label">{{ __('financial.tax') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="tax" name="tax"
                                    value="{{ old('tax', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="other_deductions" class="form-label">{{ __('financial.other_deductions') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="other_deductions" name="other_deductions"
                                    value="{{ old('other_deductions', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
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
