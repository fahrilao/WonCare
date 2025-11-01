@extends('layouts.admin')

@section('title', 'Lesson Details')

@push('vendor_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/highlight/highlight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
@endpush

@push('styles')
    <style>
        .iframe-short {
            --bs-aspect-ratio: 177.78%;
            margin: auto;
            max-width: 315px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl grow container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('lessons.view_title') }}</h4>
                        <div>
                            <a href="{{ route('admin.lessons.edit', $lesson ?? 1) }}"
                                class="btn btn-warning btn-sm">{{ __('common.edit') }}</a>
                            <a href="{{ route('admin.lessons.index') }}"
                                class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-2 col-4 py-5 pe-3"><strong>{{ __('lessons.title') }}:</strong></div>
                            <div class="col-md-4 col-8 py-5 ps-3">
                                {{ $lesson->title ?? 'Lesson title will be displayed here' }}
                            </div>

                            <div class="col-md-2 col-4 py-5 pe-3"><strong>{{ __('lessons.module') }}:</strong></div>
                            <div class="col-md-4 col-8 py-5 ps-3">
                                @if ($lesson->module ?? false)
                                    <a href="{{ route('admin.modules.show', $lesson->module->id) }}"
                                        class="text-decoration-none">
                                        {{ $lesson->module->title }}
                                    </a>
                                @else
                                    Lesson module will be displayed here
                                @endif
                            </div>

                            <div class="col-md-2 col-4 py-5 pe-3"><strong>{{ __('lessons.class') }}:</strong></div>
                            <div class="col-md-4 col-8 py-5 ps-3">
                                @if ($lesson->module && $lesson->module->class ?? false)
                                    <a href="{{ route('admin.classes.show', $lesson->module->class->id) }}"
                                        class="text-decoration-none">
                                        {{ $lesson->module->class->title }}
                                    </a>
                                @else
                                    Lesson class will be displayed here
                                @endif
                            </div>

                            <div class="col-md-2 col-4 py-5 pe-3"><strong>{{ __('lessons.type') }}:</strong></div>
                            <div class="col-md-4 col-8 py-5 ps-3">
                                @if ($lesson->type ?? false)
                                    @php
                                        $badgeClass = match ($lesson->type) {
                                            'video' => 'bg-primary',
                                            'text' => 'bg-info',
                                            'quiz' => 'bg-warning',
                                            'assignment' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($lesson->type) }}</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </div>

                            <div class="col-md-2 col-4 py-5 pe-3"><strong>{{ __('lessons.duration') }}:</strong></div>
                            <div class="col-md-4 col-8 py-5 ps-3">
                                @if ($lesson->duration ?? false)
                                    {{ $lesson->formatted_duration }} ({{ $lesson->duration }} seconds)
                                @else
                                    0:00 (0 seconds)
                                @endif
                            </div>

                            <div class="col-md-2 col-4 py-5 pe-3"><strong>{{ __('lessons.position') }}:</strong></div>
                            <div class="col-md-4 col-8 py-5 ps-3">
                                {{ $lesson->position ?? 'Lesson position will be displayed here' }}
                            </div>

                            <div class="col-md-2 col-4 py-5 pe-3"><strong>{{ __('common.created_at') }}:</strong></div>
                            <div class="col-md-4 col-8 py-5 ps-3">
                                {{ $lesson->created_at ?? 'Creation date will be displayed here' }}
                            </div>

                            <div class="col-md-2 col-4 py-5 pe-3"><strong>{{ __('common.updated_at') }}:</strong></div>
                            <div class="col-md-4 col-8 py-5 ps-3">
                                {{ $lesson->updated_at ?? 'Last update date will be displayed here' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="col-md-2 col-4 mb-3"><strong>{{ __('lessons.content') }}:</strong></div>
                            @if ($lesson->type === 'video' && $lesson->hasVideo())
                                @if ($lesson->video_source === 'youtube' && $lesson->youtube_url)
                                    <div class="ratio mb-3 text-center iframe-short">
                                        <iframe width="315" height="560"
                                            src="{{ str_replace('short', 'embed', $lesson->youtube_url) }}"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                    </div>
                                    <small class="text-muted">
                                        <strong>{{ __('lessons.youtube_url') }}:</strong>
                                        <a href="{{ $lesson->youtube_url }}"
                                            target="_blank">{{ $lesson->youtube_url }}</a>
                                    </small>
                                @elseif($lesson->video_source === 'upload' && $lesson->video_file)
                                    <video controls style="width: 100%; max-width: 600px;">
                                        <source src="{{ asset('storage/' . $lesson->video_file) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <br>
                                    <small class="text-muted">
                                        <strong>{{ __('lessons.video_file') }}:</strong>
                                        {{ basename($lesson->video_file) }}
                                    </small>
                                @endif
                                <br>
                            @endif
                            @if ($lesson->content ?? false)
                                {!! nl2br(e($lesson->content)) !!}
                            @else
                                <span class="text-muted">{{ __('common.no_content') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Question Section --}}
        @if ($lesson->type === 'quiz')
            <div class="mt-5">
                <ul class="nav nav-pills me-4" id="question-tabs">
                    @foreach ($lesson->questions as $index => $question)
                        <li class="nav-item">
                            <button type="button" class="nav-link {{ $index === 0 ? 'active' : '' }} question-nav-btn"
                                data-question-id="{{ $question->id }}">
                                {{ __('questions.question') }} {{ $index + 1 }}
                            </button>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        @if ($lesson->questions->isEmpty())
                            <button type="button" class="btn btn-primary" id="add-question-btn">
                                <i class="ti tabler-plus"></i>
                                {{ __('questions.add_question') }}
                            </button>
                        @else
                            <button type="button" class="nav-link" id="add-question-btn">
                                <i class="ti tabler-plus"></i>
                                {{ __('questions.add_question') }}
                            </button>
                        @endif
                    </li>
                </ul>

                <!-- Single Question Form -->
                <div class="mt-4" id="question-form-container"
                    style="{{ $lesson->questions->isEmpty() ? 'display: none;' : '' }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <strong>{{ __('lessons.question') }}:</strong>
                                <div class="btn-group">
                                    <button class="btn btn-warning btn-sm" id="edit-current-question-btn">
                                        <i class="ti tabler-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" id="delete-current-question-btn">
                                        <i class="ti tabler-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Question Display -->
                            <div id="current-question-display">
                                <!-- Content will be loaded by JavaScript -->
                            </div>

                            <!-- Question Edit Form -->
                            <div id="current-question-edit" style="display: none;">
                                <div id="current-question-toolbar">
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-header" value="1"></button>
                                        <button class="ql-header" value="2"></button>
                                    </span>
                                </div>
                                <div id="current-question-editor"></div>
                                <div class="mt-2">
                                    <button class="btn btn-primary btn-sm" id="save-current-question-btn">
                                        {{ __('questions.save_question') }}
                                    </button>
                                    <button class="btn btn-secondary btn-sm" id="cancel-current-question-btn">
                                        {{ __('questions.cancel') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Options Section -->
                            <div class="mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <strong>{{ __('lessons.options') }}:</strong>
                                    <button class="btn btn-success btn-sm" id="add-current-option-btn">
                                        <i class="ti tabler-plus"></i> {{ __('questions.add_option') }}
                                    </button>
                                </div>

                                <div id="current-options-container">
                                    <!-- Options will be loaded by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- End Question Section --}}
    </div>
    </div>
@endsection


@push('vendor_scripts')
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/highlight/highlight.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentQuestionEditor = null;
            let currentQuestionId = null;
            let lessonId = {{ $lesson->id }};
            let questionsData = @json($lesson->questions->load('options'));

            // Initialize first question if exists
            if (questionsData.length > 0) {
                loadQuestion(questionsData[0].id);
            }

            // Question navigation click handler
            $(document).on('click', '.question-nav-btn', function() {
                const questionId = $(this).data('question-id');

                // Update active state
                $('.question-nav-btn').removeClass('active');
                $(this).addClass('active');

                // Load question content
                loadQuestion(questionId);
            });

            // Load question content into single form
            function loadQuestion(questionId) {
                const question = questionsData.find(q => q.id == questionId);
                if (!question) return;

                currentQuestionId = questionId;

                // Show form container
                $('#question-form-container').show();
                $('#no-questions-message').hide();

                // Load question display
                $('#current-question-display').html(question.question || '');

                // Load options
                loadOptions(question.options || []);

                // Initialize Quill editor for this question
                if (currentQuestionEditor) {
                    currentQuestionEditor = null;
                }
            }

            // Load options into container
            function loadOptions(options) {
                let optionsHtml = '';

                if (options.length === 0) {
                    optionsHtml = '<p class="text-muted">{{ __('questions.no_options') }}</p>';
                } else {
                    options.forEach(function(option) {
                        const correctClass = option.is_correct ? 'btn-primary' : 'btn-outline-primary';
                        const starIcon = option.is_correct ? 'star-filled' : 'star';
                        const correctBadge = option.is_correct ?
                            '<span class="badge bg-success ms-2">{{ __('questions.correct_answer') }}</span>' :
                            '';

                        optionsHtml += `
                            <div class="option-item mt-3" id="option-${option.id}">
                                <div class="d-flex align-items-center">
                                    <div class="btn-group me-3">
                                        <button class="btn btn-warning btn-sm edit-option-btn" 
                                                data-option-id="${option.id}">
                                            <i class="ti tabler-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-option-btn" 
                                                data-option-id="${option.id}">
                                            <i class="ti tabler-trash"></i>
                                        </button>
                                        <button class="btn ${correctClass} btn-sm set-correct-btn" 
                                                data-option-id="${option.id}"
                                                title="{{ __('questions.set_correct') }}">
                                            <i class="ti tabler-${starIcon}"></i>
                                        </button>
                                    </div>
                                    <div class="grow">
                                        <div class="option-display" id="option-display-${option.id}">
                                            ${option.option_text}${correctBadge}
                                        </div>
                                        <div class="option-edit" id="option-edit-${option.id}" style="display: none;">
                                            <input type="text" class="form-control" 
                                                   value="${option.option_text}" 
                                                   placeholder="{{ __('questions.enter_option') }}">
                                            <div class="mt-2">
                                                <button class="btn btn-primary btn-sm save-option-btn" 
                                                        data-option-id="${option.id}">
                                                    {{ __('questions.save_option') }}
                                                </button>
                                                <button class="btn btn-secondary btn-sm cancel-option-btn" 
                                                        data-option-id="${option.id}">
                                                    {{ __('questions.cancel') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }

                $('#current-options-container').html(optionsHtml);
            }

            // Add new question
            $('#add-question-btn').on('click', function() {
                $.ajax({
                    url: `{{ route('admin.lessons.questions.store', $lesson) }}`,
                    method: 'POST',
                    data: {
                        question: '{{ __('questions.enter_question') }}',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload(); // Reload to show new question
                        }
                    },
                    error: function(xhr) {
                        showAlert('error', '{{ __('common.error') }}');
                    }
                });
            });

            // Edit current question
            $('#edit-current-question-btn').on('click', function() {
                if (!currentQuestionId) return;

                const question = questionsData.find(q => q.id == currentQuestionId);
                if (!question) return;

                $('#current-question-display').hide();
                $('#current-question-edit').show();

                // Initialize Quill editor
                if (!currentQuestionEditor) {
                    currentQuestionEditor = new Quill('#current-question-editor', {
                        bounds: '#current-question-editor',
                        modules: {
                            toolbar: '#current-question-toolbar'
                        },
                        theme: 'snow'
                    });
                }

                // Set content
                currentQuestionEditor.root.innerHTML = question.question || '';
            });

            // Cancel edit current question
            $('#cancel-current-question-btn').on('click', function() {
                $('#current-question-display').show();
                $('#current-question-edit').hide();
            });

            // Save current question
            $('#save-current-question-btn').on('click', function() {
                if (!currentQuestionId || !currentQuestionEditor) return;

                const questionText = currentQuestionEditor.root.innerHTML;

                $.ajax({
                    url: `{{ route('admin.questions.update', ['question' => ':question']) }}`
                        .replace(':question', currentQuestionId),
                    method: 'PUT',
                    data: {
                        question: questionText,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#current-question-display').html(questionText);
                            $('#current-question-display').show();
                            $('#current-question-edit').hide();

                            // Update questionsData
                            const questionIndex = questionsData.findIndex(q => q.id ==
                                currentQuestionId);
                            if (questionIndex !== -1) {
                                questionsData[questionIndex].question = questionText;
                            }
                        }
                    },
                    error: function(xhr) {
                        showAlert('error', '{{ __('common.error') }}');
                    }
                });
            });

            // Delete current question
            $('#delete-current-question-btn').on('click', function() {
                if (!currentQuestionId) return;

                Swal.fire({
                    icon: 'question',
                    title: '{{ __('questions.confirm_delete_question') }}',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('common.delete') }}',
                    cancelButtonText: '{{ __('common.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('admin.questions.destroy', ['question' => ':question']) }}`
                                .replace(':question', currentQuestionId),
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    location.reload();
                                }
                            },
                            error: function(xhr) {
                                showAlert('error', '{{ __('common.error') }}');
                            }
                        });
                    }
                });
            });

            // Add new option to current question
            $('#add-current-option-btn').on('click', function() {
                if (!currentQuestionId) return;

                $.ajax({
                    url: `{{ route('admin.questions.options.store', ['question' => ':question']) }}`
                        .replace(':question', currentQuestionId),
                    method: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        option_text: '{{ __('questions.enter_option') }}',
                        is_correct: false,
                        _token: '{{ csrf_token() }}'
                    }),
                    success: function(response) {
                        if (response.success) {
                            // Add option to questionsData
                            const questionIndex = questionsData.findIndex(q => q
                                .id ==
                                currentQuestionId);
                            if (questionIndex !== -1) {
                                questionsData[questionIndex].options.push(response
                                    .option);
                                loadOptions(questionsData[questionIndex].options);
                            }
                        }
                    },
                    error: function(xhr) {
                        showAlert('error', '{{ __('common.error') }}');
                    }
                });
            });

            // Edit option
            $(document).on('click', '.edit-option-btn', function() {
                const optionId = $(this).data('option-id');
                $(`#option-display-${optionId}`).hide();
                $(`#option-edit-${optionId}`).show();
            });

            // Cancel edit option
            $(document).on('click', '.cancel-option-btn', function() {
                const optionId = $(this).data('option-id');
                $(`#option-display-${optionId}`).show();
                $(`#option-edit-${optionId}`).hide();
            });

            // Save option
            $(document).on('click', '.save-option-btn', function() {
                const optionId = $(this).data('option-id');
                const optionText = $(`#option-edit-${optionId} input`).val();

                $.ajax({
                    url: `{{ route('admin.options.update', ['option' => ':option']) }}`
                        .replace(':option', optionId),
                    method: 'PUT',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        option_text: optionText,
                        _token: '{{ csrf_token() }}'
                    }),
                    success: function(response) {
                        if (response.success) {
                            // Update display
                            const correctBadge = response.option.is_correct ?
                                '<span class="badge bg-success ms-2">{{ __('questions.correct_answer') }}</span>' :
                                '';
                            $(`#option-display-${optionId}`).html(optionText +
                                correctBadge);
                            $(`#option-display-${optionId}`).show();
                            $(`#option-edit-${optionId}`).hide();

                            // Update questionsData
                            const questionIndex = questionsData.findIndex(q => q
                                .id ==
                                currentQuestionId);
                            if (questionIndex !== -1) {
                                const optionIndex = questionsData[questionIndex]
                                    .options
                                    .findIndex(o => o.id == optionId);
                                if (optionIndex !== -1) {
                                    questionsData[questionIndex].options[
                                            optionIndex]
                                        .option_text = optionText;
                                }
                            }
                        }
                    },
                    error: function(xhr) {
                        showAlert('error', '{{ __('common.error') }}');
                    }
                });
            });

            // Delete option
            $(document).on('click', '.delete-option-btn', function() {
                const optionId = $(this).data('option-id');

                Swal.fire({
                    icon: 'question',
                    title: '{{ __('questions.confirm_delete_option') }}',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('common.delete') }}',
                    cancelButtonText: '{{ __('common.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('admin.options.destroy', ['option' => ':option']) }}`
                                .replace(':option', optionId),
                            method: 'DELETE',
                            contentType: 'application/json',
                            dataType: 'json',
                            data: JSON.stringify({
                                _token: '{{ csrf_token() }}'
                            }),
                            success: function(response) {
                                if (response.success) {
                                    $(`#option-${optionId}`).remove();

                                    // Update questionsData
                                    const questionIndex = questionsData.findIndex(q => q
                                        .id ==
                                        currentQuestionId);
                                    if (questionIndex !== -1) {
                                        questionsData[questionIndex].options =
                                            questionsData[
                                                questionIndex].options.filter(o => o
                                                .id != optionId);
                                        if (questionsData[questionIndex].options
                                            .length === 0) {
                                            $('#current-options-container').html(
                                                '<p class="text-muted">{{ __('questions.no_options') }}</p>'
                                            );
                                        }
                                    }
                                }
                            },
                            error: function(xhr) {
                                showAlert('error', '{{ __('common.error') }}');
                            }
                        });
                    }
                });
            });

            // Set correct option
            $(document).on('click', '.set-correct-btn', function() {
                const optionId = $(this).data('option-id');

                $.ajax({
                    url: `{{ route('admin.options.correct', ['option' => ':option']) }}`
                        .replace(':option', optionId),
                    method: 'PATCH',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        _token: '{{ csrf_token() }}'
                    }),
                    success: function(response) {
                        if (response.success) {
                            // Update questionsData
                            const questionIndex = questionsData.findIndex(q => q
                                .id ==
                                currentQuestionId);
                            if (questionIndex !== -1) {
                                questionsData[questionIndex].options.forEach(
                                    option => {
                                        option.is_correct = (option.id ==
                                            optionId);
                                    });
                                loadOptions(questionsData[questionIndex].options);
                            }

                            showAlert('success', response.message);
                        }
                    },
                    error: function(xhr) {
                        showAlert('error', '{{ __('common.error') }}');
                    }
                });
            });

            // Helper function to show alerts
            function showAlert(type, message) {
                Swal.fire({
                    icon: type,
                    title: type === 'success' ? `{{ __('common.success') }}` : `{{ __('common.error') }}`,
                    text: message,
                })
            }
        });
    </script>
@endpush
