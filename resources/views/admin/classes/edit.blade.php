@extends('layouts.admin')

@section('title', 'Edit Class')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('classes.edit_title') }}</h4>
                        <a href="{{ route('admin.classes.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ __('classes.edit_description') }}</p>

                        <form action="{{ route('admin.classes.update', $class ?? 1) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('classes.title') }}</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                    id="title" name="title" value="{{ old('title', $class->title ?? '') }}"
                                    placeholder="Enter class title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('classes.description') }}</label>
                                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    id="description" name="description" rows="4"
                                    placeholder="Enter class description">{{ old('description', $class->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="categories" class="form-label">{{ __('classes.categories') }}</label>
                                <select class="form-select{{ $errors->has('categories') ? ' is-invalid' : '' }}" 
                                    id="categories" name="categories[]" multiple required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ in_array($category->id, old('categories', $class->categories->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categories')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">{{ __('classes.categories_help') }}</small>
                            </div>

                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">{{ __('classes.thumbnail') }}</label>
                                @if($class->thumbnail ?? false)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $class->thumbnail) }}" 
                                             class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                        <small class="d-block text-muted">{{ __('classes.current_thumbnail') }}</small>
                                    </div>
                                @endif
                                <input type="file" class="form-control{{ $errors->has('thumbnail') ? ' is-invalid' : '' }}"
                                    id="thumbnail" name="thumbnail" accept="image/*">
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">{{ __('classes.thumbnail_help') }}</small>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('classes.status') }}</label>
                                <select class="form-select{{ $errors->has('status') ? ' is-invalid' : '' }}" 
                                    id="status" name="status" required>
                                    <option value="draft" {{ old('status', $class->status ?? '') == 'draft' ? 'selected' : '' }}>
                                        {{ __('classes.status_draft') }}
                                    </option>
                                    <option value="published" {{ old('status', $class->status ?? '') == 'published' ? 'selected' : '' }}>
                                        {{ __('classes.status_published') }}
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.classes.index') }}"
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
            // Initialize Select2 for categories
            $('#categories').select2({
                placeholder: "{{ __('classes.select_categories') }}",
                allowClear: true
            });

            // Preview thumbnail
            $('#thumbnail').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Remove existing preview
                        $('#thumbnail-preview').remove();
                        
                        // Add new preview
                        const preview = $('<div id="thumbnail-preview" class="mt-2"><img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px; max-height: 200px;"><small class="d-block text-muted">{{ __('classes.new_thumbnail') }}</small></div>');
                        $('#thumbnail').parent().append(preview);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
