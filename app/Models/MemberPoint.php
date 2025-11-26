<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPoint extends Model
{
  use HasFactory;

  protected $fillable = [
    'member_id',
    'points',
    'total_earned',
    'total_spent',
  ];

  protected $casts = [
    'points' => 'integer',
    'total_earned' => 'integer',
    'total_spent' => 'integer',
  ];

  /**
   * Get the member that owns the points
   */
  public function member()
  {
    return $this->belongsTo(Member::class);
  }

  /**
   * Get point transactions
   */
  public function transactions()
  {
    return $this->hasMany(PointTransaction::class, 'member_id', 'member_id');
  }

  /**
   * Get formatted points
   */
  public function getFormattedPointsAttribute()
  {
    return number_format($this->points, 0, ',', '.');
  }

  /**
   * Get formatted total earned
   */
  public function getFormattedTotalEarnedAttribute()
  {
    return number_format($this->total_earned, 0, ',', '.');
  }

  /**
   * Get formatted total spent
   */
  public function getFormattedTotalSpentAttribute()
  {
    return number_format($this->total_spent, 0, ',', '.');
  }
}
