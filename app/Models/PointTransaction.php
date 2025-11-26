<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'member_id',
    'type',
    'points',
    'balance_after',
    'source',
    'source_id',
    'source_type',
    'source_amount',
    'source_currency',
    'description',
    'created_by',
  ];

  protected $casts = [
    'points' => 'integer',
    'balance_after' => 'integer',
    'source_amount' => 'decimal:2',
  ];

  /**
   * Get the member that owns the transaction
   */
  public function member()
  {
    return $this->belongsTo(Member::class);
  }

  /**
   * Get the admin who created the adjustment
   */
  public function creator()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  /**
   * Get the source model (polymorphic)
   */
  public function source()
  {
    return $this->morphTo('source', 'source_type', 'source_id');
  }

  /**
   * Scope for earn transactions
   */
  public function scopeEarned($query)
  {
    return $query->where('type', 'earn');
  }

  /**
   * Scope for spend transactions
   */
  public function scopeSpent($query)
  {
    return $query->where('type', 'spend');
  }

  /**
   * Scope for adjustments
   */
  public function scopeAdjustments($query)
  {
    return $query->where('type', 'adjustment');
  }

  /**
   * Get formatted points with sign
   */
  public function getFormattedPointsAttribute()
  {
    $sign = $this->points >= 0 ? '+' : '';
    return $sign . number_format($this->points, 0, ',', '.');
  }

  /**
   * Get type badge HTML
   */
  public function getTypeBadgeAttribute()
  {
    $badges = [
      'earn' => '<span class="badge bg-success">Earned</span>',
      'spend' => '<span class="badge bg-danger">Spent</span>',
      'adjustment' => '<span class="badge bg-warning">Adjustment</span>',
    ];

    return $badges[$this->type] ?? '<span class="badge bg-secondary">Unknown</span>';
  }

  /**
   * Get source label
   */
  public function getSourceLabelAttribute()
  {
    $labels = [
      'donation' => 'Donation',
      'zakat' => 'Zakat Payment',
      'course_purchase' => 'Course Purchase',
      'admin_adjustment' => 'Admin Adjustment',
      'reward' => 'Reward',
      'refund' => 'Refund',
    ];

    return $labels[$this->source] ?? ucfirst(str_replace('_', ' ', $this->source));
  }

  /**
   * Get formatted source amount
   */
  public function getFormattedSourceAmountAttribute()
  {
    if (!$this->source_amount || !$this->source_currency) {
      return '-';
    }

    $symbols = [
      'IDR' => 'Rp',
      'KRW' => '₩',
      'USD' => '$',
    ];

    $symbol = $symbols[$this->source_currency] ?? $this->source_currency;
    return $symbol . ' ' . number_format($this->source_amount, 0, ',', '.');
  }
}
