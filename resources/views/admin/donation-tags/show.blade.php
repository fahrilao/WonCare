@extends('layouts.admin')

@section('title', __('donation_tags.view_donation_tag'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('donation_tags.view_donation_tag') }}: {{ $donationTag->name }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.donation-tags.edit', $donationTag) }}" class="btn btn-warning btn-sm">
                                <i class="ti tabler-pencil"></i>
                                {{ __('common.edit') }}
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $donationTag->id }}">
                                <i class="ti tabler-trash"></i>
                                {{ __('common.delete') }}
                            </button>
                            <a href="{{ route('admin.donation-tags.index') }}" class="btn btn-secondary">
                                {{ __('common.back_to_list') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Tag Details -->
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_tags.name') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $donationTag->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_tags.slug') }}:</strong></div>
                                    <div class="col-md-9">
                                        <code>{{ $donationTag->slug }}</code>
                                    </div>
                                </div>

                                @if ($donationTag->description)
                                    <div class="row mb-3">
                                        <div class="col-md-3"><strong>{{ __('donation_tags.description') }}:</strong></div>
                                        <div class="col-md-9">{{ $donationTag->description }}</div>
                                    </div>
                                @endif

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_tags.color') }}:</strong></div>
                                    <div class="col-md-9">
                                        <div class="d-flex align-items-center gap-2">
                                            {!! $donationTag->color_preview !!}
                                            <code>{{ $donationTag->color }}</code>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_tags.sort_order') }}:</strong></div>
                                    <div class="col-md-9">{{ $donationTag->sort_order }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_tags.status') }}:</strong></div>
                                    <div class="col-md-9">{!! $donationTag->status_badge !!}</div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-3"><strong
                                            class="text-muted">{{ __('donation_tags.created_at') }}:</strong></div>
                                    <div class="col-md-9">{{ $donationTag->created_at->format('Y-m-d H:i:s') }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong
                                            class="text-muted">{{ __('donation_tags.updated_at') }}:</strong></div>
                                    <div class="col-md-9">{{ $donationTag->updated_at->format('Y-m-d H:i:s') }}</div>
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
            // Delete confirmation
            $('.delete-btn').on('click', function() {
                const tagId = $(this).data('id');

                Swal.fire({
                    title: '{{ __('donation_tags.confirm_delete') }}',
                    text: '{{ __('donation_tags.delete_warning') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('common.yes_delete') }}',
                    cancelButtonText: '{{ __('common.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.donation-tags.destroy', $donationTag) }}',
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: '{{ __('common.deleted') }}',
                                        text: response.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.href =
                                            '{{ route('admin.donation-tags.index') }}';
                                    });
                                } else {
                                    Swal.fire({
                                        title: '{{ __('common.error') }}',
                                        text: response.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: '{{ __('common.error') }}',
                                    text: '{{ __('common.error_occurred') }}',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
