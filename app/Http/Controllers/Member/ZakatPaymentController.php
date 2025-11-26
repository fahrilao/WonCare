<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\Payments\MidtransSnapService;
use App\Services\Payments\StripeCheckoutService;
use App\Services\Payments\TossPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ZakatPaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $amount = $request->get('amount');
        $note = $request->get('note', 'Zakat Payment');
        $type = $request->get('type', 'Zakat');

        // Get active payment gateways
        $paymentGateways = PaymentGateway::active()
            ->whereIn('provider', ['midtrans', 'stripe', 'toss'])
            ->get()
            ->filter(fn($g) => $g->isConfigured());

        return view('member.zakat.checkout', [
            'amount' => $amount,
            'note' => $note,
            'type' => $type,
            'paymentGateways' => $paymentGateways,
        ]);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'note' => ['nullable', 'string', 'max:1000'],
            'currency' => ['required', 'string', 'in:IDR,KRW'],
        ]);

        $member = Auth::guard('member')->user();

        // Create donation record for Zakat (without campaign)
        $donation = Donation::create([
            'member_id' => $member->id,
            'donation_campaign_id' => null, // No campaign for Zakat
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'note' => $validated['note'] ?? 'Zakat Payment',
            'payment_status' => 'pending',
            'order_id' => 'ZKT-' . date('y') . '-' . time(),
        ]);

        // Automatically select gateway based on currency
        // IDR (Rupiah) → Midtrans
        // KRW (Won) → Toss Payments
        $gateway = Donation::getGatewayForCurrency($validated['currency']);

        if (!$gateway || !$gateway->isConfigured()) {
            $currencyName = $validated['currency'] === 'KRW' ? 'Won' : 'Rupiah';
            $providerName = $validated['currency'] === 'KRW' ? 'Toss Payments' : 'Midtrans';

            return back()->with('error', "Payment gateway for {$currencyName} ({$providerName}) is not configured. Please contact administrator.");
        }

        $donation->payment_gateway_id = $gateway->id;
        $donation->payment_provider = $gateway->provider;
        $donation->save();

        try {
            if ($gateway->provider === 'midtrans') {
                $service = new MidtransSnapService($gateway);
                $result = $service->createTransaction([
                    'transaction_details' => [
                        'order_id' => $donation->order_id,
                        'gross_amount' => (int) $donation->amount,
                    ],
                    'customer_details' => [
                        'first_name' => $member->name,
                        'email' => $member->email,
                    ],
                    'item_details' => [[
                        'id' => 'zakat',
                        'name' => 'Zakat Payment',
                        'price' => (int) $donation->amount,
                        'quantity' => 1,
                    ]],
                    'callbacks' => [
                        'finish' => route('payment.callback.midtrans.finish', ['order_id' => $donation->order_id]),
                    ],
                ]);

                $donation->update([
                    'snap_token' => $result['token'] ?? null,
                    'snap_redirect_url' => $result['redirect_url'] ?? null,
                ]);

                return redirect($result['redirect_url']);
            } elseif ($gateway->provider === 'toss') {
                $service = new TossPaymentService($gateway);
                $result = $service->createPayment([
                    'order_id' => $donation->order_id,
                    'amount' => (int) $donation->amount,
                    'order_name' => 'Zakat Payment',
                    'customer_email' => $member->email,
                    'customer_name' => $member->name,
                    'success_url' => route('payment.callback.toss.success') . '?orderId=' . $donation->order_id,
                    'fail_url' => route('payment.callback.toss.fail') . '?orderId=' . $donation->order_id,
                ]);

                $donation->update([
                    'snap_token' => $result['payment_key'] ?? null,
                    'snap_redirect_url' => $result['checkout_url'] ?? null,
                ]);

                return redirect($result['checkout_url']);
            }
        } catch (\Exception $e) {
            Log::error('Zakat payment error: ' . $e->getMessage(), [
                'donation_id' => $donation->id,
                'currency' => $donation->currency,
                'provider' => $gateway->provider,
            ]);
            return back()->with('error', 'Payment processing error: ' . $e->getMessage());
        }

        return back()->with('error', 'Invalid payment provider.');
    }
}
