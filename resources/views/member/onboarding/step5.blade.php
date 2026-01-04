@extends('layouts.member')

@section('title', __('onboarding.step5_title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5 text-center">
                    <div class="mb-4">
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-success rounded-pill" style="width: 40px; height: 8px;"></span>
                            <span class="badge bg-success rounded-pill" style="width: 40px; height: 8px;"></span>
                            <span class="badge bg-success rounded-pill" style="width: 40px; height: 8px;"></span>
                            <span class="badge bg-success rounded-pill" style="width: 40px; height: 8px;"></span>
                            <span class="badge bg-primary rounded-pill" style="width: 40px; height: 8px;"></span>
                        </div>
                        <small class="text-muted">{{ __('onboarding.step') }} 5/5</small>
                    </div>

                    <div class="mb-4">
                        <div class="mb-4">
                            <i class="icon-base ti tabler-circle-check text-success" style="font-size: 80px;"></i>
                        </div>
                        <h3 class="mb-3">{{ __('onboarding.step5_title') }}</h3>
                        <p class="text-muted mb-4">{{ __('onboarding.step5_subtitle') }}</p>
                    </div>

                    <div class="card bg-label-primary mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">{{ __('onboarding.we_can_help') }}</h5>
                            <ul class="list-unstyled text-start mb-0">
                                <li class="mb-2">
                                    <i class="icon-base ti tabler-check text-primary me-2"></i>
                                    {{ __('onboarding.help_1') }}
                                </li>
                                <li class="mb-2">
                                    <i class="icon-base ti tabler-check text-primary me-2"></i>
                                    {{ __('onboarding.help_2') }}
                                </li>
                                <li class="mb-2">
                                    <i class="icon-base ti tabler-check text-primary me-2"></i>
                                    {{ __('onboarding.help_3') }}
                                </li>
                                <li class="mb-0">
                                    <i class="icon-base ti tabler-check text-primary me-2"></i>
                                    {{ __('onboarding.help_4') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <form action="{{ route('onboarding.complete') }}" method="POST">
                        @csrf
                        <div class="d-flex gap-2">
                            <a href="{{ route('onboarding.step4') }}" class="btn btn-label-secondary flex-fill">
                                {{ __('onboarding.back') }}
                            </a>
                            <button type="submit" class="btn btn-primary flex-fill">
                                {{ __('onboarding.get_started') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
