@extends('layouts.admin')

@section('title', __('donation_reports.edit_donation_report'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('donation_reports.edit_donation_report') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.donation-reports.update', $donationReport) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Campaign Selection -->
                                <div class="col-md-6 mb-3">
                                    <label for="donation_campaign_id"
                                        class="form-label">{{ __('donation_reports.campaign') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('donation_campaign_id') is-invalid @enderror"
                                        id="donation_campaign_id" name="donation_campaign_id" required>
                                        <option value="">{{ __('donation_reports.select_campaign') }}</option>
                                        @foreach ($campaigns as $campaign)
                                            <option value="{{ $campaign->id }}"
                                                {{ old('donation_campaign_id', $donationReport->donation_campaign_id) == $campaign->id ? 'selected' : '' }}>
                                                {{ $campaign->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('donation_campaign_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Distributed Amount -->
                                <div class="col-md-6 mb-3">
                                    <label for="distributed_amount"
                                        class="form-label">{{ __('donation_reports.distributed_amount') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number"
                                            class="form-control @error('distributed_amount') is-invalid @enderror"
                                            id="distributed_amount" name="distributed_amount"
                                            value="{{ old('distributed_amount', $donationReport->distributed_amount) }}"
                                            min="0" step="0.01" required>
                                        @error('distributed_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">{{ __('donation_reports.distributed_amount_help') }}</div>
                                </div>

                                <!-- Distribution Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="distribution_date"
                                        class="form-label">{{ __('donation_reports.distribution_date') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control @error('distribution_date') is-invalid @enderror"
                                        id="distribution_date" name="distribution_date"
                                        value="{{ old('distribution_date', $donationReport->distribution_date?->format('Y-m-d')) }}"
                                        max="{{ date('Y-m-d') }}" required>
                                    @error('distribution_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{ __('donation_reports.distribution_date_help') }}</div>
                                </div>

                                <!-- Description -->
                                <div class="col-12 mb-3">
                                    <label for="description"
                                        class="form-label">{{ __('donation_reports.description') }}</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4">{{ old('description', $donationReport->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{ __('donation_reports.description_help') }}</div>
                                </div>

                                <!-- Beneficiaries -->
                                <div class="col-12 mb-3">
                                    <label for="beneficiaries"
                                        class="form-label">{{ __('donation_reports.beneficiaries') }}</label>
                                    <textarea class="form-control @error('beneficiaries') is-invalid @enderror" id="beneficiaries" name="beneficiaries"
                                        rows="3">{{ old('beneficiaries', $donationReport->beneficiaries) }}</textarea>
                                    @error('beneficiaries')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{ __('donation_reports.beneficiaries_help') }}</div>
                                </div>

                                <!-- Current Evidence File -->
                                @if ($donationReport->evidence_file)
                                    <div class="col-12 mb-3">
                                        <label
                                            class="form-label">{{ __('donation_reports.current_evidence_file') }}</label>
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti tabler-file-text me-2 text-primary"></i>
                                                    <div class="flex-grow-1">
                                                        <a href="{{ asset('storage/' . $donationReport->evidence_file) }}"
                                                            target="_blank" class="text-decoration-none">
                                                            {{ basename($donationReport->evidence_file) }}
                                                        </a>
                                                        <small
                                                            class="text-muted d-block">{{ __('donation_reports.click_to_view') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Evidence File -->
                                <div class="col-12 mb-3">
                                    <label for="evidence_file" class="form-label">
                                        {{ $donationReport->evidence_file ? __('donation_reports.replace_evidence_file') : __('donation_reports.evidence_file') }}
                                    </label>
                                    <input type="file" class="form-control @error('evidence_file') is-invalid @enderror"
                                        id="evidence_file" name="evidence_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    @error('evidence_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{ __('donation_reports.evidence_file_help') }}</div>
                                </div>

                                <!-- Notes -->
                                <div class="col-12 mb-3">
                                    <label for="notes" class="form-label">{{ __('donation_reports.notes') }}</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $donationReport->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{ __('donation_reports.notes_help') }}</div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.donation-reports.show', $donationReport) }}"
                                            class="btn btn-secondary">
                                            {{ __('common.cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('donation_reports.update_report') }}
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

@push('vendor_scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for campaign selection
            $('#donation_campaign_id').select2({
                placeholder: '{{ __('donation_reports.select_campaign') }}',
                allowClear: true,
                width: '100%'
            });

            // Format number input for distributed amount
            $('#distributed_amount').on('input', function() {
                let value = $(this).val();
                // Remove any non-numeric characters except decimal point
                value = value.replace(/[^0-9.]/g, '');
                // Ensure only one decimal point
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                $(this).val(value);
            });

            // File input preview
            $('#evidence_file').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB

                    // Show file info
                    let fileInfo =
                        `<small class="text-muted d-block mt-1">Selected: ${fileName} (${fileSize} MB)</small>`;

                    // Remove existing file info
                    $(this).siblings('.file-info').remove();

                    // Add new file info
                    $(this).after(fileInfo);
                }
            });
        });
    </script>
@endpush
