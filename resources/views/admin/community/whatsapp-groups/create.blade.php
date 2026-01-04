@extends('layouts.admin')

@section('title', __('community.whatsapp_groups.create_title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('community.whatsapp_groups.create_title') }}</h4>
                        <a href="{{ route('admin.community.whatsapp-groups.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.community.whatsapp-groups.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="region"
                                    class="form-label">{{ __('community.whatsapp_groups.fields.region') }}</label>
                                <input type="text" class="form-control{{ $errors->has('region') ? ' is-invalid' : '' }}"
                                    id="region" name="region" value="{{ old('region') }}" required>
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name"
                                    class="form-label">{{ __('community.whatsapp_groups.fields.name') }}</label>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="whatsapp_link"
                                    class="form-label">{{ __('community.whatsapp_groups.fields.whatsapp_link') }}</label>
                                <input type="text"
                                    class="form-control{{ $errors->has('whatsapp_link') ? ' is-invalid' : '' }}"
                                    id="whatsapp_link" name="whatsapp_link" value="{{ old('whatsapp_link') }}" required>
                                @error('whatsapp_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description"
                                    class="form-label">{{ __('community.whatsapp_groups.fields.description') }}</label>
                                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description"
                                    name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sort_order"
                                    class="form-label">{{ __('community.whatsapp_groups.fields.sort_order') }}</label>
                                <input type="number"
                                    class="form-control{{ $errors->has('sort_order') ? ' is-invalid' : '' }}"
                                    id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">{{ __('common.active') }}</label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.community.whatsapp-groups.index') }}"
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
