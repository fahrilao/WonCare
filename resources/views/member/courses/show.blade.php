@extends('layouts.member')

@section('title', $class->title)

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Course Header -->
            <div class="card mb-4">
                <div class="card-header p-0">
                    <div class="bg-gradient-primary text-white px-4 py-4 rounded-top">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="text-white mb-2">{{ $class->title }}</h4>
                                <p class="text-white-75 mb-2">{{ $class->description }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($class->categories as $category)
                                        <span class="badge bg-white text-primary">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-end">
                                @if ($enrollment)
                                    <div class="text-white-75 mb-1">{{ __('ecourse.course_progress') }}</div>
                                    <div class="h5 text-white mb-0">
                                        {{ number_format($enrollment->completion_percentage, 1) }}%</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="ti tabler-book"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted">{{ __('ecourse.total_lessons') }}</small>
                                    <div class="fw-bold">{{ $class->total_lessons }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded bg-label-info">
                                        <i class="ti tabler-clock"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted">{{ __('ecourse.course_duration') }}</small>
                                    <div class="fw-bold">{{ $class->formatted_duration }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded bg-label-success">
                                        <i class="ti tabler-trophy"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted">{{ __('ecourse.points_earned') }}</small>
                                    <div class="fw-bold">{{ $enrollment ? $enrollment->total_points : 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded bg-label-warning">
                                        <i class="ti tabler-folder"></i>
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted">{{ __('ecourse.course_modules') }}</small>
                                    <div class="fw-bold">{{ $modules->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($enrollment)
                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __('ecourse.course_progress') }}</span>
                                <span class="fw-bold">{{ number_format($enrollment->completion_percentage, 1) }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $enrollment->completion_percentage }}%"
                                    aria-valuenow="{{ $enrollment->completion_percentage }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Course Modules -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('ecourse.course_modules') }}</h5>
                </div>
                <div class="card-body">
                    @forelse ($modules as $moduleIndex => $module)
                        <div class="mb-5">
                            <div>
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="grow">
                                        <h6 class="mb-2">
                                            <span class="badge bg-primary me-2">{{ $moduleIndex + 1 }}</span>
                                            {{ $module->title }}
                                        </h6>
                                        @if ($module->description)
                                            <p class="text-muted mb-3">{{ $module->description }}</p>
                                        @endif
                                    </div>
                                    @if ($enrollment)
                                        <div class="text-end">
                                            @php
                                                $moduleProgress = $lessonProgress->where(
                                                    'lesson.module_id',
                                                    $module->id,
                                                );
                                                $completedLessons = $moduleProgress->where('completed', true)->count();
                                                $totalLessons = $module->lessons->count();
                                                $modulePercentage =
                                                    $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
                                            @endphp
                                            <small class="text-muted">{{ $completedLessons }}/{{ $totalLessons }}
                                                {{ __('ecourse.completed') }}</small>
                                            <div class="progress mt-1" style="width: 100px; height: 6px;">
                                                <div class="progress-bar" style="width: {{ $modulePercentage }}%">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Module Lessons -->
                                @if ($module->lessons->count() > 0)
                                    <div class="mt-3">
                                        @foreach ($module->lessons as $lessonIndex => $lesson)
                                            @php
                                                $progress = null;
                                                if ($enrollment) {
                                                    $progress = $lessonProgress
                                                        ->where('lesson_id', $lesson->id)
                                                        ->first();
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center py-2 px-3 rounded border-bottom mb-2">
                                                <div class="flex-grow-1">
                                                    <div class="fw-medium">{{ $lesson->title }}</div>
                                                    @if ($lesson->duration)
                                                        <small class="text-muted">{{ $lesson->duration }}
                                                            {{ __('common.minutes') }}</small>
                                                    @endif
                                                </div>
                                                <div>
                                                    @if ($enrollment)
                                                        <a href="{{ route('member.courses.lesson', [$class, $module, $lesson]) }}"
                                                            class="btn btn-sm {{ $progress && $progress->completed ? 'btn-success' : 'btn-outline-primary' }}">
                                                            @if ($progress && $progress->completed)
                                                                <i
                                                                    class="ti tabler-check me-1"></i>{{ __('ecourse.completed') }}
                                                            @else
                                                                <i
                                                                    class="ti tabler-play me-1"></i>{{ __('ecourse.start_course') }}
                                                            @endif
                                                        </a>
                                                    @else
                                                        <span
                                                            class="badge bg-label-secondary">{{ __('ecourse.join_now') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-3">
                                        <small class="text-muted">{{ __('ecourse.no_courses_available') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="avatar avatar-xl mb-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class="ti tabler-folder icon-xl"></i>
                                </span>
                            </div>
                            <h5 class="mb-2">{{ __('ecourse.no_courses_available') }}</h5>
                            <p class="text-muted">No modules available for this course.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Join Course Button (if not enrolled) -->
            @if (!$enrollment)
                <div class="text-center mt-4">
                    <form action="{{ route('member.courses.join', $class) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti tabler-plus me-2"></i>{{ __('ecourse.join_now') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
