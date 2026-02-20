@extends('layouts.member')

@section('title', $campaign->title)
@section('body_class', 'member-modern')

@push('styles')
    <style>
        .campaign-detail-hero {
            position: relative;
            width: 100%;
            height: 320px;
            border-radius: 0.5rem 0.5rem 0 0;
            overflow: hidden;
            background: linear-gradient(135deg, #1a6b47 0%, #2d8f5f 50%, #c4a962 100%);
        }

        .campaign-detail-hero .carousel,
        .campaign-detail-hero .carousel-inner,
        .campaign-detail-hero .carousel-item {
            height: 100%;
        }

        .campaign-detail-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .campaign-detail-hero .carousel-control-prev,
        .campaign-detail-hero .carousel-control-next {
            width: 50px;
            height: 50px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.4);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .campaign-detail-hero:hover .carousel-control-prev,
        .campaign-detail-hero:hover .carousel-control-next {
            opacity: 1;
        }

        .campaign-detail-hero .carousel-control-prev {
            left: 15px;
        }

        .campaign-detail-hero .carousel-control-next {
            right: 15px;
        }

        .campaign-detail-hero .carousel-indicators {
            margin-bottom: 60px;
        }

        .campaign-detail-hero .carousel-indicators button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            border: none;
            margin: 0 4px;
        }

        .campaign-detail-hero .carousel-indicators button.active {
            background-color: #fff;
        }

        .campaign-detail-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.5) 100%);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
            pointer-events: none;
            z-index: 10;
        }

        .campaign-detail-hero-overlay>* {
            pointer-events: auto;
        }

        .default-hero-bg {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a6b47 0%, #2d8f5f 50%, #c4a962 100%);
        }

        .default-hero-bg i {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.3);
        }

        .btn-donate-hero {
            background: linear-gradient(135deg, #1a6b47, #2d8f5f);
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-donate-hero:hover {
            background: linear-gradient(135deg, #155a3c, #267a50);
            color: #fff;
            transform: scale(1.02);
        }

        .campaign-stats-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .campaign-stats-row .stat-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .campaign-progress-section {
            margin-top: 1rem;
        }

        .campaign-progress-label {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .campaign-progress-bar {
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .campaign-progress-bar .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1a6b47 0%, #2d8f5f 100%);
            border-radius: 6px;
        }

        .campaign-progress-percent {
            color: #1a6b47;
            font-weight: 600;
        }

        .campaign-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .donation-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .donation-item:last-child {
            border-bottom: none;
        }

        .donation-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(26, 107, 71, 0.15);
            color: #1a6b47;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 600;
        }

        .donation-info {
            flex: 1;
        }

        .donation-name {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .donation-amount {
            font-size: 0.8rem;
            color: #1a6b47;
            font-weight: 500;
        }

        .donation-note {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.25rem;
        }

        .donation-time {
            font-size: 0.75rem;
            color: #999;
        }

        .sidebar-card {
            position: sticky;
            top: 20px;
        }

        .sidebar-stat {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .sidebar-stat:last-child {
            border-bottom: none;
        }

        .sidebar-stat-label {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .sidebar-stat-value {
            font-weight: 600;
            color: #333;
        }

        .sidebar-stat-value.highlight {
            color: #1a6b47;
        }

        .btn-donate-sidebar {
            background: linear-gradient(135deg, #1a6b47, #2d8f5f);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px 24px;
            font-size: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-donate-sidebar:hover {
            background: linear-gradient(135deg, #155a3c, #267a50);
            color: #fff;
            transform: translateY(-1px);
        }

        .back-link {
            color: #1a6b47;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #155a3c;
        }

        /* ── Dark Mode ── */
        [data-bs-theme="dark"] .campaign-stats-row {
            color: rgba(226, 232, 240, 0.50);
        }

        [data-bs-theme="dark"] .campaign-progress-bar {
            background: rgba(255, 255, 255, 0.10);
        }

        [data-bs-theme="dark"] .campaign-progress-label {
            color: rgba(226, 232, 240, 0.55);
        }

        [data-bs-theme="dark"] .donation-item {
            border-bottom-color: rgba(255, 255, 255, 0.06);
        }

        [data-bs-theme="dark"] .donation-name {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .donation-note {
            color: rgba(226, 232, 240, 0.50);
        }

        [data-bs-theme="dark"] .donation-time {
            color: rgba(226, 232, 240, 0.35);
        }

        [data-bs-theme="dark"] .sidebar-stat {
            border-bottom-color: rgba(255, 255, 255, 0.06);
        }

        [data-bs-theme="dark"] .sidebar-stat-label {
            color: rgba(226, 232, 240, 0.50);
        }

        [data-bs-theme="dark"] .sidebar-stat-value {
            color: #e2e8f0;
        }
    </style>
@endpush

@section('content')
    <div class="page-animate">
        <div class="container py-4">
            {{-- Back Link --}}
            <a href="{{ route('member.donate.index') }}" class="back-link mb-4 d-inline-block">
                <i class="ti tabler-arrow-left"></i>
                {{ __('donation_campaigns.back_to_campaigns') }}
            </a>

            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    {{-- Main Campaign Card --}}
                    <div class="card mb-4">
                        <div class="campaign-detail-hero">
                            @php $images = $campaign->images; @endphp
                            @if ($images->count() > 0)
                                <div id="campaignCarousel" class="carousel slide" data-bs-ride="carousel">
                                    {{-- Indicators --}}
                                    @if ($images->count() > 1)
                                        <div class="carousel-indicators">
                                            @foreach ($images as $index => $image)
                                                <button type="button" data-bs-target="#campaignCarousel"
                                                    data-bs-slide-to="{{ $index }}"
                                                    class="{{ $index === 0 ? 'active' : '' }}"
                                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                                    aria-label="Slide {{ $index + 1 }}"></button>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Slides --}}
                                    <div class="carousel-inner">
                                        @foreach ($images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->image_url) }}"
                                                    alt="{{ $campaign->title }} - Image {{ $index + 1 }}">
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Controls --}}
                                    @if ($images->count() > 1)
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#campaignCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#campaignCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                </div>
                            @else
                                {{-- Default placeholder when no images --}}
                                <div class="default-hero-bg">
                                    <i class="ti tabler-photo"></i>
                                </div>
                            @endif

                            {{-- Overlay with donate button --}}
                            <div class="campaign-detail-hero-overlay">
                                <a href="{{ route('member.donate.checkout', $campaign) }}" class="btn-donate-hero">
                                    <i class="ti tabler-heart"></i>
                                    {{ __('dashboard.donate_now') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="fw-bold mb-2">{{ $campaign->title }}</h4>

                            {{-- Tags --}}
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @foreach ($campaign->tags as $tag)
                                    <span class="campaign-tag text-white"
                                        style="background-color: {{ $tag->color ?? '#1a6b47' }};">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>

                            {{-- Stats Row --}}
                            <div class="campaign-stats-row mb-3">
                                <div class="stat-item">
                                    <i class="ti tabler-users"></i>
                                    <span>{{ $wishes->count() }} {{ __('donation_campaigns.donors') }}</span>
                                </div>
                                @if ($campaign->end_date)
                                    <div class="stat-item">
                                        <i class="ti tabler-clock"></i>
                                        <span>{{ $campaign->end_date->diffInDays(now()) }}
                                            {{ __('donation_campaigns.days_left') }}</span>
                                    </div>
                                @endif
                                <div class="stat-item">
                                    <i class="ti tabler-chart-bar"></i>
                                    <span>{{ number_format($campaign->progress_percentage, 1) }}%
                                        {{ __('donation_campaigns.funded') }}</span>
                                </div>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="campaign-progress-section mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="campaign-progress-label">
                                        Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}
                                        {{ __('donation_campaigns.raised_of') }}
                                        Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}
                                    </span>
                                    <span
                                        class="campaign-progress-percent">{{ number_format($campaign->progress_percentage, 1) }}%</span>
                                </div>
                                <div class="campaign-progress-bar">
                                    <div class="progress-fill"
                                        style="width: {{ min($campaign->progress_percentage, 100) }}%">
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="campaign-description">
                                {!! nl2br(e($campaign->description)) !!}
                            </div>
                        </div>
                    </div>

                    {{-- Recent Donations Card --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">{{ __('donation_campaigns.recent_donations') }}</h5>

                            @if ($wishes->isEmpty())
                                <p class="text-muted mb-0">
                                    {{ __('donation_campaigns.no_donations_yet') }}
                                </p>
                            @else
                                <div class="donations-list">
                                    @foreach ($wishes as $wish)
                                        <div class="donation-item">
                                            <div class="donation-avatar">
                                                {{ strtoupper(substr($wish->member->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <div class="donation-info">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span
                                                            class="donation-name">{{ $wish->member->name ?? 'Anonymous' }}</span>
                                                        <span
                                                            class="donation-amount ms-2">{{ $wish->formatted_amount }}</span>
                                                    </div>
                                                    <span
                                                        class="donation-time">{{ $wish->created_at->diffForHumans() }}</span>
                                                </div>
                                                @if ($wish->note)
                                                    <p class="donation-note mb-0">{{ $wish->note }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="card sidebar-card">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">{{ __('donation_campaigns.support_campaign') }}</h5>

                            {{-- Campaign Stats --}}
                            <div class="sidebar-stats mb-4">
                                <div class="sidebar-stat">
                                    <span class="sidebar-stat-label">{{ __('donation_campaigns.raised') }}</span>
                                    <span class="sidebar-stat-value highlight">Rp
                                        {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="sidebar-stat">
                                    <span class="sidebar-stat-label">{{ __('donation_campaigns.goal_amount') }}</span>
                                    <span class="sidebar-stat-value">Rp
                                        {{ number_format($campaign->goal_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="sidebar-stat">
                                    <span class="sidebar-stat-label">{{ __('donation_campaigns.progress') }}</span>
                                    <span
                                        class="sidebar-stat-value highlight">{{ number_format($campaign->progress_percentage, 1) }}%</span>
                                </div>
                                @if ($campaign->end_date)
                                    <div class="sidebar-stat">
                                        <span class="sidebar-stat-label">{{ __('donation_campaigns.time_left') }}</span>
                                        <span class="sidebar-stat-value">{{ $campaign->end_date->diffForHumans() }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Donate Button --}}
                            <a href="{{ route('member.donate.checkout', $campaign) }}" class="btn-donate-sidebar mb-3">
                                <i class="ti tabler-heart"></i>
                                {{ __('dashboard.donate_now') }}
                            </a>

                            <p class="text-muted text-center mb-0" style="font-size: 0.85rem;">
                                <i class="ti tabler-shield-check me-1"></i>
                                {{ __('donation_campaigns.secure_payment') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
