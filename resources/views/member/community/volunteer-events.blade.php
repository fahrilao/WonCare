@extends('layouts.member')

@section('title', __('community.volunteer.events_title'))
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 mb-4">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1">{{ __('community.volunteer.events_title') }}</h4>
                        <p class="text-muted mb-0">{{ __('community.volunteer.events_subtitle') }}</p>
                    </div>
                    <a href="{{ route('member.community.volunteer-register') }}" class="btn btn-primary">
                        <i class="ti tabler-user-plus me-1"></i>{{ __('community.volunteer.register_now') }}
                    </a>
                </div>

                <!-- Upcoming Events -->
                <h5 class="mb-3">{{ __('community.volunteer.upcoming_events') }}</h5>
                @if ($upcomingEvents->count() > 0)
                    @foreach ($upcomingEvents as $event)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $event->title }}</h6>
                                    @if ($event->is_online)
                                        <span class="badge bg-label-info">
                                            <i class="ti tabler-world"></i> {{ __('community.volunteer.online') }}
                                        </span>
                                    @else
                                        <span class="badge bg-label-primary">
                                            <i class="ti tabler-map-pin"></i> {{ __('community.volunteer.offline') }}
                                        </span>
                                    @endif
                                </div>

                                <p class="text-muted mb-3">{{ $event->description }}</p>

                                <div class="row g-2 mb-3">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="ti tabler-calendar me-1"></i>
                                            {{ $event->start_at->format('d M Y, H:i') }}
                                            @if ($event->end_at)
                                                - {{ $event->end_at->format('H:i') }}
                                            @endif
                                        </small>
                                    </div>
                                    @if (!$event->is_online && $event->location)
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="ti tabler-map-pin me-1"></i>{{ $event->location }}
                                            </small>
                                        </div>
                                    @endif
                                    @if ($event->region)
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="ti tabler-map me-1"></i>{{ $event->region }}
                                            </small>
                                        </div>
                                    @endif
                                </div>

                                @if ($event->registration_link)
                                    <a href="{{ $event->registration_link }}" target="_blank"
                                        class="btn btn-sm btn-primary">
                                        <i
                                            class="ti tabler-external-link me-1"></i>{{ __('community.volunteer.register_event') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card mb-4">
                        <div class="card-body text-center py-4">
                            <i class="ti tabler-calendar-off ti-lg text-muted mb-2"></i>
                            <p class="text-muted mb-0">{{ __('community.volunteer.no_upcoming_events') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Past Events -->
                @if ($pastEvents->count() > 0)
                    <h5 class="mb-3 mt-4">{{ __('community.volunteer.past_events') }}</h5>
                    @foreach ($pastEvents as $event)
                        <div class="card mb-3 opacity-75">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $event->title }}</h6>
                                    <span class="badge bg-label-secondary">
                                        {{ __('community.volunteer.completed') }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="ti tabler-calendar me-1"></i>
                                    {{ $event->start_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Become a Volunteer -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ti tabler-heart-handshake me-2"></i>{{ __('community.volunteer.become_volunteer') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">{{ __('community.volunteer.become_volunteer_desc') }}</p>
                        <a href="{{ route('member.community.volunteer-register') }}" class="btn btn-primary w-100">
                            <i class="ti tabler-user-plus me-1"></i>{{ __('community.volunteer.register_now') }}
                        </a>
                    </div>
                </div>

                <!-- Volunteer Types -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('community.volunteer.types_title') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="mb-1">
                                <i class="ti tabler-device-laptop text-info me-1"></i>
                                {{ __('community.volunteer.type_digital') }}
                            </h6>
                            <small class="text-muted">{{ __('community.volunteer.type_digital_desc') }}</small>
                        </div>
                        <div class="mb-3">
                            <h6 class="mb-1">
                                <i class="ti tabler-users text-primary me-1"></i>
                                {{ __('community.volunteer.type_offline') }}
                            </h6>
                            <small class="text-muted">{{ __('community.volunteer.type_offline_desc') }}</small>
                        </div>
                        <div>
                            <h6 class="mb-1">
                                <i class="ti tabler-world text-success me-1"></i>
                                {{ __('community.volunteer.type_both') }}
                            </h6>
                            <small class="text-muted">{{ __('community.volunteer.type_both_desc') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
