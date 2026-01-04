@extends('layouts.admin')

@section('title', __('events.detail_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('events.detail_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.events.edit', $event) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.events.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($event->banner_image)
                            <div class="mb-4">
                                <img src="{{ $event->banner_url }}" alt="{{ $event->title }}" class="img-fluid rounded"
                                    style="max-height: 300px; width: 100%; object-fit: cover;">
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <h3>{{ $event->title }}</h3>
                                <div class="mb-3">
                                    {!! $event->type_badge !!}
                                    {!! $event->status_badge !!}
                                </div>
                                <div class="mb-3">
                                    <strong>{{ __('events.fields.description') }}:</strong>
                                    <p>{{ $event->description ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('events.fields.date_range') }}</h6>
                                        <p class="mb-2"><i
                                                class="ti ti-calendar me-2"></i>{{ $event->formatted_date_range }}
                                        </p>

                                        @if ($event->type === 'offline')
                                            <h6 class="card-title mt-3">{{ __('events.fields.location') }}</h6>
                                            <p class="mb-2"><i
                                                    class="ti ti-map-pin me-2"></i>{{ $event->location ?? '-' }}
                                            </p>
                                        @else
                                            <h6 class="card-title mt-3">{{ __('events.fields.meeting_link') }}</h6>
                                            <p class="mb-2">
                                                @if ($event->meeting_link)
                                                    <a href="{{ $event->meeting_link }}" target="_blank"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="ti ti-video me-1"></i>{{ __('events.types.online') }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        @endif

                                        <h6 class="card-title mt-3">{{ __('events.fields.participants') }}</h6>
                                        <p class="mb-0">
                                            <strong>{{ $event->confirmedRsvps()->count() }}</strong>
                                            @if ($event->max_participants)
                                                / {{ $event->max_participants }}
                                            @else
                                                / ∞
                                            @endif
                                        </p>
                                        @if ($event->availableSlots())
                                            <small
                                                class="text-success">{{ __('events.info.available_slots', ['count' => $event->availableSlots()]) }}</small>
                                        @elseif($event->isFull())
                                            <small class="text-danger">{{ __('events.info.full') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($event->notes)
                            <div class="mt-3">
                                <strong>{{ __('events.fields.notes') }}:</strong>
                                <p style="white-space: pre-wrap;">{{ $event->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RSVP List -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ __('events.rsvp_title') }} ({{ $event->rsvps->count() }})</h5>
                        @if ($event->send_reminder && $event->confirmedRsvps()->where('reminder_sent', false)->count() > 0)
                            <button type="button" class="btn btn-primary btn-sm" id="sendRemindersBtn">
                                <i class="ti ti-bell me-1"></i>{{ __('events.reminders.send_all') }}
                                ({{ $event->confirmedRsvps()->where('reminder_sent', false)->count() }})
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($event->rsvps->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('events.rsvp.name') }}</th>
                                            <th>{{ __('events.rsvp.email') }}</th>
                                            <th>{{ __('events.rsvp.phone') }}</th>
                                            <th>{{ __('events.rsvp.status') }}</th>
                                            <th>{{ __('events.rsvp.reminder_sent') }}</th>
                                            <th>{{ __('common.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($event->rsvps as $rsvp)
                                            <tr>
                                                <td>{{ $rsvp->name }}</td>
                                                <td>{{ $rsvp->email }}</td>
                                                <td>{{ $rsvp->phone ?? '-' }}</td>
                                                <td>{!! $rsvp->status_badge !!}</td>
                                                <td>
                                                    @if ($rsvp->reminder_sent)
                                                        <span class="badge bg-success">{{ __('common.yes') }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ __('common.no_value') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($rsvp->status !== 'attended')
                                                        <button type="button"
                                                            class="btn btn-sm btn-success mark-attended-btn"
                                                            data-rsvp-id="{{ $rsvp->id }}">
                                                            <i
                                                                class="ti ti-check"></i>{{ __('events.rsvp.mark_attended') }}
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">{{ __('datatable.events.emptyTable') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Documentation -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ __('events.documentation.title') }} ({{ $event->documentation->count() }})</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#uploadDocModal">
                            <i class="ti ti-upload me-1"></i>{{ __('events.documentation.upload') }}
                        </button>
                    </div>
                    <div class="card-body">
                        @if ($event->documentation->count() > 0)
                            <div class="row">
                                @foreach ($event->documentation as $doc)
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            @if ($doc->type === 'photo')
                                                <img src="{{ $doc->file_url }}" class="card-img-top"
                                                    alt="{{ $doc->title }}" style="height: 200px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                                    style="height: 200px;">
                                                    <i class="ti ti-video" style="font-size: 48px;"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <p class="card-text small">{{ $doc->title ?? $doc->type }}</p>
                                                <button type="button" class="btn btn-sm btn-danger delete-doc-btn"
                                                    data-doc-id="{{ $doc->id }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">{{ __('common.no_data') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Documentation Modal -->
    <div class="modal fade" id="uploadDocModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('events.documentation.upload') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="uploadDocForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="doc_type" class="form-label">{{ __('events.documentation.type') }}</label>
                            <select class="form-select" id="doc_type" name="type" required>
                                <option value="photo">{{ __('events.documentation.photo') }}</option>
                                <option value="video">{{ __('events.documentation.video') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="doc_file" class="form-label">{{ __('events.documentation.file') }}</label>
                            <input type="file" class="form-control" id="doc_file" name="file" required>
                            <small class="form-text text-muted">Max 10MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="doc_title" class="form-label">{{ __('events.fields.title') }}</label>
                            <input type="text" class="form-control" id="doc_title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="doc_description"
                                class="form-label">{{ __('events.documentation.description') }}</label>
                            <textarea class="form-control" id="doc_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('common.upload') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Send Reminders
            $('#sendRemindersBtn').on('click', function() {
                if (confirm('{{ __('events.reminders.send_all') }}?')) {
                    $.ajax({
                        url: '{{ route('admin.events.send-reminders', $event) }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Success', response.message, 'success');
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message || 'An error occurred',
                                'error');
                        }
                    });
                }
            });

            // Mark as Attended
            $('.mark-attended-btn').on('click', function() {
                const rsvpId = $(this).data('rsvp-id');
                $.ajax({
                    url: `/admin/event-rsvps/${rsvpId}/status`,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: 'attended'
                    },
                    success: function(response) {
                        Swal.fire('Success', response.message, 'success');
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message || 'An error occurred',
                            'error');
                    }
                });
            });

            // Upload Documentation
            $('#uploadDocForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.events.upload-documentation', $event) }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire('Success', response.message, 'success');
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message || 'An error occurred',
                            'error');
                    }
                });
            });

            // Delete Documentation
            $('.delete-doc-btn').on('click', function() {
                const docId = $(this).data('doc-id');
                if (confirm('{{ __('common.delete_confirm') }}?')) {
                    $.ajax({
                        url: `/admin/event-documentation/${docId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Success', response.message, 'success');
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message || 'An error occurred',
                                'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
