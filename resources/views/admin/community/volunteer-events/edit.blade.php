@extends('layouts.admin')

@section('title', __('community.volunteer_events.edit_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.volunteer_events.edit_title') }}</h4>
                        <a href="{{ route('admin.community.volunteer-events.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.community.volunteer-events.update', $event) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title"
                                    class="form-label">{{ __('community.volunteer_events.fields.title') }}</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                    id="title" name="title" value="{{ old('title', $event->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="region"
                                    class="form-label">{{ __('community.volunteer_events.fields.region') }}</label>
                                <input type="text" class="form-control{{ $errors->has('region') ? ' is-invalid' : '' }}"
                                    id="region" name="region" value="{{ old('region', $event->region) }}">
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_at"
                                        class="form-label">{{ __('community.volunteer_events.fields.start_at') }}</label>
                                    <input type="datetime-local"
                                        class="form-control{{ $errors->has('start_at') ? ' is-invalid' : '' }}"
                                        id="start_at" name="start_at"
                                        value="{{ old('start_at', $event->start_at ? $event->start_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('start_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_at"
                                        class="form-label">{{ __('community.volunteer_events.fields.end_at') }}</label>
                                    <input type="datetime-local"
                                        class="form-control{{ $errors->has('end_at') ? ' is-invalid' : '' }}"
                                        id="end_at" name="end_at"
                                        value="{{ old('end_at', $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('end_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="location"
                                    class="form-label">{{ __('community.volunteer_events.fields.location') }}</label>
                                <input type="text"
                                    class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" id="location"
                                    name="location" value="{{ old('location', $event->location) }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="registration_link"
                                    class="form-label">{{ __('community.volunteer_events.fields.registration_link') }}</label>
                                <input type="text"
                                    class="form-control{{ $errors->has('registration_link') ? ' is-invalid' : '' }}"
                                    id="registration_link" name="registration_link"
                                    value="{{ old('registration_link', $event->registration_link) }}">
                                @error('registration_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description"
                                    class="form-label">{{ __('community.volunteer_events.fields.description') }}</label>
                                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description"
                                    name="description" rows="6">{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="is_online" name="is_online"
                                    {{ old('is_online', $event->is_online) ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="is_online">{{ __('community.volunteer_events.fields.is_online') }}</label>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">{{ __('common.active') }}</label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.community.volunteer-events.index') }}"
                                    class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
