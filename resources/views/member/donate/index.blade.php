@extends('layouts.member')

@section('title', __('navigation.donate'))
@section('body_class', 'member-modern')

@push('styles')
    <style>
        .donate-hero {
            background: linear-gradient(135deg, #1a6b47 0%, #2d8f5f 50%, #c4a962 100%);
            border-radius: 16px;
            padding: 40px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .donate-hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='80' fill='rgba(255,255,255,0.05)'/%3E%3C/svg%3E") no-repeat center right;
            background-size: contain;
        }

        .donate-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            color: #fff;
            margin-bottom: 16px;
        }

        .donate-hero h1 {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .donate-hero p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            max-width: 500px;
            margin: 0;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .section-title i {
            color: #1a6b47;
            font-size: 1.25rem;
        }

        .section-title h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: #1a1a1a;
        }

        .campaign-card {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .campaign-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .campaign-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .campaign-tag.education {
            background: #e3f2fd;
            color: #1565c0;
        }

        .campaign-tag.food {
            background: #fff3e0;
            color: #ef6c00;
        }

        .campaign-tag.health {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .campaign-tag.emergency {
            background: #ffebee;
            color: #c62828;
        }

        .campaign-tag.orphanage {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .campaign-card h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .campaign-card .description {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 16px;
            line-height: 1.5;
            flex-grow: 1;
        }

        .campaign-stats {
            margin-bottom: 8px;
        }

        .campaign-stats .amount-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .campaign-stats .collected {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .campaign-stats .percentage {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1a6b47;
        }

        .campaign-progress {
            height: 6px;
            background: #e8e8e8;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .campaign-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #1a6b47, #2d8f5f);
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .campaign-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 16px;
        }

        .campaign-meta i {
            font-size: 0.85rem;
            margin-right: 4px;
        }

        .btn-donate {
            background: linear-gradient(135deg, #1a6b47, #2d8f5f);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-donate:hover {
            background: linear-gradient(135deg, #155a3c, #267a50);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-donate i {
            font-size: 1rem;
        }

        .filter-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 24px;
        }

        .filter-tab {
            padding: 8px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            background: #fff;
            color: #666;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .filter-tab:hover,
        .filter-tab.active {
            background: #1a6b47;
            border-color: #1a6b47;
            color: #fff;
        }

        @media (max-width: 768px) {
            .donate-hero {
                padding: 24px;
            }

            .donate-hero h1 {
                font-size: 1.5rem;
            }

            .donate-hero p {
                font-size: 0.9rem;
            }
        }

        /* ── Dark Mode ── */
        [data-bs-theme="dark"] .section-title h2 {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .campaign-card {
            background: var(--bs-body-bg);
            border-color: var(--bs-border-color);
        }

        [data-bs-theme="dark"] .campaign-card h3 {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .campaign-card .description {
            color: rgba(226, 232, 240, 0.55);
        }

        [data-bs-theme="dark"] .campaign-stats .collected {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .campaign-progress {
            background: rgba(255, 255, 255, 0.10);
        }

        [data-bs-theme="dark"] .campaign-meta {
            color: rgba(226, 232, 240, 0.45);
        }

        [data-bs-theme="dark"] .campaign-tag.education {
            background: rgba(21, 101, 192, 0.18);
            color: #90caf9;
        }

        [data-bs-theme="dark"] .campaign-tag.food {
            background: rgba(239, 108, 0, 0.15);
            color: #ffcc80;
        }

        [data-bs-theme="dark"] .campaign-tag.health {
            background: rgba(46, 125, 50, 0.18);
            color: #a5d6a7;
        }

        [data-bs-theme="dark"] .campaign-tag.emergency {
            background: rgba(198, 40, 40, 0.15);
            color: #ef9a9a;
        }

        [data-bs-theme="dark"] .campaign-tag.orphanage {
            background: rgba(123, 31, 162, 0.15);
            color: #ce93d8;
        }

        [data-bs-theme="dark"] .filter-tab {
            background: var(--bs-body-bg);
            border-color: var(--bs-border-color);
            color: rgba(226, 232, 240, 0.65);
        }

        [data-bs-theme="dark"] .filter-tab:hover,
        [data-bs-theme="dark"] .filter-tab.active {
            background: #1a6b47;
            border-color: #1a6b47;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="page-animate">
        <div class="container py-4">
            {{-- Hero Section --}}
            <div class="donate-hero">
                <div class="donate-hero-badge">
                    <i class="ti tabler-sparkles"></i>
                    {{ __('donation_campaigns.make_difference') }}
                </div>
                <h1>{{ __('donation_campaigns.support_campaigns') }}</h1>
                <p>{{ __('donation_campaigns.hero_description') }}</p>
            </div>

            {{-- Newest Campaigns --}}
            <div class="mb-5">
                <div class="section-title">
                    <i class="ti tabler-heart"></i>
                    <h2>{{ __('donation_campaigns.newest_campaigns') }}</h2>
                </div>

                @if ($bannerCampaigns->isEmpty())
                    <div class="text-center text-muted py-4">
                        {{ __('common.no_content') }}
                    </div>
                @else
                    <div class="row g-4">
                        @foreach ($bannerCampaigns as $campaign)
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="campaign-card">
                                    @php
                                        $tagName = $campaign->tags->first()?->name ?? 'General';
                                        $tagSlug = \Illuminate\Support\Str::slug($tagName);
                                        $tagClass = match (true) {
                                            str_contains(strtolower($tagName), 'education') => 'education',
                                            str_contains(strtolower($tagName), 'food') => 'food',
                                            str_contains(strtolower($tagName), 'health') => 'health',
                                            str_contains(strtolower($tagName), 'emergency') => 'emergency',
                                            str_contains(strtolower($tagName), 'orphan') => 'orphanage',
                                            default => 'education',
                                        };
                                    @endphp
                                    <span class="campaign-tag {{ $tagClass }}">{{ $tagName }}</span>
                                    <h3>{{ $campaign->title }}</h3>
                                    <p class="description">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 70) }}
                                    </p>

                                    <div class="campaign-stats">
                                        <div class="amount-row">
                                            <span class="collected">Rp
                                                {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                            <span
                                                class="percentage">{{ number_format($campaign->progress_percentage, 1) }}%</span>
                                        </div>
                                        <div class="campaign-progress">
                                            <div class="campaign-progress-bar"
                                                style="width: {{ min($campaign->progress_percentage, 100) }}%"></div>
                                        </div>
                                    </div>

                                    <div class="campaign-meta">
                                        <span>
                                            <i class="ti tabler-clock"></i>
                                            @if ($campaign->end_date)
                                                {{ $campaign->end_date->diffInDays(now()) }}
                                                {{ __('donation_campaigns.days_left') }}
                                            @else
                                                {{ __('donation_campaigns.no_deadline') }}
                                            @endif
                                        </span>
                                        <span>{{ __('donation_campaigns.from') }} Rp
                                            {{ number_format($campaign->goal_amount, 0, ',', '.') }}</span>
                                    </div>

                                    <a href="{{ route('member.donate.show', $campaign) }}" class="btn-donate">
                                        <i class="ti tabler-heart"></i>
                                        {{ __('dashboard.donate_now') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Running to Close Campaigns --}}
            <div class="mb-5">
                <div class="section-title">
                    <i class="ti tabler-heart"></i>
                    <h2>{{ __('donation_campaigns.running_to_close') }}</h2>
                </div>

                @if ($nearClosingCampaigns->isEmpty())
                    <div class="text-center text-muted py-4">
                        {{ __('common.no_content') }}
                    </div>
                @else
                    <div class="row g-4">
                        @foreach ($nearClosingCampaigns as $campaign)
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="campaign-card">
                                    @php
                                        $tagName = $campaign->tags->first()?->name ?? 'General';
                                        $tagClass = match (true) {
                                            str_contains(strtolower($tagName), 'education') => 'education',
                                            str_contains(strtolower($tagName), 'food') => 'food',
                                            str_contains(strtolower($tagName), 'health') => 'health',
                                            str_contains(strtolower($tagName), 'emergency') => 'emergency',
                                            str_contains(strtolower($tagName), 'orphan') => 'orphanage',
                                            default => 'education',
                                        };
                                    @endphp
                                    <span class="campaign-tag {{ $tagClass }}">{{ $tagName }}</span>
                                    <h3>{{ $campaign->title }}</h3>
                                    <p class="description">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 70) }}
                                    </p>

                                    <div class="campaign-stats">
                                        <div class="amount-row">
                                            <span class="collected">Rp
                                                {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                            <span
                                                class="percentage">{{ number_format($campaign->progress_percentage, 1) }}%</span>
                                        </div>
                                        <div class="campaign-progress">
                                            <div class="campaign-progress-bar"
                                                style="width: {{ min($campaign->progress_percentage, 100) }}%"></div>
                                        </div>
                                    </div>

                                    <div class="campaign-meta">
                                        <span>
                                            <i class="ti tabler-clock"></i>
                                            @if ($campaign->end_date)
                                                {{ $campaign->end_date->diffInDays(now()) }}
                                                {{ __('donation_campaigns.days_left') }}
                                            @else
                                                {{ __('donation_campaigns.no_deadline') }}
                                            @endif
                                        </span>
                                        <span>{{ __('donation_campaigns.from') }} Rp
                                            {{ number_format($campaign->goal_amount, 0, ',', '.') }}</span>
                                    </div>

                                    <a href="{{ route('member.donate.show', $campaign) }}" class="btn-donate">
                                        <i class="ti tabler-heart"></i>
                                        {{ __('dashboard.donate_now') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Discover More Campaigns --}}
            <div class="mb-5">
                <div class="section-title">
                    <h2>{{ __('donation_campaigns.discover_campaigns') }}</h2>
                </div>

                {{-- Category Filter Tabs (AJAX) --}}
                <div class="filter-tabs" id="filterTabs">
                    <button type="button" class="filter-tab active" data-tag="all">
                        {{ __('common.all') }}
                    </button>
                    @foreach ($tags as $tag)
                        <button type="button" class="filter-tab" data-tag="{{ $tag->slug }}">
                            {{ $tag->name }}
                        </button>
                    @endforeach
                </div>

                {{-- Campaign Grid (loaded via AJAX) --}}
                <div class="row g-4" id="discoverCampaignsGrid">
                    @foreach ($randomCampaigns as $campaign)
                        @php
                            $tagName = $campaign->tags->first()?->name ?? 'General';
                            $tagClass = match (true) {
                                str_contains(strtolower($tagName), 'education') => 'education',
                                str_contains(strtolower($tagName), 'food') => 'food',
                                str_contains(strtolower($tagName), 'health') => 'health',
                                str_contains(strtolower($tagName), 'emergency') => 'emergency',
                                str_contains(strtolower($tagName), 'orphan') => 'orphanage',
                                default => 'education',
                            };
                            $daysLeft = $campaign->end_date
                                ? $campaign->end_date->diffInDays(now()) . ' ' . __('donation_campaigns.days_left')
                                : __('donation_campaigns.no_deadline');
                        @endphp
                        @include('member.donate._campaign-card', [
                            'campaign' => $campaign,
                            'tagName' => $tagName,
                            'tagClass' => $tagClass,
                            'daysLeft' => $daysLeft,
                        ])
                    @endforeach
                </div>

                {{-- Loading indicator --}}
                <div class="text-center py-4 d-none" id="loadingIndicator">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">{{ __('common.loading') }}</span>
                    </div>
                    <p class="mt-2 text-muted">{{ __('common.loading') }}</p>
                </div>

                {{-- No content message --}}
                <div class="text-center text-muted py-4 d-none" id="noContentMessage">
                    {{ __('common.no_content') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.getElementById('filterTabs');
            const campaignsGrid = document.getElementById('discoverCampaignsGrid');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const noContentMessage = document.getElementById('noContentMessage');

            let currentTag = 'all';
            let currentPage = 2; // Start at page 2 since page 1 is already rendered by server
            let isLoading = false;
            let hasMore = {{ $randomCampaigns->count() >= 8 ? 'true' : 'false' }}; // Check if there might be more
            const apiUrl = '{{ route('member.donate.api.campaigns') }}';

            // Tag filter click handler
            filterTabs.addEventListener('click', function(e) {
                const tab = e.target.closest('.filter-tab');
                if (!tab) return;

                // Update active state
                filterTabs.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Load campaigns for selected tag
                currentTag = tab.dataset.tag;
                currentPage = 1;
                hasMore = true;
                loadCampaigns(true); // true = replace content
            });

            // Infinite scroll
            function handleScroll() {
                if (isLoading || !hasMore) return;

                const scrollPosition = window.innerHeight + window.scrollY;
                const threshold = document.documentElement.scrollHeight - 300;

                if (scrollPosition >= threshold) {
                    loadCampaigns(false); // false = append content
                }
            }

            // Debounce scroll handler
            let scrollTimeout;
            window.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(handleScroll, 100);
            });

            // Load campaigns via AJAX
            async function loadCampaigns(replace = false) {
                if (isLoading) return;

                isLoading = true;
                loadingIndicator.classList.remove('d-none');
                noContentMessage.classList.add('d-none');

                if (replace) {
                    campaignsGrid.innerHTML = '';
                }

                try {
                    const response = await fetch(`${apiUrl}?tag=${currentTag}&page=${currentPage}`);
                    const data = await response.json();

                    if (replace && !data.html) {
                        noContentMessage.classList.remove('d-none');
                    } else {
                        campaignsGrid.insertAdjacentHTML('beforeend', data.html);
                    }

                    hasMore = data.hasMore;
                    currentPage = data.nextPage;

                } catch (error) {
                    console.error('Error loading campaigns:', error);
                } finally {
                    isLoading = false;
                    loadingIndicator.classList.add('d-none');
                }
            }
        });
    </script>
@endpush
