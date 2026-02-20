@extends('layouts.admin')

@section('title', __('events.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-header">
                            {{ __('events.title') }}
                            <small class="text-secondary">{{ __('events.subtitle') }}</small>
                        </h5>
                        <div class="pe-5">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                                <i class="ti tabler-plus me-1"></i>{{ __('common.create') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="eventsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('events.fields.title') }}</th>
                                        <th>{{ __('events.fields.type') }}</th>
                                        <th>{{ __('events.fields.date_range') }}</th>
                                        <th>{{ __('events.fields.participants') }}</th>
                                        <th>{{ __('events.fields.status') }}</th>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#eventsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.events.index') }}',
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
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'date_range',
                        name: 'start_datetime'
                    },
                    {
                        data: 'participants',
                        name: 'participants',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [3, 'desc']
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
                    zeroRecords: "{{ __('datatable.events.zeroRecords') }}",
                    emptyTable: "{{ __('datatable.events.emptyTable') }}",
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
