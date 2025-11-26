<?php

namespace App\Services\Payments;

use App\Models\PaymentGateway;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TossPaymentService
{
  protected PaymentGateway $gateway;

  protected Client $client;

  public function __construct(PaymentGateway $gateway)
  {
    $this->gateway = $gateway;

    $this->client = new Client([
      'base_uri' => $gateway->is_sandbox
        ? 'https://api.tosspayments.com'
        : 'https://api.tosspayments.com',
      'timeout' => 10,
    ]);
  }

  /**
   * Create a Toss Payment and return payment key and checkout URL.
   *
   * @param  array  $payload
   * @return array{payment_key:string, checkout_url:string}
   *
   * @throws GuzzleException
   */
  public function createPayment(array $payload): array
  {
    $secretKey = $this->gateway->secret_key;

    $response = $this->client->post('/v1/payments', [
      'headers' => [
        'Authorization' => 'Basic ' . base64_encode($secretKey . ':'),
        'Content-Type' => 'application/json',
      ],
      'json' => [
        'orderId' => $payload['order_id'],
        'amount' => $payload['amount'],
        'orderName' => $payload['order_name'],
        'successUrl' => $payload['success_url'],
        'failUrl' => $payload['fail_url'],
        'customerEmail' => $payload['customer_email'] ?? null,
        'customerName' => $payload['customer_name'] ?? null,
      ],
    ]);

    $data = json_decode((string) $response->getBody(), true);

    return [
      'payment_key' => $data['paymentKey'] ?? '',
      'checkout_url' => $data['checkoutUrl'] ?? '',
    ];
  }
}
