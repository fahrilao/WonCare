<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\DonationCampaign;
use App\Models\DonationTag;
use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\Payments\MidtransSnapService;
use App\Services\Payments\StripeCheckoutService;
use App\Services\Payments\TossPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DonateController extends Controller
{
  public function index(Request $request)
  {
    // Check if this is a Zakat payment request
    $isZakatPayment = $request->has('type') && $request->get('type') === 'zakat';
    $zakatAmount = $request->get('amount');
    $zakatNote = $request->get('note');

    // Banner slider: newest active campaigns with primary image if available
    $bannerCampaigns = DonationCampaign::active()
      ->with(['primaryImage', 'tags'])
      ->latest()
      ->take(5)
      ->get();

    // Running to close: active campaigns ordered by nearest end_date
    $nearClosingCampaigns = DonationCampaign::active()
      ->whereNotNull('end_date')
      ->orderBy('end_date', 'asc')
      ->take(8)
      ->get();

    // Tags: active, ordered
    $tags = DonationTag::active()->ordered()->get();

    // Filter campaigns for Zakat if requested
    $randomCampaignsQuery = DonationCampaign::active()->with('primaryImage');

    if ($isZakatPayment) {
      // Try to find Zakat-related campaigns
      $randomCampaignsQuery->where(function ($query) {
        $query->where('title', 'like', '%zakat%')
          ->orWhere('description', 'like', '%zakat%');
      });
    }

    $randomCampaigns = $randomCampaignsQuery
      ->inRandomOrder()
      ->take(8)
      ->get();

    // If no Zakat campaigns found, get the first available campaign
    if ($isZakatPayment && $randomCampaigns->isEmpty()) {
      $randomCampaigns = DonationCampaign::active()
        ->with('primaryImage')
        ->take(8)
        ->get();
    }

    return view('member.donate.index', [
      'bannerCampaigns' => $bannerCampaigns,
      'nearClosingCampaigns' => $nearClosingCampaigns,
      'tags' => $tags,
      'randomCampaigns' => $randomCampaigns,
      'isZakatPayment' => $isZakatPayment,
      'zakatAmount' => $zakatAmount,
      'zakatNote' => $zakatNote,
    ]);
  }

  public function history()
  {
    $member = Auth::guard('member')->user();

    $donations = Donation::with(['campaign.primaryImage'])
      ->where('member_id', $member->id)
      ->orderByDesc('created_at')
      ->paginate(15);

    $successfulCount = Donation::where('member_id', $member->id)
      ->where('status', 'paid')
      ->count();

    $totalAmount = Donation::where('member_id', $member->id)
      ->where('status', 'paid')
      ->sum('amount');

    return view('member.donate.history', [
      'donations' => $donations,
      'successfulCount' => $successfulCount,
      'totalAmount' => $totalAmount,
    ]);
  }

  public function show(DonationCampaign $campaign)
  {
    $campaign->load(['primaryImage', 'images', 'tags']);

    $wishes = Donation::with('member')
      ->where('donation_campaign_id', $campaign->id)
      ->whereNotNull('note')
      ->orderByDesc('created_at')
      ->take(20)
      ->get();

    return view('member.donate.show', [
      'campaign' => $campaign,
      'wishes' => $wishes,
    ]);
  }

  public function checkout(DonationCampaign $campaign, Request $request)
  {
    $campaign->load(['primaryImage', 'tags']);

    // Get active payment gateways
    $paymentGateways = PaymentGateway::active()
      ->whereIn('provider', ['midtrans', 'stripe', 'toss'])
      ->get()
      ->filter(fn($g) => $g->isConfigured());

    // Check for Zakat payment parameters
    $prefilledAmount = $request->get('amount');
    $prefilledNote = $request->get('note');

    return view('member.donate.checkout', [
      'campaign' => $campaign,
      'paymentGateways' => $paymentGateways,
      'prefilledAmount' => $prefilledAmount,
      'prefilledNote' => $prefilledNote,
    ]);
  }

  public function store(Request $request, DonationCampaign $campaign)
  {
    $validated = $request->validate([
      'amount' => ['required', 'numeric', 'min:1'],
      'note' => ['nullable', 'string', 'max:1000'],
      'payment_provider' => ['nullable', 'string', 'in:midtrans,stripe,toss'],
    ]);

    $member = Auth::guard('member')->user();

    // Create donation record
    $donation = Donation::create([
      'member_id' => $member->id,
      'donation_campaign_id' => $campaign->id,
      'amount' => $validated['amount'],
      'status' => 'pending',
      'note' => $validated['note'] ?? null,
    ]);

    // Generate unique order ID
    $orderId = 'DON-' . $donation->id . '-' . time();
    $donation->order_id = $orderId;
    $donation->save();

    // Get preferred payment provider or find any active gateway
    $preferredProvider = $validated['payment_provider'] ?? null;

    if ($preferredProvider) {
      $gateway = \App\Models\PaymentGateway::active()
        ->byProvider($preferredProvider)
        ->first();
    } else {
      // Try to find any active configured gateway in order: midtrans, stripe, toss
      $gateway = \App\Models\PaymentGateway::active()
        ->whereIn('provider', ['midtrans', 'stripe', 'toss'])
        ->get()
        ->first(fn($g) => $g->isConfigured());
    }

    if (!$gateway || !$gateway->isConfigured()) {
      return redirect()
        ->route('member.donate.show', $campaign)
        ->with('info', 'Donation recorded as pending. Payment gateway is not configured yet.');
    }

    try {
      $redirectUrl = $this->processPayment($donation, $gateway, $campaign, $member);

      if ($redirectUrl) {
        // Redirect to payment gateway (Midtrans Snap, Stripe Checkout, or Toss)
        return redirect()->away($redirectUrl);
      }

      // If no redirect URL returned, show error
      return redirect()
        ->route('member.donate.show', $campaign)
        ->with('error', 'Failed to create payment session. Please try again.');
    } catch (\Throwable $e) {
      Log::error('Payment creation failed: ' . $e->getMessage(), [
        'donation_id' => $donation->id,
        'provider' => $gateway->provider,
        'error' => $e->getTraceAsString(),
      ]);

      return redirect()
        ->route('member.donate.show', $campaign)
        ->with('error', 'Payment processing error: ' . $e->getMessage());
    }
  }

  protected function processPayment(Donation $donation, $gateway, DonationCampaign $campaign, $member): ?string
  {
    $donation->payment_gateway_id = $gateway->id;
    $donation->payment_provider = $gateway->provider;

    switch ($gateway->provider) {
      case 'midtrans':
        return $this->processMidtransPayment($donation, $gateway, $campaign, $member);

      case 'stripe':
        return $this->processStripePayment($donation, $gateway, $campaign, $member);

      case 'toss':
        return $this->processTossPayment($donation, $gateway, $campaign, $member);

      default:
        return null;
    }
  }

  protected function processMidtransPayment(Donation $donation, $gateway, DonationCampaign $campaign, $member): ?string
  {
    $payload = [
      'transaction_details' => [
        'order_id' => $donation->order_id,
        'gross_amount' => (int) $donation->amount,
      ],
      'customer_details' => [
        'first_name' => $member->name,
        'email' => $member->email,
      ],
      'item_details' => [
        [
          'id' => (string) $campaign->id,
          'price' => (int) $donation->amount,
          'quantity' => 1,
          'name' => substr($campaign->title, 0, 50),
        ],
      ],
      'callbacks' => [
        'finish' => route('payment.callback.midtrans.finish', ['order_id' => $donation->order_id]),
      ],
    ];

    $service = new MidtransSnapService($gateway);
    $result = $service->createTransaction($payload);

    $donation->snap_token = $result['token'] ?? null;
    $donation->snap_redirect_url = $result['redirect_url'] ?? null;
    $donation->save();

    return $donation->snap_redirect_url;
  }

  protected function processStripePayment(Donation $donation, $gateway, DonationCampaign $campaign, $member): ?string
  {
    $payload = [
      'amount' => (int) ($donation->amount * 100), // Stripe uses cents
      'currency' => 'usd',
      'item_name' => substr($campaign->title, 0, 50),
      'customer_email' => $member->email,
      'success_url' => route('payment.callback.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $donation->order_id,
      'cancel_url' => route('payment.callback.stripe.cancel') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $donation->order_id,
      'metadata' => [
        'order_id' => $donation->order_id,
        'donation_id' => $donation->id,
        'campaign_id' => $campaign->id,
      ],
    ];

    $service = new StripeCheckoutService($gateway);
    $result = $service->createCheckoutSession($payload);

    $donation->snap_token = $result['session_id'] ?? null; // Reuse snap_token for session_id
    $donation->snap_redirect_url = $result['checkout_url'] ?? null;
    $donation->save();

    return $donation->snap_redirect_url;
  }

  protected function processTossPayment(Donation $donation, $gateway, DonationCampaign $campaign, $member): ?string
  {
    $payload = [
      'order_id' => $donation->order_id,
      'amount' => (int) $donation->amount,
      'order_name' => substr($campaign->title, 0, 50),
      'customer_email' => $member->email,
      'customer_name' => $member->name,
      'success_url' => route('payment.callback.toss.success') . '?orderId=' . $donation->order_id,
      'fail_url' => route('payment.callback.toss.fail') . '?orderId=' . $donation->order_id,
    ];

    $service = new TossPaymentService($gateway);
    $result = $service->createPayment($payload);

    $donation->snap_token = $result['payment_key'] ?? null; // Reuse snap_token for payment_key
    $donation->snap_redirect_url = $result['checkout_url'] ?? null;
    $donation->save();

    return $donation->snap_redirect_url;
  }
}
