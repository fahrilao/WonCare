<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberPoint;
use App\Models\PointConversionSetting;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PointService
{
  /**
   * Award points to member for payment
   */
  public function awardPointsForPayment(
    Member $member,
    float $amount,
    string $currency,
    string $source,
    $sourceId = null,
    $sourceType = null,
    string $description = null
  ) {
    try {
      // Get conversion setting for currency
      $conversionSetting = PointConversionSetting::active()
        ->byCurrency($currency)
        ->first();

      if (!$conversionSetting) {
        Log::warning("No active point conversion setting found for currency: {$currency}");
        return null;
      }

      // Calculate points
      $points = $conversionSetting->calculatePoints($amount);

      if ($points <= 0) {
        Log::info("No points to award for amount: {$amount} {$currency}");
        return null;
      }

      // Award points in transaction
      return DB::transaction(function () use (
        $member,
        $points,
        $source,
        $sourceId,
        $sourceType,
        $amount,
        $currency,
        $description
      ) {
        // Get or create member points record
        $memberPoints = MemberPoint::firstOrCreate(
          ['member_id' => $member->id],
          ['points' => 0, 'total_earned' => 0, 'total_spent' => 0]
        );

        // Update points
        $memberPoints->points += $points;
        $memberPoints->total_earned += $points;
        $memberPoints->save();

        // Create transaction record
        $transaction = PointTransaction::create([
          'member_id' => $member->id,
          'type' => 'earn',
          'points' => $points,
          'balance_after' => $memberPoints->points,
          'source' => $source,
          'source_id' => $sourceId,
          'source_type' => $sourceType,
          'source_amount' => $amount,
          'source_currency' => $currency,
          'description' => $description ?? "Earned {$points} points from {$source}",
        ]);

        Log::info("Points awarded", [
          'member_id' => $member->id,
          'points' => $points,
          'source' => $source,
          'amount' => $amount,
          'currency' => $currency,
        ]);

        return $transaction;
      });
    } catch (\Exception $e) {
      Log::error("Error awarding points", [
        'member_id' => $member->id,
        'error' => $e->getMessage(),
      ]);
      return null;
    }
  }

  /**
   * Spend points
   */
  public function spendPoints(
    Member $member,
    int $points,
    string $source,
    $sourceId = null,
    $sourceType = null,
    string $description = null
  ) {
    try {
      return DB::transaction(function () use (
        $member,
        $points,
        $source,
        $sourceId,
        $sourceType,
        $description
      ) {
        // Get member points
        $memberPoints = MemberPoint::where('member_id', $member->id)->lockForUpdate()->first();

        if (!$memberPoints || $memberPoints->points < $points) {
          throw new \Exception("Insufficient points");
        }

        // Update points
        $memberPoints->points -= $points;
        $memberPoints->total_spent += $points;
        $memberPoints->save();

        // Create transaction record
        $transaction = PointTransaction::create([
          'member_id' => $member->id,
          'type' => 'spend',
          'points' => -$points, // Negative for spend
          'balance_after' => $memberPoints->points,
          'source' => $source,
          'source_id' => $sourceId,
          'source_type' => $sourceType,
          'description' => $description ?? "Spent {$points} points on {$source}",
        ]);

        Log::info("Points spent", [
          'member_id' => $member->id,
          'points' => $points,
          'source' => $source,
        ]);

        return $transaction;
      });
    } catch (\Exception $e) {
      Log::error("Error spending points", [
        'member_id' => $member->id,
        'error' => $e->getMessage(),
      ]);
      throw $e;
    }
  }

  /**
   * Get member point balance
   */
  public function getBalance(Member $member)
  {
    $memberPoints = MemberPoint::where('member_id', $member->id)->first();
    return $memberPoints ? $memberPoints->points : 0;
  }

  /**
   * Check if member has enough points
   */
  public function hasEnoughPoints(Member $member, int $points)
  {
    return $this->getBalance($member) >= $points;
  }
}
