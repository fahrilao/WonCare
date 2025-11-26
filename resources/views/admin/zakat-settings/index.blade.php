@extends('layouts.admin')

@section('title', __('zakat.settings'))

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="ti tabler-settings me-2"></i>
                {{ __('zakat.manage_settings') }}
            </h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti tabler-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-4">{{ __('zakat.settings_description') }}</p>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('zakat.category') }}</th>
                                <th>{{ __('zakat.label') }}</th>
                                <th>{{ __('zakat.value') }}</th>
                                <th>{{ __('zakat.unit') }}</th>
                                <th>{{ __('zakat.is_active') }}</th>
                                <th>{{ __('zakat.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $currentCategory = null; @endphp
                            @foreach ($settings as $setting)
                                @if ($currentCategory !== $setting->category)
                                    @php $currentCategory = $setting->category; @endphp
                                    <tr class="table-light">
                                        <td colspan="6" class="fw-bold">
                                            <i class="ti tabler-folder me-1"></i>
                                            {{ ucfirst($setting->category) }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="fw-bold">{{ $setting->label }}</div>
                                        @if ($setting->description)
                                            <small class="text-muted">{{ $setting->description }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ number_format($setting->value, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>{{ $setting->unit }}</td>
                                    <td>
                                        @if ($setting->is_active)
                                            <span class="badge bg-success">
                                                <i class="ti tabler-check me-1"></i>{{ __('common.active') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="ti tabler-x me-1"></i>{{ __('common.inactive') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.zakat-settings.edit', $setting) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="ti tabler-edit"></i>
                                            {{ __('common.edit') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="mb-3"><i class="ti tabler-info-circle me-2"></i>About Zakat Settings</h6>
                <ul class="mb-0">
                    <li><strong>Gold Price:</strong> Current market price per gram (used for Zakat Mal calculation)</li>
                    <li><strong>Silver Price:</strong> Current market price per gram (used for Zakat Mal calculation)</li>
                    <li><strong>Gold Nisab:</strong> Minimum gold amount (85 grams) to be obligated for Zakat</li>
                    <li><strong>Silver Nisab:</strong> Minimum silver amount (595 grams) to be obligated for Zakat</li>
                    <li><strong>Rice Price:</strong> Current market price per kg (used for Zakat Fitrah calculation)</li>
                    <li><strong>Fitrah Amount:</strong> Amount of rice per person (2.5 kg or 3.5 liters)</li>
                    <li><strong>Zakat Percentage:</strong> Standard Zakat rate (2.5%)</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
