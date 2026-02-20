@extends('layouts.member')

@section('title', $class->title)
@section('body_class', 'member-modern')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/member-course.css') }}" />
    <style>
        .course-detail-hero {
            position: relative;
            width: 100%;
            height: 280px;
            border-radius: 0.5rem 0.5rem 0 0;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.05) 100%);
        }

        .course-detail-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-detail-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }

        .btn-continue-learning {
            background: #1e8e74;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .btn-continue-learning:hover {
            background: #166a57;
            color: #fff;
            transform: scale(1.02);
        }

        .course-stats-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .course-stats-row .stat-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .course-progress-section {
            margin-top: 1rem;
        }

        .course-progress-label {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .course-progress-bar {
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .course-progress-bar .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1e8e74 0%, #38a88f 100%);
            border-radius: 6px;
        }

        .course-progress-percent {
            color: #1e8e74;
            font-weight: 600;
        }

        .module-accordion {
            border: none;
        }

        .module-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .module-number {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(30, 142, 116, 0.15);
            color: #1e8e74;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .module-info {
            flex: 1;
        }

        .module-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.15rem;
        }

        .module-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .module-toggle {
            color: #6c757d;
            transition: transform 0.2s ease;
        }

        .module-header[aria-expanded="true"] .module-toggle {
            transform: rotate(180deg);
        }

        .lesson-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 0;
            padding-left: 3.25rem;
            border-bottom: 1px solid #f5f5f5;
        }

        .lesson-item:last-child {
            border-bottom: none;
        }

        .lesson-status {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .lesson-status.completed {
            background: rgba(30, 142, 116, 0.15);
            color: #1e8e74;
        }

        .lesson-status.pending {
            background: #f0f0f0;
            color: #aaa;
        }

        .lesson-type-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .lesson-type-icon.video {
            background: rgba(255, 152, 0, 0.15);
            color: #ff9800;
        }

        .lesson-type-icon.quiz {
            background: rgba(156, 39, 176, 0.15);
            color: #9c27b0;
        }

        .lesson-type-icon.text {
            background: rgba(33, 150, 243, 0.15);
            color: #2196f3;
        }

        .lesson-info {
            flex: 1;
        }

        .lesson-title {
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
        }

        .lesson-duration {
            font-size: 0.8rem;
            color: #999;
        }

        /* ── Dark Mode ── */
        [data-bs-theme="dark"] .course-stats-row {
            color: rgba(226, 232, 240, 0.50);
        }

        [data-bs-theme="dark"] .course-progress-bar {
            background: rgba(255, 255, 255, 0.10);
        }

        [data-bs-theme="dark"] .module-header {
            border-bottom-color: rgba(255, 255, 255, 0.07);
        }

        [data-bs-theme="dark"] .module-title {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .module-meta {
            color: rgba(226, 232, 240, 0.45);
        }

        [data-bs-theme="dark"] .module-toggle {
            color: rgba(226, 232, 240, 0.45);
        }

        [data-bs-theme="dark"] .lesson-item {
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }

        [data-bs-theme="dark"] .lesson-status.pending {
            background: rgba(255, 255, 255, 0.08);
            color: rgba(226, 232, 240, 0.35);
        }

        [data-bs-theme="dark"] .lesson-title {
            color: #e2e8f0;
        }

        [data-bs-theme="dark"] .lesson-duration {
            color: rgba(226, 232, 240, 0.40);
        }

        [data-bs-theme="dark"] .course-progress-label {
            color: rgba(226, 232, 240, 0.55);
        }
    </style>
@endpush

@section('content')
    <div class="page-animate">
        @php
            $thumbnailUrl = $class->thumbnail ? asset('storage/' . $class->thumbnail) : null;
            $totalLessons = (int) ($class->total_lessons ?? 0);
            $minutes = (int) ($class->estimated_duration ?? 0);
            $hours = $minutes > 0 ? (int) floor($minutes / 60) : 0;
            $remainingMinutes = $minutes > 0 ? (int) ($minutes % 60) : 0;
            $completedLessonsCount = $enrollment ? $lessonProgress->where('completed', true)->count() : 0;
            $progressPercent = $enrollment ? (int) round($enrollment->completion_percentage) : 0;
            $enrolledStudents = $class->enrollments()->count();
        @endphp

        <div class="row">
            <div class="col-12">
                <a href="{{ route('member.courses.index') }}"
                    class="text-decoration-none d-inline-flex align-items-center gap-2 mb-4" style="color: #1e8e74;">
                    <i class="icon-base ti tabler-arrow-left"></i>
                    {{ __('ecourse.back_to_courses') }}
                </a>

                <div class="card mb-4">
                    <div class="course-detail-hero">
                        @if ($thumbnailUrl)
                            <img src="{{ $thumbnailUrl }}" alt="{{ $class->title }}">
                        @endif
                        <div class="course-detail-hero-overlay">
                            @if ($enrollment)
                                @php
                                    $firstIncompleteLesson = null;
                                    foreach ($modules as $module) {
                                        foreach ($module->lessons as $lesson) {
                                            $progress = $lessonProgress->where('lesson_id', $lesson->id)->first();
                                            if (!$progress || !$progress->completed) {
                                                $firstIncompleteLesson = ['module' => $module, 'lesson' => $lesson];
                                                break 2;
                                            }
                                        }
                                    }
                                @endphp
                                @if ($firstIncompleteLesson)
                                    <a href="{{ route('member.courses.lesson', [$class, $firstIncompleteLesson['module'], $firstIncompleteLesson['lesson']]) }}"
                                        class="btn-continue-learning">
                                        <i class="icon-base ti tabler-player-play"></i>
                                        {{ __('ecourse.continue_learning') }}
                                    </a>
                                @else
                                    <span class="btn-continue-learning">
                                        <i class="icon-base ti tabler-check"></i>
                                        {{ __('ecourse.course_completed') }}
                                    </span>
                                @endif
                            @else
                                <form action="{{ route('member.courses.join', $class) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-continue-learning">
                                        <i class="icon-base ti tabler-plus"></i>
                                        {{ __('ecourse.join_now') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold mb-2">{{ $class->title }}</h4>
                        @if ($class->description)
                            <p class="text-muted mb-3">{{ $class->description }}</p>
                        @endif

                        <div class="course-stats-row">
                            <div class="stat-item">
                                <i class="icon-base ti tabler-book-2"></i>
                                <span>{{ $totalLessons }} {{ __('ecourse.lessons') }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="icon-base ti tabler-clock"></i>
                                <span>{{ $hours }}h {{ $remainingMinutes }}m</span>
                            </div>
                            <div class="stat-item">
                                <i class="icon-base ti tabler-folder"></i>
                                <span>{{ $modules->count() }} {{ __('ecourse.modules') }}</span>
                            </div>
                            <div class="stat-item">
                                <i class="icon-base ti tabler-users"></i>
                                <span>{{ number_format($enrolledStudents) }} {{ __('ecourse.students') }}</span>
                            </div>
                        </div>

                        @if ($enrollment)
                            <div class="course-progress-section">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="course-progress-label">
                                        {{ $completedLessonsCount }} {{ __('ecourse.of') }} {{ $totalLessons }}
                                        {{ __('ecourse.lessons_completed') }}
                                    </span>
                                    <span class="course-progress-percent">{{ $progressPercent }}%</span>
                                </div>
                                <div class="course-progress-bar">
                                    <div class="progress-fill" style="width: {{ $progressPercent }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">{{ __('ecourse.course_content') }}</h5>

                        <div class="accordion module-accordion" id="moduleAccordion">
                            @forelse ($modules as $moduleIndex => $module)
                                @php
                                    $moduleLessonsCount = $module->lessons->count();
                                    $moduleCompletedCount = 0;
                                    $moduleDuration = 0;
                                    if ($enrollment) {
                                        foreach ($module->lessons as $lesson) {
                                            $progress = $lessonProgress->where('lesson_id', $lesson->id)->first();
                                            if ($progress && $progress->completed) {
                                                $moduleCompletedCount++;
                                            }
                                        }
                                    }
                                    foreach ($module->lessons as $lesson) {
                                        $moduleDuration += (int) ($lesson->duration ?? 0);
                                    }
                                    $moduleHours = $moduleDuration > 0 ? (int) floor($moduleDuration / 60) : 0;
                                    $moduleMinutes = $moduleDuration > 0 ? (int) ($moduleDuration % 60) : 0;
                                @endphp

                                <div class="accordion-item border-0">
                                    <div class="module-header" data-bs-toggle="collapse"
                                        data-bs-target="#module{{ $moduleIndex }}"
                                        aria-expanded="{{ $moduleIndex === 0 ? 'true' : 'false' }}">
                                        <div class="module-number">{{ $moduleIndex + 1 }}</div>
                                        <div class="module-info">
                                            <div class="module-title">{{ $module->title }}</div>
                                            <div class="module-meta">
                                                @if ($enrollment)
                                                    {{ $moduleCompletedCount }}/{{ $moduleLessonsCount }}
                                                    {{ __('ecourse.lessons') }}
                                                @else
                                                    {{ $moduleLessonsCount }} {{ __('ecourse.lessons') }}
                                                @endif
                                                @if ($moduleDuration > 0)
                                                    •
                                                    {{ $moduleHours > 0 ? $moduleHours . 'h ' : '' }}{{ $moduleMinutes }}m
                                                @endif
                                            </div>
                                        </div>
                                        <i class="icon-base ti tabler-chevron-up module-toggle"></i>
                                    </div>

                                    <div id="module{{ $moduleIndex }}"
                                        class="accordion-collapse collapse {{ $moduleIndex === 0 ? 'show' : '' }}"
                                        data-bs-parent="#moduleAccordion">
                                        <div class="accordion-body p-0">
                                            @foreach ($module->lessons as $lesson)
                                                @php
                                                    $lessonProgressItem = null;
                                                    $isCompleted = false;
                                                    if ($enrollment) {
                                                        $lessonProgressItem = $lessonProgress
                                                            ->where('lesson_id', $lesson->id)
                                                            ->first();
                                                        $isCompleted =
                                                            $lessonProgressItem && $lessonProgressItem->completed;
                                                    }
                                                    $lessonType = $lesson->type ?? 'video';
                                                @endphp

                                                @if ($enrollment)
                                                    <a href="{{ route('member.courses.lesson', [$class, $module, $lesson]) }}"
                                                        class="lesson-item text-decoration-none">
                                                    @else
                                                        <div class="lesson-item">
                                                @endif
                                                <div class="lesson-status {{ $isCompleted ? 'completed' : 'pending' }}">
                                                    @if ($isCompleted)
                                                        <i class="icon-base ti tabler-check" style="font-size: 12px;"></i>
                                                    @else
                                                        <i class="icon-base ti tabler-circle" style="font-size: 8px;"></i>
                                                    @endif
                                                </div>
                                                <div class="lesson-type-icon {{ $lessonType }}">
                                                    @if ($lessonType === 'quiz')
                                                        <i class="icon-base ti tabler-help-circle"
                                                            style="font-size: 14px;"></i>
                                                    @elseif ($lessonType === 'text')
                                                        <i class="icon-base ti tabler-file-text"
                                                            style="font-size: 14px;"></i>
                                                    @else
                                                        <i class="icon-base ti tabler-player-play"
                                                            style="font-size: 14px;"></i>
                                                    @endif
                                                </div>
                                                <div class="lesson-info">
                                                    <div class="lesson-title">{{ $lesson->title }}</div>
                                                    @if ($lesson->duration)
                                                        <div class="lesson-duration">{{ $lesson->duration }}m</div>
                                                    @endif
                                                </div>
                                                @if ($enrollment)
                                                    </a>
                                                @else
                                        </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="icon-base ti tabler-folder icon-xl text-muted mb-3"></i>
                    <h5 class="mb-2">{{ __('ecourse.no_modules') }}</h5>
                    <p class="text-muted mb-0">{{ __('ecourse.no_modules_message') }}</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    </div>
@endsection
