@extends('layouts.admin')

@section('title', __('community.volunteer_registrations.edit_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.volunteer_registrations.edit_title') }}</h4>
                        <a href="{{ route('admin.community.volunteer-registrations.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.community.volunteer-registrations.update', $registration) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="full_name"
                                        class="form-label">{{ __('community.volunteer_registrations.fields.full_name') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('full_name') ? ' is-invalid' : '' }}"
                                        id="full_name" name="full_name"
                                        value="{{ old('full_name', $registration->full_name) }}" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone"
                                        class="form-label">{{ __('community.volunteer_registrations.fields.phone') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone"
                                        name="phone" value="{{ old('phone', $registration->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email"
                                        class="form-label">{{ __('community.volunteer_registrations.fields.email') }}</label>
                                    <input type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"
                                        name="email" value="{{ old('email', $registration->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="region"
                                        class="form-label">{{ __('community.volunteer_registrations.fields.region') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('region') ? ' is-invalid' : '' }}"
                                        id="region" name="region" value="{{ old('region', $registration->region) }}">
                                    @error('region')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="type"
                                        class="form-label">{{ __('community.volunteer_registrations.fields.type') }}</label>
                                    <select class="form-select{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                        id="type" name="type" required>
                                        @php $value = old('type', $registration->type); @endphp
                                        <option value="digital" {{ $value === 'digital' ? 'selected' : '' }}>digital
                                        </option>
                                        <option value="offline" {{ $value === 'offline' ? 'selected' : '' }}>offline
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status"
                                        class="form-label">{{ __('community.volunteer_registrations.fields.status') }}</label>
                                    <select class="form-select{{ $errors->has('status') ? ' is-invalid' : '' }}"
                                        id="status" name="status" required>
                                        @php $value = old('status', $registration->status); @endphp
                                        <option value="new" {{ $value === 'new' ? 'selected' : '' }}>new</option>
                                        <option value="contacted" {{ $value === 'contacted' ? 'selected' : '' }}>contacted
                                        </option>
                                        <option value="approved" {{ $value === 'approved' ? 'selected' : '' }}>approved
                                        </option>
                                        <option value="rejected" {{ $value === 'rejected' ? 'selected' : '' }}>rejected
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="skills"
                                    class="form-label">{{ __('community.volunteer_registrations.fields.skills') }}</label>
                                <textarea class="form-control{{ $errors->has('skills') ? ' is-invalid' : '' }}" id="skills" name="skills"
                                    rows="3">{{ old('skills', $registration->skills) }}</textarea>
                                @error('skills')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="availability"
                                    class="form-label">{{ __('community.volunteer_registrations.fields.availability') }}</label>
                                <textarea class="form-control{{ $errors->has('availability') ? ' is-invalid' : '' }}" id="availability"
                                    name="availability" rows="3">{{ old('availability', $registration->availability) }}</textarea>
                                @error('availability')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="notes"
                                    class="form-label">{{ __('community.volunteer_registrations.fields.notes') }}</label>
                                <textarea class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }}" id="notes" name="notes"
                                    rows="3">{{ old('notes', $registration->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.community.volunteer-registrations.index') }}"
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
