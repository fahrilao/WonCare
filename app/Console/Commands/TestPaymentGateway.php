<?php

namespace App\Console\Commands;

use App\Models\PaymentGateway;
use App\Services\Payments\MidtransSnapService;
use App\Services\Payments\StripeCheckoutService;
use App\Services\Payments\TossPaymentService;
use Illuminate\Console\Command;

class TestPaymentGateway extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'payment:test {provider=midtrans}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Test payment gateway integration';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $provider = $this->argument('provider');

    $this->info("Testing {$provider} payment gateway...");
    $this->newLine();

    // Find gateway
    $gateway = PaymentGateway::active()
      ->byProvider($provider)
      ->first();

    if (!$gateway) {
      $this->error("❌ No active {$provider} gateway found!");
      $this->info("Please configure the gateway in admin panel first.");
      return 1;
    }

    if (!$gateway->isConfigured()) {
      $this->error("❌ Gateway is not configured (missing API keys)!");
      return 1;
    }

    $this->info("✅ Gateway found: {$gateway->name}");
    $this->info("   Provider: {$gateway->provider}");
    $this->info("   Sandbox: " . ($gateway->is_sandbox ? 'Yes' : 'No'));
    $this->newLine();

    // Test service instantiation
    try {
      $this->info("Testing service class instantiation...");

      $service = match ($provider) {
        'midtrans' => new MidtransSnapService($gateway),
        'stripe' => new StripeCheckoutService($gateway),
        'toss' => new TossPaymentService($gateway),
        default => throw new \Exception("Unknown provider: {$provider}"),
      };

      $this->info("✅ Service class loaded successfully!");
      $this->info("   Class: " . get_class($service));
      $this->newLine();
    } catch (\Throwable $e) {
      $this->error("❌ Failed to load service class!");
      $this->error("   Error: " . $e->getMessage());
      return 1;
    }

    // Test payment creation (dry run)
    try {
      $this->info("Testing payment creation (this will make a real API call)...");
      $this->newLine();

      $testPayload = $this->getTestPayload($provider);

      $this->info("Payload:");
      $this->line(json_encode($testPayload, JSON_PRETTY_PRINT));
      $this->newLine();

      if (!$this->confirm('Do you want to proceed with the API call?', false)) {
        $this->info("Test cancelled.");
        return 0;
      }

      $result = match ($provider) {
        'midtrans' => $service->createTransaction($testPayload),
        'stripe' => $service->createCheckoutSession($testPayload),
        'toss' => $service->createPayment($testPayload),
      };

      $this->info("✅ Payment created successfully!");
      $this->newLine();
      $this->info("Result:");
      $this->line(json_encode($result, JSON_PRETTY_PRINT));
      $this->newLine();

      if (isset($result['redirect_url']) || isset($result['checkout_url'])) {
        $url = $result['redirect_url'] ?? $result['checkout_url'];
        $this->info("🌐 Payment URL: {$url}");
      }
    } catch (\Throwable $e) {
      $this->error("❌ Payment creation failed!");
      $this->error("   Error: " . $e->getMessage());
      $this->newLine();
      $this->error("Stack trace:");
      $this->line($e->getTraceAsString());
      return 1;
    }

    $this->newLine();
    $this->info("✅ All tests passed!");
    return 0;
  }

  protected function getTestPayload(string $provider): array
  {
    $orderId = 'TEST-' . time();

    return match ($provider) {
      'midtrans' => [
        'transaction_details' => [
          'order_id' => $orderId,
          'gross_amount' => 50000,
        ],
        'customer_details' => [
          'first_name' => 'Test User',
          'email' => 'test@example.com',
        ],
        'item_details' => [
          [
            'id' => '1',
            'price' => 50000,
            'quantity' => 1,
            'name' => 'Test Donation',
          ],
        ],
      ],
      'stripe' => [
        'amount' => 5000000, // 50000 * 100 (cents)
        'currency' => 'usd',
        'item_name' => 'Test Donation',
        'customer_email' => 'test@example.com',
        'success_url' => url('/payment/callback/stripe/success?session_id={CHECKOUT_SESSION_ID}'),
        'cancel_url' => url('/payment/callback/stripe/cancel?session_id={CHECKOUT_SESSION_ID}'),
        'metadata' => [
          'order_id' => $orderId,
        ],
      ],
      'toss' => [
        'order_id' => $orderId,
        'amount' => 50000,
        'order_name' => 'Test Donation',
        'customer_email' => 'test@example.com',
        'customer_name' => 'Test User',
        'success_url' => url('/payment/callback/toss/success?orderId=' . $orderId),
        'fail_url' => url('/payment/callback/toss/fail?orderId=' . $orderId),
      ],
    };
  }
}
