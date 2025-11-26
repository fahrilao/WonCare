<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Services\PointService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
  /**
   * Handle Midtrans payment notification webhook.
   */
  public function midtransWebhook(Request $request)
  {
    $payload = $request->all();
    Log::info('Midtrans webhook received', $payload);

    $orderId = $payload['order_id'] ?? null;
    $transactionStatus = $payload['transaction_status'] ?? null;
    $fraudStatus = $payload['fraud_status'] ?? null;

    if (!$orderId) {
      return response()->json(['message' => 'Invalid order_id'], 400);
    }

    $donation = Donation::where('order_id', $orderId)->first();

    if (!$donation) {
      Log::warning('Donation not found for order_id: ' . $orderId);
      return response()->json(['message' => 'Donation not found'], 404);
    }

    // Update payment status based on Midtrans status
    if ($transactionStatus === 'capture') {
      if ($fraudStatus === 'accept') {
        $donation->payment_status = 'success';
        $donation->paid_at = now();
      }
    } elseif ($transactionStatus === 'settlement') {
      $donation->payment_status = 'success';
      $donation->paid_at = now();

      // Update campaign collected amount
      $campaign = $donation->campaign;
      if ($campaign) {
        $campaign->collected_amount += $donation->amount;
        $campaign->save();
      }

      // Award points to member
      $this->awardPointsForDonation($donation);
    } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
      $donation->payment_status = 'failed';
    } elseif ($transactionStatus === 'pending') {
      $donation->payment_status = 'pending';
    }

    $donation->payment_response = json_encode($payload);
    $donation->save();

    return response()->json(['message' => 'OK'], 200);
  }

  /**
   * Handle Midtrans finish redirect (user returns from payment page).
   */
  public function midtransFinish(Request $request)
  {
    $orderId = $request->query('order_id');

    if (!$orderId) {
      return redirect()->route('dashboard')
        ->with('error', 'Invalid payment session');
    }

    $donation = Donation::where('order_id', $orderId)->first();

    if (!$donation) {
      return redirect()->route('dashboard')
        ->with('error', 'Donation not found');
    }

    if ($donation->payment_status === 'success') {
      return redirect()->route('member.donate.history')
        ->with('success', 'Payment successful! Thank you for your donation of ' . $donation->formatted_amount . ' to ' . ($donation->campaign->title ?? 'the campaign') . '.');
    }

    return redirect()->route('member.donate.history')
      ->with('info', 'Payment is being processed. You will be notified once confirmed.');
  }

  /**
   * Handle Stripe webhook.
   */
  public function stripeWebhook(Request $request)
  {
    $payload = $request->all();
    Log::info('Stripe webhook received', $payload);

    $eventType = $payload['type'] ?? null;

    if ($eventType === 'checkout.session.completed') {
      $session = $payload['data']['object'] ?? [];
      $orderId = $session['metadata']['order_id'] ?? null;

      if (!$orderId) {
        return response()->json(['message' => 'Invalid order_id'], 400);
      }

      $donation = Donation::where('order_id', $orderId)->first();

      if (!$donation) {
        Log::warning('Donation not found for order_id: ' . $orderId);
        return response()->json(['message' => 'Donation not found'], 404);
      }

      $donation->payment_status = 'success';
      $donation->paid_at = now();
      $donation->payment_response = json_encode($payload);
      $donation->save();

      // Update campaign collected amount
      $campaign = $donation->campaign;
      if ($campaign) {
        $campaign->collected_amount += $donation->amount;
        $campaign->save();
      }

      // Award points to member
      $this->awardPointsForDonation($donation);
    }

    return response()->json(['message' => 'OK'], 200);
  }

  /**
   * Handle Stripe success redirect.
   */
  public function stripeSuccess(Request $request)
  {
    $orderId = $request->query('order_id');
    $sessionId = $request->query('session_id');

    if (!$orderId && !$sessionId) {
      return redirect()->route('dashboard')
        ->with('error', 'Invalid payment session');
    }

    // Find donation by order_id (preferred) or session_id
    $donation = $orderId
      ? Donation::where('order_id', $orderId)->first()
      : Donation::where('snap_token', $sessionId)->first();

    if (!$donation) {
      return redirect()->route('dashboard')
        ->with('error', 'Donation not found');
    }

    if ($donation->payment_status === 'success') {
      return redirect()->route('member.donate.history')
        ->with('success', 'Payment successful! Thank you for your donation of ' . $donation->formatted_amount . ' to ' . ($donation->campaign->title ?? 'the campaign') . '.');
    }

    return redirect()->route('member.donate.history')
      ->with('info', 'Payment is being processed. You will be notified once confirmed.');
  }

  /**
   * Handle Stripe cancel redirect.
   */
  public function stripeCancel(Request $request)
  {
    $sessionId = $request->query('session_id');

    if ($sessionId) {
      $donation = Donation::where('snap_token', $sessionId)->first();

      if ($donation) {
        $donation->payment_status = 'cancelled';
        $donation->save();

        $campaign = $donation->campaign;

        return redirect()->route('member.donate.show', $campaign)
          ->with('error', 'Payment was cancelled.');
      }
    }

    return redirect()->route('dashboard')
      ->with('error', 'Payment was cancelled.');
  }

  /**
   * Handle Toss webhook.
   */
  public function tossWebhook(Request $request)
  {
    $payload = $request->all();
    Log::info('Toss webhook received', $payload);

    $orderId = $payload['orderId'] ?? null;
    $status = $payload['status'] ?? null;

    if (!$orderId) {
      return response()->json(['message' => 'Invalid orderId'], 400);
    }

    $donation = Donation::where('order_id', $orderId)->first();

    if (!$donation) {
      Log::warning('Donation not found for order_id: ' . $orderId);
      return response()->json(['message' => 'Donation not found'], 404);
    }

    if ($status === 'DONE') {
      $donation->payment_status = 'success';
      $donation->paid_at = now();
      $donation->payment_response = json_encode($payload);
      $donation->save();

      // Update campaign collected amount
      $campaign = $donation->campaign;
      if ($campaign) {
        $campaign->collected_amount += $donation->amount;
        $campaign->save();
      }

      // Award points to member
      $this->awardPointsForDonation($donation);
    } elseif (in_array($status, ['CANCELED', 'FAILED'])) {
      $donation->payment_status = 'failed';
      $donation->payment_response = json_encode($payload);
      $donation->save();
    }

    return response()->json(['message' => 'OK'], 200);
  }

  /**
   * Handle Toss success redirect.
   */
  public function tossSuccess(Request $request)
  {
    $orderId = $request->query('orderId');

    if (!$orderId) {
      return redirect()->route('dashboard')
        ->with('error', 'Invalid payment session');
    }

    $donation = Donation::where('order_id', $orderId)->first();

    if (!$donation) {
      return redirect()->route('dashboard')
        ->with('error', 'Donation not found');
    }

    return redirect()->route('member.donate.history')
      ->with('success', 'Payment successful! Thank you for your donation of ' . $donation->formatted_amount . ' to ' . ($donation->campaign->title ?? 'the campaign') . '.');
  }

  /**
   * Handle Toss fail redirect.
   */
  public function tossFail(Request $request)
  {
    $orderId = $request->query('orderId');

    if ($orderId) {
      $donation = Donation::where('order_id', $orderId)->first();

      if ($donation) {
        $donation->payment_status = 'failed';
        $donation->save();

        $campaign = $donation->campaign;

        return redirect()->route('member.donate.show', $campaign)
          ->with('error', 'Payment failed. Please try again.');
      }
    }

    return redirect()->route('dashboard')
      ->with('error', 'Payment failed.');
  }

  /**
   * Award points to member for donation/zakat payment
   */
  private function awardPointsForDonation(Donation $donation)
  {
    try {
      $pointService = app(PointService::class);

      // Determine source type
      $source = $donation->donation_campaign_id ? 'donation' : 'zakat';
      $sourceType = Donation::class;

      // Award points
      $pointService->awardPointsForPayment(
        $donation->member,
        $donation->amount,
        $donation->currency,
        $source,
        $donation->id,
        $sourceType,
        "Earned points from {$source} payment"
      );

      Log::info("Points awarded for donation", [
        'donation_id' => $donation->id,
        'member_id' => $donation->member_id,
        'amount' => $donation->amount,
        'currency' => $donation->currency,
      ]);
    } catch (\Exception $e) {
      Log::error("Failed to award points for donation", [
        'donation_id' => $donation->id,
        'error' => $e->getMessage(),
      ]);
      // Don't throw exception - points failure shouldn't block payment
    }
  }
}
