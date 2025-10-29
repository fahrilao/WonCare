<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'duration' => 'nullable|integer|min:0',
            'position' => 'nullable|integer|min:0',
            'type' => 'nullable|string|max:255',
        ];

        // Add video-specific validation when type is video
        if ($this['type'] === 'video') {
            $rules['video_source'] = 'required|in:youtube,upload';

            if ($this['video_source'] === 'youtube') {
                $rules['youtube_url'] = ['required', 'url', 'regex:/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+/'];
            } elseif ($this['video_source'] === 'upload') {
                $rules['video_file'] = 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400'; // Optional on update
            }
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'module_id.required' => 'Please select a module.',
            'module_id.exists' => 'Selected module is invalid.',
            'duration.min' => 'Duration must be at least 0 seconds.',
            'video_source.required' => 'Please select a video source when lesson type is video.',
            'youtube_url.required' => 'YouTube URL is required when using YouTube as video source.',
            'youtube_url.regex' => 'Please enter a valid YouTube URL.',
            'video_file.mimes' => 'Video file must be: mp4, avi, mov, wmv, flv, or webm.',
            'video_file.max' => 'Video file size must not exceed 100MB.',
        ];
    }
}
