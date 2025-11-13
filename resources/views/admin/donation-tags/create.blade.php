@extends('layouts.admin')

@section('title', __('donation_tags.create_donation_tag'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('donation_tags.create_donation_tag') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.donation-tags.store') }}" method="POST" id="donation-tag-form">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('donation_tags.name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="{{ __('donation_tags.enter_tag_name') }}" required>
                                        <div class="form-text">{{ __('donation_tags.name_help') }}</div>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Slug -->
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">{{ __('donation_tags.slug') }}</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug') }}"
                                            placeholder="auto-generated">
                                        <div class="form-text">{{ __('donation_tags.slug_help') }}</div>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label for="description"
                                            class="form-label">{{ __('donation_tags.description') }}</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="3" placeholder="{{ __('donation_tags.enter_description') }}">{{ old('description') }}</textarea>
                                        <div class="form-text">{{ __('donation_tags.description_help') }}</div>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Color -->
                                    <div class="mb-3">
                                        <label for="color" class="form-label">{{ __('donation_tags.color') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="color"
                                                class="form-control form-control-color @error('color') is-invalid @enderror"
                                                id="color" name="color" value="{{ old('color', '#3b82f6') }}"
                                                required>
                                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                                id="color-text" value="{{ old('color', '#3b82f6') }}" placeholder="#3b82f6"
                                                pattern="^#[0-9A-Fa-f]{6}$">
                                        </div>
                                        <div class="form-text">{{ __('donation_tags.color_help') }}</div>
                                        @error('color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Sort Order -->
                                    <div class="mb-3">
                                        <label for="sort_order"
                                            class="form-label">{{ __('donation_tags.sort_order') }}</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                            id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                                            min="0" placeholder="0">
                                        <div class="form-text">{{ __('donation_tags.sort_order_help') }}</div>
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="py-5">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                {{ __('donation_tags.is_active') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.donation-tags.index') }}" class="btn btn-secondary">
                                            {{ __('common.cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('common.create') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-generate slug from name
            $('#name').on('input', function() {
                const name = $(this).val();
                const slug = name.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
                $('#slug').val(slug);
            });

            // Sync color picker with text input
            $('#color').on('input', function() {
                $('#color-text').val($(this).val());
            });

            $('#color-text').on('input', function() {
                const color = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
                    $('#color').val(color);
                }
            });

            // Form validation
            $('#donation-tag-form').on('submit', function(e) {
                const colorValue = $('#color-text').val();
                if (!/^#[0-9A-Fa-f]{6}$/.test(colorValue)) {
                    e.preventDefault();
                    alert('{{ __('donation_tags.color_format') }}');
                    return false;
                }

                // Set the color input value to match text input
                $('#color').val(colorValue);
            });
        });
    </script>
@endpush
