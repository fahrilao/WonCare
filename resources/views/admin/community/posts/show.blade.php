@extends('layouts.admin')

@section('title', __('community.posts.detail_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.posts.detail_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.community.posts.edit', $post) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.community.posts.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="text-muted">{{ __('community.posts.fields.title') }}</div>
                                <div class="fw-bold">{{ $post->title }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.posts.fields.author_name') }}</div>
                                <div class="fw-bold">{{ $post->author_name ?? '-' }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-muted">{{ __('community.posts.fields.status') }}</div>
                                <div class="fw-bold">{{ $post->status }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-muted">{{ __('community.posts.fields.pinned') }}</div>
                                <div class="fw-bold">{{ $post->is_pinned ? __('common.yes') : __('common.no_value') }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted">{{ __('community.posts.fields.published_at') }}</div>
                                <div class="fw-bold">
                                    {{ $post->published_at ? $post->published_at->format('Y-m-d H:i:s') : '-' }}</div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted">{{ __('community.posts.fields.content') }}</div>
                                <div class="mt-2" style="white-space: pre-wrap;">{{ $post->content }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
