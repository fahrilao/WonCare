@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('users.view_title') }}</h4>
                        <div>
                            <a href="{{ route('admin.users.edit', $user ?? 1) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.users.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"><strong>ID:</strong></div>
                            <div class="col-md-9">{{ $user->id ?? 'User ID will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('users.name') }}:</strong></div>
                            <div class="col-md-9">{{ $user->name ?? 'User name will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('users.email') }}:</strong></div>
                            <div class="col-md-9">{{ $user->email ?? 'User email will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('common.created_at') }}:</strong></div>
                            <div class="col-md-9">{{ $user->created_at ?? 'Creation date will be displayed here' }}</div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3"><strong>{{ __('common.updated_at') }}:</strong></div>
                            <div class="col-md-9">{{ $user->updated_at }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
