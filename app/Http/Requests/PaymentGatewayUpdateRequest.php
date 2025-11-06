<?php

namespace App\Http\Requests;

use App\Models\PaymentGateway;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentGatewayUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', Rule::in(array_keys(PaymentGateway::PROVIDERS))],
            'api_key' => ['nullable', 'string', 'max:1000'],
            'secret_key' => ['nullable', 'string', 'max:1000'],
            'webhook_secret' => ['nullable', 'string', 'max:1000'],
            'additional_config' => ['nullable', 'array'],
            'is_active' => ['boolean'],
            'is_sandbox' => ['boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('payment_gateways.name_required'),
            'name.max' => __('payment_gateways.name_max'),
            'provider.required' => __('payment_gateways.provider_required'),
            'provider.in' => __('payment_gateways.provider_invalid'),
            'api_key.max' => __('payment_gateways.api_key_max'),
            'secret_key.max' => __('payment_gateways.secret_key_max'),
            'webhook_secret.max' => __('payment_gateways.webhook_secret_max'),
            'additional_config.array' => __('payment_gateways.additional_config_array'),
            'is_active.boolean' => __('payment_gateways.is_active_boolean'),
            'is_sandbox.boolean' => __('payment_gateways.is_sandbox_boolean'),
            'description.max' => __('payment_gateways.description_max'),
        ];
    }
}