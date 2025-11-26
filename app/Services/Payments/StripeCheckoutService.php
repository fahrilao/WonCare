<?php

namespace App\Services\Payments;

use App\Models\PaymentGateway;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class StripeCheckoutService
{
  protected PaymentGateway $gateway;

  protected Client $client;

  public function __construct(PaymentGateway $gateway)
  {
    $this->gateway = $gateway;

    $this->client = new Client([
      'base_uri' => 'https://api.stripe.com',
      'timeout' => 10,
    ]);
  }

  /**
   * Create a Stripe Checkout Session and return session ID and URL.
   *
   * @param  array  $payload
   * @return array{session_id:string, checkout_url:string}
   *
   * @throws GuzzleException
   */
  public function createCheckoutSession(array $payload): array
  {
    $secretKey = $this->gateway->secret_key;

    $response = $this->client->post('/v1/checkout/sessions', [
      'headers' => [
        'Authorization' => 'Bearer ' . $secretKey,
        'Content-Type' => 'application/x-www-form-urlencoded',
      ],
      'form_params' => [
        'mode' => 'payment',
        'success_url' => $payload['success_url'],
        'cancel_url' => $payload['cancel_url'],
        'line_items' => [
          [
            'price_data' => [
              'currency' => $payload['currency'] ?? 'usd',
              'product_data' => [
                'name' => $payload['item_name'],
              ],
              'unit_amount' => $payload['amount'], // in cents
            ],
            'quantity' => 1,
          ],
        ],
        'customer_email' => $payload['customer_email'] ?? null,
        'metadata' => $payload['metadata'] ?? [],
      ],
    ]);

    $data = json_decode((string) $response->getBody(), true);

    return [
      'session_id' => $data['id'] ?? '',
      'checkout_url' => $data['url'] ?? '',
    ];
  }
}
