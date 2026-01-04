@extends('layouts.member')

@section('title', __('onboarding.welcome_title'))
@section('body_class', 'member-onboarding')

@section('content')
    <div class="onboarding-shell page-animate">
        <div class="onboarding-card card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="onboarding-step mb-3">{{ __('onboarding.step') }} 1/5</div>
                    <h2 class="onboarding-title mb-2">{{ __('onboarding.welcome_title') }}</h2>
                    <p class="onboarding-subtitle mb-0">{{ __('onboarding.welcome_subtitle') }}</p>
                    <div class="onboarding-progress" aria-hidden="true">
                        <span class="is-active"></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div class="row g-3 g-md-4 mb-4">
                    <div class="col-md-6 tile-animate">
                        <div class="onboarding-tile tile-primary">
                            <div class="d-flex gap-3">
                                <div class="tile-icon">
                                    <i class="icon-base ti tabler-chart-line"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ __('onboarding.feature_1_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('onboarding.feature_1_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 tile-animate">
                        <div class="onboarding-tile tile-success">
                            <div class="d-flex gap-3">
                                <div class="tile-icon">
                                    <i class="icon-base ti tabler-target"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ __('onboarding.feature_2_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('onboarding.feature_2_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 tile-animate">
                        <div class="onboarding-tile tile-info">
                            <div class="d-flex gap-3">
                                <div class="tile-icon">
                                    <i class="icon-base ti tabler-bulb"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ __('onboarding.feature_3_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('onboarding.feature_3_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 tile-animate">
                        <div class="onboarding-tile tile-warning">
                            <div class="d-flex gap-3">
                                <div class="tile-icon">
                                    <i class="icon-base ti tabler-school"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ __('onboarding.feature_4_title') }}</h5>
                                    <p class="text-muted mb-0">{{ __('onboarding.feature_4_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('onboarding.step1.store') }}" method="POST" class="onboarding-actions">
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
@endsection
