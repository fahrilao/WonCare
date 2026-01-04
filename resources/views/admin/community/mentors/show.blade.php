@extends('layouts.admin')

@section('title', __('community.mentors.detail_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.mentors.detail_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.community.mentors.edit', $mentor) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.community.mentors.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.mentors.fields.name') }}</div>
                                <div class="fw-bold">{{ $mentor->name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.mentors.fields.status') }}</div>
                                <div class="fw-bold">{{ $mentor->is_active ? __('common.active') : __('common.inactive') }}
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.mentors.fields.title') }}</div>
                                <div class="fw-bold">{{ $mentor->title ?? '-' }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.mentors.fields.expertise') }}</div>
                                <div style="white-space: pre-wrap;">{{ $mentor->expertise ?? '-' }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.mentors.fields.photo_path') }}</div>
                                <div>
                                    @if ($mentor->photo_path)
                                        {{ $mentor->photo_path }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted">{{ __('community.mentors.fields.bio') }}</div>
                                <div style="white-space: pre-wrap;">{{ $mentor->bio ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
