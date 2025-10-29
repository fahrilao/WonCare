@extends('layouts.admin')

@section('title', 'Edit Lesson')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('lessons.edit_title') }}</h4>
                        <a href="{{ route('admin.lessons.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ __('lessons.edit_description') }}</p>

                        <form action="{{ route('admin.lessons.update', $lesson ?? 1) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="module_id" class="form-label">{{ __('lessons.module') }}</label>
                                <select class="form-select{{ $errors->has('module_id') ? ' is-invalid' : '' }}" 
                                    id="module_id" name="module_id" required>
                                    <option value="">{{ __('lessons.select_module') }}</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" 
                                            {{ old('module_id', $lesson->module_id ?? '') == $module->id ? 'selected' : '' }}>
                                            {{ $module->title }} ({{ $module->class ? $module->class->title : 'No Class' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('module_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('lessons.title') }}</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                    id="title" name="title" value="{{ old('title', $lesson->title ?? '') }}"
                                    placeholder="Enter lesson title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('lessons.content') }}</label>
                                <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                    id="content" name="content" rows="6"
                                    placeholder="Enter lesson content">{{ old('content', $lesson->content ?? '') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">{{ __('lessons.type') }}</label>
                                        <select class="form-select{{ $errors->has('type') ? ' is-invalid' : '' }}" 
                                            id="type" name="type">
                                            <option value="">{{ __('lessons.select_type') }}</option>
                                            <option value="video" {{ old('type', $lesson->type ?? '') == 'video' ? 'selected' : '' }}>
                                                {{ __('lessons.type_video') }}
                                            </option>
                                            <option value="text" {{ old('type', $lesson->type ?? '') == 'text' ? 'selected' : '' }}>
                                                {{ __('lessons.type_text') }}
                                            </option>
                                            <option value="quiz" {{ old('type', $lesson->type ?? '') == 'quiz' ? 'selected' : '' }}>
                                                {{ __('lessons.type_quiz') }}
                                            </option>
                                            <option value="assignment" {{ old('type', $lesson->type ?? '') == 'assignment' ? 'selected' : '' }}>
                                                {{ __('lessons.type_assignment') }}
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Video Source Fields (shown only when type is video) -->
                            <div id="video-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="video_source" class="form-label">{{ __('lessons.video_source') }}</label>
                                    <select class="form-select{{ $errors->has('video_source') ? ' is-invalid' : '' }}" 
                                        id="video_source" name="video_source">
                                        <option value="">{{ __('lessons.select_video_source') }}</option>
                                        <option value="youtube" {{ old('video_source', $lesson->video_source ?? '') == 'youtube' ? 'selected' : '' }}>
                                            {{ __('lessons.video_source_youtube') }}
                                        </option>
                                        <option value="upload" {{ old('video_source', $lesson->video_source ?? '') == 'upload' ? 'selected' : '' }}>
                                            {{ __('lessons.video_source_upload') }}
                                        </option>
                                    </select>
                                    @error('video_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- YouTube URL Field -->
                                <div id="youtube-field" class="mb-3" style="display: none;">
                                    <label for="youtube_url" class="form-label">{{ __('lessons.youtube_url') }}</label>
                                    <input type="url" class="form-control{{ $errors->has('youtube_url') ? ' is-invalid' : '' }}"
                                        id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $lesson->youtube_url ?? '') }}"
                                        placeholder="https://www.youtube.com/watch?v=...">
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('lessons.youtube_url_help') }}</small>
                                </div>

                                <!-- Video Upload Field -->
                                <div id="upload-field" class="mb-3" style="display: none;">
                                    @if($lesson->video_file ?? false)
                                        <div class="mb-2">
                                            <small class="text-muted">{{ __('lessons.current_video') }}: {{ basename($lesson->video_file) }}</small>
                                        </div>
                                    @endif
                                    <label for="video_file" class="form-label">{{ __('lessons.video_file') }}</label>
                                    <input type="file" class="form-control{{ $errors->has('video_file') ? ' is-invalid' : '' }}"
                                        id="video_file" name="video_file" accept="video/*">
                                    @error('video_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('lessons.video_file_help_edit') }}</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">{{ __('lessons.duration') }}</label>
                                        <input type="number" class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}"
                                            id="duration" name="duration" value="{{ old('duration', $lesson->duration ?? '') }}"
                                            placeholder="Duration in seconds" min="0">
                                        @error('duration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">{{ __('lessons.duration_help') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">{{ __('lessons.position') }}</label>
                                        <input type="number" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                                            id="position" name="position" value="{{ old('position', $lesson->position ?? '') }}"
                                            placeholder="Enter position" min="0">
                                        @error('position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">{{ __('lessons.position_help') }}</small>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.lessons.index') }}"
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

@push('vendor_scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for module selection
            $('#module_id').select2({
                placeholder: "{{ __('lessons.select_module') }}",
                allowClear: true
            });

            // Handle lesson type change
            $('#type').on('change', function() {
                const type = $(this).val();
                const videoFields = $('#video-fields');
                
                if (type === 'video') {
                    videoFields.show();
                } else {
                    videoFields.hide();
                    $('#video_source').val('');
                    $('#youtube_url').val('');
                    $('#video_file').val('');
                    $('#youtube-field, #upload-field').hide();
                }
            });

            // Handle video source change
            $('#video_source').on('change', function() {
                const source = $(this).val();
                const youtubeField = $('#youtube-field');
                const uploadField = $('#upload-field');
                
                if (source === 'youtube') {
                    youtubeField.show();
                    uploadField.hide();
                    $('#video_file').val('');
                } else if (source === 'upload') {
                    uploadField.show();
                    youtubeField.hide();
                    $('#youtube_url').val('');
                } else {
                    youtubeField.hide();
                    uploadField.hide();
                    $('#youtube_url').val('');
                    $('#video_file').val('');
                }
            });

            // Initialize on page load if values exist
            if ($('#type').val() === 'video') {
                $('#video-fields').show();
                $('#video_source').trigger('change');
            }
        });
    </script>
@endpush
