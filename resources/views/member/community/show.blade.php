@extends('layouts.member')

@section('title', $post->title)
@section('body_class', 'member-modern')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('member.community.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="ti tabler-arrow-left"></i> {{ __('community.back_to_feed') }}
                    </a>
                </div>

                <!-- Post Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Post Header -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-lg me-3">
                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                        <i class="ti tabler-user ti-lg"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $post->author_name ?: __('community.anonymous') }}</h6>
                                    <small class="text-muted">
                                        <i class="ti tabler-clock"></i>
                                        {{ $post->published_at->format('F d, Y \a\t H:i') }}
                                    </small>
                                </div>
                            </div>
                            @if ($post->is_pinned)
                                <span class="badge bg-primary">
                                    <i class="ti tabler-pin"></i> {{ __('community.pinned') }}
                                </span>
                            @endif
                        </div>

                        <!-- Post Title -->
                        <h2 class="mb-4">{{ $post->title }}</h2>

                        <!-- Post Content -->
                        <div class="post-content">
                            {!! nl2br(e($post->content)) !!}
                        </div>

                        <!-- Post Meta -->
                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center text-muted">
                            <div>
                                <i class="ti tabler-calendar"></i>
                                <small>{{ __('community.published') }}: {{ $post->published_at->format('M d, Y') }}</small>
                            </div>
                            <div>
                                <i class="ti tabler-clock"></i>
                                <small>{{ $post->published_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="mb-3">{{ __('community.share_post') }}</h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="sharePost('facebook')">
                                <i class="ti tabler-brand-facebook"></i> Facebook
                            </button>
                            <button class="btn btn-sm btn-outline-info" onclick="sharePost('twitter')">
                                <i class="ti tabler-brand-twitter"></i> Twitter
                            </button>
                            <button class="btn btn-sm btn-outline-success" onclick="sharePost('whatsapp')">
                                <i class="ti tabler-brand-whatsapp"></i> WhatsApp
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="copyLink()">
                                <i class="ti tabler-link"></i> {{ __('community.copy_link') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Related Posts -->
                @if ($relatedPosts->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ti tabler-article me-2"></i>{{ __('community.related_posts') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach ($relatedPosts as $relatedPost)
                                    <a href="{{ route('member.community.show', $relatedPost->id) }}"
                                        class="list-group-item list-group-item-action border-0 px-0">
                                        <h6 class="mb-1">{{ Str::limit($relatedPost->title, 60) }}</h6>
                                        <small class="text-muted">
                                            <i class="ti tabler-calendar"></i>
                                            {{ $relatedPost->published_at->format('M d, Y') }}
                                        </small>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Back to Feed -->
                <div class="card">
                    <div class="card-body text-center">
                        <i class="ti tabler-arrow-back ti-lg text-primary mb-3"></i>
                        <h6 class="mb-3">{{ __('community.explore_more') }}</h6>
                        <a href="{{ route('member.community.index') }}" class="btn btn-primary w-100">
                            {{ __('community.back_to_feed') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #4a5568;
        }

        .post-content p {
            margin-bottom: 1rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function sharePost(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $post->title }}');
            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title}%20${url}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        }

        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('{{ __('community.link_copied') }}');
            });
        }
    </script>
@endpush
