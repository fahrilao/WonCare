@extends('layouts.admin')

@section('title', __('community.volunteer_events.detail_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.volunteer_events.detail_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.community.volunteer-events.edit', $event) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.community.volunteer-events.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.title') }}</div>
                                <div class="fw-bold">{{ $event->title }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.region') }}</div>
                                <div class="fw-bold">{{ $event->region ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.mode') }}</div>
                                <div class="fw-bold">{{ $event->is_online ? __('common.online') : __('common.offline') }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.start_at') }}</div>
                                <div class="fw-bold">{{ $event->start_at ? $event->start_at->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.end_at') }}</div>
                                <div class="fw-bold">{{ $event->end_at ? $event->end_at->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.location') }}</div>
                                <div class="fw-bold">{{ $event->location ?? '-' }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.registration_link') }}
                                </div>
                                <div>
                                    @if ($event->registration_link)
                                        <a href="{{ $event->registration_link }}" target="_blank"
                                            rel="noopener">{{ $event->registration_link }}</a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.status') }}</div>
                                <div class="fw-bold">{{ $event->is_active ? __('common.active') : __('common.inactive') }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted">{{ __('community.volunteer_events.fields.description') }}</div>
                                <div style="white-space: pre-wrap;">{{ $event->description ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
