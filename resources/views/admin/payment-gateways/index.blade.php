@extends('layouts.admin')

@section('title', __('payment_gateways.list_title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endpush

@section('content')
    <div class="container-xxl grow container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('payment_gateways.list_title') }}</h4>
                        <a href="{{ route('admin.payment-gateways.create') }}" class="btn btn-primary">
                            <i class="ti tabler-plus"></i>
                            {{ __('common.add') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="payment-gateways-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('payment_gateways.dt_name') }}</th>
                                        <th>{{ __('payment_gateways.dt_provider') }}</th>
                                        <th>{{ __('payment_gateways.dt_status') }}</th>
                                        <th>{{ __('payment_gateways.dt_mode') }}</th>
                                        <th>{{ __('payment_gateways.dt_configured') }}</th>
                                        <th>{{ __('payment_gateways.dt_creator') }}</th>
                                        <th>{{ __('payment_gateways.dt_created_at') }}</th>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('common.delete_confirmation_text') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('common.delete_cancel_button') }}</button>
                    <button type="button" class="btn btn-danger"
                        id="confirmDelete">{{ __('common.delete_confirm_button') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#payment-gateways-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.payment-gateways.index') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'provider_name',
                        name: 'provider'
                    },
                    {
                        data: 'status_badge',
                        name: 'is_active'
                    },
                    {
                        data: 'mode_badge',
                        name: 'is_sandbox'
                    },
                    {
                        data: 'configured',
                        name: 'configured',
                        orderable: false,
                        searchable: false
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
                    zeroRecords: "{{ __('datatable.lessons.zeroRecords') }}",
                    emptyTable: "{{ __('datatable.lessons.emptyTable') }}",
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

            // Handle delete button click
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
                            url: '{{ route('admin.payment-gateways.destroy', ':id') }}'
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
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    $('#payment-gateways-table').DataTable().ajax
                                        .reload();
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
