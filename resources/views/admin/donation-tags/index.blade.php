@extends('layouts.admin')

@section('title', __('donation_tags.manage_donation_tags'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title mb-0">{{ __('donation_tags.donation_tags') }}</h4>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.donation-tags.create') }}" class="btn btn-primary">
                                    <i class="ti tabler-plus me-1"></i>{{ __('donation_tags.add_new_tag') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="donation-tags-table" class="table table-striped table-hover w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('donation_tags.tag_name') }}</th>
                                        <th>{{ __('donation_tags.description') }}</th>
                                        <th>{{ __('donation_tags.status') }}</th>
                                        <th>{{ __('donation_tags.sort_order') }}</th>
                                        <th>{{ __('donation_tags.creator') }}</th>
                                        <th>{{ __('donation_tags.created_at') }}</th>
                                        <th>{{ __('donation_tags.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endpush


@push('vendor_scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#donation-tags-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('admin.donation-tags.index') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name_display',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'is_active',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'sort_order',
                        name: 'sort_order',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'creator_name',
                        name: 'creator.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [5, 'asc'],
                    [1, 'asc']
                ], // Sort by sort_order, then name
                language: {
                    processing: '{{ __('datatable.processing') }}',
                    search: '{{ __('datatable.search') }}',
                    lengthMenu: '{{ __('datatable.show') }} _MENU_ {{ __('datatable.entries') }}',
                    info: '{{ __('datatable.showing') }} _START_ {{ __('datatable.to') }} _END_ {{ __('datatable.of') }} _TOTAL_ {{ __('datatable.entries') }}',
                    infoEmpty: '{{ __('datatable.showing') }} 0 {{ __('datatable.to') }} 0 {{ __('datatable.of') }} 0 {{ __('datatable.entries') }}',
                    infoFiltered: '({{ __('datatable.filtered') }} {{ __('datatable.from') }} _MAX_ {{ __('datatable.total_entries') }})',
                    zeroRecords: '{{ __('donation_tags.no_tags_found') }}',
                    emptyTable: '{{ __('donation_tags.no_tags_found') }}',
                    paginate: {
                        first: '{{ __('datatable.first') }}',
                        previous: '{{ __('datatable.previous') }}',
                        next: '{{ __('datatable.next') }}',
                        last: '{{ __('datatable.last') }}'
                    }
                }
            });

            // Delete confirmation
            $(document).on('click', '.delete-btn', function() {
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
                            url: '{{ route('admin.donation-tags.destroy', '') }}/' + tagId,
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
                                    });
                                    table.ajax.reload();
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
