@extends('layouts.admin')

@section('title', 'Class Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('classes.view_title') }}</h4>
                        <div>
                            <a href="{{ route('admin.classes.edit', $class ?? 1) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.classes.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"><strong>ID:</strong></div>
                            <div class="col-md-9">{{ $class->id ?? 'Class ID will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('classes.title') }}:</strong></div>
                            <div class="col-md-9">{{ $class->title ?? 'Class title will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('classes.description') }}:</strong></div>
                            <div class="col-md-9">
                                @if($class->description ?? false)
                                    {!! nl2br(e($class->description)) !!}
                                @else
                                    Class description will be displayed here
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('classes.categories') }}:</strong></div>
                            <div class="col-md-9">
                                @if($class->categories ?? false)
                                    @foreach($class->categories as $category)
                                        <span class="badge bg-primary me-1">{{ $category->name }}</span>
                                    @endforeach
                                @else
                                    Class categories will be displayed here
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('classes.thumbnail') }}:</strong></div>
                            <div class="col-md-9">
                                @if($class->thumbnail ?? false)
                                    <img src="{{ asset('storage/' . $class->thumbnail) }}" 
                                         class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                                @else
                                    <span class="text-muted">No thumbnail uploaded</span>
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('classes.status') }}:</strong></div>
                            <div class="col-md-9">
                                @if($class->status ?? false)
                                    @if($class->status === 'published')
                                        <span class="badge bg-success">{{ __('classes.status_published') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('classes.status_draft') }}</span>
                                    @endif
                                @else
                                    Class status will be displayed here
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('common.created_at') }}:</strong></div>
                            <div class="col-md-9">{{ $class->created_at ?? 'Creation date will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('common.updated_at') }}:</strong></div>
                            <div class="col-md-9">{{ $class->updated_at ?? 'Last update date will be displayed here' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
