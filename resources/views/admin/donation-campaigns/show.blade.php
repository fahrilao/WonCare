@extends('layouts.admin')

@section('title', __('donation_campaigns.view_title'))

@section('content')
    <div class="container-xxl grow container-p-y">
        <div class="row gap-4">
            <div class="col-md-12">
                <!-- Campaign Status Information -->
                <div class="row align-items-stretch">
                    <div class="col-md-6">
                        <div class="card border-primary h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title text-primary">{{ __('donation_campaigns.status') }}</h6>
                                <div class="mb-2">
                                    @if ($donationCampaign->status == 'active')
                                        <i class="ti tabler-clock text-success" style="font-size: 2rem;"></i>
                                        <p class="text-success mb-0">Campaign is currently active</p>
                                    @elseif($donationCampaign->status == 'completed')
                                        <i class="ti tabler-clock-off text-warning" style="font-size: 2rem;"></i>
                                        <p class="text-warning mb-0">Campaign has ended</p>
                                    @else
                                        <i class="ti tabler-clock text-info" style="font-size: 2rem;"></i>
                                        <p class="text-info mb-0">Campaign not yet started</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-success h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ __('donation_campaigns.progress') }}
                                </h6>
                                <div class="mb-2">
                                    <div style="font-size: 2rem;" class="text-success">
                                        {{ $donationCampaign->progress_percentage }}%
                                    </div>
                                    <p class="mb-0">
                                        Rp. {{ $donationCampaign->formatted_collected_amount }} of
                                        Rp. {{ $donationCampaign->formatted_goal_amount }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('donation_campaigns.view_title') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.donation-campaigns.edit', $donationCampaign->id) }}"
                                class="btn btn-warning btn-sm">
                                <i class="ti tabler-pencil"></i>
                                {{ __('common.edit') }}
                            </a>
                            <a href="{{ route('admin.donation-campaigns.index') }}" class="btn btn-secondary">
                                {{ __('common.back_to_list') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Campaign Image -->
                            @if ($donationCampaign->image_url)
                                <div class="col-md-4 mb-4">
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $donationCampaign->image_url) }}"
                                            alt="{{ $donationCampaign->title }}" class="img-fluid rounded shadow-sm"
                                            style="max-height: 300px;">
                                    </div>
                                </div>
                            @endif

                            <!-- Campaign Details -->
                            <div class="{{ $donationCampaign->image_url ? 'col-md-8' : 'col-md-12' }}">
                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_campaigns.title') }}:</strong></div>
                                    <div class="col-md-9">{{ $donationCampaign->title }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_campaigns.status') }}:</strong></div>
                                    <div class="col-md-9">
                                        @php
                                            $badgeClass = match ($donationCampaign->status) {
                                                'draft' => 'bg-secondary',
                                                'active' => 'bg-success',
                                                'completed' => 'bg-primary',
                                                'cancelled' => 'bg-danger',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ __('donation_campaigns.status_' . $donationCampaign->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_campaigns.goal_amount') }}:</strong>
                                    </div>
                                    <div class="col-md-9">
                                        <span class="h5 text-primary">Rp.
                                            {{ $donationCampaign->formatted_goal_amount }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_campaigns.collected_amount') }}:</strong>
                                    </div>
                                    <div class="col-md-9">
                                        <span class="h5 text-success">Rp.
                                            {{ $donationCampaign->formatted_collected_amount }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_campaigns.remaining_amount') }}:</strong>
                                    </div>
                                    <div class="col-md-9">
                                        <span class="h5 text-info">Rp.
                                            {{ $donationCampaign->formatted_remaining_amount }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_campaigns.start_date') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $donationCampaign->start_date ? $donationCampaign->start_date->format('M d, Y H:i') : '-' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_campaigns.end_date') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $donationCampaign->end_date ? $donationCampaign->end_date->format('M d, Y H:i') : __('donation_campaigns.unlimited_duration') }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('donation_campaigns.creator') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $donationCampaign->creator ? $donationCampaign->creator->name : '-' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('common.created_at') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $donationCampaign->created_at ? $donationCampaign->created_at->format('M d, Y H:i') : '-' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3"><strong>{{ __('common.updated_at') }}:</strong></div>
                                    <div class="col-md-9">
                                        {{ $donationCampaign->updated_at ? $donationCampaign->updated_at->format('M d, Y H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if ($donationCampaign->description)
                            <div class="mt-4">
                                <h5>{{ __('donation_campaigns.description') }}</h5>
                                {!! nl2br(e($donationCampaign->description)) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
