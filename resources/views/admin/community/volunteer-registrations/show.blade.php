@extends('layouts.admin')

@section('title', __('community.volunteer_registrations.detail_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.volunteer_registrations.detail_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.community.volunteer-registrations.edit', $registration) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.community.volunteer-registrations.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.full_name') }}</div>
                                <div class="fw-bold">{{ $registration->full_name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.status') }}</div>
                                <div class="fw-bold">{{ $registration->status }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.phone') }}</div>
                                <div class="fw-bold">{{ $registration->phone ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.email') }}</div>
                                <div class="fw-bold">{{ $registration->email ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.region') }}</div>
                                <div class="fw-bold">{{ $registration->region ?? '-' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.type') }}</div>
                                <div class="fw-bold">{{ $registration->type }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.skills') }}</div>
                                <div style="white-space: pre-wrap;">{{ $registration->skills ?? '-' }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.availability') }}
                                </div>
                                <div style="white-space: pre-wrap;">{{ $registration->availability ?? '-' }}</div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted">{{ __('community.volunteer_registrations.fields.notes') }}</div>
                                <div style="white-space: pre-wrap;">{{ $registration->notes ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
