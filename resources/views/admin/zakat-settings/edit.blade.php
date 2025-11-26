@extends('layouts.admin')

@section('title', __('zakat.edit_setting'))

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="ti tabler-edit me-2"></i>
                {{ __('zakat.edit_setting') }}
            </h3>
            <a href="{{ route('admin.zakat-settings.index') }}" class="btn btn-secondary">
                <i class="ti tabler-arrow-left me-1"></i>
                {{ __('common.back') }}
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.zakat-settings.update', $zakatSetting) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">{{ __('zakat.category') }}</label>
                                <input type="text" class="form-control" value="{{ ucfirst($zakatSetting->category) }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('zakat.label') }}</label>
                                <input type="text" class="form-control" value="{{ $zakatSetting->label }}" readonly>
                                @if ($zakatSetting->description)
                                    <small class="text-muted">{{ $zakatSetting->description }}</small>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('zakat.key') }}</label>
                                <input type="text" class="form-control" value="{{ $zakatSetting->key }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('zakat.value') }} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="value"
                                        class="form-control @error('value') is-invalid @enderror"
                                        value="{{ old('value', $zakatSetting->value) }}" min="0" step="0.01"
                                        required>
                                    <span class="input-group-text">{{ $zakatSetting->unit }}</span>
                                </div>
                                @error('value')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                        {{ old('is_active', $zakatSetting->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        {{ __('zakat.is_active') }}
                                    </label>
                                </div>
                                <small class="text-muted">If inactive, this setting will not be used in calculations</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti tabler-device-floppy me-1"></i>
                                    {{ __('zakat.update_setting') }}
                                </button>
                                <a href="{{ route('admin.zakat-settings.index') }}" class="btn btn-secondary">
                                    {{ __('common.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti tabler-info-circle me-2"></i>Setting Information</h6>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Created:</dt>
                            <dd class="col-sm-7">{{ $zakatSetting->created_at->format('d M Y') }}</dd>

                            <dt class="col-sm-5">Updated:</dt>
                            <dd class="col-sm-7">{{ $zakatSetting->updated_at->format('d M Y') }}</dd>

                            <dt class="col-sm-5">Status:</dt>
                            <dd class="col-sm-7">
                                @if ($zakatSetting->is_active)
                                    <span class="badge bg-success">{{ __('common.active') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('common.inactive') }}</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="ti tabler-help me-2"></i>Guidelines</h6>
                        <ul class="small mb-0">
                            <li>Update prices regularly to reflect current market rates</li>
                            <li>Gold and silver prices should be in Rupiah per gram</li>
                            <li>Rice price should be in Rupiah per kilogram</li>
                            <li>Nisab values are fixed Islamic standards</li>
                            <li>Zakat percentage is typically 2.5%</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
