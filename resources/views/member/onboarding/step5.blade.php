@extends('layouts.member')

@section('title', __('onboarding.step5_title'))
@section('body_class', 'member-onboarding')

@section('content')
    <div class="onboarding-shell page-animate">
        <div class="onboarding-card card">
            <div class="card-body text-center">
                <div class="onboarding-step mb-3">{{ __('onboarding.step') }} 5/5</div>
                <div class="onboarding-progress mb-4" aria-hidden="true">
                    <span class="is-done"></span>
                    <span class="is-done"></span>
                    <span class="is-done"></span>
                    <span class="is-done"></span>
                    <span class="is-active"></span>
                </div>

                <div class="mb-4">
                    <div class="mb-3">
                        <span class="tile-icon" style="width: 64px; height: 64px; border-radius: 18px;">
                            <i class="icon-base ti tabler-circle-check" style="font-size: 28px;"></i>
                        </span>
                    </div>
                    <h2 class="onboarding-title mb-2">{{ __('onboarding.step5_title') }}</h2>
                    <p class="onboarding-subtitle mb-0">{{ __('onboarding.step5_subtitle') }}</p>
                </div>

                <div class="onboarding-tile tile-primary mb-4 text-start tile-animate">
                    <h5 class="mb-3 text-center">{{ __('onboarding.we_can_help') }}</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="icon-base ti tabler-check" style="margin-top: 2px;"></i>
                            <span>{{ __('onboarding.help_1') }}</span>
                        </li>
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="icon-base ti tabler-check" style="margin-top: 2px;"></i>
                            <span>{{ __('onboarding.help_2') }}</span>
                        </li>
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="icon-base ti tabler-check" style="margin-top: 2px;"></i>
                            <span>{{ __('onboarding.help_3') }}</span>
                        </li>
                        <li class="mb-0 d-flex align-items-start gap-2">
                            <i class="icon-base ti tabler-check" style="margin-top: 2px;"></i>
                            <span>{{ __('onboarding.help_4') }}</span>
                        </li>
                    </ul>
                </div>

                <form action="{{ route('onboarding.complete') }}" method="POST" class="onboarding-actions">
                    @csrf
                    <div class="d-flex gap-2 onboarding-actions">
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
@endsection
