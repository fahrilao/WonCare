@extends('layouts.member')

@section('title', __('onboarding.step3_title'))
@section('body_class', 'member-onboarding')

@section('content')
    <div class="onboarding-shell page-animate">
        <div class="onboarding-card card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="onboarding-step mb-3">{{ __('onboarding.step') }} 3/5</div>
                    <h2 class="onboarding-title mb-2">{{ __('onboarding.step3_title') }}</h2>
                    <p class="onboarding-subtitle mb-0">{{ __('onboarding.step3_subtitle') }}</p>
                    <div class="onboarding-progress" aria-hidden="true">
                        <span class="is-done"></span>
                        <span class="is-done"></span>
                        <span class="is-active"></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <form action="{{ route('onboarding.step3.store') }}" method="POST" class="onboarding-actions">
                    @csrf

                    <p class="text-muted mb-4">{{ __('onboarding.expense_help') }}</p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rent" class="form-label">{{ __('financial.expense_categories.rent') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="rent" name="rent"
                                    value="{{ old('rent', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="food" class="form-label">{{ __('financial.expense_categories.food') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="food" name="food"
                                    value="{{ old('food', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="remittance"
                                class="form-label">{{ __('financial.expense_categories.remittance') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="remittance" name="remittance"
                                    value="{{ old('remittance', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="transport"
                                class="form-label">{{ __('financial.expense_categories.transport') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="transport" name="transport"
                                    value="{{ old('transport', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="entertainment"
                                class="form-label">{{ __('financial.expense_categories.entertainment') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="entertainment" name="entertainment"
                                    value="{{ old('entertainment', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="charity"
                                class="form-label">{{ __('financial.expense_categories.charity') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="charity" name="charity"
                                    value="{{ old('charity', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="other" class="form-label">{{ __('financial.expense_categories.other') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="other" name="other"
                                    value="{{ old('other', 0) }}" placeholder="0" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 onboarding-actions">
                        <a href="{{ route('onboarding.step2') }}" class="btn btn-label-secondary flex-fill">
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
