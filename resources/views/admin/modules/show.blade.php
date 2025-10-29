@extends('layouts.admin')

@section('title', 'Module Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('modules.view_title') }}</h4>
                        <div>
                            <a href="{{ route('admin.modules.edit', $module ?? 1) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.modules.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"><strong>ID:</strong></div>
                            <div class="col-md-9">{{ $module->id ?? 'Module ID will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('modules.title') }}:</strong></div>
                            <div class="col-md-9">{{ $module->title ?? 'Module title will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('modules.class') }}:</strong></div>
                            <div class="col-md-9">
                                @if($module->class ?? false)
                                    <a href="{{ route('admin.classes.show', $module->class->id) }}" class="text-decoration-none">
                                        {{ $module->class->title }}
                                    </a>
                                @else
                                    Module class will be displayed here
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('modules.position') }}:</strong></div>
                            <div class="col-md-9">{{ $module->position ?? 'Module position will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('common.created_at') }}:</strong></div>
                            <div class="col-md-9">{{ $module->created_at ?? 'Creation date will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('common.updated_at') }}:</strong></div>
                            <div class="col-md-9">{{ $module->updated_at ?? 'Last update date will be displayed here' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
