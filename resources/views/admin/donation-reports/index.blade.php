@extends('layouts.admin')

@section('title', __('donation_reports.manage_donation_reports'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title mb-0">{{ __('donation_reports.donation_reports') }}</h4>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('admin.donation-reports.create') }}" class="btn btn-primary">
                                    <i class="ti tabler-plus me-1"></i>{{ __('donation_reports.add_new_report') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="donation-reports-table" class="table table-striped table-hover w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('donation_reports.campaign') }}</th>
                                        <th>{{ __('donation_reports.report_title') }}</th>
                                        <th>{{ __('donation_reports.distributed_amount') }}</th>
                                        <th>{{ __('donation_reports.distribution_date') }}</th>
                                        <th>{{ __('donation_reports.status') }}</th>
                                        <th>{{ __('donation_reports.created_by') }}</th>
                                        <th>{{ __('common.created_at') }}</th>
                                        <th>{{ __('common.actions') }}</th>
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

@push('vendor_scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#donation-reports-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.donation-reports.index') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'campaign_title',
                        name: 'donationCampaign.title'
                    },
                    {
                        data: 'report_title',
                        name: 'id'
                    },
                    {
                        data: 'formatted_distributed_amount',
                        name: 'distributed_amount'
                    },
                    {
                        data: 'formatted_distribution_date',
                        name: 'distribution_date'
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'creator_name',
                        name: 'creator.name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        width: '15%'
                    }
                ],
                order: [
                    [7, 'desc']
                ],
                pageLength: 25,
                responsive: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">{{ __('datatable.loadingRecords') }}</span></div>',
                    search: "{{ __('datatable.search') }}",
                    lengthMenu: "{{ __('datatable.lengthMenu') }}",
                    info: "{{ __('datatable.info') }}",
                    infoEmpty: "{{ __('datatable.infoEmpty') }}",
                    infoFiltered: "{{ __('datatable.infoFiltered') }}",
                    loadingRecords: "{{ __('datatable.loadingRecords') }}",
                    zeroRecords: "{{ __('datatable.categories.zeroRecords') }}",
                    emptyTable: "{{ __('datatable.categories.emptyTable') }}",
                    paginate: {
                        first: "{{ __('datatable.paginate.first') }}",
                        previous: "{{ __('datatable.paginate.previous') }}",
                        next: "{{ __('datatable.paginate.next') }}",
                        last: "{{ __('datatable.paginate.last') }}"
                    },
                    aria: {
                        sortAscending: "{{ __('datatable.aria.sortAscending') }}",
                        sortDescending: "{{ __('datatable.aria.sortDescending') }}"
                    }
                }
            });

            // Delete functionality
            $(document).on('click', '.delete-btn', function() {
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
                            url: '{{ route('admin.donation-reports.destroy', ':id') }}'
                                .replace(':id', id),
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
                                    });
                                    table.ajax.reload();
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
            $(document).on('click', '.verify-btn', function() {
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
                            url: '{{ route('admin.donation-reports.verify', ':id') }}'
                                .replace(':id', id),
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
                                    });
                                    table.ajax.reload();
                                }
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON;
                                Swal.fire({
                                    title: '{{ __('common.error') }}',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });

            // Reject functionality
            $(document).on('click', '.reject-btn', function() {
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
                            url: '{{ route('admin.donation-reports.reject', ':id') }}'
                                .replace(':id', id),
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
                                    });
                                    table.ajax.reload();
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
        });
    </script>
@endpush
