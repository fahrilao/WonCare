@extends('layouts.member')

@section('title', __('members.dashboard_title'))
@section('body_class', 'member-modern')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/member-course.css') }}" />
    <style>
        .member-dashboard-hero {
            background: linear-gradient(135deg, rgba(30, 142, 116, 1) 0%, rgba(56, 168, 143, 1) 100%);
            border-radius: 1.25rem;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            min-height: 200px;
        }

        .member-dashboard-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.12) 1px, transparent 1px);
            background-size: 28px 28px;
            opacity: 0.35;
            pointer-events: none;
        }

        .member-dashboard-hero>* {
            position: relative;
            z-index: 1;
        }

        .member-dashboard-quickcard {
            border-radius: 1rem;
        }

        .member-dashboard-quickicon {
            width: 44px;
            height: 44px;
            border-radius: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <div class="page-animate">
        <div class="member-dashboard-hero mb-5">
            <div class="d-flex flex-column gap-4">
                <div>
                    <h2 class="text-white mb-1" style="font-weight: 700;">
                        {{ __('members.welcome_back_name', ['name' => $member->name]) }}
                    </h2>
                    <div class="text-white">{{ __('members.dashboard_subtitle') }}</div>
                </div>

                <div class="col-lg-7 col-xl-6 p-0">
                    <div class="input-group input-group-merge bg-white rounded-pill shadow-sm">
                        <span class="input-group-text bg-transparent border-0">
                            <i class="icon-base ti tabler-search"></i>
                        </span>
                        <input type="text" class="form-control border-0"
                            placeholder="{{ __('members.dashboard_search') }}" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-12 col-md-6 col-xl-3">
                <a href="{{ route('member.courses.index') }}" class="text-decoration-none">
                    <div class="card member-dashboard-quickcard h-100">
                        <div class="card-body">
                            <div class="member-dashboard-quickicon bg-label-success mb-3">
                                <i class="icon-base ti tabler-device-desktop icon-md"></i>
                            </div>
                            <div class="fw-semibold text-heading">{{ __('dashboard.member_quick_ecourse_title') }}</div>
                            <div class="text-muted" style="font-size: .85rem;">
                                {{ __('dashboard.member_quick_ecourse_subtitle') }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <a href="{{ route('member.donate.index') }}" class="text-decoration-none">
                    <div class="card member-dashboard-quickcard h-100">
                        <div class="card-body">
                            <div class="member-dashboard-quickicon bg-label-danger mb-3">
                                <i class="icon-base ti tabler-heart icon-md"></i>
                            </div>
                            <div class="fw-semibold text-heading">{{ __('dashboard.member_quick_donation_title') }}</div>
                            <div class="text-muted" style="font-size: .85rem;">
                                {{ __('dashboard.member_quick_donation_subtitle') }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <a href="{{ route('member.zakat.calculator') }}" class="text-decoration-none">
                    <div class="card member-dashboard-quickcard h-100">
                        <div class="card-body">
                            <div class="member-dashboard-quickicon bg-label-warning mb-3">
                                <i class="icon-base ti tabler-calculator icon-md"></i>
                            </div>
                            <div class="fw-semibold text-heading">{{ __('dashboard.member_quick_zakat_title') }}</div>
                            <div class="text-muted" style="font-size: .85rem;">
                                {{ __('dashboard.member_quick_zakat_subtitle') }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <a href="javascript:void(0)" class="text-decoration-none">
                    <div class="card member-dashboard-quickcard h-100">
                        <div class="card-body">
                            <div class="member-dashboard-quickicon bg-label-primary mb-3">
                                <i class="icon-base ti tabler-calendar icon-md"></i>
                            </div>
                            <div class="fw-semibold text-heading">{{ __('dashboard.member_quick_event_title') }}</div>
                            <div class="text-muted" style="font-size: .85rem;">
                                {{ __('dashboard.member_quick_event_subtitle') }}</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- E-Course List --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="mb-0">{{ __('dashboard.continue_your_learning') }}</h5>
                <div class="text-muted" style="font-size: .85rem;">{{ __('dashboard.member_continue_subtitle') }}</div>
            </div>
            <a href="{{ route('member.courses.index') }}" class="text-decoration-none" style="font-size: .85rem;">
                <span class="text-success">{{ __('dashboard.member_view_all_courses') }}</span>
                <i class="icon-base ti tabler-arrow-right ms-1"></i>
            </a>
        </div>

        @php
            $continueCourses = $continueCourses ?? collect();
        @endphp

        @if ($continueCourses->isEmpty())
            <div class="card">
                <div class="card-body text-center text-muted">
                    {{ __('dashboard.member_no_courses') }}
                </div>
            </div>
        @else
            <div class="d-flex flex-column gap-4">
                @foreach ($continueCourses as $enrollment)
                    @php
                        $class = $enrollment->class;
                        $progress = (float) ($enrollment->completion_percentage ?? 0);
                        $progressInt = (int) round($progress);
                        $totalLessons = (int) ($class->total_lessons ?? 0);
                        $minutes = (int) ($class->estimated_duration ?? 0);
                        $hours = $minutes > 0 ? (int) floor($minutes / 60) : 0;
                        $remainingMinutes = $minutes > 0 ? (int) ($minutes % 60) : 0;
                        $thumbnailUrl = $class && $class->thumbnail ? asset('storage/' . $class->thumbnail) : null;
                    @endphp

                    @if ($class)
                        <a href="{{ route('member.courses.show', $class) }}" class="text-decoration-none">
                            <div class="card member-course-card">
                                <div class="d-flex gap-4">
                                    <div class="member-course-thumb"
                                        style="min-width: 200px; background-image: url('{{ $thumbnailUrl }}'); background-size: cover; background-position: center;">
                                        <div class="member-course-play">
                                            <i class="icon-base ti tabler-player-play icon-md"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="fw-semibold text-heading">{{ $class->title }}</div>
                                        @if ($class->description)
                                            <div class="text-muted mt-1" style="font-size: .9rem;">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($class->description), 140) }}
                                            </div>
                                        @endif

                                        <div class="d-flex flex-wrap gap-3 text-muted mt-2" style="font-size: .85rem;">
                                            <div class="d-flex align-items-center gap-1">
                                                <i class="icon-base ti tabler-book icon-sm"></i>
                                                <span>{{ __('dashboard.lessons_count', ['count' => $totalLessons]) }}</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-1">
                                                <i class="icon-base ti tabler-clock icon-sm"></i>
                                                <span>{{ __('dashboard.duration_hm', ['hours' => $hours, 'minutes' => $remainingMinutes]) }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2"
                                                style="font-size: .85rem;">
                                                <span class="text-muted">{{ __('dashboard.progress') }}</span>
                                                <span class="text-success fw-semibold">{{ $progressInt }}%</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $progressInt }}%"
                                                    aria-valuenow="{{ $progressInt }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
