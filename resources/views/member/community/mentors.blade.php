@extends('layouts.member')

@section('title', __('community.mentors.title'))
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="mb-1">{{ __('community.mentors.title') }}</h4>
            <p class="text-muted">{{ __('community.mentors.subtitle') }}</p>
        </div>

        @if ($mentors->count() > 0)
            <div class="row">
                @foreach ($mentors as $mentor)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <!-- Mentor Photo -->
                                <div class="mb-3">
                                    @if ($mentor->photo_path)
                                        <img src="{{ asset('storage/' . $mentor->photo_path) }}" alt="{{ $mentor->name }}"
                                            class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="d-flex justify-content-center">
                                            <span
                                                class="avatar-initial rounded-circle bg-label-primary d-flex align-items-center justify-content-center"
                                                style="width:80px;height:80px;font-size:2rem;font-weight:600;">
                                                {{ strtoupper(substr($mentor->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Mentor Info -->
                                <h5 class="mb-1">{{ $mentor->name }}</h5>
                                <p class="text-primary mb-3">{{ $mentor->title }}</p>

                                @if ($mentor->expertise)
                                    <div class="mb-3">
                                        @foreach ((array) $mentor->expertise as $skill)
                                            <span class="badge bg-label-info me-1 mb-1">{{ trim($skill) }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                @if ($mentor->bio)
                                    <p class="text-muted small text-start">{{ $mentor->bio }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti tabler-user-search ti-lg text-muted mb-3"></i>
                    <h5 class="text-muted">{{ __('community.mentors.no_mentors') }}</h5>
                    <p class="text-muted">{{ __('community.mentors.no_mentors_desc') }}</p>
                </div>
            </div>
        @endif

        <!-- Info Section -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="mb-3">{{ __('community.mentors.about_title') }}</h5>
                <p class="text-muted mb-3">{{ __('community.mentors.about_desc') }}</p>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="ti tabler-book text-primary me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-1">{{ __('community.mentors.expertise_1') }}</h6>
                                <small class="text-muted">{{ __('community.mentors.expertise_1_desc') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="ti tabler-certificate text-primary me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-1">{{ __('community.mentors.expertise_2') }}</h6>
                                <small class="text-muted">{{ __('community.mentors.expertise_2_desc') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="ti tabler-chart-line text-primary me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-1">{{ __('community.mentors.expertise_3') }}</h6>
                                <small class="text-muted">{{ __('community.mentors.expertise_3_desc') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
