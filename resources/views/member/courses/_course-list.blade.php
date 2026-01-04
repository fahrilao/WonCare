@forelse ($classes as $class)
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
                    <div class="flex-grow-1">
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
                                <span>{{ $class->modules->count() }} {{ __('ecourse.modules') }}</span>
                            </div>
                        </div>

                        @if ($isJoined)
                            <div class="course-progress-section">
                                <span class="course-progress-label">{{ __('dashboard.progress') }}</span>
                                <div class="course-progress-bar">
                                    <div class="progress-fill" style="width: {{ $progressInt }}%"></div>
                                </div>
                                <span class="course-progress-percent">{{ $progressInt }}%</span>
                            </div>
                        @else
                            <div class="mt-3">
                                @if ($canAccess)
                                    <form action="{{ route('member.courses.join', $class) }}" method="POST"
                                        class="d-inline">
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
                            <span class="badge-status completed">{{ __('ecourse.completed') }}</span>
                        @elseif ($isJoined)
                            <span class="badge-status in-progress">{{ __('ecourse.in_progress') }}</span>
                        @elseif (!$canAccess)
                            <span class="badge-status locked">
                                <i class="ti tabler-lock" style="font-size: 0.7rem;"></i>
                                {{ __('ecourse.locked') }}
                            </span>
                        @else
                            <span class="badge-status available">{{ __('ecourse.available') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="icon-base ti tabler-search icon-xl mb-3"></i>
            <h5 class="mb-2">{{ __('ecourse.no_results') }}</h5>
            <p class="text-muted mb-0">{{ __('ecourse.try_different_search') }}</p>
        </div>
    </div>
@endforelse
