@extends('layouts.member')

@section('title', __('onboarding.step1_title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-success rounded-pill" style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-primary rounded-pill" style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 40px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 40px; height: 8px;"></span>
                            </div>
                            <small class="text-muted">{{ __('onboarding.step') }} 2/5</small>
                        </div>
                        <h4 class="mb-2">{{ __('onboarding.step1_title') }}</h4>
                        <p class="text-muted">{{ __('onboarding.step1_subtitle') }}</p>
                    </div>

                    <form action="{{ route('onboarding.step2.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="monthly_income" class="form-label">{{ __('onboarding.monthly_income') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('monthly_income') is-invalid @enderror"
                                    id="monthly_income" name="monthly_income"
                                    value="{{ old('monthly_income', $member->monthly_income) }}" placeholder="0"
                                    step="0.01" required>
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
