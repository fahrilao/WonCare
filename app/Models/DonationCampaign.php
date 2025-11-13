<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DonationCampaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'goal_amount',
        'collected_amount',
        'start_date',
        'end_date',
        'status',
        'image_url',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'goal_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created the campaign.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the images for the campaign.
     */
    public function images()
    {
        return $this->hasMany(DonationCampaignImage::class)->ordered();
    }

    /**
     * Get the primary image for the campaign.
     */
    public function primaryImage()
    {
        return $this->hasOne(DonationCampaignImage::class)->primary();
    }

    /**
     * Get the tags associated with the campaign.
     */
    public function tags()
    {
        return $this->belongsToMany(DonationTag::class, 'donation_campaign_tag')
                    ->withTimestamps()
                    ->orderBy('sort_order')
                    ->orderBy('name');
    }

    /**
     * Get the donation reports for the campaign.
     */
    public function donationReports()
    {
        return $this->hasMany(DonationReport::class)->latest();
    }

    /**
     * Get the progress percentage of the campaign.
     */
    public function getProgressPercentageAttribute()
    {
        if ($this->goal_amount <= 0) {
            return 0;
        }
        
        return min(100, round(($this->collected_amount / $this->goal_amount) * 100, 2));
    }

    /**
     * Get the remaining amount to reach the goal.
     */
    public function getRemainingAmountAttribute()
    {
        return max(0, $this->goal_amount - $this->collected_amount);
    }

    /**
     * Check if the campaign is active.
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && 
               $this->start_date <= now() && 
               ($this->end_date === null || $this->end_date >= now());
    }

    /**
     * Check if the campaign has ended.
     */
    public function getHasEndedAttribute()
    {
        return $this->end_date !== null && $this->end_date < now();
    }

    /**
     * Get formatted goal amount.
     */
    public function getFormattedGoalAmountAttribute()
    {
        return number_format($this->goal_amount, 2);
    }

    /**
     * Get formatted collected amount.
     */
    public function getFormattedCollectedAmountAttribute()
    {
        return number_format($this->collected_amount, 2);
    }

    /**
     * Get formatted remaining amount.
     */
    public function getFormattedRemainingAmountAttribute()
    {
        return number_format($this->remaining_amount, 2);
    }

    /**
     * Scope a query to only include active campaigns.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where(function ($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
    }

    /**
     * Scope a query to only include campaigns by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to order by latest.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
