<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
  use HasFactory;

  protected $fillable = [
    'member_id',
    'donation_campaign_id',
    'amount',
    'currency',
    'note',
    'order_id',
    'payment_status',
    'payment_gateway_id',
    'payment_provider',
    'snap_token',
    'snap_redirect_url',
    'payment_response',
    'paid_at',
  ];

  protected $casts = [
    'amount' => 'decimal:2',
    'paid_at' => 'datetime',
  ];

  /**
   * Available currencies
   */
  const CURRENCY_IDR = 'IDR'; // Indonesian Rupiah
  const CURRENCY_KRW = 'KRW'; // Korean Won

  const CURRENCIES = [
    self::CURRENCY_IDR => 'Rupiah (Rp)',
    self::CURRENCY_KRW => 'Won (₩)',
  ];

  public function member()
  {
    return $this->belongsTo(Member::class);
  }

  public function campaign()
  {
    return $this->belongsTo(DonationCampaign::class, 'donation_campaign_id');
  }

  public function paymentGateway()
  {
    return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
  }

  /**
   * Get formatted amount with currency symbol
   */
  public function getFormattedAmountAttribute(): string
  {
    $symbol = $this->currency === self::CURRENCY_KRW ? '₩' : 'Rp';
    $decimals = $this->currency === self::CURRENCY_KRW ? 0 : 0; // Both use 0 decimals

    return $symbol . ' ' . number_format($this->amount, $decimals, ',', '.');
  }

  /**
   * Get currency symbol
   */
  public function getCurrencySymbolAttribute(): string
  {
    return $this->currency === self::CURRENCY_KRW ? '₩' : 'Rp';
  }

  /**
   * Get currency name
   */
  public function getCurrencyNameAttribute(): string
  {
    return self::CURRENCIES[$this->currency] ?? $this->currency;
  }

  /**
   * Get amount converted to IDR (base currency)
   */
  public function getAmountInIDR(): float
  {
    // If already in IDR, return as is
    if ($this->currency === self::CURRENCY_IDR) {
      return (float) $this->amount;
    }

    // Get currency setting for conversion
    $currencySetting = \App\Models\CurrencySetting::getByCurrencyCode($this->currency);

    if (!$currencySetting) {
      // Fallback: return amount as is if currency setting not found
      return (float) $this->amount;
    }

    // Convert to IDR using exchange rate
    return $currencySetting->convertToIDR((float) $this->amount);
  }

  /**
   * Determine payment gateway based on currency
   */
  public static function getGatewayForCurrency(string $currency): ?PaymentGateway
  {
    $provider = $currency === self::CURRENCY_KRW ? 'toss' : 'midtrans';

    return PaymentGateway::active()
      ->byProvider($provider)
      ->first();
  }
}
