<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointConversionSetting extends Model
{
  use HasFactory;

  protected $fillable = [
    'currency',
    'amount_per_point',
    'is_active',
    'description',
  ];

  protected $casts = [
    'amount_per_point' => 'decimal:2',
    'is_active' => 'boolean',
  ];

  /**
   * Get active conversion settings
   */
  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }

  /**
   * Get conversion setting by currency
   */
  public function scopeByCurrency($query, $currency)
  {
    return $query->where('currency', $currency);
  }

  /**
   * Calculate points from amount
   */
  public function calculatePoints($amount)
  {
    if ($this->amount_per_point <= 0) {
      return 0;
    }

    return floor($amount / $this->amount_per_point);
  }

  /**
   * Get formatted conversion rate
   */
  public function getFormattedRateAttribute()
  {
    return number_format($this->amount_per_point, 0, ',', '.') . ' ' . $this->currency . ' = 1 Point';
  }

  /**
   * Get status badge HTML
   */
  public function getStatusBadgeAttribute()
  {
    return $this->is_active
      ? '<span class="badge bg-success">Active</span>'
      : '<span class="badge bg-secondary">Inactive</span>';
  }
}
