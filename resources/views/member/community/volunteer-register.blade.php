@extends('layouts.member')

@section('title', __('community.volunteer.register_title'))
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Page Header -->
                <div class="mb-4">
                    <h4 class="mb-1">{{ __('community.volunteer.register_title') }}</h4>
                    <p class="text-muted">{{ __('community.volunteer.register_subtitle') }}</p>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('member.community.volunteer-register.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('community.volunteer.full_name') }} *</label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                        name="full_name" value="{{ old('full_name', auth('member')->user()->name) }}"
                                        required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('community.volunteer.phone') }} *</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone', auth('member')->user()->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('community.volunteer.email') }} *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email', auth('member')->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('community.volunteer.region') }} *</label>
                                    <input type="text" class="form-control @error('region') is-invalid @enderror"
                                        name="region" value="{{ old('region') }}"
                                        placeholder="{{ __('community.volunteer.region_placeholder') }}" required>
                                    @error('region')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">{{ __('community.volunteer.type') }} *</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type"
                                                    value="digital" id="typeDigital"
                                                    {{ old('type') == 'digital' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="typeDigital">
                                                    {{ __('community.volunteer.type_digital') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type"
                                                    value="offline" id="typeOffline"
                                                    {{ old('type') == 'offline' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="typeOffline">
                                                    {{ __('community.volunteer.type_offline') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" value="both"
                                                    id="typeBoth" {{ old('type') == 'both' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="typeBoth">
                                                    {{ __('community.volunteer.type_both') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('type')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">{{ __('community.volunteer.skills') }}</label>
                                    <textarea class="form-control" name="skills" rows="3"
                                        placeholder="{{ __('community.volunteer.skills_placeholder') }}">{{ old('skills') }}</textarea>
                                    <small class="text-muted">{{ __('community.volunteer.skills_help') }}</small>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">{{ __('community.volunteer.availability') }}</label>
                                    <textarea class="form-control" name="availability" rows="2"
                                        placeholder="{{ __('community.volunteer.availability_placeholder') }}">{{ old('availability') }}</textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">{{ __('community.volunteer.notes') }}</label>
                                    <textarea class="form-control" name="notes" rows="3"
                                        placeholder="{{ __('community.volunteer.notes_placeholder') }}">{{ old('notes') }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('member.community.volunteer-events') }}"
                                    class="btn btn-outline-secondary">
                                    {{ __('common.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti tabler-send me-1"></i>{{ __('community.volunteer.submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6 class="mb-3">{{ __('community.volunteer.why_volunteer') }}</h6>
                        <ul class="mb-0">
                            <li>{{ __('community.volunteer.benefit_1') }}</li>
                            <li>{{ __('community.volunteer.benefit_2') }}</li>
                            <li>{{ __('community.volunteer.benefit_3') }}</li>
                            <li>{{ __('community.volunteer.benefit_4') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
