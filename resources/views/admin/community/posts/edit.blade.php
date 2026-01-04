@extends('layouts.admin')

@section('title', __('community.posts.edit_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.posts.edit_title') }}</h4>
                        <a href="{{ route('admin.community.posts.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.community.posts.update', $post) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('community.posts.fields.title') }}</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                    id="title" name="title" value="{{ old('title', $post->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="author_name"
                                    class="form-label">{{ __('community.posts.fields.author_name') }}</label>
                                <input type="text"
                                    class="form-control{{ $errors->has('author_name') ? ' is-invalid' : '' }}"
                                    id="author_name" name="author_name"
                                    value="{{ old('author_name', $post->author_name) }}">
                                @error('author_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('community.posts.fields.status') }}</label>
                                <select class="form-select{{ $errors->has('status') ? ' is-invalid' : '' }}" id="status"
                                    name="status" required>
                                    @php $value = old('status', $post->status); @endphp
                                    <option value="published" {{ $value === 'published' ? 'selected' : '' }}>published
                                    </option>
                                    <option value="draft" {{ $value === 'draft' ? 'selected' : '' }}>draft</option>
                                    <option value="hidden" {{ $value === 'hidden' ? 'selected' : '' }}>hidden</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="is_pinned" name="is_pinned"
                                    {{ old('is_pinned', $post->is_pinned) ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="is_pinned">{{ __('community.posts.fields.pinned') }}</label>
                            </div>

                            <div class="mb-3">
                                <label for="published_at"
                                    class="form-label">{{ __('community.posts.fields.published_at') }}</label>
                                <input type="datetime-local"
                                    class="form-control{{ $errors->has('published_at') ? ' is-invalid' : '' }}"
                                    id="published_at" name="published_at"
                                    value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="content" class="form-label">{{ __('community.posts.fields.content') }}</label>
                                <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" id="content" name="content"
                                    rows="10" required>{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.community.posts.index') }}"
                                    class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
