@extends('layouts.member')

@section('title', __('ecourse.course_catalog'))

@section('content')
    <div class="row">
        <div class="col-12">
            <h5>{{ __('ecourse.course_catalog') }}</h5>
            <p class="text-muted mb-5">{{ __('ecourse.browse_courses') }} - Join any course to start learning</p>
            @if ($classes->count() > 0)
                <div class="row">
                    @foreach ($classes as $class)
                        @php
                            $enrollment = $class->enrollments->first();
                            $isJoined = $enrollment !== null;
                        @endphp
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header p-0">
                                    <div class="bg-gradient-primary text-white px-4 py-3 rounded-top">
                                        <h6 class="text-white mb-1">{{ $class->title }}</h6>
                                        <small class="text-white-50">
                                            {{ $class->categories->pluck('name')->implode(', ') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column pt-4">
                                    <p class="text-muted mb-3">{{ Str::limit($class->description, 100) }}</p>

                                    <!-- Course Stats -->
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">{{ __('ecourse.total_lessons') }}</small>
                                            <div class="fw-bold">{{ $class->total_lessons }}</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">{{ __('ecourse.course_duration') }}</small>
                                            <div class="fw-bold">{{ $class->formatted_duration }}</div>
                                        </div>
                                    </div>

                                    @if ($isJoined)
                                        <!-- Progress Bar for joined courses -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-muted">{{ __('ecourse.course_progress') }}</small>
                                                <small
                                                    class="fw-bold">{{ number_format($enrollment->completion_percentage, 1) }}%</small>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $enrollment->completion_percentage }}%"
                                                    aria-valuenow="{{ $enrollment->completion_percentage }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                        <!-- Status Badge -->
                                        <div class="mb-3">
                                            @if ($enrollment->isCompleted())
                                                <span class="badge bg-success">{{ __('ecourse.completed') }}</span>
                                                <small
                                                    class="text-muted ms-2">{{ $enrollment->completed_at->format('M d, Y') }}</small>
                                            @elseif($enrollment->completion_percentage > 0)
                                                <span class="badge bg-info">{{ __('ecourse.in_progress') }}</span>
                                                <small class="text-muted ms-2">{{ $enrollment->total_points }} points
                                                    earned</small>
                                            @else
                                                <span class="badge bg-secondary">{{ __('ecourse.not_started') }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <!-- Course Info for non-joined courses -->
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted">{{ __('ecourse.course_modules') }}</small>
                                                    <div class="fw-bold">{{ $class->modules->count() }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Status</small>
                                                    <div><span class="badge bg-label-primary">Available</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Action Button -->
                                    <div class="mt-auto">
                                        @if ($isJoined)
                                            <a href="{{ route('member.courses.show', $class) }}"
                                                class="btn btn-primary w-100">
                                                <i class="ti tabler-book me-2"></i>
                                                @if ($enrollment->completion_percentage > 0)
                                                    {{ __('ecourse.continue_course') }}
                                                @else
                                                    {{ __('ecourse.start_course') }}
                                                @endif
                                            </a>
                                        @else
                                            <form action="{{ route('member.courses.join', $class) }}" method="POST"
                                                class="d-inline w-100">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary w-100">
                                                    <i class="ti tabler-plus me-2"></i>{{ __('ecourse.join_now') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="avatar avatar-xl mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="ti tabler-book icon-xl"></i>
                        </span>
                    </div>
                    <h5 class="mb-2">{{ __('ecourse.no_courses_available') }}</h5>
                    <p class="text-muted mb-4">No courses are available at the moment. Please check back later.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
