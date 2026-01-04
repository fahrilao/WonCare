<div class="col-12 col-sm-6 col-lg-3">
    <div class="campaign-card">
        <span class="campaign-tag {{ $tagClass }}">{{ $tagName }}</span>
        <h3>{{ $campaign->title }}</h3>
        <p class="description">
            {{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 70) }}
        </p>

        <div class="campaign-stats">
            <div class="amount-row">
                <span class="collected">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                <span class="percentage">{{ number_format($campaign->progress_percentage, 1) }}%</span>
            </div>
            <div class="campaign-progress">
                <div class="campaign-progress-bar" style="width: {{ min($campaign->progress_percentage, 100) }}%"></div>
            </div>
        </div>

        <div class="campaign-meta">
            <span>
                <i class="ti tabler-clock"></i>
                {{ $daysLeft }}
            </span>
            <span>{{ __('donation_campaigns.from') }} Rp {{ number_format($campaign->goal_amount, 0, ',', '.') }}</span>
        </div>

        <a href="{{ route('member.donate.show', $campaign) }}" class="btn-donate">
            <i class="ti tabler-heart"></i>
            {{ __('dashboard.donate_now') }}
        </a>
    </div>
</div>
