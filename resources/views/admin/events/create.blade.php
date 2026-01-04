@extends('layouts.admin')

@section('title', __('events.create_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('events.create_title') }}</h4>
                        <a href="{{ route('admin.events.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="title" class="form-label">{{ __('events.fields.title') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title"
                                        name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="type" class="form-label">{{ __('events.fields.type') }}</label>
                                    <select class="form-select{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                        id="type" name="type" required>
                                        <option value="offline" {{ old('type') === 'offline' ? 'selected' : '' }}>
                                            {{ __('events.types.offline') }}</option>
                                        <option value="online" {{ old('type') === 'online' ? 'selected' : '' }}>
                                            {{ __('events.types.online') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('events.fields.description') }}</label>
                                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description"
                                    name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row" id="location-field">
                                <div class="col-12 mb-3">
                                    <label for="location" class="form-label">{{ __('events.fields.location') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}"
                                        id="location" name="location" value="{{ old('location') }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" id="meeting-link-field" style="display: none;">
                                <div class="col-12 mb-3">
                                    <label for="meeting_link"
                                        class="form-label">{{ __('events.fields.meeting_link') }}</label>
                                    <input type="url"
                                        class="form-control{{ $errors->has('meeting_link') ? ' is-invalid' : '' }}"
                                        id="meeting_link" name="meeting_link" value="{{ old('meeting_link') }}">
                                    @error('meeting_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_datetime"
                                        class="form-label">{{ __('events.fields.start_datetime') }}</label>
                                    <input type="datetime-local"
                                        class="form-control{{ $errors->has('start_datetime') ? ' is-invalid' : '' }}"
                                        id="start_datetime" name="start_datetime" value="{{ old('start_datetime') }}"
                                        required>
                                    @error('start_datetime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_datetime"
                                        class="form-label">{{ __('events.fields.end_datetime') }}</label>
                                    <input type="datetime-local"
                                        class="form-control{{ $errors->has('end_datetime') ? ' is-invalid' : '' }}"
                                        id="end_datetime" name="end_datetime" value="{{ old('end_datetime') }}" required>
                                    @error('end_datetime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="max_participants"
                                        class="form-label">{{ __('events.fields.max_participants') }}</label>
                                    <input type="number"
                                        class="form-control{{ $errors->has('max_participants') ? ' is-invalid' : '' }}"
                                        id="max_participants" name="max_participants" value="{{ old('max_participants') }}"
                                        min="1">
                                    @error('max_participants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('events.info.unlimited_slots') }}</small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="status" class="form-label">{{ __('events.fields.status') }}</label>
                                    <select class="form-select{{ $errors->has('status') ? ' is-invalid' : '' }}"
                                        id="status" name="status" required>
                                        <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                            {{ __('events.statuses.draft') }}</option>
                                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                            {{ __('events.statuses.published') }}</option>
                                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>
                                            {{ __('events.statuses.cancelled') }}</option>
                                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>
                                            {{ __('events.statuses.completed') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="reminder_hours_before"
                                        class="form-label">{{ __('events.fields.reminder_hours_before') }}</label>
                                    <input type="number"
                                        class="form-control{{ $errors->has('reminder_hours_before') ? ' is-invalid' : '' }}"
                                        id="reminder_hours_before" name="reminder_hours_before"
                                        value="{{ old('reminder_hours_before', 24) }}" min="1">
                                    @error('reminder_hours_before')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="banner_image"
                                    class="form-label">{{ __('events.fields.banner_image') }}</label>
                                <input type="file"
                                    class="form-control{{ $errors->has('banner_image') ? ' is-invalid' : '' }}"
                                    id="banner_image" name="banner_image" accept="image/*">
                                @error('banner_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Max 2MB</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="require_rsvp"
                                            name="require_rsvp" value="1"
                                            {{ old('require_rsvp', true) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="require_rsvp">{{ __('events.fields.require_rsvp') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="send_reminder"
                                            name="send_reminder" value="1"
                                            {{ old('send_reminder', true) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="send_reminder">{{ __('events.fields.send_reminder') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label">{{ __('events.fields.notes') }}</label>
                                <textarea class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }}" id="notes" name="notes"
                                    rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.events.index') }}"
                                    class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('common.create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Toggle location/meeting link fields based on event type
            $('#type').on('change', function() {
                if ($(this).val() === 'online') {
                    $('#location-field').hide();
                    $('#meeting-link-field').show();
                } else {
                    $('#location-field').show();
                    $('#meeting-link-field').hide();
                }
            });

            // Trigger on page load
            $('#type').trigger('change');
        });
    </script>
@endpush
