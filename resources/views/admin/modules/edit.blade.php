@extends('layouts.admin')

@section('title', 'Edit Module')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('modules.edit_title') }}</h4>
                        <a href="{{ route('admin.modules.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ __('modules.edit_description') }}</p>

                        <form action="{{ route('admin.modules.update', $module ?? 1) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="class_id" class="form-label">{{ __('modules.class') }}</label>
                                <select class="form-select{{ $errors->has('class_id') ? ' is-invalid' : '' }}" 
                                    id="class_id" name="class_id" required>
                                    <option value="">{{ __('modules.select_class') }}</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" 
                                            {{ old('class_id', $module->class_id ?? '') == $class->id ? 'selected' : '' }}>
                                            {{ $class->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('modules.title') }}</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                    id="title" name="title" value="{{ old('title', $module->title ?? '') }}"
                                    placeholder="Enter module title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="position" class="form-label">{{ __('modules.position') }}</label>
                                <input type="number" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                                    id="position" name="position" value="{{ old('position', $module->position ?? '') }}"
                                    placeholder="Enter position" min="0">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">{{ __('modules.position_help') }}</small>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.modules.index') }}"
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
            // Initialize Select2 for class selection
            $('#class_id').select2({
                placeholder: "{{ __('modules.select_class') }}",
                allowClear: true
            });
        });
    </script>
@endpush
