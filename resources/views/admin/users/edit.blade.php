@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <h5 class="card-header">
                        {{ __('users.edit_title') }}
                        <small class="text-secondary">{{ __('users.edit_description') }}</small>
                    </h5>
                    <div class="card-body">
                        <!-- Form placeholder -->
                        <form method="POST" action="{{ route('admin.users.update', $user ?? 1) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('users.name') }}</label>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    id="name" name="name" value="{{ old('name', $user->name ?? '') }}"
                                    placeholder="Enter user name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('users.email') }}</label>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    id="email" name="email" value="{{ old('email', $user->email ?? '') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('users.password') }}</label>
                                <input type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password"
                                    name="password" placeholder="Leave blank to keep current password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">{{ __('users.leave_blank_password') }}</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation"
                                    class="form-label">{{ __('users.confirm_password') }}</label>
                                <input type="password"
                                    class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirm new password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.users.index') }}"
                                    class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                <div>
                                    <a href="{{ route('admin.users.show', $user ?? 1) }}"
                                        class="btn btn-info me-2">{{ __('common.view') }}</a>
                                    <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
