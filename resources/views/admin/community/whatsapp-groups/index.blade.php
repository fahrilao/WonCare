@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-header">
                            {{ __('community.whatsapp_groups.title') }}
                            <small class="text-secondary">{{ __('community.whatsapp_groups.subtitle') }}</small>
                        </h5>
                        <div class="pe-5">
                            <a href="{{ route('admin.community.whatsapp-groups.create') }}" class="btn btn-primary">
                                <i class="ti tabler-plus"></i>
                                {{ __('common.add') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="whatsapp-groups-table" class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('community.whatsapp_groups.fields.region') }}</th>
                                        <th>{{ __('community.whatsapp_groups.fields.name') }}</th>
                                        <th>{{ __('community.whatsapp_groups.fields.whatsapp_link') }}</th>
                                        <th>{{ __('community.whatsapp_groups.fields.status') }}</th>
                                        <th class="text-center" width="180px">{{ __('common.actions') }}</th>
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
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#whatsapp-groups-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.community.whatsapp-groups.index') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'region',
                        name: 'region'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'whatsapp_link',
                        name: 'whatsapp_link'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
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
                    zeroRecords: "{{ __('datatable.whatsapp_groups.zeroRecords') }}",
                    emptyTable: "{{ __('datatable.whatsapp_groups.emptyTable') }}",
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
