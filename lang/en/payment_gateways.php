<?php

return [
    // General
    'payment_gateways' => 'Payment Gateways',
    'payment_gateway' => 'Payment Gateway',
    'create_title' => 'Create Payment Gateway',
    'edit_title' => 'Edit Payment Gateway',
    'view_title' => 'Payment Gateway Details',
    'list_title' => 'Payment Gateways',

    // Fields
    'name' => 'Gateway Name',
    'provider' => 'Provider',
    'api_key' => 'API Key',
    'secret_key' => 'Secret Key',
    'webhook_secret' => 'Webhook Secret',
    'additional_config' => 'Additional Configuration',
    'is_active' => 'Status',
    'is_sandbox' => 'Mode',
    'description' => 'Description',
    'creator' => 'Created By',

    // Provider options
    'provider_midtrans' => 'Midtrans',
    'provider_stripe' => 'Stripe',
    'provider_toss' => 'Toss Payments',

    // Status options
    'sandbox' => 'Sandbox',
    'production' => 'Production',
    'configured' => 'Configured',
    'not_configured' => 'Not Configured',

    // Placeholders
    'name_placeholder' => 'Enter gateway name...',
    'api_key_placeholder' => 'Enter API key...',
    'secret_key_placeholder' => 'Enter secret key...',
    'webhook_secret_placeholder' => 'Enter webhook secret...',
    'description_placeholder' => 'Enter gateway description...',

    // Help text
    'name_help' => 'Enter a descriptive name for this payment gateway',
    'provider_help' => '-- Choose Provider --',
    'api_key_help' => 'API key from your payment gateway provider',
    'secret_key_help' => 'Secret key from your payment gateway provider',
    'webhook_secret_help' => 'Webhook secret for secure communication',
    'is_active_help' => 'Enable or disable this payment gateway',
    'is_sandbox_help' => 'Use sandbox mode for testing',
    'description_help' => 'Optional description for this gateway configuration',
    'additional_config_help' => 'Additional configuration in JSON format',

    // Validation messages
    'name_required' => 'Gateway name is required',
    'name_max' => 'Gateway name may not be greater than 255 characters',
    'provider_required' => 'Provider is required',
    'provider_invalid' => 'Selected provider is invalid',
    'api_key_max' => 'API key may not be greater than 1000 characters',
    'secret_key_max' => 'Secret key may not be greater than 1000 characters',
    'webhook_secret_max' => 'Webhook secret may not be greater than 1000 characters',
    'additional_config_array' => 'Additional configuration must be valid JSON',
    'is_active_boolean' => 'Status must be true or false',
    'is_sandbox_boolean' => 'Mode must be true or false',
    'description_max' => 'Description may not be greater than 1000 characters',

    // Success messages
    'created_successfully' => 'Payment gateway created successfully',
    'updated_successfully' => 'Payment gateway updated successfully',
    'deleted_successfully' => 'Payment gateway deleted successfully',

    // Info messages
    'not_set' => 'Not Set',
    'connection_successful' => 'Connection test successful',
    'connection_failed' => 'Connection test failed',

    // DataTable columns
    'dt_name' => 'Name',
    'dt_provider' => 'Provider',
    'dt_status' => 'Status',
    'dt_mode' => 'Mode',
    'dt_configured' => 'Configured',
    'dt_creator' => 'Creator',
    'dt_created_at' => 'Created',
    'dt_actions' => 'Actions',

    // Security
    'masked_key' => 'Key is encrypted and masked for security',
    'test_connection' => 'Test Connection',
];