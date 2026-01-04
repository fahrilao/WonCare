@extends('layouts.admin')

@section('title', __('community.mentors.create_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.mentors.create_title') }}</h4>
                        <a href="{{ route('admin.community.mentors.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.community.mentors.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name"
                                        class="form-label">{{ __('community.mentors.fields.name') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name"
                                        name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="title"
                                        class="form-label">{{ __('community.mentors.fields.title') }}</label>
                                    <input type="text"
                                        class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" id="title"
                                        name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="expertise"
                                    class="form-label">{{ __('community.mentors.fields.expertise') }}</label>
                                <textarea class="form-control{{ $errors->has('expertise') ? ' is-invalid' : '' }}" id="expertise" name="expertise"
                                    rows="3">{{ old('expertise') }}</textarea>
                                @error('expertise')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Example: Zakat, Keuangan Pribadi, Parenting,
                                    dll.</small>
                            </div>

                            <div class="mb-3">
                                <label for="photo_path"
                                    class="form-label">{{ __('community.mentors.fields.photo_path') }}</label>
                                <input type="text"
                                    class="form-control{{ $errors->has('photo_path') ? ' is-invalid' : '' }}"
                                    id="photo_path" name="photo_path" value="{{ old('photo_path') }}">
                                @error('photo_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="bio" class="form-label">{{ __('community.mentors.fields.bio') }}</label>
                                <textarea class="form-control{{ $errors->has('bio') ? ' is-invalid' : '' }}" id="bio" name="bio"
                                    rows="6">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="sort_order"
                                        class="form-label">{{ __('community.mentors.fields.sort_order') }}</label>
                                    <input type="number"
                                        class="form-control{{ $errors->has('sort_order') ? ' is-invalid' : '' }}"
                                        id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                                        min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-8 d-flex align-items-center">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">{{ __('common.active') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.community.mentors.index') }}"
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
