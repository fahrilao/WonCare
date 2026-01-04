@extends('layouts.member')

@section('title', __('onboarding.welcome_title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-primary rounded-pill" style="width: 50px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill" style="width: 50px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 50px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 50px; height: 8px;"></span>
                                <span class="badge bg-label-secondary rounded-pill"
                                    style="width: 50px; height: 8px;"></span>
                            </div>
                            <small class="text-muted">{{ __('onboarding.step') }} 1/5</small>
                        </div>
                        <h3 class="mb-3">{{ __('onboarding.welcome_title') }}</h3>
                        <p class="text-muted">{{ __('onboarding.welcome_subtitle') }}</p>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="card bg-label-primary h-100">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <i class="icon-base ti tabler-chart-line text-primary" style="font-size: 40px;"></i>
                                    </div>
                                    <h5 class="mb-2">{{ __('onboarding.feature_1_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('onboarding.feature_1_desc') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-label-success h-100">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <i class="icon-base ti tabler-target text-success" style="font-size: 40px;"></i>
                                    </div>
                                    <h5 class="mb-2">{{ __('onboarding.feature_2_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('onboarding.feature_2_desc') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-label-info h-100">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <i class="icon-base ti tabler-bulb text-info" style="font-size: 40px;"></i>
                                    </div>
                                    <h5 class="mb-2">{{ __('onboarding.feature_3_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('onboarding.feature_3_desc') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-label-warning h-100">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <i class="icon-base ti tabler-school text-warning" style="font-size: 40px;"></i>
                                    </div>
                                    <h5 class="mb-2">{{ __('onboarding.feature_4_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('onboarding.feature_4_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('onboarding.step1.store') }}" method="POST">
                        @csrf
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('onboarding.lets_start') }}
                                <i class="icon-base ti tabler-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
