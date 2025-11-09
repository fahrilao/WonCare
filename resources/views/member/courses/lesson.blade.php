@extends('layouts.member-fullscreen')

@section('title', $lesson->title)

@push('styles')
    <style>
        .lesson-container {
            height: 100vh;
            width: 100%;
            overflow: hidden;
            position: relative;
            background: #000;
            cursor: grab;
            user-select: none;
            /* Prevent text selection during drag */
        }

        .lesson-container:active {
            cursor: grabbing;
        }

        .video-container {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .video-player {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            background: transparent;
            pointer-events: none;
            /* Allow iframe interaction by default */
            transition: pointer-events 0.1s;
        }

        .video-overlay.capturing {
            pointer-events: auto;
            /* Capture events during gesture */
        }

        .video-tap-zones {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 3;
            pointer-events: none;
        }

        .tap-zone {
            position: absolute;
            top: 0;
            width: 30%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: auto;
            transition: background-color 0.2s ease;
        }

        .tap-zone-left {
            left: 0;
        }

        .tap-zone-right {
            right: 0;
        }

        .tap-zone:active {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Lesson Info Overlay */
        .lesson-info-overlay {
            position: absolute;
            bottom: 80px;
            left: 20px;
            right: 80px;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 16px;
            color: white;
            z-index: 3;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .lesson-info-overlay.show {
            opacity: 1;
            transform: translateY(0);
        }

        .lesson-info-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .lesson-info-description {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.4;
        }

        .lesson-info-meta {
            font-size: 0.8rem;
            opacity: 0.7;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Quiz Styles */
        .quiz-container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 20px;
            color: white;
            overflow-y: auto;
        }

        .quiz-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .quiz-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .quiz-progress {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            font-size: 0.9rem;
        }

        .quiz-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .question-card {
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .question-text {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .options-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .option-btn {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            text-align: left;
            transition: all 0.3s ease;
            cursor: pointer;
            backdrop-filter: blur(10px);
        }

        .option-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        .option-btn.selected {
            background: rgba(59, 130, 246, 0.3);
            border-color: #3b82f6;
        }

        .option-btn.correct {
            background: rgba(34, 197, 94, 0.3);
            border-color: #22c55e;
        }

        .option-btn.incorrect {
            background: rgba(239, 68, 68, 0.3);
            border-color: #ef4444;
        }

        .option-letter {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 16px;
            flex-shrink: 0;
        }

        .option-text {
            flex: 1;
        }


        .quiz-results {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .results-content {
            text-align: center;
            max-width: 400px;
            padding: 40px;
        }

        .results-icon {
            font-size: 4rem;
            color: #fbbf24;
            margin-bottom: 20px;
        }

        .results-content h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .score-display {
            font-size: 2rem;
            font-weight: 600;
            color: #3b82f6;
            margin-bottom: 30px;
        }

        .quiz-complete-btn {
            background: #22c55e;
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quiz-complete-btn:hover {
            background: #16a34a;
            transform: translateY(-2px);
        }

        .lesson-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(transparent 60%, rgba(0, 0, 0, 0.8));
            pointer-events: none;
            z-index: 2;
        }

        .side-controls {
            position: absolute;
            right: 15px;
            bottom: 100px;
            z-index: 3;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .side-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .side-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.1);
        }

        .side-btn.completed {
            background: rgba(34, 197, 94, 0.8);
            border-color: rgba(34, 197, 94, 0.9);
        }

        .navigation-hint {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            z-index: 2;
            animation: fadeInOut 3s ease-in-out infinite;
        }

        @keyframes fadeInOut {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        .progress-indicator {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            z-index: 3;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            padding: 10px 15px;
            backdrop-filter: blur(10px);
        }

        .progress-text {
            color: white;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .progress-bar-container {
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: #22c55e;
            transition: width 0.3s ease;
        }

        .video-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        @media (max-width: 768px) {
            .lesson-controls {
                padding: 15px;
            }

            .side-controls {
                right: 10px;
                bottom: 80px;
            }

            .side-btn {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="lesson-container" id="lessonContainer">
        <!-- Progress Indicator -->
        <div class="progress-indicator d-none">
            <div class="progress-text">
                {{ __('ecourse.lesson_progress') }}: {{ $currentIndex + 1 }} / {{ $moduleLessons->count() }}
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill" style="width: {{ (($currentIndex + 1) / $moduleLessons->count()) * 100 }}%">
                </div>
            </div>
        </div>

        <!-- Content Area - Video or Quiz -->
        @if ($lesson->questions && $lesson->questions->count() > 0)
            <!-- Quiz Interface -->
            <div class="quiz-container" id="quizContainer">
                <div class="quiz-header">
                    <h2 class="quiz-title">{{ $lesson->title }}</h2>
                    <div class="quiz-progress">
                        <span id="currentQuestion">1</span> / {{ $lesson->questions->count() }}
                    </div>
                </div>

                <div class="quiz-content">
                    @foreach ($lesson->questions as $index => $question)
                        <div class="question-card" data-question="{{ $index + 1 }}"
                            style="{{ $index === 0 ? '' : 'display: none;' }}">
                            <div class="question-text">
                                {!! $question->question !!}
                            </div>

                            <div class="options-container">
                                @foreach ($question->options as $optionIndex => $option)
                                    <button class="option-btn" data-question="{{ $index + 1 }}"
                                        data-option="{{ $optionIndex + 1 }}"
                                        data-correct="{{ $option->is_correct ? 'true' : 'false' }}">
                                        <span class="option-letter">{{ chr(65 + $optionIndex) }}</span>
                                        <span class="option-text">{{ $option->option_text }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="quiz-results" id="quizResults" style="display: none;">
                    <div class="results-content">
                        <div class="results-icon">
                            <i class="ti tabler-trophy"></i>
                        </div>
                        <h3>{{ __('ecourse.quiz_completed') }}</h3>
                        <div class="score-display">
                            <span id="finalScore">0</span> / {{ $lesson->questions->count() }}
                        </div>
                        <button class="quiz-complete-btn" id="completeQuizBtn">
                            {{ __('ecourse.complete_lesson') }}
                        </button>
                    </div>
                </div>
            </div>
        @elseif ($lesson->video_file)
            <!-- Use video tag for direct video files -->
            <div class="video-container">
                <video class="video-player" id="videoPlayer" controls autoplay muted playsinline>
                    <source src="{{ asset('storage/' . $lesson->video_file) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <!-- Tap zones for lesson navigation -->
                <div class="video-tap-zones">
                    <div class="tap-zone tap-zone-left" id="tapZoneLeftVideo"></div>
                    <div class="tap-zone tap-zone-right" id="tapZoneRightVideo"></div>
                </div>
            </div>
        @elseif ($lesson->youtube_url)
            <!-- Use iframe for YouTube URLs -->
            <div class="video-container">
                <iframe class="video-player" id="videoPlayerIframe"
                    src="{{ $lesson->youtube_url }}?enablejsapi=1&controls=1&modestbranding=1&rel=0" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
                <!-- Transparent overlay to capture touch events -->
                <div class="video-overlay" id="videoOverlay">
                    <!-- Tap zones for lesson navigation -->
                    <div class="tap-zone tap-zone-left" id="tapZoneLeft"></div>
                    <div class="tap-zone tap-zone-right" id="tapZoneRight"></div>
                </div>
            </div>
        @else
            <div class="video-placeholder">
                <i class="ti tabler-video"></i>
            </div>
        @endif

        <!-- Overlay -->
        <div class="lesson-overlay"></div>

        <!-- Lesson Info Overlay -->
        <div class="lesson-info-overlay" id="lessonInfoOverlay">
            <div class="lesson-info-title">{{ $lesson->title }}</div>
            @if ($lesson->content)
                <div class="lesson-info-description">{{ $lesson->content }}</div>
            @endif
        </div>

        <!-- Side Controls -->
        <div class="side-controls">
            @if ($previousLesson)
                <button class="side-btn" id="prevLessonBtn" title="{{ __('ecourse.previous_lesson') }}">
                    <i class="ti tabler-chevron-up"></i>
                </button>
            @endif

            @if ($nextLesson)
                <button class="side-btn" id="nextLessonBtn" title="{{ __('ecourse.next_lesson') }}">
                    <i class="ti tabler-chevron-down"></i>
                </button>
            @endif

            @if (!$progress || !$progress->completed)
                <button class="side-btn" id="completeBtn" title="{{ __('ecourse.mark_complete') }}">
                    <i class="ti tabler-check"></i>
                </button>
            @else
                <div class="side-btn completed" title="{{ __('ecourse.completed') }}">
                    <i class="ti tabler-check"></i>
                </div>
            @endif

            <button class="side-btn" id="infoBtn" title="Lesson Info">
                <i class="ti tabler-info-circle"></i>
            </button>

            <button class="side-btn" onclick="window.location.href='{{ route('member.courses.show', $class) }}'"
                title="{{ __('ecourse.back_to_course') }}">
                <i class="ti tabler-arrow-left"></i>
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('lessonContainer');
            const videoPlayer = document.getElementById('videoPlayer'); // HTML5 video element
            const videoPlayerIframe = document.getElementById('videoPlayerIframe'); // YouTube iframe
            const videoOverlay = document.getElementById('videoOverlay');
            let startY = 0;
            let currentY = 0;
            let isScrolling = false;
            let isDragging = false;
            let startX = 0;
            let currentX = 0;

            // Smart touch events for swipe gestures
            container.addEventListener('touchstart', function(e) {
                startY = e.touches[0].clientY;
                isScrolling = false;
                console.log('Touch start:', startY);

                // Enable overlay after short delay to detect intent
                setTimeout(() => {
                    if (videoOverlay && startY) {
                        videoOverlay.classList.add('capturing');
                    }
                }, 100);
            }, {
                passive: false
            });

            container.addEventListener('touchmove', function(e) {
                if (!startY) return;

                currentY = e.touches[0].clientY;
                const diffY = startY - currentY;

                if (Math.abs(diffY) > 15) {
                    isScrolling = true;
                    e.preventDefault(); // Prevent default scrolling

                    // Ensure overlay is capturing
                    if (videoOverlay) {
                        videoOverlay.classList.add('capturing');
                    }
                }
                console.log('Touch move:', currentY, 'Diff:', diffY);
            }, {
                passive: false
            });

            container.addEventListener('touchend', function(e) {
                console.log('Touch end - isScrolling:', isScrolling, 'startY:', startY);
                if (!isScrolling || !startY) {
                    startY = 0;
                    currentY = 0;
                    isScrolling = false;
                    return;
                }

                const diffY = startY - currentY;
                const threshold = 50;
                console.log('Final diffY:', diffY, 'threshold:', threshold);

                if (Math.abs(diffY) > threshold) {
                    if (diffY > 0) {
                        // Swipe up - next lesson
                        console.log('Swipe up detected - going to next lesson');
                        @if ($nextLesson)
                            navigateToLesson(
                                '{{ route('member.courses.lesson', [$class, $module, $nextLesson]) }}');
                        @endif
                    } else {
                        // Swipe down - previous lesson
                        console.log('Swipe down detected - going to previous lesson');
                        @if ($previousLesson)
                            navigateToLesson(
                                '{{ route('member.courses.lesson', [$class, $module, $previousLesson]) }}'
                            );
                        @endif
                    }
                }

                startY = 0;
                currentY = 0;
                isScrolling = false;

                // Reset overlay to allow iframe interaction
                if (videoOverlay) {
                    videoOverlay.classList.remove('capturing');
                }
            }, {
                passive: false
            });

            // Mouse drag events for desktop
            container.addEventListener('mousedown', function(e) {
                isDragging = true;
                startY = e.clientY;
                startX = e.clientX;
                isScrolling = false;
                console.log('Mouse down:', startY, startX);

                // Enable overlay for mouse drag
                if (videoOverlay) {
                    videoOverlay.classList.add('capturing');
                }

                // Prevent text selection during drag
                e.preventDefault();
            });

            container.addEventListener('mousemove', function(e) {
                if (!isDragging) return;

                currentY = e.clientY;
                currentX = e.clientX;
                const diffY = startY - currentY;
                const diffX = startX - currentX;

                // Check if significant movement (either vertical or horizontal)
                if (Math.abs(diffY) > 15 || Math.abs(diffX) > 15) {
                    isScrolling = true;
                    e.preventDefault();

                    // Show visual feedback
                    document.body.style.cursor = 'grabbing';
                }
                console.log('Mouse move - Y:', diffY, 'X:', diffX);
            });

            container.addEventListener('mouseup', function(e) {
                if (!isDragging) return;

                console.log('Mouse up - isScrolling:', isScrolling);

                if (isScrolling) {
                    const diffY = startY - currentY;
                    const diffX = startX - currentX;
                    const threshold = 50;

                    // Prioritize vertical movement (like TikTok)
                    if (Math.abs(diffY) > Math.abs(diffX) && Math.abs(diffY) > threshold) {
                        if (diffY > 0) {
                            // Drag up - next lesson
                            console.log('Mouse drag up - next lesson');
                            @if ($nextLesson)
                                navigateToLesson(
                                    '{{ route('member.courses.lesson', [$class, $module, $nextLesson]) }}'
                                );
                            @endif
                        } else {
                            // Drag down - previous lesson
                            console.log('Mouse drag down - previous lesson');
                            @if ($previousLesson)
                                navigateToLesson(
                                    '{{ route('member.courses.lesson', [$class, $module, $previousLesson]) }}'
                                );
                            @endif
                        }
                    }
                    // Horizontal movement (alternative navigation)
                    else if (Math.abs(diffX) > threshold) {
                        if (diffX > 0) {
                            // Drag left - previous lesson
                            console.log('Mouse drag left - previous lesson');
                            @if ($previousLesson)
                                navigateToLesson(
                                    '{{ route('member.courses.lesson', [$class, $module, $previousLesson]) }}'
                                );
                            @endif
                        } else {
                            // Drag right - next lesson
                            console.log('Mouse drag right - next lesson');
                            @if ($nextLesson)
                                navigateToLesson(
                                    '{{ route('member.courses.lesson', [$class, $module, $nextLesson]) }}'
                                );
                            @endif
                        }
                    }
                }

                // Reset everything
                isDragging = false;
                startY = 0;
                currentY = 0;
                startX = 0;
                currentX = 0;
                isScrolling = false;
                document.body.style.cursor = 'default';

                // Reset overlay
                if (videoOverlay) {
                    videoOverlay.classList.remove('capturing');
                }
            });

            // Handle mouse leave to reset drag state
            container.addEventListener('mouseleave', function(e) {
                if (isDragging) {
                    isDragging = false;
                    isScrolling = false;
                    document.body.style.cursor = 'default';
                    if (videoOverlay) {
                        videoOverlay.classList.remove('capturing');
                    }
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                switch (e.key) {
                    case 'ArrowUp':
                        e.preventDefault();
                        @if ($previousLesson)
                            navigateToLesson(
                                '{{ route('member.courses.lesson', [$class, $module, $previousLesson]) }}'
                            );
                        @endif
                        break;
                    case 'ArrowDown':
                        e.preventDefault();
                        @if ($nextLesson)
                            navigateToLesson(
                                '{{ route('member.courses.lesson', [$class, $module, $nextLesson]) }}');
                        @endif
                        break;
                    case ' ':
                        e.preventDefault();
                        // Only works with HTML5 video, not YouTube iframe
                        if (videoPlayer) {
                            videoPlayer.paused ? videoPlayer.play() : videoPlayer.pause();
                        }
                        break;
                    case 'Escape':
                        e.preventDefault();
                        window.location.href = '{{ route('member.courses.show', $class) }}';
                        break;
                }
            });

            // Side navigation buttons
            const prevLessonBtn = document.getElementById('prevLessonBtn');
            const nextLessonBtn = document.getElementById('nextLessonBtn');

            if (prevLessonBtn) {
                prevLessonBtn.addEventListener('click', function() {
                    @if ($previousLesson)
                        navigateToLesson(
                            '{{ route('member.courses.lesson', [$class, $module, $previousLesson]) }}');
                    @endif
                });
            }

            if (nextLessonBtn) {
                nextLessonBtn.addEventListener('click', function() {
                    @if ($nextLesson)
                        navigateToLesson(
                            '{{ route('member.courses.lesson', [$class, $module, $nextLesson]) }}');
                    @endif
                });
            }

            // Lesson info toggle
            const infoBtn = document.getElementById('infoBtn');
            const lessonInfoOverlay = document.getElementById('lessonInfoOverlay');
            let infoTimeout;

            if (infoBtn && lessonInfoOverlay) {
                // Toggle info on button click
                infoBtn.addEventListener('click', function() {
                    lessonInfoOverlay.classList.toggle('show');

                    // Auto-hide after 5 seconds if shown
                    if (lessonInfoOverlay.classList.contains('show')) {
                        clearTimeout(infoTimeout);
                        infoTimeout = setTimeout(() => {
                            lessonInfoOverlay.classList.remove('show');
                        }, 5000);
                    }
                });

                // Show info automatically on page load for 3 seconds
                setTimeout(() => {
                    lessonInfoOverlay.classList.add('show');
                    infoTimeout = setTimeout(() => {
                        lessonInfoOverlay.classList.remove('show');
                    }, 3000);
                }, 1000);
            }

            // Complete lesson button
            const completeBtn = document.getElementById('completeBtn');
            if (completeBtn) {
                completeBtn.addEventListener('click', function() {
                    markComplete();
                });
            }

            function markComplete() {
                fetch('{{ route('member.courses.lesson.complete', [$class, $module, $lesson]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI
                            if (completeBtn) completeBtn.style.display = 'none';
                            // Update button to completed state
                            const sideControls = document.querySelector('.side-controls');
                            if (sideControls && completeBtn) {
                                completeBtn.outerHTML =
                                    '<div class="side-btn completed" title="{{ __('ecourse.completed') }}"><i class="ti tabler-check"></i></div>';
                            }

                            // Show success message
                            showNotification('{{ __('ecourse.lesson_completed') }}', 'success');

                            // Auto-advance to next lesson after 2 seconds
                            @if ($nextLesson)
                                setTimeout(() => {
                                    navigateToLesson(
                                        '{{ route('member.courses.lesson', [$class, $module, $nextLesson]) }}'
                                    );
                                }, 2000);
                            @endif
                        } else {
                            showNotification('{{ __('common.error') }}', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('{{ __('common.error') }}', 'error');
                    });
            }

            // Add click handler for next video preview
            const nextVideoPreview = document.querySelector('.next-video-preview');
            if (nextVideoPreview) {
                nextVideoPreview.addEventListener('click', function() {
                    @if ($nextLesson)
                        navigateToLesson(
                            '{{ route('member.courses.lesson', [$class, $module, $nextLesson]) }}');
                    @endif
                });
            }

            // Tap zone handlers for lesson navigation
            const tapZoneLeft = document.getElementById('tapZoneLeft');
            const tapZoneRight = document.getElementById('tapZoneRight');
            const tapZoneLeftVideo = document.getElementById('tapZoneLeftVideo');
            const tapZoneRightVideo = document.getElementById('tapZoneRightVideo');

            // Left tap - Previous lesson
            function handleLeftTap() {
                @if ($previousLesson)
                    navigateToLesson('{{ route('member.courses.lesson', [$class, $module, $previousLesson]) }}');
                @endif
            }

            // Right tap - Next lesson  
            function handleRightTap() {
                @if ($nextLesson)
                    navigateToLesson('{{ route('member.courses.lesson', [$class, $module, $nextLesson]) }}');
                @endif
            }

            // Add event listeners for all tap zones
            if (tapZoneLeft) tapZoneLeft.addEventListener('click', handleLeftTap);
            if (tapZoneRight) tapZoneRight.addEventListener('click', handleRightTap);
            if (tapZoneLeftVideo) tapZoneLeftVideo.addEventListener('click', handleLeftTap);
            if (tapZoneRightVideo) tapZoneRightVideo.addEventListener('click', handleRightTap);


            // Video controls for HTML5 video (not iframe)
            if (videoPlayer) {
                videoPlayer.addEventListener('ended', function() {
                    if (!{{ $progress && $progress->completed ? 'true' : 'false' }}) {
                        markComplete();
                    }
                });
            }

            // Quiz functionality
            const quizContainer = document.getElementById('quizContainer');
            if (quizContainer) {
                let currentQuestionIndex = 0;
                let selectedAnswers = {};
                let score = 0;
                const totalQuestions = {{ $lesson->questions ? $lesson->questions->count() : 0 }};

                // Option selection
                document.querySelectorAll('.option-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const questionNum = this.dataset.question;
                        const optionNum = this.dataset.option;
                        const isCorrect = this.dataset.correct === 'true';

                        // Remove previous selection
                        document.querySelectorAll(`[data-question="${questionNum}"]`).forEach(
                            option => {
                                option.classList.remove('selected');
                            });

                        // Mark current selection
                        this.classList.add('selected');
                        selectedAnswers[questionNum] = {
                            option: optionNum,
                            correct: isCorrect
                        };

                        // Auto-advance after selection
                        setTimeout(() => {
                            processAnswer(parseInt(questionNum));
                        }, 500);
                    });
                });

                // Process answer function
                function processAnswer(questionNum) {
                    const currentAnswer = selectedAnswers[questionNum];
                    if (!currentAnswer) return;

                    // Show correct/incorrect feedback
                    const currentCard = document.querySelector(`[data-question="${questionNum}"]`);
                    const options = currentCard.querySelectorAll('.option-btn');

                    options.forEach(option => {
                        if (option.dataset.correct === 'true') {
                            option.classList.add('correct');
                        } else if (option.classList.contains('selected') && option.dataset.correct ===
                            'false') {
                            option.classList.add('incorrect');
                        }
                        option.disabled = true;
                    });

                    // Update score
                    if (currentAnswer.correct) {
                        score++;
                    }

                    // Auto-advance to next question or results
                    setTimeout(() => {
                        if (currentQuestionIndex < totalQuestions - 1) {
                            // Move to next question
                            currentQuestionIndex++;
                            showQuestion(currentQuestionIndex);
                        } else {
                            // Show results
                            showQuizResults();
                        }
                    }, 1500);
                }


                function showQuestion(index) {
                    // Hide all questions
                    document.querySelectorAll('.question-card').forEach(card => {
                        card.style.display = 'none';
                    });

                    // Show current question
                    const currentCard = document.querySelector(`[data-question="${index + 1}"]`);
                    if (currentCard) {
                        currentCard.style.display = 'block';

                        // Re-enable options for this question if not already answered
                        const options = currentCard.querySelectorAll('.option-btn');
                        if (!selectedAnswers[index + 1]) {
                            options.forEach(option => {
                                option.disabled = false;
                                option.classList.remove('correct', 'incorrect', 'selected');
                            });
                        }
                    }

                    // Update progress
                    document.getElementById('currentQuestion').textContent = index + 1;
                }

                function showQuizResults() {
                    document.getElementById('finalScore').textContent = score;
                    document.getElementById('quizResults').style.display = 'flex';
                }

                // Complete quiz
                document.getElementById('completeQuizBtn').addEventListener('click', function() {
                    markComplete();
                });
            }
        });

        function navigateToLesson(url) {
            // Add smooth transition
            document.body.style.opacity = '0.8';
            setTimeout(() => {
                window.location.href = url;
            }, 200);
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#22c55e' : '#ef4444'};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                z-index: 9999;
                font-size: 0.9rem;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                transform: translateX(100%);
                transition: transform 0.3s ease;
            `;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    </script>
@endpush
