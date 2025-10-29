<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassCreateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
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
            'categories.required' => 'Please select at least one category.',
            'categories.min' => 'Please select at least one category.',
            'categories.*.exists' => 'Selected category is invalid.',
        ];
    }
}
