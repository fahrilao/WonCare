@extends('layouts.member')

@section('title', __('community.whatsapp_groups.title'))
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <!-- Page Header -->
                <div class="mb-4">
                    <h4 class="mb-1">{{ __('community.whatsapp_groups.title') }}</h4>
                    <p class="text-muted">{{ __('community.whatsapp_groups.subtitle') }}</p>
                </div>

                @if ($groups->count() > 0)
                    @foreach ($groups as $region => $regionGroups)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ti tabler-map-pin me-2"></i>{{ $region }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($regionGroups as $group)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card h-100 border">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $group->name }}</h6>
                                                    @if ($group->description)
                                                        <p class="card-text text-muted small mb-3">{{ $group->description }}
                                                        </p>
                                                    @endif
                                                    <a href="{{ $group->whatsapp_link }}" target="_blank"
                                                        class="btn btn-success btn-sm w-100">
                                                        <i class="ti tabler-brand-whatsapp me-1"></i>
                                                        {{ __('community.whatsapp_groups.join_group') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="ti tabler-brand-whatsapp ti-lg text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('community.whatsapp_groups.no_groups') }}</h5>
                            <p class="text-muted">{{ __('community.whatsapp_groups.no_groups_desc') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
