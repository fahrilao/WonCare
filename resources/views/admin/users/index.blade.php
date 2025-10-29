@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-header">
                            {{ __('navigation.users') }}
                            <small class="text-secondary">{{ __('users.list_description') }}</small>
                        </h5>
                        <div class="pe-5">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="ti tabler-plus"></i>
                                {{ __('common.add') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- DataTables -->
                        <div class="table-responsive">
                            <table id="users-table" class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('users.name') }}</th>
                                        <th>{{ __('users.email') }}</th>
                                        <th>{{ __('users.created_at') }}</th>
                                        <th class="text-center" width="150px">{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts._form_delete')
@endsection

@push('vendor_scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.users.index') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                pageLength: 10,
                responsive: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">{{ __('datatable.loadingRecords') }}</span></div>',
                    search: "{{ __('datatable.search') }}",
                    lengthMenu: "{{ __('datatable.lengthMenu') }}",
                    info: "{{ __('datatable.info') }}",
                    infoEmpty: "{{ __('datatable.infoEmpty') }}",
                    infoFiltered: "{{ __('datatable.infoFiltered') }}",
                    loadingRecords: "{{ __('datatable.loadingRecords') }}",
                    zeroRecords: "{{ __('datatable.users.zeroRecords') }}",
                    emptyTable: "{{ __('datatable.users.emptyTable') }}",
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
        });
    </script>
@endpush
