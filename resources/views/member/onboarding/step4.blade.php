@extends('layouts.member')

@section('title', __('onboarding.step4_title'))
@section('body_class', 'member-onboarding')

@section('content')
    <div class="onboarding-shell page-animate">
        <div class="onboarding-card card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="onboarding-step mb-3">{{ __('onboarding.step') }} 4/5</div>
                    <h2 class="onboarding-title mb-2">{{ __('onboarding.step4_title') }}</h2>
                    <p class="onboarding-subtitle mb-0">{{ __('onboarding.step4_subtitle') }}</p>
                    <div class="onboarding-progress" aria-hidden="true">
                        <span class="is-done"></span>
                        <span class="is-done"></span>
                        <span class="is-done"></span>
                        <span class="is-active"></span>
                        <span></span>
                    </div>
                </div>

                <form action="{{ route('onboarding.step4.store') }}" method="POST" class="onboarding-actions">
                    @csrf

                    <div class="mb-4">
                        <label for="occupation" class="form-label">{{ __('onboarding.occupation') }} *</label>
                        <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation"
                            name="occupation" value="{{ old('occupation', $member->occupation) }}"
                            placeholder="{{ __('onboarding.occupation_placeholder') }}" required>
                        @error('occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="financial_goal" class="form-label">{{ __('onboarding.financial_goal') }} *</label>
                        <textarea class="form-control @error('financial_goal') is-invalid @enderror" id="financial_goal" name="financial_goal"
                            rows="3" placeholder="{{ __('onboarding.financial_goal_placeholder') }}" required>{{ old('financial_goal', $member->financial_goal) }}</textarea>
                        @error('financial_goal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="savings_target_amount" class="form-label">{{ __('financial.savings_target') }}
                            ({{ __('onboarding.optional') }})</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="savings_target_amount"
                                name="savings_target_amount" value="{{ old('savings_target_amount') }}" placeholder="0"
                                step="0.01">
                        </div>
                        <small class="text-muted">{{ __('onboarding.savings_target_help') }}</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('financial.dream_assets') }}
                            ({{ __('onboarding.optional') }})</label>
                        <small class="text-muted d-block mb-2">{{ __('onboarding.dream_assets_help') }}</small>
                        <div id="dream-assets-container">
                            <div class="dream-asset-item mb-3">
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        <input type="text" class="form-control" name="dream_assets[0][name]"
                                            placeholder="{{ __('financial.asset_name') }}">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" name="dream_assets[0][cost]"
                                                placeholder="0" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <select class="form-select" name="dream_assets[0][priority]">
                                            <option value="1">{{ __('financial.priority_levels.1') }}</option>
                                            <option value="2" selected>{{ __('financial.priority_levels.2') }}
                                            </option>
                                            <option value="3">{{ __('financial.priority_levels.3') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-dream-asset">
                            <i class="ti tabler-plus"></i> {{ __('onboarding.add_dream_asset') }}
                        </button>
                    </div>

                    <div class="d-flex gap-2 onboarding-actions">
                        <a href="{{ route('onboarding.step3') }}" class="btn btn-label-secondary flex-fill">
                            {{ __('onboarding.back') }}
                        </a>
                        <button type="submit" class="btn btn-primary flex-fill">
                            {{ __('onboarding.continue') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let assetIndex = 1;
        document.getElementById('add-dream-asset').addEventListener('click', function() {
            const container = document.getElementById('dream-assets-container');
            const newAsset = `
            <div class="dream-asset-item mb-3">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <input type="text" class="form-control" name="dream_assets[${assetIndex}][name]" placeholder="{{ __('financial.asset_name') }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="dream_assets[${assetIndex}][cost]" placeholder="0" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" name="dream_assets[${assetIndex}][priority]">
                            <option value="1">{{ __('financial.priority_levels.1') }}</option>
                            <option value="2" selected>{{ __('financial.priority_levels.2') }}</option>
                            <option value="3">{{ __('financial.priority_levels.3') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', newAsset);
            assetIndex++;
        });
    </script>
@endpush
