@extends('layouts.admin')

@section('title', __('donation_reports.view_donation_report'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title mb-0">{{ __('donation_reports.donation_report_details') }}</h4>
                                <small class="text-muted">{{ __('donation_reports.report_id') }}:
                                    #{{ $donationReport->id }}</small>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group">
                                    @if ($donationReport->canBeEdited())
                                        <a href="{{ route('admin.donation-reports.edit', $donationReport) }}"
                                            class="btn btn-warning">
                                            <i class="ti tabler-edit me-1"></i>{{ __('common.edit') }}
                                        </a>
                                    @endif

                                    @if ($donationReport->canBeVerified())
                                        <button type="button" class="btn btn-success verify-btn"
                                            data-id="{{ $donationReport->id }}">
                                            <i class="ti tabler-check me-1"></i>{{ __('donation_reports.verify') }}
                                        </button>
                                        <button type="button" class="btn btn-secondary reject-btn"
                                            data-id="{{ $donationReport->id }}">
                                            <i class="ti tabler-x me-1"></i>{{ __('donation_reports.reject') }}
                                        </button>
                                    @endif

                                    <button type="button" class="btn btn-danger delete-btn"
                                        data-id="{{ $donationReport->id }}"
                                        data-name="{{ $donationReport->institution_name }}">
                                        <i class="ti tabler-trash me-1"></i>{{ __('common.delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Campaign Information -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3">{{ __('donation_reports.campaign_information') }}</h5>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong>{{ __('donation_reports.campaign') }}:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            @if ($donationReport->donationCampaign)
                                                <a href="{{ route('admin.donation-campaigns.show', $donationReport->donationCampaign) }}"
                                                    class="text-decoration-none">
                                                    {{ $donationReport->donationCampaign->title }}
                                                </a>
                                            @else
                                                <span class="text-muted">{{ __('donation_reports.not_found') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <!-- Distribution Information -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3">{{ __('donation_reports.distribution_information') }}
                                    </h5>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <strong>{{ __('donation_reports.distributed_amount') }}:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span
                                                class="h5 text-success">Rp.{{ $donationReport->formatted_distributed_amount }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <strong>{{ __('donation_reports.distribution_date') }}:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $donationReport->formatted_distribution_date }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <strong>{{ __('donation_reports.status') }}:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {!! $donationReport->status_badge !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Description -->
                                @if ($donationReport->description)
                                    <div class="mb-4">
                                        <h5 class="text-primary mb-3">{{ __('donation_reports.description') }}</h5>
                                        <p class="text-muted">{{ $donationReport->description }}</p>
                                    </div>
                                @endif

                                <!-- Beneficiaries -->
                                @if ($donationReport->beneficiaries)
                                    <div class="mb-4">
                                        <h5 class="text-primary mb-3">{{ __('donation_reports.beneficiaries') }}</h5>
                                        <p class="text-muted">{{ $donationReport->beneficiaries }}</p>
                                    </div>
                                @endif

                                <!-- Evidence File -->
                                @if ($donationReport->evidence_file)
                                    <div class="mb-4">
                                        <h5 class="text-primary mb-3">{{ __('donation_reports.evidence_file') }}</h5>
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti tabler-file-text me-3 text-primary"
                                                        style="font-size: 2rem;"></i>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ basename($donationReport->evidence_file) }}
                                                        </h6>
                                                        <small
                                                            class="text-muted">{{ __('donation_reports.click_to_download') }}</small>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $donationReport->evidence_file) }}"
                                                        target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="ti tabler-download me-1"></i>{{ __('common.download') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Notes -->
                                @if ($donationReport->notes)
                                    <div class="mb-4">
                                        <h5 class="text-primary mb-3">{{ __('donation_reports.notes') }}</h5>
                                        <div class="alert alert-info">
                                            <i class="ti tabler-info-circle me-2"></i>
                                            {{ $donationReport->notes }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Verification Information -->
                                @if ($donationReport->verified_at)
                                    <div class="mb-4">
                                        <h5 class="text-primary mb-3">{{ __('donation_reports.verification_information') }}
                                        </h5>
                                        <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <strong>{{ __('donation_reports.verified_by') }}:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                {{ $donationReport->verifier ? $donationReport->verifier->name : __('common.not_available') }}
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <strong>{{ __('donation_reports.verified_at') }}:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                {{ $donationReport->verified_at->format('M d, Y H:i:s') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- System Information -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3">{{ __('common.system_information') }}</h5>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <strong>{{ __('common.created_by') }}:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $donationReport->creator ? $donationReport->creator->name : __('common.not_available') }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <strong>{{ __('common.created_at') }}:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $donationReport->created_at->format('M d, Y H:i:s') }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <strong>{{ __('common.updated_at') }}:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            {{ $donationReport->updated_at->format('M d, Y H:i:s') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Images Management Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Images Management Tab -->
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="mb-3">{{ __('donation_reports.current_images') }}</h5>

                                <div class="row" id="existing-images">
                                    @foreach ($donationReport->images as $image)
                                        <div class="col-md-4 mb-3 existing-image" data-image-id="{{ $image->id }}">
                                            <div class="card">
                                                <div class="position-relative">
                                                    <img src="{{ asset($image->image_url) }}"
                                                        alt="{{ $image->alt_text ?: 'Report Image' }}"
                                                        class="card-img-top" style="height: 200px; object-fit: cover;">
                                                    @if ($image->is_primary)
                                                        <span class="badge bg-success position-absolute top-0 start-0 m-2">
                                                            {{ __('donation_reports.primary_image') }}
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
                                                            class="text-muted">{{ __('donation_reports.no_alt_text') }}</small>
                                                    @endif
                                                    <div class="mt-2">
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-sm set-primary-btn"
                                                            data-image-id="{{ $image->id }}"
                                                            {{ $image->is_primary ? 'disabled' : '' }}>
                                                            {{ __('donation_reports.set_as_primary') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($donationReport->images->count() === 0)
                                    <div class="text-center py-4" id="no-images-message">
                                        <i class="ti tabler-photo-off text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-2">{{ __('donation_reports.no_images') }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">{{ __('donation_reports.add_new_images') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <form id="upload-images-form" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="report_id" value="{{ $donationReport->id }}">

                                            <div class="mb-3">
                                                <label for="new_images"
                                                    class="form-label">{{ __('donation_reports.select_images') }}</label>
                                                <input type="file" class="form-control" id="new_images"
                                                    name="images[]" accept="image/*" multiple required>
                                                <small
                                                    class="form-text text-muted">{{ __('donation_reports.images_help') }}</small>
                                            </div>

                                            <div id="new-image-preview-container" class="mb-3"></div>

                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ti tabler-upload me-1"></i>
                                                {{ __('donation_reports.upload_images') }}
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Delete functionality
            $('.delete-btn').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                Swal.fire({
                    title: '{{ __('common.delete_confirmation_text') }}',
                    text: '{{ __('donation_reports.confirm_delete_text') }}' + ' "' + name + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('common.delete') }}',
                    cancelButtonText: '{{ __('common.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.donation-reports.destroy', $donationReport) }}',
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: '{{ __('common.success') }}',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.href =
                                            '{{ route('admin.donation-reports.index') }}';
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: '{{ __('common.error') }}',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            // Verify functionality
            $('.verify-btn').on('click', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: '{{ __('donation_reports.confirm_verify') }}',
                    text: '{{ __('donation_reports.confirm_verify_text') }}',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '{{ __('donation_reports.verify') }}',
                    cancelButtonText: '{{ __('common.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.donation-reports.verify', $donationReport) }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: '{{ __('donation_reports.verified') }}',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON;
                                Swal.fire({
                                    title: '{{ __('common.error') }}',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            // Reject functionality
            $('.reject-btn').on('click', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: '{{ __('donation_reports.confirm_reject') }}',
                    text: '{{ __('donation_reports.confirm_reject_text') }}',
                    input: 'textarea',
                    inputLabel: '{{ __('donation_reports.rejection_notes') }}',
                    inputPlaceholder: '{{ __('donation_reports.rejection_notes_placeholder') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '{{ __('donation_reports.reject') }}',
                    cancelButtonText: '{{ __('common.cancel') }}',
                    inputValidator: (value) => {
                        if (!value) {
                            return '{{ __('donation_reports.rejection_notes_required') }}';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.donation-reports.reject', $donationReport) }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                notes: result.value
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: '{{ __('donation_reports.rejected') }}',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON;
                                Swal.fire({
                                    title: '{{ __('common.error') }}',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            // Image upload functionality
            $('#upload-images-form').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.prop('disabled', true).html(
                    '<i class="spinner-border spinner-border-sm me-1"></i>Uploading...');

                $.ajax({
                    url: '{{ route('admin.donation-reports.upload-images', $donationReport) }}',
                    type: 'POST',
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

                                // Remove the "no images" message if it exists
                                $('#no-images-message').remove();

                                // Add each new image to the grid
                                response.images.forEach(function(image) {
                                    const imageHtml = `
                                        <div class="col-md-4 mb-3 existing-image" data-image-id="${image.id}">
                                            <div class="card">
                                                <div class="position-relative">
                                                    <img src="${image.url}" alt="${image.alt_text || 'Report Image'}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                                    ${image.is_primary ? '<span class="badge bg-success position-absolute top-0 start-0 m-2">{{ __('donation_reports.primary_image') }}</span>' : ''}
                                                    <div class="position-absolute top-0 end-0 m-2">
                                                        <button type="button" class="btn btn-danger btn-sm remove-existing-image" data-image-id="${image.id}">
                                                            <i class="ti tabler-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body p-2">
                                                    <small class="text-muted">${image.alt_text || '{{ __('donation_reports.no_alt_text') }}'}</small>
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-outline-primary btn-sm set-primary-btn" data-image-id="${image.id}" ${image.is_primary ? 'disabled' : ''}>
                                                            {{ __('donation_reports.set_as_primary') }}
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
                        showNotification('error', response.message ||
                            '{{ __('common.error') }}');
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Image preview functionality
            $('#new_images').on('change', function() {
                const files = this.files;
                const previewContainer = $('#new-image-preview-container');
                previewContainer.empty();

                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const previewHtml = `
                                <div class="col-md-6 mb-2">
                                    <div class="card">
                                        <img src="${e.target.result}" class="card-img-top" style="height: 100px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <small class="text-muted">${file.name}</small>
                                        </div>
                                    </div>
                                </div>
                            `;
                            previewContainer.append(previewHtml);
                        };

                        reader.readAsDataURL(file);
                    }
                }
            });

            // Bind image event handlers
            function bindImageEventHandlers() {
                // Remove existing image
                $('.remove-existing-image').off('click').on('click', function() {
                    const imageId = $(this).data('image-id');
                    const imageContainer = $(this).closest('.existing-image');

                    Swal.fire({
                        title: '{{ __('common.delete_confirmation_text') }}',
                        text: '{{ __('donation_reports.confirm_delete_image') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '{{ __('common.delete') }}',
                        cancelButtonText: '{{ __('common.cancel') }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('admin.donation-reports.delete-image', [$donationReport, ':imageId']) }}'
                                    .replace(':imageId', imageId),
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        imageContainer.fadeOut(300, function() {
                                            $(this).remove();
                                            updateImageCount();

                                            // Check if no images left and show "no images" message
                                            if ($(
                                                    '#existing-images .existing-image'
                                                    )
                                                .length === 0) {
                                                $('#existing-images').after(`
                                                    <div class="text-center py-4" id="no-images-message">
                                                        <i class="ti tabler-photo-off text-muted" style="font-size: 3rem;"></i>
                                                        <p class="text-muted mt-2">{{ __('donation_reports.no_images') }}</p>
                                                    </div>
                                                `);
                                            }
                                        });
                                        showNotification('success', response.message);
                                    }
                                },
                                error: function(xhr) {
                                    const response = xhr.responseJSON;
                                    showNotification('error', response.message ||
                                        '{{ __('common.error') }}');
                                }
                            });
                        }
                    });
                });

                // Set primary image
                $('.set-primary-btn').off('click').on('click', function() {
                    const imageId = $(this).data('image-id');
                    const button = $(this);

                    $.ajax({
                        url: '{{ route('admin.donation-reports.set-primary-image', [$donationReport, ':imageId']) }}'
                            .replace(':imageId', imageId),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove primary badge from all images
                                $('.existing-image .badge').remove();
                                $('.set-primary-btn').prop('disabled', false);

                                // Add primary badge to this image
                                button.closest('.existing-image').find('.position-relative')
                                    .prepend(
                                        '<span class="badge bg-success position-absolute top-0 start-0 m-2">{{ __('donation_reports.primary_image') }}</span>'
                                    );
                                button.prop('disabled', true);

                                showNotification('success', response.message);
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            showNotification('error', response.message ||
                                '{{ __('common.error') }}');
                        }
                    });
                });
            }

            // Initial binding
            bindImageEventHandlers();

            // Helper functions
            function showNotification(type, message) {
                Swal.fire({
                    title: type === 'success' ? '{{ __('common.success') }}' :
                        '{{ __('common.error') }}',
                    text: message,
                    icon: type,
                    timer: 3000,
                    showConfirmButton: false
                });
            }

            function updateImageCount() {
                const count = $('#existing-images .existing-image').length;
                $('#images-tab .badge').text(count);
            }
        });
    </script>
@endpush
