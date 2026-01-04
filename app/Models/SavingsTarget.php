<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'target_year',
        'target_amount',
        'current_amount',
        'description',
        'is_achieved',
        'achieved_at',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'is_achieved' => 'boolean',
        'achieved_at' => 'date',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Helper Methods
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        return min(100, round(($this->current_amount / $this->target_amount) * 100, 2));
    }

    public function getRemainingAmountAttribute()
    {
        return max(0, $this->target_amount - $this->current_amount);
    }

    public function checkAndMarkAchieved()
    {
        if (!$this->is_achieved && $this->current_amount >= $this->target_amount) {
            $this->is_achieved = true;
            $this->achieved_at = now();
            $this->save();
        }
    }

    // Scopes
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    public function scopeForYear($query, $year)
    {
        return $query->where('target_year', $year);
    }

    public function scopeAchieved($query)
    {
        return $query->where('is_achieved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_achieved', false);
    }
}
