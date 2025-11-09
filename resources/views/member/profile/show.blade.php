@extends('layouts.member')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('members.my_profile') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Picture -->
                            <div class="col-12 col-md-4 mb-6 text-center">
                                <div class="avatar avatar-xl mx-auto mb-4">
                                    <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="rounded-circle">
                                </div>
                                <h5 class="mb-1">{{ $member->name }}</h5>
                                <p class="text-muted mb-3">{{ $member->email }}</p>
                            </div>

                            <hr class="d-block d-sm-none">

                            <!-- Profile Information -->
                            <div class="col-12 col-md-8">
                                <h6>{{ __('members.profile_information') }}</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">{{ __('members.name') }}</label>
                                        <p class="mb-0">{{ $member->name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">{{ __('members.email') }}</label>
                                        <p class="mb-0">{{ $member->email }}</p>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">{{ __('members.phone') }}</label>
                                        <p class="mb-0">{{ $member->phone ?: __('members.not_provided') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">{{ __('members.date_of_birth') }}</label>
                                        <p class="mb-0">
                                            @if ($member->date_of_birth)
                                                {{ $member->date_of_birth->format('F j, Y') }}
                                                @if ($member->age)
                                                    <small class="text-muted">({{ $member->age }}
                                                        {{ __('members.years_old') }})</small>
                                                @endif
                                            @else
                                                {{ __('members.not_provided') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">{{ __('members.gender') }}</label>
                                        <p class="mb-0">
                                            @if ($member->gender)
                                                {{ __('members.' . $member->gender) }}
                                            @else
                                                {{ __('members.not_provided') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">{{ __('members.language') }}</label>
                                        <p class="mb-0">
                                            @switch($member->language)
                                                @case('en')
                                                    English
                                                @break

                                                @case('id')
                                                    Bahasa Indonesia
                                                @break

                                                @case('ko')
                                                    한국어
                                                @break

                                                @default
                                                    English
                                            @endswitch
                                        </p>
                                    </div>
                                    @if ($member->address)
                                        <div class="col-12 mb-4">
                                            <label class="form-label text-muted">{{ __('members.address') }}</label>
                                            <p class="mb-0">{{ $member->address }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr class="d-block d-sm-none">

                        <div class="row">
                            <!-- Account Information -->
                            <div class="col-12 mb-6">
                                <h6>{{ __('members.account_information') }}</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">{{ __('members.member_since') }}</label>
                                        <p class="mb-0">{{ $member->created_at->format('F j, Y') }}</p>
                                        <small class="text-muted">{{ $member->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">{{ __('members.last_login') }}</label>
                                        <p class="mb-0">
                                            @if ($member->last_login_at)
                                                {{ $member->last_login_at->format('M j, Y H:i') }}
                                                <small
                                                    class="text-muted d-block">{{ $member->last_login_at->diffForHumans() }}</small>
                                            @else
                                                {{ __('members.never') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <!-- Quick Actions -->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('profile.edit') }}" class="btn btn-primary w-100">
                                            <i class="ti tabler-edit me-2"></i>{{ __('members.edit_profile') }}
                                        </a>
                                    </div>
                                    @if (!$member->isGoogleUser() || $member->password)
                                        <div class="col-md-4 mb-3">
                                            <a href="{{ route('profile.change-password') }}" class="btn btn-warning w-100">
                                                <i class="ti tabler-lock me-2"></i>{{ __('members.change_password') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
