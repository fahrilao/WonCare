@extends('layouts.admin')

@section('title', __('donation_campaigns.list_title'))

@section('content')
    <div class="container-xxl grow container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('donation_campaigns.list_title') }}</h4>
                        <a href="{{ route('admin.donation-campaigns.create') }}" class="btn btn-primary">
                            <i class="ti tabler-plus"></i>
                            {{ __('common.add') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="donation-campaigns-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('donation_campaigns.dt_title') }}</th>
                                        <th>{{ __('donation_campaigns.dt_goal_amount') }}</th>
                                        <th>{{ __('donation_campaigns.dt_collected_amount') }}</th>
                                        <th>{{ __('donation_campaigns.dt_progress') }}</th>
                                        <th>{{ __('donation_campaigns.dt_status') }}</th>
                                        <th>{{ __('donation_campaigns.dt_creator') }}</th>
                                        <th>{{ __('donation_campaigns.dt_created_at') }}</th>
                                        <th>{{ __('donation_campaigns.dt_actions') }}</th>
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#donation-campaigns-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.donation-campaigns.index') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'formatted_goal_amount',
                        name: 'goal_amount'
                    },
                    {
                        data: 'formatted_collected_amount',
                        name: 'collected_amount'
                    },
                    {
                        data: 'progress_percentage',
                        name: 'progress_percentage',
                        orderable: false
                    },
                    {
                        data: 'status_badge',
                        name: 'status'
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
                        searchable: false
                    }
                ],
                order: [
                    [7, 'desc']
                ],
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
                    text: `"${name}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('common.delete_confirm_button') }}',
                    cancelButtonText: '{{ __('common.delete_cancel_button') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('admin.donation-campaigns.index') }}/${id}`,
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
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    table.ajax.reload();
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: '{{ __('common.failed') }}',
                                    text: '{{ __('common.error') }}',
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
