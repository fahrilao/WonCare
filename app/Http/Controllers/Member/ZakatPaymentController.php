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
            'payment_provider' => ['nullable', 'string', 'in:midtrans,stripe,toss'],
        ]);

        $member = Auth::guard('member')->user();

        // Create donation record for Zakat (without campaign)
        $donation = Donation::create([
            'member_id' => $member->id,
            'donation_campaign_id' => null, // No campaign for Zakat
            'amount' => $validated['amount'],
            'note' => $validated['note'] ?? 'Zakat Payment',
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_provider' => $validated['payment_provider'] ?? null,
            'order_id' => 'ZKT-' . date('y') . '-' . time(),
        ]);

        // If no payment provider selected, just save as pending
        if (!$validated['payment_provider']) {
            return redirect()->route('member.donate.history')
                ->with('success', 'Zakat payment recorded. Please complete payment.');
        }

        // Process payment based on provider
        $paymentProvider = $validated['payment_provider'];
        $gateway = PaymentGateway::active()
            ->where('provider', $paymentProvider)
            ->first();

        if (!$gateway || !$gateway->isConfigured()) {
            return back()->with('error', 'Payment gateway not configured.');
        }

        try {
            if ($paymentProvider === 'midtrans') {
                $service = new MidtransSnapService($gateway);
                $result = $service->createTransaction([
                    'order_id' => $donation->order_id,
                    'amount' => $donation->amount,
                    'customer' => [
                        'name' => $member->name,
                        'email' => $member->email,
                    ],
                    'item_details' => [[
                        'id' => 'zakat',
                        'name' => 'Zakat Payment',
                        'price' => $donation->amount,
                        'quantity' => 1,
                    ]],
                ]);

                $donation->update([
                    'snap_token' => $result['token'] ?? null,
                    'snap_redirect_url' => $result['redirect_url'] ?? null,
                ]);

                return redirect($result['redirect_url']);
            } elseif ($paymentProvider === 'stripe') {
                $service = new StripeCheckoutService($gateway);
                $result = $service->createCheckoutSession([
                    'order_id' => $donation->order_id,
                    'amount' => $donation->amount,
                    'customer_email' => $member->email,
                    'description' => 'Zakat Payment',
                ]);

                $donation->update([
                    'snap_token' => $result['session_id'] ?? null,
                    'snap_redirect_url' => $result['url'] ?? null,
                ]);

                return redirect($result['url']);
            } elseif ($paymentProvider === 'toss') {
                $service = new TossPaymentService($gateway);
                $result = $service->createPayment([
                    'order_id' => $donation->order_id,
                    'amount' => $donation->amount,
                    'customer_name' => $member->name,
                    'description' => 'Zakat Payment',
                ]);

                $donation->update([
                    'snap_token' => $result['payment_key'] ?? null,
                    'snap_redirect_url' => $result['checkout_url'] ?? null,
                ]);

                return redirect($result['checkout_url']);
            }
        } catch (\Exception $e) {
            Log::error('Zakat payment error: ' . $e->getMessage());
            return back()->with('error', 'Payment processing error: ' . $e->getMessage());
        }

        return back()->with('error', 'Invalid payment provider.');
    }
}
