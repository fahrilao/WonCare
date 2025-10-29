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
        return [
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'duration' => 'nullable|integer|min:0',
            'position' => 'nullable|integer|min:0',
            'type' => 'nullable|string|max:255',
        ];
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
        ];
    }
}
