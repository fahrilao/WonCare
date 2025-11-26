<?php

namespace App\Services\Payments;

use App\Models\PaymentGateway;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MidtransSnapService
{
    protected PaymentGateway $gateway;

    protected Client $client;

    public function __construct(PaymentGateway $gateway)
    {
        $this->gateway = $gateway;

        $this->client = new Client([
            'base_uri' => $gateway->is_sandbox
                ? 'https://app.sandbox.midtrans.com'
                : 'https://app.midtrans.com',
            'timeout' => 10,
        ]);
    }

    /**
     * Create a Snap transaction and return token and redirect URL.
     *
     * @param  array  $payload
     * @return array{token:string, redirect_url:string}
     *
     * @throws GuzzleException
     */
    public function createTransaction(array $payload): array
    {
        $serverKey = $this->gateway->secret_key;

        $response = $this->client->post('/snap/v1/transactions', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($serverKey . ':'),
            ],
            'json' => $payload,
        ]);

        $data = json_decode((string) $response->getBody(), true);

        return [
            'token' => $data['token'] ?? '',
            'redirect_url' => $data['redirect_url'] ?? '',
        ];
    }
}
