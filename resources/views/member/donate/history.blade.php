@extends('layouts.member')

@section('title', 'My Donation History')
@section('body_class', 'member-modern')

@section('content')
    <div class="page-animate">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-bold">
                    My Donation Histories
                </h4>
            </div>
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ti tabler-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="ti tabler-info-circle me-2"></i>
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="shrink-0">
                                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                                <i class="ti tabler-heart text-primary" style="font-size: 2rem;"></i>
                                            </div>
                                        </div>
                                        <div class="grow ms-3">
                                            <h6 class="text-muted mb-1">Total Donations</h6>
                                            <h4 class="mb-0">{{ $donations->total() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded p-3">
                                                <i class="ti tabler-check text-success" style="font-size: 2rem;"></i>
                                            </div>
                                        </div>
                                        <div class="grow ms-3">
                                            <h6 class="text-muted mb-1">Successful</h6>
                                            <h4 class="mb-0">{{ $successfulCount }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Donations List -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            @if ($donations->isEmpty())
                                <div class="text-center py-5">
                                    <i class="ti tabler-heart-broken text-muted" style="font-size: 4rem;"></i>
                                    <h5 class="text-muted mt-3">No donations yet</h5>
                                    <p class="text-muted">Start making a difference today!</p>
                                    <a href="{{ route('member.donate.index') }}" class="btn btn-primary mt-2">
                                        Browse Campaigns
                                    </a>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Campaign</th>
                                                <th>Amount</th>
                                                <th>Payment Method</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($donations as $donation)
                                                <tr>
                                                    <td>
                                                        <div class="small text-muted">
                                                            {{ $donation->created_at->format('d M Y') }}</div>
                                                        <div class="small text-muted">
                                                            {{ $donation->created_at->format('H:i') }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if ($donation->campaign?->primaryImage)
                                                                <img src="{{ asset('storage/' . $donation->campaign->primaryImage->image_url) }}"
                                                                    alt="{{ $donation->campaign->title }}"
                                                                    class="rounded me-2"
                                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                                            @endif
                                                            <div>
                                                                @if ($donation->campaign)
                                                                    <div class="fw-bold">
                                                                        {{ $donation->campaign->title }}
                                                                    </div>
                                                                @else
                                                                    <div class="fw-bold text-success">
                                                                        Zakat Payment
                                                                    </div>
                                                                @endif
                                                                <div class="small text-muted">Order:
                                                                    {{ $donation->order_id }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $donation->formatted_amount }}</strong>
                                                        <div class="small text-muted">{{ $donation->currency_name }}</div>
                                                    </td>
                                                    <td>
                                                        @if ($donation->payment_provider)
                                                            <div class="d-flex align-items-center">
                                                                @if ($donation->payment_provider === 'midtrans')
                                                                    <i
                                                                        class="ti tabler-building-bank text-primary me-2"></i>
                                                                @elseif($donation->payment_provider === 'stripe')
                                                                    <i class="ti tabler-credit-card text-primary me-2"></i>
                                                                @elseif($donation->payment_provider === 'toss')
                                                                    <i class="ti tabler-wallet text-primary me-2"></i>
                                                                @endif
                                                                <span
                                                                    class="text-capitalize">{{ $donation->payment_provider }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($donation->status === 'paid')
                                                            <span class="badge bg-success">
                                                                <i class="ti tabler-check me-1"></i>
                                                                Paid
                                                            </span>
                                                        @elseif($donation->status === 'pending')
                                                            <span class="badge bg-warning">
                                                                <i class="ti tabler-clock me-1"></i>
                                                                Pending
                                                            </span>
                                                        @elseif($donation->status === 'failed')
                                                            <span class="badge bg-danger">
                                                                <i class="ti tabler-x me-1"></i>
                                                                Failed
                                                            </span>
                                                        @else
                                                            <span
                                                                class="badge bg-secondary">{{ ucfirst($donation->status) }}</span>
                                                        @endif
                                                        @if ($donation->paid_at)
                                                            <div class="small text-muted mt-1">
                                                                {{ $donation->paid_at->format('d M Y H:i') }}</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            @if ($donation->campaign)
                                                                <a href="{{ route('member.donate.show', $donation->campaign) }}"
                                                                    class="btn btn-outline-primary" title="View Campaign">
                                                                    <i class="ti tabler-eye"></i>
                                                                </a>
                                                            @endif

                                                            @if ($donation->status === 'pending' && $donation->snap_redirect_url)
                                                                <a href="{{ $donation->snap_redirect_url }}"
                                                                    class="btn btn-outline-success"
                                                                    title="Continue Payment">
                                                                    <i class="ti tabler-credit-card"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="mt-4">
                                    {{ $donations->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
