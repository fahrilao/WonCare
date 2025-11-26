@extends('layouts.member')

@section('title', __('navigation.donate'))

@section('content')
    <div class="container">
        {{-- Newest Campaigns - Grid List --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold">
                    {{ __('donation_campaigns.newest_campaigns') }}
                </h4>
            </div>

            @if ($bannerCampaigns->isEmpty())
                <div class="text-center text-muted">
                    {{ __('common.no_content') }}
                </div>
            @else
                <div class="row">
                    @foreach ($bannerCampaigns as $campaign)
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card h-100">
                                <div class="card-header p-0">
                                    @php $primaryImage = $campaign->primaryImage; @endphp
                                    @if ($primaryImage)
                                        <img src="{{ asset('storage/' . $primaryImage->image_url) }}" class="card-img-top"
                                            style="height: 160px; object-fit: cover;" alt="{{ $campaign->title }}">
                                    @endif
                                </div>
                                <div class="card-body pt-5 d-flex flex-column">
                                    <h6 class="mb-2">{{ $campaign->title }}</h6>
                                    <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 80) }}
                                    </p>

                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted">Rp
                                                {{ number_format($campaign->collected_amount, 0, ',', '.') }}</small>
                                            <small class="text-muted">{{ $campaign->progress_percentage }}%</small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted">Rp
                                                {{ number_format($campaign->goal_amount, 0, ',', '.') }}</small>
                                            @if ($campaign->end_date)
                                                <small class="text-muted">
                                                    <i class="ti tabler-clock me-1"></i>
                                                    {{ $campaign->end_date->diffForHumans() }}
                                                </small>
                                            @endif
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $campaign->progress_percentage }}%"
                                                aria-valuenow="{{ $campaign->progress_percentage }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('member.donate.show', $campaign) }}"
                                            class="btn btn-primary btn-sm w-100">
                                            <i class="ti tabler-heart me-1"></i>{{ __('dashboard.donate_now') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Running to Close Campaigns --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold">{{ __('donation_campaigns.near_closing_campaigns') }}</h4>
            </div>

            @if ($nearClosingCampaigns->isEmpty())
                <div class="text-center text-muted">
                    {{ __('common.no_content') }}
                </div>
            @else
                <div class="row">
                    @foreach ($nearClosingCampaigns as $campaign)
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card h-100">
                                <div class="card-header p-0">
                                    @php $primaryImage = $campaign->primaryImage; @endphp
                                    @if ($primaryImage)
                                        <img src="{{ asset('storage/' . $primaryImage->image_url) }}" class="card-img-top"
                                            style="height: 160px; object-fit: cover;" alt="{{ $campaign->title }}">
                                    @endif
                                </div>
                                <div class="card-body pt-5 d-flex flex-column">
                                    <h6 class="mb-2">{{ $campaign->title }}</h6>
                                    <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 80) }}</p>

                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted">Rp
                                                {{ number_format($campaign->collected_amount, 0, ',', '.') }}</small>
                                            <small class="text-muted">{{ $campaign->progress_percentage }}%</small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted">Rp
                                                {{ number_format($campaign->goal_amount, 0, ',', '.') }}</small>
                                            @if ($campaign->end_date)
                                                <small class="text-muted"><i class="ti tabler-clock me-1"></i>
                                                    {{ $campaign->end_date->diffForHumans() }}</small>
                                            @endif
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $campaign->progress_percentage }}%"
                                                aria-valuenow="{{ $campaign->progress_percentage }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('member.donate.show', $campaign) }}"
                                            class="btn btn-primary btn-sm w-100">
                                            <i class="ti tabler-heart me-1"></i>{{ __('dashboard.donate_now') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Random Campaigns --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold">{{ __('donation_campaigns.random_campaigns') }}</h4>
            </div>

            <div class="d-flex flex-wrap mb-5" style="gap: 0.5rem;">
                @foreach ($tags as $tag)
                    <span class="badge px-3 py-2 text-white" style="background-color: {{ $tag->color ?? '#e9ecef' }};">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>

            @if ($randomCampaigns->isEmpty())
                <div class="text-center text-muted">
                    {{ __('common.no_content') }}
                </div>
            @else
                <div class="row">
                    @foreach ($randomCampaigns as $campaign)
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card h-100">
                                <div class="card-header p-0">
                                    @php $primaryImage = $campaign->primaryImage; @endphp
                                    @if ($primaryImage)
                                        <img src="{{ asset('storage/' . $primaryImage->image_url) }}" class="card-img-top"
                                            style="height: 160px; object-fit: cover;" alt="{{ $campaign->title }}">
                                    @endif
                                </div>
                                <div class="card-body pt-5 d-flex flex-column">
                                    <h6 class="mb-2">{{ $campaign->title }}</h6>
                                    <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 80) }}</p>

                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="text-muted">Rp
                                                {{ number_format($campaign->collected_amount, 0, ',', '.') }}</small>
                                            <small class="text-muted">{{ $campaign->progress_percentage }}%</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $campaign->progress_percentage }}%"
                                                aria-valuenow="{{ $campaign->progress_percentage }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <a href="{{ route('member.donate.show', $campaign) }}"
                                        class="btn btn-primary btn-sm mt-auto">
                                        <i class="ti tabler-heart me-1"></i>{{ __('dashboard.donate_now') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
