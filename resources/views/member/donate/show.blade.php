@extends('layouts.member')

@section('title', $campaign->title)

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card mb-4">
                    <div class="card-header p-0">
                        @php $primaryImage = $campaign->primaryImage; @endphp
                        @if ($primaryImage)
                            <img src="{{ asset('storage/' . $primaryImage->image_url) }}" class="card-img-top"
                                style="max-height: 320px; object-fit: cover;" alt="{{ $campaign->title }}">
                        @endif
                    </div>
                    <div class="card-body pt-5">
                        <h4 class="mb-2">{{ $campaign->title }}</h4>
                        <div class="d-flex flex-wrap mb-4" style="gap: 0.5rem;">
                            @foreach ($campaign->tags as $tag)
                                <span class="badge px-3 py-2 text-white"
                                    style="background-color: {{ $tag->color ?? '#e9ecef' }};">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">
                                    Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }} /
                                    Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}
                                </small>
                                @if ($campaign->end_date)
                                    <small class="text-muted">
                                        <i class="ti tabler-clock me-1"></i>
                                        {{ $campaign->end_date->diffForHumans() }}
                                    </small>
                                @endif
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $campaign->progress_percentage }}%"
                                    aria-valuenow="{{ $campaign->progress_percentage }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>

                        <p class="text-muted mb-3">{!! nl2br(e($campaign->description)) !!}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Recent Donations</h5>

                        @if ($wishes->isEmpty())
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                No donations yet. Be the first to support this campaign.
                            </p>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach ($wishes as $wish)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <div>
                                                <strong>{{ $wish->member->name ?? 'Member' }}</strong>
                                                <span class="text-muted" style="font-size: 0.8rem;">
                                                    – {{ $wish->formatted_amount }}
                                                </span>
                                            </div>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ $wish->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        @if ($wish->note)
                                            <p class="mb-0" style="font-size: 0.9rem;">
                                                {{ $wish->note }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card" style="position: sticky; top: 20px;">
                    <div class="card-body">
                        <h5 class="mb-4">Support This Campaign</h5>

                        <!-- Campaign Stats -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Raised</span>
                                <strong>Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Goal</span>
                                <span>Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Progress</span>
                                <strong class="text-primary">{{ $campaign->progress_percentage }}%</strong>
                            </div>
                            @if ($campaign->end_date)
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Time Left</span>
                                    <span>{{ $campaign->end_date->diffForHumans() }}</span>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <!-- Donate Button -->
                        <a href="{{ route('member.donate.checkout', $campaign) }}"
                            class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="ti tabler-heart me-2"></i>
                            Donate Now
                        </a>

                        <p class="text-muted text-center mb-0" style="font-size: 0.85rem;">
                            <i class="ti tabler-shield-check me-1"></i>
                            Secure and trusted payment
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
