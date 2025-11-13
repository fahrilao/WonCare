<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationCampaignUpdateRequest extends FormRequest
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
            'goal_amount' => 'required|numeric|min:0|max:999999999999.99',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:draft,active,completed,cancelled',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_alt' => 'nullable|array',
            'image_alt.*' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:donation_tags,id',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:donation_campaign_images,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => __('donation_campaigns.title_required'),
            'title.max' => __('donation_campaigns.title_max'),
            'goal_amount.required' => __('donation_campaigns.goal_amount_required'),
            'goal_amount.numeric' => __('donation_campaigns.goal_amount_numeric'),
            'goal_amount.min' => __('donation_campaigns.goal_amount_min'),
            'goal_amount.max' => __('donation_campaigns.goal_amount_max'),
            'start_date.required' => __('donation_campaigns.start_date_required'),
            'start_date.date' => __('donation_campaigns.start_date_date'),
            'end_date.date' => __('donation_campaigns.end_date_date'),
            'end_date.after' => __('donation_campaigns.end_date_after'),
            'status.required' => __('donation_campaigns.status_required'),
            'status.in' => __('donation_campaigns.status_in'),
            'image.image' => __('donation_campaigns.image_image'),
            'image.mimes' => __('donation_campaigns.image_mimes'),
            'image.max' => __('donation_campaigns.image_max'),
        ];
    }
}
