@extends('layouts.admin')

@section('title', __('community.whatsapp_groups.detail_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.whatsapp_groups.detail_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.community.whatsapp-groups.edit', $group) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.community.whatsapp-groups.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.whatsapp_groups.fields.region') }}</div>
                                <div class="fw-bold">{{ $group->region }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.whatsapp_groups.fields.status') }}</div>
                                <div class="fw-bold">{{ $group->is_active ? __('common.active') : __('common.inactive') }}
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.whatsapp_groups.fields.name') }}</div>
                                <div class="fw-bold">{{ $group->name }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.whatsapp_groups.fields.whatsapp_link') }}</div>
                                <div>
                                    <a href="{{ $group->whatsapp_link }}" target="_blank"
                                        rel="noopener">{{ $group->whatsapp_link }}</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted">{{ __('community.whatsapp_groups.fields.description') }}</div>
                                <div>{{ $group->description ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
