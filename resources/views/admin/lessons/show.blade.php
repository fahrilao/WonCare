@extends('layouts.admin')

@section('title', 'Lesson Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('lessons.view_title') }}</h4>
                        <div>
                            <a href="{{ route('admin.lessons.edit', $lesson ?? 1) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.lessons.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"><strong>ID:</strong></div>
                            <div class="col-md-9">{{ $lesson->id ?? 'Lesson ID will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('lessons.title') }}:</strong></div>
                            <div class="col-md-9">{{ $lesson->title ?? 'Lesson title will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('lessons.module') }}:</strong></div>
                            <div class="col-md-9">
                                @if($lesson->module ?? false)
                                    <a href="{{ route('admin.modules.show', $lesson->module->id) }}" class="text-decoration-none">
                                        {{ $lesson->module->title }}
                                    </a>
                                @else
                                    Lesson module will be displayed here
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('lessons.class') }}:</strong></div>
                            <div class="col-md-9">
                                @if($lesson->module && $lesson->module->class ?? false)
                                    <a href="{{ route('admin.classes.show', $lesson->module->class->id) }}" class="text-decoration-none">
                                        {{ $lesson->module->class->title }}
                                    </a>
                                @else
                                    Lesson class will be displayed here
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('lessons.content') }}:</strong></div>
                            <div class="col-md-9">
                                @if($lesson->content ?? false)
                                    <div class="border rounded p-3 bg-light">
                                        {!! nl2br(e($lesson->content)) !!}
                                    </div>
                                @else
                                    <span class="text-muted">No content available</span>
                                @endif
                            </div>
                        </div>
                        <hr>

                        @if($lesson->type === 'video' && $lesson->hasVideo())
                            <div class="row">
                                <div class="col-md-3"><strong>{{ __('lessons.video') }}:</strong></div>
                                <div class="col-md-9">
                                    @if($lesson->video_source === 'youtube' && $lesson->youtube_url)
                                        <div class="embed-responsive embed-responsive-16by9 mb-3">
                                            <iframe class="embed-responsive-item" 
                                                src="{{ $lesson->youtube_embed_url }}" 
                                                allowfullscreen
                                                style="width: 100%; height: 315px; border: none;">
                                            </iframe>
                                        </div>
                                        <small class="text-muted">
                                            <strong>{{ __('lessons.youtube_url') }}:</strong> 
                                            <a href="{{ $lesson->youtube_url }}" target="_blank">{{ $lesson->youtube_url }}</a>
                                        </small>
                                    @elseif($lesson->video_source === 'upload' && $lesson->video_file)
                                        <video controls style="width: 100%; max-width: 600px;">
                                            <source src="{{ asset('storage/' . $lesson->video_file) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <br>
                                        <small class="text-muted">
                                            <strong>{{ __('lessons.video_file') }}:</strong> {{ basename($lesson->video_file) }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <hr>
                        @endif

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('lessons.type') }}:</strong></div>
                            <div class="col-md-9">
                                @if($lesson->type ?? false)
                                    @php
                                        $badgeClass = match($lesson->type) {
                                            'video' => 'bg-primary',
                                            'text' => 'bg-info',
                                            'quiz' => 'bg-warning',
                                            'assignment' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($lesson->type) }}</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('lessons.duration') }}:</strong></div>
                            <div class="col-md-9">
                                @if($lesson->duration ?? false)
                                    {{ $lesson->formatted_duration }} ({{ $lesson->duration }} seconds)
                                @else
                                    0:00 (0 seconds)
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('lessons.position') }}:</strong></div>
                            <div class="col-md-9">{{ $lesson->position ?? 'Lesson position will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('common.created_at') }}:</strong></div>
                            <div class="col-md-9">{{ $lesson->created_at ?? 'Creation date will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('common.updated_at') }}:</strong></div>
                            <div class="col-md-9">{{ $lesson->updated_at ?? 'Last update date will be displayed here' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
