@extends('layouts.member')

@section('title', __('community.title'))
@section('body_class', 'member-modern')

@push('styles')
    <style>
        [data-bs-theme="dark"] .post-card .text-dark {
            color: #e2e8f0 !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1">{{ __('community.feed_title') }}</h4>
                        <p class="text-muted mb-0">{{ __('community.feed_subtitle') }}</p>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('member.community.index') }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti tabler-search"></i></span>
                                <input type="text" class="form-control" name="search"
                                    placeholder="{{ __('community.search_placeholder') }}" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">{{ __('common.search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Posts Feed -->
                <div id="posts-container">
                    @forelse($posts as $post)
                        <div class="card mb-4 post-card">
                            <div class="card-body">
                                <!-- Post Header -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-3">
                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                <i class="ti tabler-user ti-md"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $post->author_name ?: __('community.anonymous') }}</h6>
                                            <small class="text-muted">
                                                <i class="ti tabler-clock"></i>
                                                {{ $post->published_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                    @if ($post->is_pinned)
                                        <span class="badge bg-primary">
                                            <i class="ti tabler-pin"></i> {{ __('community.pinned') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Post Content -->
                                <h5 class="card-title mb-3">
                                    <a href="{{ route('member.community.show', $post->id) }}"
                                        class="text-body text-decoration-none">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <div class="post-content mb-3">
                                    <p class="text-muted mb-0">
                                        {{ Str::limit(strip_tags($post->content), 200) }}
                                    </p>
                                </div>

                                <!-- Post Footer -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('member.community.show', $post->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        {{ __('community.read_more') }} <i class="ti tabler-arrow-right"></i>
                                    </a>
                                    <div class="text-muted small">
                                        <i class="ti tabler-calendar"></i>
                                        {{ $post->published_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="ti tabler-inbox ti-lg text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('community.no_posts') }}</h5>
                                <p class="text-muted">{{ __('community.no_posts_desc') }}</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($posts->hasPages())
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Pinned Posts -->
                @if ($pinnedPosts->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ti tabler-pin me-2"></i>{{ __('community.pinned_posts') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach ($pinnedPosts as $pinnedPost)
                                    <a href="{{ route('member.community.show', $pinnedPost->id) }}"
                                        class="list-group-item list-group-item-action border-0 px-0">
                                        <div class="d-flex align-items-start">
                                            <i class="ti tabler-pin text-primary me-2 mt-1"></i>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ Str::limit($pinnedPost->title, 50) }}</h6>
                                                <small class="text-muted">
                                                    {{ $pinnedPost->published_at->format('M d, Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Community Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ti tabler-info-circle me-2"></i>{{ __('community.about') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">{{ __('community.about_desc') }}</p>
                        <div class="d-grid gap-2">
                            <div class="d-flex align-items-center">
                                <i class="ti tabler-users text-primary me-2"></i>
                                <span>{{ __('community.connect_members') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ti tabler-messages text-primary me-2"></i>
                                <span>{{ __('community.share_stories') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ti tabler-bulb text-primary me-2"></i>
                                <span>{{ __('community.get_insights') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ti tabler-chart-bar me-2"></i>{{ __('community.stats') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">{{ __('community.total_posts') }}</span>
                            <strong>{{ $posts->total() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">{{ __('community.pinned_posts') }}</span>
                            <strong>{{ $pinnedPosts->count() }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="ti tabler-link me-2"></i>{{ __('community.quick_links') }}
                        </h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('member.community.whatsapp-groups') }}"
                            class="list-group-item list-group-item-action">
                            <i
                                class="ti tabler-brand-whatsapp text-success me-2"></i>{{ __('community.whatsapp_groups.title') }}
                        </a>
                        <a href="{{ route('member.community.volunteer-events') }}"
                            class="list-group-item list-group-item-action">
                            <i
                                class="ti tabler-calendar-event text-primary me-2"></i>{{ __('community.volunteer.events_title') }}
                        </a>
                        <a href="{{ route('member.community.mentors') }}" class="list-group-item list-group-item-action">
                            <i class="ti tabler-school text-info me-2"></i>{{ __('community.mentors.title') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .post-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .post-content {
            line-height: 1.6;
        }
    </style>
@endpush
