@extends('layouts.admin')

@section('title', 'Create Lesson')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ __('lessons.create_title') }}</h4>
                        <a href="{{ route('admin.lessons.index') }}"
                            class="btn btn-secondary btn-sm">{{ __('common.back_to_list') }}</a>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ __('lessons.create_description') }}</p>

                        <form action="{{ route('admin.lessons.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="module_id" class="form-label">{{ __('lessons.module') }}</label>
                                <select class="form-select{{ $errors->has('module_id') ? ' is-invalid' : '' }}"
                                    id="module_id" name="module_id" required>
                                    <option value="">{{ __('lessons.select_module') }}</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}"
                                            {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                            {{ $module->title }}
                                            ({{ $module->class ? $module->class->title : 'No Class' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('module_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('lessons.title') }}</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                    id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Enter lesson title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('lessons.content') }}</label>
                                <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" id="content" name="content"
                                    rows="6" placeholder="Enter lesson content">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">{{ __('lessons.type') }}</label>
                                        <select class="form-select{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                            id="type" name="type">
                                            <option value="">{{ __('lessons.select_type') }}</option>
                                            <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>
                                                {{ __('lessons.type_video') }}
                                            </option>
                                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>
                                                {{ __('lessons.type_text') }}
                                            </option>
                                            <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>
                                                {{ __('lessons.type_quiz') }}
                                            </option>
                                            <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>
                                                {{ __('lessons.type_assignment') }}
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Video Source Fields (shown only when type is video) -->
                            <div id="video-fields" style="display: none;">
                                <div class="mb-3">
                                    <label for="video_source" class="form-label">{{ __('lessons.video_source') }}</label>
                                    <select class="form-select{{ $errors->has('video_source') ? ' is-invalid' : '' }}"
                                        id="video_source" name="video_source">
                                        <option value="">{{ __('lessons.select_video_source') }}</option>
                                        <option value="youtube" {{ old('video_source') == 'youtube' ? 'selected' : '' }}>
                                            {{ __('lessons.video_source_youtube') }}
                                        </option>
                                        <option value="upload" {{ old('video_source') == 'upload' ? 'selected' : '' }}>
                                            {{ __('lessons.video_source_upload') }}
                                        </option>
                                    </select>
                                    @error('video_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- YouTube URL Field -->
                                <div id="youtube-field" class="mb-3" style="display: none;">
                                    <label for="youtube_url" class="form-label">{{ __('lessons.youtube_url') }}</label>
                                    <input type="url"
                                        class="form-control{{ $errors->has('youtube_url') ? ' is-invalid' : '' }}"
                                        id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}"
                                        placeholder="https://www.youtube.com/watch?v=...">
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('lessons.youtube_url_help') }}</small>
                                </div>

                                <!-- Video Upload Field (Chunked) -->
                                <div id="upload-field" class="mb-3" style="display: none;">
                                    <label class="form-label">{{ __('lessons.video_file') }}</label>
                                    <input type="hidden" name="video_path" id="video_path"
                                        value="{{ old('video_path') }}">

                                    <div id="video-dropzone" class="border border-2 border-dashed rounded p-4 text-center"
                                        style="cursor: pointer; background: #f8f9fa;">
                                        <div id="dropzone-content">
                                            <i class="ti tabler-cloud-upload icon-xl text-muted mb-2"></i>
                                            <p class="mb-1">{{ __('lessons.drag_drop_video') }}</p>
                                            <small class="text-muted">{{ __('lessons.video_file_help') }}</small>
                                        </div>
                                        <div id="upload-progress" style="display: none;">
                                            <div class="mb-2">
                                                <span id="upload-filename" class="fw-medium"></span>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div id="progress-bar"
                                                    class="progress-bar progress-bar-striped progress-bar-animated"
                                                    role="progressbar" style="width: 0%">0%</div>
                                            </div>
                                            <small id="upload-status" class="text-muted mt-2 d-block"></small>
                                        </div>
                                        <div id="upload-success" style="display: none;">
                                            <i class="ti tabler-circle-check icon-xl text-success mb-2"></i>
                                            <p class="mb-1 text-success fw-medium">{{ __('lessons.video_uploaded') }}</p>
                                            <small id="uploaded-filename" class="text-muted"></small>
                                            <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                                id="remove-video">
                                                <i class="ti tabler-trash me-1"></i>{{ __('common.remove') }}
                                            </button>
                                        </div>
                                    </div>
                                    <input type="file" id="video_file_input" accept="video/*" style="display: none;">
                                    @error('video_path')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">{{ __('lessons.duration') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}"
                                            id="duration" name="duration" value="{{ old('duration') }}"
                                            placeholder="Duration in seconds" min="0">
                                        @error('duration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">{{ __('lessons.duration_help') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">{{ __('lessons.position') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                                            id="position" name="position" value="{{ old('position') }}"
                                            placeholder="Enter position (optional)" min="0">
                                        @error('position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">{{ __('lessons.position_help') }}</small>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.lessons.index') }}"
                                    class="btn btn-secondary">{{ __('common.cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('common.create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor_scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for module selection
            $('#module_id').select2({
                placeholder: "{{ __('lessons.select_module') }}",
                allowClear: true
            });

            // Handle lesson type change
            $('#type').on('change', function() {
                const type = $(this).val();
                const videoFields = $('#video-fields');

                if (type === 'video') {
                    videoFields.show();
                } else {
                    videoFields.hide();
                    $('#video_source').val('');
                    $('#youtube_url').val('');
                    $('#video_path').val('');
                    $('#youtube-field, #upload-field').hide();
                    resetUploadUI();
                }
            });

            // Handle video source change
            $('#video_source').on('change', function() {
                const source = $(this).val();
                const youtubeField = $('#youtube-field');
                const uploadField = $('#upload-field');

                if (source === 'youtube') {
                    youtubeField.show();
                    uploadField.hide();
                    $('#video_path').val('');
                    resetUploadUI();
                } else if (source === 'upload') {
                    uploadField.show();
                    youtubeField.hide();
                    $('#youtube_url').val('');
                } else {
                    youtubeField.hide();
                    uploadField.hide();
                    $('#youtube_url').val('');
                    $('#video_path').val('');
                    resetUploadUI();
                }
            });

            // Initialize on page load if values exist
            if ($('#type').val() === 'video') {
                $('#video-fields').show();
                $('#video_source').trigger('change');
            }

            // Chunked Upload Logic
            const dropzone = document.getElementById('video-dropzone');
            const fileInput = document.getElementById('video_file_input');
            const uploadUrl = '{{ route('admin.upload.chunked') }}';
            const csrfToken = '{{ csrf_token() }}';

            // Click to select file
            dropzone.addEventListener('click', function(e) {
                if (e.target.id !== 'remove-video' && !e.target.closest('#remove-video')) {
                    fileInput.click();
                }
            });

            // Drag and drop events
            dropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropzone.classList.add('border-primary', 'bg-light');
            });

            dropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropzone.classList.remove('border-primary', 'bg-light');
            });

            dropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                dropzone.classList.remove('border-primary', 'bg-light');
                const files = e.dataTransfer.files;
                if (files.length > 0 && files[0].type.startsWith('video/')) {
                    uploadChunkedFile(files[0]);
                }
            });

            // File input change
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    uploadChunkedFile(this.files[0]);
                }
            });

            // Remove video button
            $('#remove-video').on('click', function(e) {
                e.stopPropagation();
                $('#video_path').val('');
                resetUploadUI();
            });

            function resetUploadUI() {
                $('#dropzone-content').show();
                $('#upload-progress').hide();
                $('#upload-success').hide();
                $('#progress-bar').css('width', '0%').text('0%');
            }

            function uploadChunkedFile(file) {
                const chunkSize = 2 * 1024 * 1024; // 2MB chunks
                const totalChunks = Math.ceil(file.size / chunkSize);
                let currentChunk = 0;

                $('#dropzone-content').hide();
                $('#upload-progress').show();
                $('#upload-success').hide();
                $('#upload-filename').text(file.name);

                function uploadNextChunk() {
                    const start = currentChunk * chunkSize;
                    const end = Math.min(start + chunkSize, file.size);
                    const chunk = file.slice(start, end);

                    const formData = new FormData();
                    formData.append('file', chunk, file.name);
                    formData.append('_token', csrfToken);
                    formData.append('folder', 'lessons/videos');

                    // Resumable.js compatible headers
                    const headers = {
                        'X-CSRF-TOKEN': csrfToken
                    };

                    $.ajax({
                        url: uploadUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'Content-Range': `bytes ${start}-${end - 1}/${file.size}`,
                            'X-Chunk-Number': currentChunk + 1,
                            'X-Chunk-Total': totalChunks,
                            'X-Chunk-Size': chunkSize,
                            'X-File-Name': encodeURIComponent(file.name),
                            'X-File-Size': file.size
                        },
                        xhr: function() {
                            const xhr = new window.XMLHttpRequest();
                            return xhr;
                        },
                        success: function(response) {
                            currentChunk++;
                            const percent = Math.round((currentChunk / totalChunks) * 100);
                            $('#progress-bar').css('width', percent + '%').text(percent + '%');
                            $('#upload-status').text(
                                `Uploading chunk ${currentChunk} of ${totalChunks}...`);

                            if (response.path) {
                                // Upload complete
                                $('#video_path').val(response.path);
                                $('#upload-progress').hide();
                                $('#upload-success').show();
                                $('#uploaded-filename').text(file.name);
                            } else if (currentChunk < totalChunks) {
                                // Upload next chunk
                                uploadNextChunk();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Upload error:', error);
                            resetUploadUI();
                            alert('Upload failed: ' + (xhr.responseJSON?.message || error));
                        }
                    });
                }

                uploadNextChunk();
            }
        });
    </script>
@endpush
