@extends('layouts.member')

@section('title', __('ecourse.course_catalog'))
@section('body_class', 'member-modern')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/member-course.css') }}" />
    <style>
        .course-catalog-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.25rem;
        }

        .course-catalog-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            background: rgba(30, 142, 116, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e8e74;
        }

        .course-filter-btn {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #495057;
            font-size: 0.9rem;
        }

        .course-title-link {
            color: #1e8e74;
            font-weight: 600;
            font-size: 1rem;
        }

        .course-title-link:hover {
            color: #166a57;
        }

        .course-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .course-stats-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .course-progress-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.75rem;
        }

        .course-progress-label {
            color: #6c757d;
            font-size: 0.85rem;
            min-width: 55px;
        }

        .course-progress-bar {
            flex: 1;
            height: 10px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }

        .course-progress-bar .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1e8e74 0%, #38a88f 100%);
            border-radius: 5px;
        }

        .course-progress-percent {
            color: #1e8e74;
            font-weight: 600;
            font-size: 0.9rem;
            min-width: 40px;
            text-align: right;
        }

        .badge-status {
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-status.in-progress {
            background: #1e8e74;
            color: #fff;
        }

        .badge-status.available {
            background: #fff;
            border: 1px solid #1e8e74;
            color: #1e8e74;
        }

        .badge-status.completed {
            background: #198754;
            color: #fff;
        }

        .badge-status.locked {
            background: #fff;
            border: 1px solid #ffc107;
            color: #856404;
        }

        .btn-join-course {
            background: #fff;
            border: 1px solid #1e8e74;
            color: #1e8e74;
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .btn-join-course:hover {
            background: #1e8e74;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="page-animate">
        <div class="row">
            <div class="col-12">
                <div class="course-catalog-header">
                    <div class="course-catalog-icon">
                        <i class="icon-base ti tabler-layout-grid icon-md"></i>
                    </div>
                    <h4 class="mb-0 fw-bold">{{ __('ecourse.course_catalog') }}</h4>
                </div>
                <p class="text-muted mb-4">{{ __('ecourse.browse_courses') }}</p>

                <div class="d-flex gap-3 mb-4">
                    <div class="grow">
                        <div class="input-group input-group-merge bg-white shadow-sm">
                            <span class="input-group-text bg-transparent border-0">
                                <i class="icon-base ti tabler-search"></i>
                            </span>
                            <input type="text" class="form-control border-0" id="courseSearch"
                                placeholder="{{ __('ecourse.search_courses') }}" />
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="course-filter-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="icon-base ti tabler-filter"></i>
                            <span id="filterLabel">{{ __('ecourse.all_categories') }}</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item category-filter active" href="#" data-category="">
                                    {{ __('ecourse.all_categories') }}
                                </a>
                            </li>
                            @foreach ($categories as $cat)
                                <li>
                                    <a class="dropdown-item category-filter" href="#"
                                        data-category="{{ $cat->slug }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">
                        <span id="courseCount">{{ $classes->count() }}</span> {{ __('ecourse.courses_found') }}
                    </small>
                    <div id="searchLoading" class="d-none">
                        <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                        <span class="text-muted ms-1">{{ __('common.loading') }}...</span>
                    </div>
                </div>
                @if ($classes->count() > 0)
                    <div class="d-flex flex-column gap-4" id="courseList">
                        @foreach ($classes as $class)
                            @php
                                $enrollment = $class->enrollments->first();
                                $isJoined = $enrollment !== null;
                                $progress = $isJoined ? (float) ($enrollment->completion_percentage ?? 0) : 0;
                                $progressInt = (int) round($progress);
                                $totalLessons = (int) ($class->total_lessons ?? 0);
                                $minutes = (int) ($class->estimated_duration ?? 0);
                                $hours = $minutes > 0 ? (int) floor($minutes / 60) : 0;
                                $remainingMinutes = $minutes > 0 ? (int) ($minutes % 60) : 0;
                                $thumbnailUrl = $class->thumbnail ? asset('storage/' . $class->thumbnail) : null;
                                $isCompleted = $isJoined && $enrollment->isCompleted();
                                $canAccess = $class->memberCanAccess($member);
                                $pointsNeeded = $class->pointsNeededFor($member);
                            @endphp

                            <div class="card member-course-card course-item">
                                <div class="d-flex gap-4">
                                    <a href="{{ route('member.courses.show', $class) }}" class="text-decoration-none">
                                        <div class="member-course-thumb"
                                            style="min-width: 180px; height: 140px; background-image: url('{{ $thumbnailUrl }}'); background-size: cover; background-position: center;">
                                            <div class="member-course-play">
                                                <i class="icon-base ti tabler-player-play icon-md"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="card-body py-3 ps-0">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="grow">
                                                <a href="{{ route('member.courses.show', $class) }}"
                                                    class="course-title-link text-decoration-none">
                                                    {{ $class->title }}
                                                </a>

                                                @if ($class->description)
                                                    <p class="text-muted mb-2" style="font-size: .875rem;">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($class->description), 100) }}
                                                    </p>
                                                @endif

                                                <div class="course-stats">
                                                    <div class="course-stats-item">
                                                        <i class="icon-base ti tabler-book-2"></i>
                                                        <span>{{ $totalLessons }} {{ __('ecourse.lessons') }}</span>
                                                    </div>
                                                    <div class="course-stats-item">
                                                        <i class="icon-base ti tabler-clock"></i>
                                                        <span>{{ $hours }}h {{ $remainingMinutes }}m</span>
                                                    </div>
                                                    <div class="course-stats-item">
                                                        <i class="icon-base ti tabler-folder"></i>
                                                        <span>{{ $class->modules->count() }}
                                                            {{ __('ecourse.modules') }}</span>
                                                    </div>
                                                </div>

                                                @if ($isJoined)
                                                    <div class="course-progress-section">
                                                        <span
                                                            class="course-progress-label">{{ __('dashboard.progress') }}</span>
                                                        <div class="course-progress-bar">
                                                            <div class="progress-fill" style="width: {{ $progressInt }}%">
                                                            </div>
                                                        </div>
                                                        <span class="course-progress-percent">{{ $progressInt }}%</span>
                                                    </div>
                                                @else
                                                    <div class="mt-3">
                                                        @if ($canAccess)
                                                            <form action="{{ route('member.courses.join', $class) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn-join-course">
                                                                    <i class="icon-base ti tabler-plus"></i>
                                                                    {{ __('ecourse.join_now') }}
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="text-warning" style="font-size: 0.85rem;">
                                                                <i class="ti tabler-lock me-1"></i>
                                                                {{ __('ecourse.need_more_points', ['points' => number_format($pointsNeeded, 0, ',', '.')]) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="ms-3">
                                                @if ($isCompleted)
                                                    <span
                                                        class="badge-status completed">{{ __('ecourse.completed') }}</span>
                                                @elseif ($isJoined)
                                                    <span
                                                        class="badge-status in-progress">{{ __('ecourse.in_progress') }}</span>
                                                @elseif (!$canAccess)
                                                    <span class="badge-status locked">
                                                        <i class="ti tabler-lock" style="font-size: 0.7rem;"></i>
                                                        {{ __('ecourse.locked') }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge-status available">{{ __('ecourse.available') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center text-muted py-5">
                            <i class="icon-base ti tabler-book icon-xl mb-3"></i>
                            <h5 class="mb-2">{{ __('ecourse.no_courses_available') }}</h5>
                            <p class="text-muted mb-0">{{ __('ecourse.no_courses_message') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('courseSearch');
            const courseList = document.getElementById('courseList');
            const courseCount = document.getElementById('courseCount');
            const searchLoading = document.getElementById('searchLoading');
            const filterLabel = document.getElementById('filterLabel');
            const categoryFilters = document.querySelectorAll('.category-filter');

            let searchTimeout = null;
            let currentCategory = '';

            // Search function with debounce
            function performSearch() {
                const search = searchInput.value.trim();

                searchLoading.classList.remove('d-none');

                fetch(`{{ route('member.courses.index') }}?search=${encodeURIComponent(search)}&category=${encodeURIComponent(currentCategory)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        courseList.innerHTML = data.html;
                        courseCount.textContent = data.count;
                        searchLoading.classList.add('d-none');
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchLoading.classList.add('d-none');
                    });
            }

            // Search input event with debounce
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            });

            // Category filter click
            categoryFilters.forEach(filter => {
                filter.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Update active state
                    categoryFilters.forEach(f => f.classList.remove('active'));
                    this.classList.add('active');

                    // Update label and category
                    currentCategory = this.dataset.category;
                    filterLabel.textContent = this.textContent.trim();

                    // Perform search
                    performSearch();
                });
            });
        });
    </script>
@endpush
