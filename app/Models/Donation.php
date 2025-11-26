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
    'status',
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
}
