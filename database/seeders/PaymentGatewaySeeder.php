<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin user or create a system user
        $adminUser = User::first();
        
        // Create Midtrans Gateway (Indonesia)
        PaymentGateway::create([
            'name' => 'Midtrans Payment Gateway',
            'provider' => 'midtrans',
            'api_key' => 'SB-Mid-server-demo_api_key_12345',
            'secret_key' => 'SB-Mid-client-demo_secret_key_67890',
            'webhook_secret' => 'midtrans_webhook_secret_demo',
            'additional_config' => [
                'merchant_id' => 'demo-merchant-id',
                'client_key' => 'SB-Mid-client-demo_client_key',
                'environment' => 'sandbox',
                'currency' => 'IDR',
                'payment_methods' => ['credit_card', 'bank_transfer', 'e_wallet'],
                'notification_url' => config('app.url') . '/webhook/midtrans',
                'finish_url' => config('app.url') . '/payment/success',
                'error_url' => config('app.url') . '/payment/failed'
            ],
            'is_active' => true,
            'is_sandbox' => true,
            'description' => 'Midtrans payment gateway for Indonesian market. Supports credit cards, bank transfers, and e-wallets.',
            'created_by' => $adminUser?->id,
        ]);

        // Create Stripe Gateway (International)
        PaymentGateway::create([
            'name' => 'Stripe Payment Gateway',
            'provider' => 'stripe',
            'api_key' => 'pk_test_51234567890abcdefghijklmnopqrstuvwxyz',
            'secret_key' => 'sk_test_51234567890abcdefghijklmnopqrstuvwxyz',
            'webhook_secret' => 'whsec_1234567890abcdefghijklmnopqrstuvwxyz',
            'additional_config' => [
                'webhook_endpoint_secret' => 'whsec_demo_endpoint_secret',
                'currency' => 'usd',
                'payment_methods' => ['card', 'bank_transfer', 'paypal'],
                'capture_method' => 'automatic',
                'confirmation_method' => 'automatic',
                'success_url' => config('app.url') . '/payment/success',
                'cancel_url' => config('app.url') . '/payment/cancel'
            ],
            'is_active' => true,
            'is_sandbox' => true,
            'description' => 'Stripe payment gateway for international payments. Supports credit cards, bank transfers, and digital wallets.',
            'created_by' => $adminUser?->id,
        ]);

        // Create Toss Payments Gateway (Korea)
        PaymentGateway::create([
            'name' => 'Toss Payments Gateway',
            'provider' => 'toss',
            'api_key' => 'test_ak_demo_1234567890abcdefghijklmnop',
            'secret_key' => 'test_sk_demo_1234567890abcdefghijklmnop',
            'webhook_secret' => 'toss_webhook_secret_demo_12345',
            'additional_config' => [
                'client_key' => 'test_ck_demo_1234567890abcdefghijklmnop',
                'currency' => 'KRW',
                'payment_methods' => ['card', 'transfer', 'virtual_account', 'mobile'],
                'success_url' => config('app.url') . '/payment/success',
                'fail_url' => config('app.url') . '/payment/failed',
                'webhook_url' => config('app.url') . '/webhook/toss',
                'country' => 'KR',
                'locale' => 'ko_KR'
            ],
            'is_active' => false, // Disabled by default
            'is_sandbox' => true,
            'description' => 'Toss Payments gateway for Korean market. Supports credit cards, bank transfers, virtual accounts, and mobile payments.',
            'created_by' => $adminUser?->id,
        ]);

        // Create additional demo gateways for testing
        PaymentGateway::create([
            'name' => 'Stripe Production Gateway',
            'provider' => 'stripe',
            'api_key' => 'pk_live_demo_production_key_placeholder',
            'secret_key' => 'sk_live_demo_production_key_placeholder',
            'webhook_secret' => 'whsec_live_demo_webhook_secret',
            'additional_config' => [
                'webhook_endpoint_secret' => 'whsec_live_endpoint_secret',
                'currency' => 'usd',
                'payment_methods' => ['card'],
                'capture_method' => 'automatic',
                'confirmation_method' => 'automatic'
            ],
            'is_active' => false, // Disabled by default for production
            'is_sandbox' => false,
            'description' => 'Production Stripe gateway - disabled by default for security.',
            'created_by' => $adminUser?->id,
        ]);

        PaymentGateway::create([
            'name' => 'Midtrans Production Gateway',
            'provider' => 'midtrans',
            'api_key' => 'Mid-server-production_api_key_placeholder',
            'secret_key' => 'Mid-client-production_secret_key_placeholder',
            'webhook_secret' => 'midtrans_production_webhook_secret',
            'additional_config' => [
                'merchant_id' => 'production-merchant-id',
                'client_key' => 'Mid-client-production_client_key',
                'environment' => 'production',
                'currency' => 'IDR',
                'payment_methods' => ['credit_card', 'bank_transfer', 'e_wallet']
            ],
            'is_active' => false, // Disabled by default for production
            'is_sandbox' => false,
            'description' => 'Production Midtrans gateway - disabled by default for security.',
            'created_by' => $adminUser?->id,
        ]);

        $this->command->info('Payment Gateway seeder completed successfully!');
        $this->command->info('Created 5 payment gateway configurations:');
        $this->command->info('- Midtrans Sandbox (Active)');
        $this->command->info('- Stripe Sandbox (Active)');
        $this->command->info('- Toss Payments Sandbox (Inactive)');
        $this->command->info('- Stripe Production (Inactive)');
        $this->command->info('- Midtrans Production (Inactive)');
    }
}
