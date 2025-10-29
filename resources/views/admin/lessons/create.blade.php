@extends('layouts.admin')

@section('title', 'Create Lesson')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('lessons.create_title') }}</h4>
                        <a href="{{ route('admin.lessons.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ __('lessons.create_description') }}</p>

                        <form action="{{ route('admin.lessons.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="module_id" class="form-label">{{ __('lessons.module') }}</label>
                                <select class="form-select{{ $errors->has('module_id') ? ' is-invalid' : '' }}" 
                                    id="module_id" name="module_id" required>
                                    <option value="">{{ __('lessons.select_module') }}</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" 
                                            {{ old('module_id') == $module->id ? 'selected' : '' }}>
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
                                    id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Enter lesson title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('lessons.content') }}</label>
                                <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                    id="content" name="content" rows="6"
                                    placeholder="Enter lesson content">{{ old('content') }}</textarea>
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
                                            <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>
                                                {{ __('lessons.type_video') }}
                                            </option>
                                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>
                                                {{ __('lessons.type_text') }}
                                            </option>
                                            <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>
                                                {{ __('lessons.type_quiz') }}
                                            </option>
                                            <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>
                                                {{ __('lessons.type_assignment') }}
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">{{ __('lessons.duration') }}</label>
                                        <input type="number" class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}"
                                            id="duration" name="duration" value="{{ old('duration') }}"
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
                                            id="position" name="position" value="{{ old('position') }}"
                                            placeholder="Enter position (optional)" min="0">
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
                                <button type="submit" class="btn btn-primary">{{ __('common.create') }}</button>
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
        });
    </script>
@endpush
