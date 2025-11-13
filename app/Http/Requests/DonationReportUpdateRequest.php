<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationReportUpdateRequest extends FormRequest
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
            'donation_campaign_id' => 'required|exists:donation_campaigns,id',
            'distributed_amount' => 'required|numeric|min:0|max:999999999999.99',
            'distribution_date' => 'required|date|before_or_equal:today',
            'description' => 'nullable|string',
            'beneficiaries' => 'nullable|string',
            'evidence_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
            'notes' => 'nullable|string|max:1000',
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
            'donation_campaign_id.required' => __('donation_reports.campaign_required'),
            'donation_campaign_id.exists' => __('donation_reports.campaign_exists'),
            'distributed_amount.required' => __('donation_reports.distributed_amount_required'),
            'distributed_amount.numeric' => __('donation_reports.distributed_amount_numeric'),
            'distributed_amount.min' => __('donation_reports.distributed_amount_min'),
            'distributed_amount.max' => __('donation_reports.distributed_amount_max'),
            'distribution_date.required' => __('donation_reports.distribution_date_required'),
            'distribution_date.date' => __('donation_reports.distribution_date_date'),
            'distribution_date.before_or_equal' => __('donation_reports.distribution_date_before_or_equal'),
            'evidence_file.file' => __('donation_reports.evidence_file_file'),
            'evidence_file.mimes' => __('donation_reports.evidence_file_mimes'),
            'evidence_file.max' => __('donation_reports.evidence_file_max'),
        ];
    }
}
