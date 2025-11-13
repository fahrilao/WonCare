@extends('layouts.admin')

@section('title', __('donation_campaigns.edit_title'))

@section('content')
    <div class="container-xxl grow container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('donation_campaigns.edit_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.donation-campaigns.show', $donationCampaign->id) }}"
                                class="btn btn-info btn-sm">
                                {{ __('common.view') }}
                            </a>
                            <a href="{{ route('admin.donation-campaigns.index') }}" class="btn btn-secondary">
                                {{ __('common.back_to_list') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.donation-campaigns.update', $donationCampaign->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Title -->
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">
                                        {{ __('donation_campaigns.title') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $donationCampaign->title) }}"
                                        placeholder="{{ __('donation_campaigns.title_placeholder') }}" required>
                                    <small class="form-text text-muted">{{ __('donation_campaigns.title_help') }}</small>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">
                                        {{ __('donation_campaigns.status') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="">{{ __('donation_campaigns.status_help') }}</option>
                                        <option value="draft"
                                            {{ old('status', $donationCampaign->status) == 'draft' ? 'selected' : '' }}>
                                            {{ __('donation_campaigns.status_draft') }}
                                        </option>
                                        <option value="active"
                                            {{ old('status', $donationCampaign->status) == 'active' ? 'selected' : '' }}>
                                            {{ __('donation_campaigns.status_active') }}
                                        </option>
                                        <option value="completed"
                                            {{ old('status', $donationCampaign->status) == 'completed' ? 'selected' : '' }}>
                                            {{ __('donation_campaigns.status_completed') }}
                                        </option>
                                        <option value="cancelled"
                                            {{ old('status', $donationCampaign->status) == 'cancelled' ? 'selected' : '' }}>
                                            {{ __('donation_campaigns.status_cancelled') }}
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Goal Amount -->
                                <div class="col-md-6 mb-3">
                                    <label for="goal_amount" class="form-label">
                                        {{ __('donation_campaigns.goal_amount') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp. </span>
                                        <input type="number"
                                            class="form-control @error('goal_amount') is-invalid @enderror" id="goal_amount"
                                            name="goal_amount"
                                            value="{{ old('goal_amount', $donationCampaign->goal_amount) }}"
                                            placeholder="{{ __('donation_campaigns.goal_amount_placeholder') }}"
                                            step="0.01" min="0" required>
                                        @error('goal_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small
                                        class="form-text text-muted">{{ __('donation_campaigns.goal_amount_help') }}</small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Start Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">
                                        {{ __('donation_campaigns.start_date') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local"
                                        class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                                        name="start_date"
                                        value="{{ old('start_date', $donationCampaign->start_date ? $donationCampaign->start_date->format('Y-m-d\TH:i') : '') }}"
                                        required>
                                    <small
                                        class="form-text text-muted">{{ __('donation_campaigns.start_date_help') }}</small>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- End Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="end_date"
                                        class="form-label">{{ __('donation_campaigns.end_date') }}</label>
                                    <input type="datetime-local"
                                        class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                                        name="end_date"
                                        value="{{ old('end_date', $donationCampaign->end_date ? $donationCampaign->end_date->format('Y-m-d\TH:i') : '') }}">
                                    <small
                                        class="form-text text-muted">{{ __('donation_campaigns.end_date_help') }}</small>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description"
                                    class="form-label">{{ __('donation_campaigns.description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="{{ __('donation_campaigns.description_placeholder') }}">{{ old('description', $donationCampaign->description) }}</textarea>
                                <small class="form-text text-muted">{{ __('donation_campaigns.description_help') }}</small>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tags -->
                            <div class="mb-3">
                                <label for="tags" class="form-label">{{ __('donation_campaigns.tags') }}</label>
                                <select class="form-select @error('tags') is-invalid @enderror" id="tags"
                                    name="tags[]" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', $donationCampaign->tags->pluck('id')->toArray())) ? 'selected' : '' }}
                                            data-color="{{ $tag->color }}">
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">{{ __('donation_campaigns.tags_help') }}</small>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.donation-campaigns.index') }}" class="btn btn-secondary">
                                    {{ __('common.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('common.update') }}
                                </button>
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <style>
        .image-preview {
            position: relative;
            display: inline-block;
            margin: 5px;
        }

        .image-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid #ddd;
        }

        .image-preview .remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
        }

        .select2-selection__choice {
            background-color: var(--bs-primary) !important;
            border: 1px solid var(--bs-primary) !important;
            color: white !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let imagesToDelete = [];

        $(document).ready(function() {
            // Initialize Select2 for tags
            $('#tags').select2({
                placeholder: '{{ __('donation_campaigns.select_tags') }}',
                allowClear: true,
                templateResult: function(tag) {
                    if (!tag.id) return tag.text;
                    const color = $(tag.element).data('color');
                    return $('<span style="color: ' + color + '; font-weight: bold;">' + tag.text +
                        '</span>');
                },
                templateSelection: function(tag) {
                    if (!tag.id) return tag.text;
                    const color = $(tag.element).data('color');
                    return $('<span style="background-color: ' + color +
                        '; color: white; padding: 2px 6px; border-radius: 3px;">' + tag.text +
                        '</span>');
                }
            });

            // Handle existing image removal
            $('.remove-existing-image').on('click', function() {
                const imageId = $(this).data('image-id');
                const imageContainer = $(this).closest('.existing-image');

                // Add to delete list
                imagesToDelete.push(imageId);
                $('#delete_images').val(JSON.stringify(imagesToDelete));

                // Hide the image container
                imageContainer.fadeOut(300, function() {
                    $(this).remove();
                });
            });

            // Image preview functionality for new images
            $('#images').on('change', function() {
                const files = this.files;
                const container = $('#image-preview-container');
                container.empty();

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const preview = $(`
                            <div class="image-preview" data-index="${i}">
                                <img src="${e.target.result}" alt="Preview">
                                <button type="button" class="remove-image" onclick="removeImagePreview(${i})">&times;</button>
                                <input type="text" class="form-control form-control-sm mt-1" 
                                       name="image_alt[${i}]" placeholder="Alt text (optional)">
                            </div>
                        `);
                        container.append(preview);
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Update end_date minimum when start_date changes
            $('#start_date').on('change', function() {
                const startDate = $(this).val();
                if (startDate) {
                    $('#end_date').attr('min', startDate);
                }
            });

            // Set initial minimum for end_date
            const currentStartDate = $('#start_date').val();
            if (currentStartDate) {
                $('#end_date').attr('min', currentStartDate);
            }
        });

        // Remove image preview function
        function removeImagePreview(index) {
            $(`.image-preview[data-index="${index}"]`).remove();

            // Reset file input to trigger change event properly
            const fileInput = document.getElementById('images');
            const dt = new DataTransfer();
            const files = fileInput.files;

            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }

            fileInput.files = dt.files;

            // Re-index remaining previews
            $('.image-preview').each(function(newIndex) {
                $(this).attr('data-index', newIndex);
                $(this).find('input[name^="image_alt"]').attr('name', `image_alt[${newIndex}]`);
                $(this).find('.remove-image').attr('onclick', `removeImagePreview(${newIndex})`);
            });
        }
    </script>
@endpush
