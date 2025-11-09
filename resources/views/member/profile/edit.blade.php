@extends('layouts.member')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('members.edit_profile') }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ __('common.error') }}!</strong> {{ __('members.fix_errors_below') }}
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Profile Information -->
                                <div class="col-md-12 mb-6">
                                    <h6>{{ __('members.basic_information') }}</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="name" class="form-label">{{ __('members.name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $member->name) }}"
                                                required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="email" class="form-label">{{ __('members.email') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email', $member->email) }}"
                                                required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="phone" class="form-label">{{ __('members.phone') }}</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="date_of_birth"
                                                class="form-label">{{ __('members.date_of_birth') }}</label>
                                            <input type="date"
                                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                                id="date_of_birth" name="date_of_birth"
                                                value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="gender" class="form-label">{{ __('members.gender') }}</label>
                                            <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                                name="gender">
                                                <option value="">{{ __('members.select_gender') }}</option>
                                                <option value="male"
                                                    {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>
                                                    {{ __('members.male') }}
                                                </option>
                                                <option value="female"
                                                    {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>
                                                    {{ __('members.female') }}
                                                </option>
                                                <option value="other"
                                                    {{ old('gender', $member->gender) == 'other' ? 'selected' : '' }}>
                                                    {{ __('members.other') }}
                                                </option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label for="address" class="form-label">{{ __('members.address') }}</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $member->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-between gap-2">
                                        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                                            {{ __('common.cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti tabler-check me-2"></i>{{ __('common.update') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Avatar preview
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');

            if (avatarInput && avatarPreview) {
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endsection
