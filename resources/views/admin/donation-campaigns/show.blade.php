@extends('layouts.admin')

@section('title', __('donation_campaigns.view_title'))

@section('content')
    <div class="container-xxl grow container-p-y">
        <div class="row gap-4">
            <div class="col-md-12">
                <!-- Campaign Status Information -->
                <div class="row align-items-stretch">
                    <div class="col-md-6">
                        <div class="card border-primary h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title text-primary">{{ __('donation_campaigns.status') }}</h6>
                                <div class="mb-2">
                                    @if ($donationCampaign->status == 'active')
                                        <i class="ti tabler-clock text-success" style="font-size: 2rem;"></i>
                                        <p class="text-success mb-0">Campaign is currently active</p>
                                    @elseif($donationCampaign->status == 'completed')
                                        <i class="ti tabler-clock-off text-warning" style="font-size: 2rem;"></i>
                                        <p class="text-warning mb-0">Campaign has ended</p>
                                    @else
                                        <i class="ti tabler-clock text-info" style="font-size: 2rem;"></i>
                                        <p class="text-info mb-0">Campaign not yet started</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-success h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ __('donation_campaigns.progress') }}
                                </h6>
                                <div class="mb-2">
                                    <div style="font-size: 2rem;" class="text-success">
                                        {{ $donationCampaign->progress_percentage }}%
                                    </div>
                                    <p class="mb-0">
                                        Rp. {{ $donationCampaign->formatted_collected_amount }} of
                                        Rp. {{ $donationCampaign->formatted_goal_amount }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('donation_campaigns.view_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.donation-campaigns.edit', $donationCampaign->id) }}"
                                class="btn btn-warning btn-sm">
                                <i class="ti tabler-pencil"></i>
                                {{ __('common.edit') }}
                            </a>
                            <a href="{{ route('admin.donation-campaigns.index') }}" class="btn btn-secondary">
                                {{ __('common.back_to_list') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs mb-4" id="campaignTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                    data-bs-target="#details" type="button" role="tab">
                                    <i class="ti tabler-info-circle me-1"></i>
                                    {{ __('donation_campaigns.campaign_details') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images"
                                    type="button" role="tab">
                                    <i class="ti tabler-photo me-1"></i>
                                    {{ __('donation_campaigns.manage_images') }}
                                    <span class="badge bg-primary ms-1">{{ $donationCampaign->images->count() }}</span>
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="campaignTabContent">
                            <!-- Campaign Details Tab -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel">
                                <div class="row">
                                    <!-- Campaign Images Preview -->
                                    @if ($donationCampaign->images->count() > 0 || $donationCampaign->image_url)
                                        <div class="col-md-4 mb-4">
                                            @if ($donationCampaign->images->count() > 0)
                                                <!-- Multiple Images Carousel -->
                                                <div id="campaignImagesCarousel" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        @foreach ($donationCampaign->images as $index => $image)
                                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                <img src="{{ asset('storage/' . $image->image_url) }}"
                                                                    alt="{{ $image->alt_text ?: $donationCampaign->title }}"
                                                                    class="d-block w-100 rounded shadow-sm"
                                                                    style="height: 300px; object-fit: cover;">
                                                                @if ($image->alt_text)
                                                                    <div class="carousel-caption d-none d-md-block">
                                                                        <p
                                                                            class="mb-0 bg-dark bg-opacity-75 rounded px-2 py-1">
                                                                            {{ $image->alt_text }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if ($donationCampaign->images->count() > 1)
                                                        <button class="carousel-control-prev" type="button"
                                                            data-bs-target="#campaignImagesCarousel" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon"></span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button"
                                                            data-bs-target="#campaignImagesCarousel" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon"></span>
                                                        </button>
                                                        <div class="carousel-indicators">
                                                            @foreach ($donationCampaign->images as $index => $image)
                                                                <button type="button"
                                                                    data-bs-target="#campaignImagesCarousel"
                                                                    data-bs-slide-to="{{ $index }}"
                                                                    class="{{ $index === 0 ? 'active' : '' }}"></button>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif ($donationCampaign->image_url)
                                                <!-- Single Legacy Image -->
                                                <div class="text-center">
                                                    <img src="{{ asset('storage/' . $donationCampaign->image_url) }}"
                                                        alt="{{ $donationCampaign->title }}"
                                                        class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Campaign Details -->
                                    <div
                                        class="{{ $donationCampaign->images->count() > 0 || $donationCampaign->image_url ? 'col-md-8' : 'col-md-12' }}">
                                        <div class="row mb-3">
                                            <div class="col-md-3"><strong>{{ __('donation_campaigns.title') }}:</strong>
                                            </div>
                                            <div class="col-md-9">{{ $donationCampaign->title }}</div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3"><strong>{{ __('donation_campaigns.status') }}:</strong>
                                            </div>
                                            <div class="col-md-9">
                                                @php
                                                    $badgeClass = match ($donationCampaign->status) {
                                                        'draft' => 'bg-secondary',
                                                        'active' => 'bg-success',
                                                        'completed' => 'bg-primary',
                                                        'cancelled' => 'bg-danger',
                                                        default => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ __('donation_campaigns.status_' . $donationCampaign->status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <strong>{{ __('donation_campaigns.goal_amount') }}:</strong>
                                            </div>
                                            <div class="col-md-9">
                                                <span class="h5 text-primary">Rp.
                                                    {{ $donationCampaign->formatted_goal_amount }}</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <strong>{{ __('donation_campaigns.collected_amount') }}:</strong>
                                            </div>
                                            <div class="col-md-9">
                                                <span class="h5 text-success">Rp.
                                                    {{ $donationCampaign->formatted_collected_amount }}</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <strong>{{ __('donation_campaigns.remaining_amount') }}:</strong>
                                            </div>
                                            <div class="col-md-9">
                                                <span class="h5 text-info">Rp.
                                                    {{ $donationCampaign->formatted_remaining_amount }}</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <strong>{{ __('donation_campaigns.start_date') }}:</strong></div>
                                            <div class="col-md-9">
                                                {{ $donationCampaign->start_date ? $donationCampaign->start_date->format('M d, Y H:i') : '-' }}
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <strong>{{ __('donation_campaigns.end_date') }}:</strong></div>
                                            <div class="col-md-9">
                                                {{ $donationCampaign->end_date ? $donationCampaign->end_date->format('M d, Y H:i') : __('donation_campaigns.unlimited_duration') }}
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3"><strong>{{ __('donation_campaigns.creator') }}:</strong>
                                            </div>
                                            <div class="col-md-9">
                                                {{ $donationCampaign->creator ? $donationCampaign->creator->name : '-' }}
                                            </div>
                                        </div>

                                        <!-- Tags -->
                                        @if ($donationCampaign->tags->count() > 0)
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <strong>{{ __('donation_campaigns.tags') }}:</strong></div>
                                                <div class="col-md-9">
                                                    @foreach ($donationCampaign->tags as $tag)
                                                        <span class="badge rounded-pill me-1 mb-1"
                                                            style="background-color: {{ $tag->color }}; color: white;">
                                                            {{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row mb-3">
                                            <div class="col-md-3"><strong>{{ __('common.created_at') }}:</strong></div>
                                            <div class="col-md-9">
                                                {{ $donationCampaign->created_at ? $donationCampaign->created_at->format('M d, Y H:i') : '-' }}
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3"><strong>{{ __('common.updated_at') }}:</strong></div>
                                            <div class="col-md-9">
                                                {{ $donationCampaign->updated_at ? $donationCampaign->updated_at->format('M d, Y H:i') : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if ($donationCampaign->description)
                                    <div class="mt-4">
                                        <h5>{{ __('donation_campaigns.description') }}</h5>
                                        {!! nl2br(e($donationCampaign->description)) !!}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Images Management Tab -->
                        <div class="tab-pane fade" id="images" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="mb-3">{{ __('donation_campaigns.current_images') }}</h5>

                                    @if ($donationCampaign->images->count() > 0)
                                        <div class="row" id="existing-images">
                                            @foreach ($donationCampaign->images as $image)
                                                <div class="col-md-4 mb-3 existing-image"
                                                    data-image-id="{{ $image->id }}">
                                                    <div class="card">
                                                        <div class="position-relative">
                                                            <img src="{{ asset('storage/' . $image->image_url) }}"
                                                                alt="{{ $image->alt_text ?: $donationCampaign->title }}"
                                                                class="card-img-top"
                                                                style="height: 200px; object-fit: cover;">
                                                            @if ($image->is_primary)
                                                                <span
                                                                    class="badge bg-success position-absolute top-0 start-0 m-2">
                                                                    {{ __('donation_campaigns.primary_image') }}
                                                                </span>
                                                            @endif
                                                            <div class="position-absolute top-0 end-0 m-2">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-existing-image"
                                                                    data-image-id="{{ $image->id }}">
                                                                    <i class="ti tabler-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-body p-2">
                                                            @if ($image->alt_text)
                                                                <small class="text-muted">{{ $image->alt_text }}</small>
                                                            @else
                                                                <small
                                                                    class="text-muted">{{ __('donation_campaigns.no_alt_text') }}</small>
                                                            @endif
                                                            <div class="mt-2">
                                                                <button type="button"
                                                                    class="btn btn-outline-primary btn-sm set-primary-btn"
                                                                    data-image-id="{{ $image->id }}"
                                                                    {{ $image->is_primary ? 'disabled' : '' }}>
                                                                    {{ __('donation_campaigns.set_as_primary') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="ti tabler-photo-off text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2">{{ __('donation_campaigns.no_images') }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">{{ __('donation_campaigns.add_new_images') }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="upload-images-form" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="campaign_id"
                                                    value="{{ $donationCampaign->id }}">

                                                <div class="mb-3">
                                                    <label for="new_images"
                                                        class="form-label">{{ __('donation_campaigns.select_images') }}</label>
                                                    <input type="file" class="form-control" id="new_images"
                                                        name="images[]" accept="image/*" multiple required>
                                                    <small
                                                        class="form-text text-muted">{{ __('donation_campaigns.images_help') }}</small>
                                                </div>

                                                <div id="new-image-preview-container" class="mb-3"></div>

                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="ti tabler-upload me-1"></i>
                                                    {{ __('donation_campaigns.upload_images') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
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
        .nav-tabs .nav-link {
            border-radius: 0.375rem 0.375rem 0 0;
        }

        .image-preview-small {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.375rem;
            border: 2px solid #ddd;
            margin: 2px;
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
        $(document).ready(function() {

            // Image preview for new uploads
            $('#new_images').on('change', function() {
                const files = this.files;
                const container = $('#new-image-preview-container');
                container.empty();

                if (files.length > 0) {
                    container.append('<p class="mb-2"><strong>Preview:</strong></p>');
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            container.append(
                                `<img src="${e.target.result}" class="image-preview-small">`);
                        };

                        reader.readAsDataURL(file);
                    }
                }
            });

            // Upload new images
            $('#upload-images-form').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html(
                    '<i class="ti tabler-loader-2 me-1"></i> Uploading...');

                $.ajax({
                    url: '{{ route('admin.donation-campaigns.upload-images', $donationCampaign->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Clear the form and preview
                            $('#new_images').val('');
                            $('#new-image-preview-container').empty();
                            
                            // Add new images to the grid
                            if (response.images && response.images.length > 0) {
                                const existingImagesContainer = $('#existing-images');
                                
                                // If no images existed before, remove the "no images" message
                                if (existingImagesContainer.siblings('.text-center').length > 0) {
                                    existingImagesContainer.siblings('.text-center').remove();
                                }
                                
                                // Add each new image to the grid
                                response.images.forEach(function(image) {
                                    const imageHtml = `
                                        <div class="col-md-4 mb-3 existing-image" data-image-id="${image.id}">
                                            <div class="card">
                                                <div class="position-relative">
                                                    <img src="/storage/${image.image_url}" 
                                                         alt="${image.alt_text || '{{ $donationCampaign->title }}'}"
                                                         class="card-img-top" style="height: 200px; object-fit: cover;">
                                                    ${image.is_primary ? '<span class="badge bg-success position-absolute top-0 start-0 m-2">{{ __('donation_campaigns.primary_image') }}</span>' : ''}
                                                    <div class="position-absolute top-0 end-0 m-2">
                                                        <button type="button" class="btn btn-danger btn-sm remove-existing-image" data-image-id="${image.id}">
                                                            <i class="ti tabler-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body p-2">
                                                    ${image.alt_text ? `<small class="text-muted">${image.alt_text}</small>` : '<small class="text-muted">{{ __('donation_campaigns.no_alt_text') }}</small>'}
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-outline-primary btn-sm set-primary-btn" 
                                                                data-image-id="${image.id}" ${image.is_primary ? 'disabled' : ''}>
                                                            {{ __('donation_campaigns.set_as_primary') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    existingImagesContainer.append(imageHtml);
                                });
                                
                                // Re-bind event handlers for new elements
                                bindImageEventHandlers();
                                
                                // Update image count badge
                                updateImageCount();
                            }
                            
                            showNotification('success', response.message);
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        showNotification('error', response.message || 'Upload failed');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Bind event handlers for image management
            bindImageEventHandlers();

            // Function to bind event handlers for image elements
            function bindImageEventHandlers() {
                // Remove existing event handlers to prevent duplicates
                $(document).off('click', '.remove-existing-image');
                $(document).off('click', '.set-primary-btn');

                // Remove existing image
                $(document).on('click', '.remove-existing-image', function() {
                    const imageId = $(this).data('image-id');
                    const imageContainer = $(this).closest('.existing-image');

                    if (confirm('{{ __('donation_campaigns.confirm_delete_image') }}')) {
                        $.ajax({
                            url: '{{ route('admin.donation-campaigns.delete-image', $donationCampaign->id) }}',
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_id: imageId
                            },
                            success: function(response) {
                                if (response.success) {
                                    imageContainer.fadeOut(300, function() {
                                        $(this).remove();
                                        updateImageCount();
                                        
                                        // Check if no images left and show "no images" message
                                        if ($('#existing-images .existing-image').length === 0) {
                                            $('#existing-images').after(`
                                                <div class="text-center py-4">
                                                    <i class="ti tabler-photo-off text-muted" style="font-size: 3rem;"></i>
                                                    <p class="text-muted mt-2">{{ __('donation_campaigns.no_images') }}</p>
                                                </div>
                                            `);
                                        }
                                    });
                                    showNotification('success', response.message);
                                }
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON;
                                showNotification('error', response.message || 'Delete failed');
                            }
                        });
                    }
                });

                // Set primary image
                $(document).on('click', '.set-primary-btn', function() {
                    const imageId = $(this).data('image-id');
                    const button = $(this);

                    $.ajax({
                        url: '{{ route('admin.donation-campaigns.set-primary-image', $donationCampaign->id) }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            image_id: imageId
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove all primary badges and enable all buttons
                                $('.badge:contains("{{ __('donation_campaigns.primary_image') }}")')
                                    .remove();
                                $('.set-primary-btn').prop('disabled', false);

                                // Add primary badge to selected image and disable its button
                                button.closest('.existing-image').find('.position-relative')
                                    .prepend(
                                        '<span class="badge bg-success position-absolute top-0 start-0 m-2">{{ __('donation_campaigns.primary_image') }}</span>'
                                    );
                                button.prop('disabled', true);

                                showNotification('success', response.message);
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            showNotification('error', response.message || 'Update failed');
                        }
                    });
                });
            }


            // Update badge counts
            function updateImageCount() {
                const count = $('#existing-images .existing-image').length;
                $('#images-tab .badge').text(count);
            }


            // Show notification
            function showNotification(type, message) {
                // You can customize this based on your notification system
                if (type === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    </script>
@endpush
